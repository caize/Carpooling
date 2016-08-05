<?php
namespace app\common\model;

use think\Model;

class Area extends Model
{
	protected $autoWriteTimestamp = false;
	
	/**
	 * 获取城市
	 * @author chouchong
	 */
	public function getArea()
	{
		return $this->where(['parent_id'=>530000])->select();
	}
}
