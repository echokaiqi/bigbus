<?php
namespace Home\Controller;
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
class MemberController extends HomeController{
    //用户的主页
    public function index(){
        isset($_SESSION['bus_home']['user_auth']['id'])?$where=array('id'=>$_SESSION['bus_home']['user_auth']['id']):$where=array('id'=>0);
        json_api(false,'home_member',$where,1,'session');
    }

    //用户账单查询
    public function check(){
        isset($_GET['uid'])?$where=array('uid'=>$_GET['uid']):$where=array('uid'=>0);
        json_api(false,'monydetail',$where,2);
    }

    //用户临时乘车扫码
    public function scan(){
        if(isset($_SESSION['bus_home']['user_auth']['id'])){
            if(isset($_GET['catstatus'])){
                $where=array(
                    'pid' => $_GET['id'],
                    'carstatus'=>$_GET['carstatus'],
                    'uid'=>$_SESSION['bus_home']['user_auth']['id'],
                    'time' => time(),
                );
                $data = M('ride')->where($where)->add();
                if($data){
                    $data = M('ride')
                        ->alias("a")
                        ->field('a.*,b.name,c.title')
                        ->join("left join bus_detail as b on b.id = a.pid")
                        ->join("left join bus_route as c on b.rid = c.id")
                        ->where($where)
                        ->find();
                    if($data){
                        json_api($data);
                    }else{
                        $data = array(
                            'id'=>0
                        );
                        json_api(false,'ride',$data,1);
                    }
                }else{
                    $data = array(
                        'id'=>0
                    );
                    json_api(false,'ride',$data,1);
                }
            }else{
                $data = array(
                    'id'=>0
                );
                json_api(false,'ride',$data,1);
            }
        }else{
            $data = array(
                'id'=>0
            );
            json_api(false,'ride',$data,1);
        }
    }


}