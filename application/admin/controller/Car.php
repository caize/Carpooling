<?php
namespace app\admin\controller;

class Car extends Base
{

	/**
	 * 车辆列表
	 * @author chouchong
	 */
	public function index()
	{
      return view('',['car'=>model('car')->order('id desc')->paginate()]);
	}
	/**
	 * 添加车辆信息
	 * @author chouchong
	 */
	public function add()
	{
		if($this->request->isAjax()){
           if(validate('Car')->check(input('post.'))){
           	   if(model('Car')->add(input('post.'))){
           	   	  return ['status'=>1];
           	   }
               return ['status'=>-1,'msg'=>'添加失败'];
           }
           return ['status'=>-1,'msg'=>validate('Car')->getError()];
		}
	    return view('',['brand'=>model('brand')->select(),'city'=>model('Area')->getArea()]);
	}
	/**
	 * 编辑车辆
	 * @author chouchong
	 */
	public function edit()
	{
		if($this->request->isAjax()){
           if(validate('Car')->check(input('post.'))){
           	   if(model('Car')->edit(input('post.'))){
           	   	  return ['status'=>1];
           	   }
               return ['status'=>-1,'msg'=>'添加失败'];
           }
           return ['status'=>-2,'msg'=>validate('Car')->getError()];
		}
	    return view('',[
	    	'car'=>model('car')->getCar(input('param.id')),
	    	'brand'=>model('brand')->select(),
	    	'city'=>model('Area')->getArea()
	    ]);
	}
	/**
	 * 审核车辆
	 * @author chouchong
	 */
	public function checkCar()
	{
		if($this->request->isAjax()){
           	if(model('Car')->where('id',input('post.id'))->update(input('post.'))){
           	   	return ['status'=>1];
           	}
            return ['status'=>-1,'msg'=>'审核失败'];
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
