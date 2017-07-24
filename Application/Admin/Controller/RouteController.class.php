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
class RouteController extends AdminController
{

    public function index()
    {
        $m=M('route');
        $place = $_SESSION['bus_admin']['place']['place'];
        $place == 0?$where = " id>0 ":$where = 'id>0 and place='.$place;
        $p=getpage($m,$where,10);
        $data = $m->where(' hide=0 ')->select();
        for ($i = 0; $i < count($data); $i++) {
            $nick = M('member')->field('nickname')->where(' uid= ' . $data[$i]['uid'])->find();
            $number = M('detail')->field(" count(*) ")->where(" rid =" . $data[$i]['id'])->find();
            $data[$i]['nickname'] = $nick['nickname'];
            $data[$i]['time'] = date('Y-m-d H:i:s', $data[$i]['time']);
            $data[$i]['bodytime'] = $number['count(*)'];
        }
        $page=$p->show();
        $this->assign('page',$page);
        $this->assign('data', $data);
        $this->display();
    }

    public function add()
    {
        if (IS_POST) {
            $data = I('post.');
            if (empty($data['title']) || empty($data['start']) || empty($data['end'])) $this->error('请补全信息,否则无法提交', U('Route/add'));
            $data['time'] = time();
            $data['uid'] = UID;
            $data['status'] = 1;
            $route_add = M('route')->add($data);
            if ($route_add) {
                $this->success('线路录入添加成功', U('Route/index'));
            } else {
                $this->error('线路录入添加失败', U('Route/add'));
            }
        } else {
            $place = $_SESSION['bus_admin']['place']['place'];
            $place == 0?$where = " id >=1 ":$where = 'id>0 and place='.$place;
            $data = M('place')
                ->field("id,title")
                ->where($where)
                ->select();
            $this->assign('data',$data);
            $this->display();
        }
    }

    public function get_oper($method = null)
    {
        $id = I("get.id");
        $id = is_array($id) ? implode(',', $id) : $id;
        if (empty($id)) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] = $id;
        switch (strtolower($method)) {
            case 'forbidroute':
                $this->forbid('Route', $map);
                break;
            case 'resumeroute':
                $this->resume('Route', $map);
                break;
            case 'deleteroute':
                $this->delete('Route', $map);
                break;
            case 'deletsroute':
                if (M('Route')->where($map)->delete()) {
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
    }


//公司权限座位首位添加
    public function placeAdd()
    {

        if (IS_POST) {
            $data = I('post.');
            if (empty($data['title']) || empty($data['position']) || empty($data['mobile'])) $this->error('请补全信息,否则无法提交', U('Route/placeAdd'));
            $data['time'] = time();
            $data['uid'] = UID;
            $route_add = M('place')->add($data);
            if ($route_add) {
                $this->success('公司录入成功', U('Route/placeList'));
            } else {
                $this->error('公司录入失败', U('Route/placeAdd'));
            }
        } else {

            $this->display();
        }
    }

    // 公司信息展示showList

    public function placeList(){
        $m=M('place');
        $where=('id>0');
        $p=getpage($m,$where,3);
        $data = $m->select();

        for($i=0;$i<count($data);$i++){
            $data[$i]['time'] = date('Y-m-d H:i:s',$data[$i]['time']);
            $nickname = M('ucenter_member')->field('username')->where(' id='.$data[$i]['uid'])->find();
            $data[$i]['nickname'] = $nickname['username'];
        }
        $page=$p->show();
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->display();
    }

    //公司信息刷新
    public function showList(){
        $id = I('get.id');
        $data = M('place')->where(' id='.$id)->find();
        session('place',$data);
        session('placestart',1);
        if($data){
            $this->success('公司成功', U('Route/placeList'));
        }else{
            $this->error('公司转换', U('Route/placeList'));
        }
    }

}