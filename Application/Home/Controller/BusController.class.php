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
class BusController extends HomeController{

    public function route(){
        //通过查询当地的位置来判断公司是否存在 线路列表
        empty($_SESSION['bus_home']['place']['id'])?
            $route_where = array('place'=>0):
            $route_where = array('place'=>$_SESSION['bus_home']['place']['id']);
        json_api(false,'route',$route_where,2);
    }
    //点击某个线路显示该线路的详细信息
    public function detail(){
        if(isset($_GET['id'])){
            $where=array(
                'id' => $_GET['id'],
                'place'=>$_SESSION['bus_home']['place']['id']
            );
            json_api(false,'route',$where,1);
        }
    }
}