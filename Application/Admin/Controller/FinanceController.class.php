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
class FinanceController extends AdminController{

    //账单明细
    public function showList(){
        $place = $_SESSION['bus_admin']['place']['place'];
        $place == 0?$places = 1:$places = $place;

        $year = date('Y',time());

        $where = array(
            'place' => $places,
            'year'  => $year
        );

        $list = M('finance')->where($where)->order(" id asc ")->select();
        $data = array();
        for($i=0;$i<count($list);$i++){
            $data[$i]['year'] = $list[$i]['year']."-".$list[$i]['month'];
            $data[$i]['income'] = $data[$i]['expenses'] = $list[$i]['money'];
        }

        $data = json_encode($data);
        $this->assign('data',$data);
        $this->display();

    }



}