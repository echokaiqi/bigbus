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
class BusController extends AdminController{
    //班车类别
    public function index(){
        $m=M('rank');
        $where='id>0';
        $p=getpage($m,$where,5);

        $data = $m->where(' hide=0 ')->order('id asc')->select();

        for($i=0;$i<count($data);$i++){
            $nick=M('member')->field('nickname')->where(' uid= '.$data[$i]['uid'])->find();
            $data[$i]['nickname'] = $nick['nickname'];
            $data[$i]['time'] = date('Y-m-d H:i:s',$data[$i]['time']);
        }
        $page=$p->show();
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->display();
    }
    //班车添加
    public function bus_add(){
        $pace = $_SESSION['bus_admin']['place']['place'];
        if(IS_POST){
            $data = I("post.");
            $id = $data['pid'];
            if(empty($data['name'])) $this->error('请完善您的信息',U('Bus/bus_add'));
            $data['time'] = time();
            $data['status'] = 0 ;

            $pace == 0?$data['place']=1:$data['place']=$pace;
            if(M('detail')->add($data)){
                $this->success('班车录入添加成功',U("Bus/detail?pid=".$id.""));
            }else{
                $this->error('班车录入添加失败',U('Bus/bus_add'));
            }
        }


        $pace == 0?$where = ' id>0 ':$where=array('place'=>$pace);

        $route = M('route')->where($where)->select();
        $rank  = M('rank')->select();
        $this->assign('route',$route);
        $this->assign('rank',$rank);
        $this->display();
    }
    //类别添加
    public function add(){
        if(IS_POST){
            $data = I('post.');
            if(empty($data['title'])||empty($data['number'])||!is_numeric($data['number'])) $this->error('请补全信息,否则无法提交',U('Bus/add'));
            $data['time'] = time();
            $data['uid']  = UID;
            $data['status'] = 1 ;
            header("content-type:text/html;charset=utf8");
            $route_add = M('rank')->add($data);
            if($route_add){
                $this->success('班车录入添加成功',U('Bus/index'));
            }else{
                $this->error('班车录入添加失败',U('Bus/add'));
            }
        }else{
            $this->display();
        }
    }
    //事物操作
    public function get_oper($method=null){
        $id = I("get.id");
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] =   $id;
        switch ( strtolower($method) ){
            case 'forbidrank':
                $this->forbid('rank', $map );
                break;
            case 'resumerank':
                $this->resume('rank', $map );
                break;
            case 'deletsrank':
                if(M('rank')->where($map)->delete()){
                    session('ADMIN_MENU_LIST',null);
                    //记录行为
                    action_log('update_Bus', 'rank', $id, UID);
                    $this->success('删除成功');
                } else {
                    $this->error('删除失败！');
                }
                break;
            default:
                $this->error('参数非法');
        }
    }
    //班车列表
    public function detail(){
        $m=M('detail');

        $place = $_SESSION['bus_admin']['place']['place'];
        $place == 0?$places = " ":$places = $place;

        isset($_GET['pid'])?
            $place == 0?
                $where = array('pid'=>$_GET['pid']):
                $where = array('pid'=>$_GET['pid'],'place' => $places):
            isset($_GET['rid'])?
                $place ==0 ?
                    $where = array('rid'=>$_GET['rid']):
                    $where = array('rid'=>$_GET['rid'],'place'=>$places):
                $place == 0?
                    $where=" id>0 ":
                    $where=" id>0 and place=".$places;

        $p=getpage($m,$where,10);

        $data = $m->where($where)->select();

        for($i=0;$i<count($data);$i++){
             $ptitle = M("rank")->field("title,status")->where(" id=".$data[$i]['pid'])->find();
             $data[$i]['ptitle'] = $ptitle['title'];
             $data[$i]['pstatus'] = $ptitle['status'];
             $ttitle = M("route")->field("title,status")->where(" id=".$data[$i]['rid'])->find();
             $data[$i]['ttitle'] = $ttitle['title'];
             $data[$i]['tstatus'] = $ttitle['status'];
             $data[$i]['time'] = date('Y-m-d H:i:s',$data[$i]['time']);
        }
        $page=$p->show();
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->display();
    }

    public function upd(){
        if(!IS_POST){
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $data = M('detail')
                    ->alias(" a ")
                    ->field(" a.id,a.name,a.pid,a.rid,b.number,b.title ")
                    ->join(" bus_rank as b on b.id=a.pid")
                    ->where(" a.id =".$id)
                    ->find();
                session("rid",$data['rid']);
                $this->assign("data",$data);
            }
        }else{
            $data = I('post.');
            if($data['rid'] == $_SESSION['bus_admin']['rid']){
                session("rid",'');
                $this->error('请更换线路',U("Bus/upd?id=".$data['id']));
            }else{
                if(M('detail')->save($data)){
                    session("rid",'');
                    $this->success("调度成功",U('Bus/detail?rid='.$data['rid']));
                }else{
                    $this->error("调度失败",U("Bus/upd?id=".$data['id']));
                }
            }
        }
        $places = M('place')->select();

        $pace = $_SESSION['bus_admin']['place']['place'];
        $pace == 0?$where = ' id>0 ':$where=array('place'=>$pace);
        $route = M('route')->where($where)->select();
        $this->assign('places',$places);
        $this->assign('route',$route);
        $this->display();
    }

    //二维码制作
    public function busUpCode(){
        \vendor("wxpay/example/phpqrcode/phpqrcode");

        if(isset($_GET['id'])){

            $id = $_GET['id'];

                    $data = 'http://www.bigbus.com?id='.$id."&catstatus = 1";
                    // 纠错级别：L、M、Q、H
                    $level = 'L';
                    // 点的大小：1到10,用于手机端4就可以了
                    $size = 6;
                    // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
                    //$path = "images/";
                    // 生成的文件名
                    $qrfile = "cartup.png";

                    \QRcode::png($data,$qrfile,$level,$size);
                    $this->assign("data",$qrfile);
                }
        $this->display();
    }

    public function busDoCode(){
        \vendor("wxpay/example/phpqrcode/phpqrcode");

        if(isset($_GET['id'])){

            $id = $_GET['id'];

            $data = 'http://www.bigbus.com?id='.$id."&catstatus = 1";
            // 纠错级别：L、M、Q、H
            $level = 'L';
            // 点的大小：1到10,用于手机端4就可以了
            $size = 6;
            // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
            //$path = "images/";
            // 生成的文件名
            $qrfile = "cartDo.png";
            \QRcode::png($data,$qrfile,$level,$size);
            $this->assign("data",$qrfile);
        }
        $this->display();
    }

    public function changeRoute(){
        if(isset($_POST['id'])){
            if(!empty($_POST['id'])){
                $where = 'id>0 and place = '.$_POST['id'];
                $msg = M('route')->where($where)->select();
                echo json_encode($msg);
            }
        }
    }
}