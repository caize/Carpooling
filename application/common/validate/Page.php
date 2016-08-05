<?php
namespace app\common\validate;

use \think\Validate;

class Page extends Validate
{
    protected $rule = [
        'title'=>'require',
    ];

    protected $message = [
        'title.require'=>'文章标题不能为空',

    ];
    // protected $scene = [
    //    'edit'=>['title'=>'require']
    // ];
}
