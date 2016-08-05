<?php
namespace app\mobile\controller;
use \think\Session;

class Car extends Base
{
	/**
	 * 发布
	 * @author chouchong
	 */
	public function index()
	{
		$this->isCheckMember(getUrl());
		return view('',[
			'brand'=>json_encode(model('brand')->field('id,name')->select()),
			'area'=>json_encode(model('area')->getArea())
		]);
	}
	/**
	 * 添加
	 * @author chouchong
	 */
	public function add()
	{
		if($this->request->isAjax()){
           if(validate('Car')->check(input('post.'))){
           	   if(model('Car')->addCar(input('post.'))){
           	   	  return ['status'=>1];
           	   }
               return ['status'=>-1,'msg'=>'添加失败'];
           }
           return ['status'=>-1,'msg'=>validate('Car')->getError()];
		}
	}
	/**
	 * 删除车辆信息
	 * @author chouchong
	 */
	public function delete()
	{
		if(empty(input('post.id'))){
            return;
		}
        else{
        	if(model('Car')->del(input('post.id'))){
        	   return ['status'=>1,'msg'=>'删除成功'];
        	}else{
        	   return ['status'=>-1,'msg'=>'操作失败，请重试！'];
        	}
        }
	}
}