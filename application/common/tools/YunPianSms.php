<?php
namespace app\common\tools;
/**
* 修改为您的apikey(https://www.yunpian.com)登陆官网后获取
*/
class YunPianSms
{


    // public $apikey = "b430611acd469c29ebbe08f845f196d8"; 测试
    // $apikey = "xxxxxxxxxxx"; //
    // $mobile = "xxxxxxxxxxx"; //请用自己的手机号代替
    // $text="【云片网】您的验证码是1234";
    // /* 发送短信 */
    public function yp_send($data = array()){
        $ch = curl_init();
        /* 设置验证方式 */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));
        /* 设置返回结果为流 */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        /* 设置超时时间*/
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        /* 设置通信方式 */
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // 发送模板短信
        // 需要对value进行编码
        $dataSms = array('apikey'=>"b430611acd469c29ebbe08f845f196d8");
        $dataSms = array_merge($dataSms,$data);
        $json_data = $this->send($ch,$dataSms);
        $array = json_decode($json_data,true);
        curl_close($ch);
        return $array;
    }
    // /* 发送模板短信 */
    public function yp_send_tpl($data = array()){
        $ch = curl_init();
        /* 设置验证方式 */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));
        /* 设置返回结果为流 */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        /* 设置超时时间*/
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        /* 设置通信方式 */
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // 发送模板短信
        // 需要对value进行编码
        $dataSms = array('apikey'=>"b430611acd469c29ebbe08f845f196d8");
        $dataSms = array_merge($dataSms,$data);
        $json_data = $this->tpl_send($ch,$dataSms);
        $array = json_decode($json_data,true);
        curl_close($ch);
        return $array;
    }
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));

    // /* 设置返回结果为流 */
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // /* 设置超时时间*/
    // curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    // /* 设置通信方式 */
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // // 取得用户信息
    // $json_data = get_user($ch,$apikey);
    // $array = json_decode($json_data,true);
    // echo '<pre>';print_r($array);
    // // 发送短信
    // $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
    // $json_data = send($ch,$data);
    // $array = json_decode($json_data,true);
    // echo '<pre>';print_r($array);
    // // 发送模板短信
    // // 需要对value进行编码
    // $data=array('tpl_id'=>'1','tpl_value'=>('#code#').'='.urlencode('1234').'&'.urlencode('#company#').'='.urlencode('欢乐行'),'apikey'=>$apikey,'mobile'=>$mobile);
    // print_r ($data);
    // $json_data = tpl_send($ch,$data);
    // $array = json_decode($json_data,true);
    // echo '<pre>';print_r($array);

    // // 发送语音验证码
    // $data=array('code'=>'9876','apikey'=>$apikey,'mobile'=>$mobile);
    // $json_data =voice_send($ch,$data);
    // $array = json_decode($json_data,true);
    // echo '<pre>';print_r($array);

    // curl_close($ch);

    /***************************************************************************************/
    //获得账户
    public function get_user($ch,$apikey){
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v1/user/get.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $apikey)));
        return curl_exec($ch);
    }
    public function send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v1/sms/send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        return curl_exec($ch);
    }
    public function tpl_send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v1/sms/tpl_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        return curl_exec($ch);
    }
    public function voice_send($ch,$data){
        curl_setopt ($ch, CURLOPT_URL, 'http://voice.yunpian.com/v1/voice/send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        return curl_exec($ch);
    }
}
?>