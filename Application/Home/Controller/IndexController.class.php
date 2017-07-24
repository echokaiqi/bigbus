<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){
        //定位 根据传递过来的位置进行查找 position 等于 设定变量
        if(IS_POST){
            $where =array(
                'position'=> I("post.position")
            );
            json_api(false,'place',$where,1,'session');
        }else{
            if(empty($_SESSION['bus_home']['place'])){
                $where = array(
                    'position' => '唐山市路北区'
                );
                json_api(false,'place',$where,1,'session');
            }else{
                $where = array(
                    'id' => $_SESSION['bus_home']['place']['id']
                );
                json_api(false,'place',$where,1);
            }
        }
    }

    //线路信息
    public function route(){
        if(!empty($_SESSION['bus_home']['place']['id'])){
            $where= array(
                'place'=>$_SESSION['bus_home']['place']['id']
            );
            json_api(false,'route',$where,2);
        }else{
            $where=array(
                'id' => 0,
            );
            json_api(false,'route',$where,1);
        }
    }

    //班车信息
    public function busDetail(){
        if(isset($_GET['route_id'])){
            $where=array(
                'rid' => $_GET['route_id'],
                'place'=>$_SESSION['bus_home']['place']['id']
            );
            $da = M('detail')
                ->alias("a")
                ->field("a.*,b.title")
                ->join('left join bus_rank as b on a.pid =b.id ')
                ->where($where)->select();
            json_api($da);
        }else{
            $where=array(
                'id' => 0
            );
            json_api(false,'detail',$where,1);
        }
    }


}