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
class AlipayController extends Controller{

    function pay(){
        vendor("Zfb/aop/AopClient.php");
        vendor("Zfb/aop/request/AlipayTradeAppPayRequest.php");
        $aop = new \AopClient();
        //支付宝开始
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        //线上app id
        $aop->appId="";
        $aop->rsaPrivateKey = '填写工具生成的商户应用私钥';
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA";
        $aop->alipayrsaPublicKey = '填写从支付宝开放后台查看的支付宝公钥';
        $bizcontent = json_encode([
            'body'=>'开通年费享受免费班车',
            'subject'=>'会员',
            'out_trade_no'=>'123456',//此订单号为商户唯一订单号
            'total_amount'=> '199.00',//保留两位小数
            'product_code'=>'QUICK_MSECURITY_PAY'
        ]);
        //**支付宝结束
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //支付宝回调
        $request->setNotifyUrl("https://bigbus.com/pay/alinotify");
        $request->setBizContent($bizcontent);
        //使用sdkExecute
        $response = $aop->sdkExecute($request);
        echo $response;
    }

}


