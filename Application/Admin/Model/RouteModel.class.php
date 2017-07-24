<?php
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
namespace Admin\Model;
use Think\Model;
class RouteModel extends Model{

    //检索线路是否存在
    public function add_search($data){

        foreach($data as $key){
            $add = $this->find($key);
            if($add) return false;
        }

    }

}