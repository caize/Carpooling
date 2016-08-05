<?php
namespace app\mobile\controller;

use \think\Request;
use \think\Session;
use \think\Config;
use app\common\tools\YunPianSms;

class Sms
{

	/**
	 * 短信发送
	 * @author chouchong
	 */
	public function send()
	{
	    Config::set('default_return_type','json');
	    if(validate('Member')->scene('sms')->check(input('post.')) == false){
	    	return ['status'=> -1,'msg'=>validate('Member')->getError()];
	    }
		$sms = new YunPianSms();
		$code = '';
	    $charset = '1234567890';
	    $_len = strlen($charset) - 1;
	    for ($i = 0;$i < 6;++$i) {
	        $code .= $charset[mt_rand(0, $_len)];
	    }
	    $data=array(
	      'tpl_id'=>'8',
	      'tpl_value'=>('#code#').'='.urlencode($code).'&'.('#tel#').'='.urlencode('4008627098').'&'.('#company#').'='.urlencode('云片网'),
	      'mobile'=>input('post.phone','')
	    );
	    Session::set('smscode',$code);
	    $object = $sms->yp_send_tpl($data);
	    return ['status'=> $object['code'],'msg'=>$object['msg']];
	}
}