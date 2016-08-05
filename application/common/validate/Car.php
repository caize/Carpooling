<?php
namespace app\common\validate;

use \think\Validate;

class Car extends Validate
{
    protected $rule = [
        'number'=>'require|checkNumber:',
        'phone'=>'require|checkPhone:',
        'bid'=>'require',
        'name'=>'require',
        'from'=>'require',
        'to'=>'require',
        'go_time'=>'require',
        'thumb'=>'require',
    ];

    protected $message = [
        'number.require'=>'车牌号不能为空',
        'number.checkNumber'=>'车牌号不正确',
        'bid.require'=>'车辆品牌不能为空',
        'phone.require'=>'联系电话不能为空',
        'phone.checkPhone'=>'联系电话不正确',
        'name.require'=>'车主姓名不能为空',
        'from.require'=>'出发地不能为空',
        'to.require'=>'目的的不能为空',
        'go_time.require'=>'出发时间不能为空',
        'thumb.require'=>'车辆图片不能为空',
    ];
    protected $scene = [

    ];
    //车牌正则验证
    public function checkNumber($value){
        if(preg_match("/[\x80-\xff]+[A-Z][0-9a-zA-Z]{5}/",$value)){
          return true;
        }
        return false;
    }
     //手机号正则验证
    public function checkPhone($value){
        if(preg_match("/^1[34578]\d{9}$/",$value)){
          return true;
        }
        return false;
    }
}
