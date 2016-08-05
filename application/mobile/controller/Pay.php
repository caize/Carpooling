<?php
namespace app\mobile\controller;

use wxpay\database\WxPayUnifiedOrder;
use wxpay\JsApiPay;
use wxpay\NativePay;
use wxpay\PayNotifyCallBack;
use wxpay\WxPayApi;
use wxpay\WxPayConfig;

use alipay\AliPay;
use unionPay\UnionPay;
use think\Log;
use think\Session;

use unionpay\sdk\LogUtil;

class Pay extends Base
{
	/**
	 * 支付
	 * @author chouchong
	 */
	public function index()
	{
		$this->isCheckMember();
		$tools = new JsApiPay();
        $openId = $tools->getOpenid(getUrl());
        Session::set('openId',$openId);
		return view('',['order'=>model('order')->find(input('param.id'))]);
	}
	/**
	 * 微信支付
	 * @author chouchong
	 */
	public function wxPay()
	{
		$tools = new JsApiPay();
		$input = new WxPayUnifiedOrder();
		$money = input('param.prepay',0.01);
        $input->setBody("拼车");
        $input->setAttach("test");
        $input->setOutTradeNo(WxPayConfig::MCHID.time());
        $input->setTotalFee($money * 100);
        $input->setTimeStart(date("YmdHis"));
        $input->setTimeExpire(date("YmdHis", time() + 600));
        $input->setGoodsTag("Reward");
        $input->setNotifyUrl('http://' . $_SERVER['HTTP_HOST'].'/mobile/pay/notify/id/' . input('param.id',0));
        $input->setTradeType("JSAPI");
        $input->setOpenid(session('openId'));
        $order = WxPayApi::unifiedOrder($input);

        $jsApiParameters = $tools->getJsApiParameters($order);
        return json_decode($jsApiParameters);
	}
	/**
	 * 微信支付 回调
	 * @author chouchong
	 */
	public function notify($id = 0)
    {
        $notify = new PayNotifyCallBack();
        $notify->handle(true);


        //找到匹配签名的订单
        $order = model('order')->find($id);
        if (!isset($order)) {
            Log::write('未找到订单，id= ' . $id);
        }
        $succeed = ($notify->getReturnCode() == 'SUCCESS') ? true : false;
        if ($succeed) {
            $order->save(['status' => '1'], ['id' => $order->id]);
            Log::write('订单' . $order->id . '状态更新成功');
        } else {
            Log::write('订单' . $id . '支付失败');
        }
    }
    /**
     * 支付宝支付
     * @author chouchong
     */
    public function alipay()
    {
        $alipay = new AliPay();
        $data['notify_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/mobile/pay/AliPayNotify';
        $data['return_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/mobile/pay/AliPayReturn';
        $data['out_trade_no'] = "PC".time();
        $data['subject'] = '拼车';
        $data['total_fee'] = 0.01;
        echo($alipay->alipay($data));
    }
    /**
     * 支付宝支付
     * @author chouchong
     */
    public function wapalipay()
    {
        $alipay = new AliPay();
        $data['notify_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/mobile/pay/AliPayNotify';
        $data['return_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/mobile/pay/AliPayReturn';
        $data['out_trade_no'] = "PC".time();
        $data['subject'] = '拼车';
        $data['total_fee'] = 0.01;
        $data['show_url'] = getUrl();
        echo($alipay->wapalipay($data));
    }
    /**
     * 支付宝支付
     * @author chouchong
     */
    public function AliPayNotify()
    {
        $Alipay = new AliPay(); //实例化银联支付操作类
        if($Alipay->verifyNotify()){    //验证
            $out_trade_no = input('post.out_trade_no');
            $trade_no = input('post.trade_no');
            $trade_status = input('post.trade_status');
            if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS')
            {
                Log::write('成功找到订单，id= ' .input('post.out_trade_no'));
                if($res !== false){
                    echo 'success';
                }
            }
        }
    }
    /**
     * 支付宝支付
     * @author chouchong
     */
    public function AliPayReturn()
    {
        $Alipay = new AliPay(); //实例化银联支付操作类
        if($Alipay->verifyReturn()){    //验证
            $out_trade_no = input('param.out_trade_no');
            $trade_no = input('param.trade_no');
            $trade_status = input('param.trade_status');
            if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS')
            {
                Log::write('成功');
            }else{
                Log::write('失败');
            }
        }
    }
    //银联支付
    public function unionpay(){
        $Uniopay = new UnionPay(); //实例化银联支付操作类
        $data['txnAmt'] = 0.01*100;   //交易金额，必填
        $data['orderId'] = time(); //订单号，选填
        $Uniopay->pay($data);
    }
    //银联支付
    public function FrontReceive(){
        $Uniopay = new UnionPay();
        //验证
        if($Uniopay->CheckData($_POST)){
            echo '订单FrontReceive支付成功';
          Log::write('订单FrontReceive支付成功');
        }else{
          Log::write('订单FrontReceive支付失败');
        }
    }
    //银联支付
    public function BackReceive(){
        $Uniopay = new UnionPay();
        //验证
        if($Uniopay->CheckData($_POST)){
            echo '订单BackReceive支付成功';
          Log::write('订单BackReceive支付成功');
        }else{
          Log::write('订单BackReceive支付失败');
        }
    }
}