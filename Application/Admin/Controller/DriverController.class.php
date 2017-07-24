<?php
namespace Admin\Controller;
//   ┏┛┻━━━┛┻┓
//   ┃||||||||||||||┃
//   ┃　　　━　　　┃
//   ┃　┳┛　┗┳　┃ 　　
//   ┃　　　┻　　　┃
//   ┃　　　　　　　┃
//   ┗━┓　　　┏━┛ 　　
//      ┃　　　┃　　
//      ┃　　　┃　　
//      ┃　　　┃　 　
//      ┃　　　┃
//      ┃　　　┗━━━┓
//      ┃　　　　　　　┣┓
//      ┃             ┃
//      ┗┓┓┏━┓ ┏┛
//      ┃┫┫　┃┫┫
// +----------------------------------
// | PHP  primary development 
// +----------------------------------
// | Creation date 2017
// +----------------------------------
// | Author: MY <yao_open@126.com> 
// +----------------------------------
class DriverController extends AdminController{

    // 司机信息表
    public function index(){
        $m=M('driver');
        $where='id>0';
        $p=getpage($m,$where,5);
        $data = $m->field('id,nickname,sex,mobile,identitycardno,age,driv_ex,time,status')->select();
        for($i=0;$i<count($data);$i++){
            $data[$i]['time'] = date('Y-m-d H:i:s',$data[$i]['time']);
        }
        $page=$p->show();
        $this->assign('page',$page);
        $this->assign("data",$data);
        $this->display();
    }

    //添加司机
    public function add($username = '', $password = '', $repassword = '', $mobile = '',$sex =0 ,$age = '',$driv_ex = '',$identitycardno = ''){

        if(IS_POST){

            /* 检测密码 */
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }

            /* 验证手机号 */
            $preg = "/^1[34578]\d{9}$/";
            if(!preg_match($preg, $mobile)){
                $this->error('请输入正确的手机号！');
            }
            if(!checkIdCard($identitycardno)){
                $this->error('身份证格式有误,请输入正确的格式');
            }
            $driverpwd=md5($password);
            $time = time();
                $user = array('username' => $username, 'password' => $driverpwd, 'mobile'=>$mobile,'time'=>$time,'sex' => $sex,'age'=>$age ,'driv_ex' =>$driv_ex, 'identitycardno'=>$identitycardno,'status' => 0);

                if (!M('driver')->add($user)) {
                    $this->error('司机添加失败！');
                } else {
                    $this->success('司机添加成功！', U('index'));
                }

            }
        else{
            $this->display();
        }
    }

    //司机工作记录
    public function detail(){
        // drid为司机id  did 为班车id
        isset($_GET['drid'])?
            $where = array(' a.drid '=>$_GET['drid']):
                isset($_GET['did'])?
                    $where = array(' a.did '=>$_GET['did']):
                    $where = " a.id >=1 ";

        $data = M('driveed')
            ->alias(' a ')
            ->field(' a.id,a.did,a.drid,a.start_t,a.end_t,b.nickname,c.name')
            ->join(" left join bus_driver as b on b.id = a.drid ")
            ->join(' left join bus_detail as c on c.id = a.did ')
            ->where($where)
            ->select();

        for($i=0;$i<count($data);$i++){
            $data[$i]['start_t'] = date('Y-m-d H:i:s',$data[$i]['start_t']);
            $data[$i]['end_t'] = date('Y-m-d H:i:s',$data[$i]['end_t']);
        }

        $this->assign('data',$data);
        $this->display();
    }
    //删除司机
    public function del($method=null){
        $id=I('get.id');
        $id = is_array($id) ? implode(',', $id) : $id;
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }
        $drid['id']=$id;
        switch (strtolower($method)) {
            case 'forbiddrive':
                $this->forbid('driver', $drid);
                break;
            case 'resumedrive':
                $this->resume('driver', $drid);
                break;
            case 'deletsdrive':
                if (M('driver')->where($drid)->delete()) {
                    session('ADMIN_MENU_LIST', null);
                    //记录行为
                    action_log('update_Route', 'Route', $id, UID);
                    $this->success('删除成功');
                } else {
                    $this->error('删除失败！');
                }
                break;
            default:
                $this->error('参数非法');
        }

        if(M('driver')->where($drid)->delete()){
            session('ADMIN_MENU_LIST',null);
            //记录行为
            action_log('update_Bus', 'driver', $id, UID);
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }

    }



}
