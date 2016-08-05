<?php
namespace app\common\model;

use think\Model;
use think\Request;

class Brand extends Model
{
	protected $table = 'car_brand';
	protected $autoWriteTimestamp = true;
	/**
	 * 关联车辆信息表
	 * @author chouchong
	 */
	public function parent(){
		return $this->hasMany('car','bid','id');
	}
}
