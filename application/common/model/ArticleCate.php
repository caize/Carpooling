<?php
namespace app\common\model;

use \think\Model;
use \think\Session;

class ArticleCate extends Model
{
    // 以上定义需要配合insert、update或者auto才能生效
	protected $auto = ['update_time','create_time'];
	/**
     * 关联：ArticleCate自身关联
     * @author chouchong
     */
	public function parent(){
		return $this->hasMany('ArticleCate','parent_id','id');
	}
	/**
     * 关联：Article表
     * @author chouchong
     */
	public function article(){
		return $this->hasMany('Article','category_id','id');
	}
	/**
	 * 获取文章分类
	 * @author chouchong
	 */
	public function getCate()
	{
      $cates = $this->where('parent_id',0)->select();
      return $cates;
	}

}