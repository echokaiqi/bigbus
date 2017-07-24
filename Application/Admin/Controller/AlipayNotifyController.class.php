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
use Think\Controller;
class AlipayNotifyController extends Controller{

    function notify(){
        vendor("Zfb/aop/AopClient.php");

        $aop = new \AopClient();
        $aop->alipayrsaPublicKey = '请填写支付宝公钥，一行字符串';
        //此处验签方式必须与下单时的签名方式一致
        $flag = $aop->rsaCheckV1($_POST, NULL, "RSA");
        //验签通过后再实现业务逻辑，比如修改订单表中的支付状态。
        /**
        ①验签通过后核实如下参数out_trade_no、total_amount、seller_id
        ②修改订单表
         **/
        //打印success，应答支付宝。必须保证本界面无错误。只打印了success，否则支付宝将重复请求回调地址。
        echo 'success';

    }

}
