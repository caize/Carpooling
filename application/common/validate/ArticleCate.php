<?php
namespace app\common\validate;

use \think\Validate;

class ArticleCate extends Validate
{
    protected $rule = [
        'title'=>'require|unique:ArticleCate',
    ];

    protected $message = [
        'title.require'=>'分类名称不能为空',
        'title.unique'=>'分类名称已经存在了',
    ];
    protected $scene = [
       'edit'=>['title'=>'require']
    ];
}
