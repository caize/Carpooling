<?php
namespace app\common\validate;

use \think\Validate;

class Price extends Validate
{
    protected $rule = [
        'from'=>'require',
        'to'=>'require',
        'price'=>'require',
    ];

    protected $message = [
        'from.require'=>'出发地不能为空',
        'to.require'=>'目的的不能为空',
        'price.require'=>'行程价格不能为空',
    ];
}
