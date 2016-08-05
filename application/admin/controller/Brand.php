<?php
namespace app\admin\controller;


class Brand extends Base
{

	/**
	 * 车辆品牌列表
	 * @author chouchong
	 */
	public function index()
	{
      return view('',['brand'=>model('brand')->paginate()]);
	}
	/**
	 * 添加品牌
	 * @author chouchong
	 */
	public function add()
	{
		if($this->request->isAjax()){
		  if(validate('Brand')->check(input('post.'))){
             $brand = model('brand')->save(input('post.'));
             return ['status'=>$brand];
		  }
		  return ['status'=>-1,'msg'=>validate('Brand')->getError()];
		}
	    return view();
	}
	/**
	 * 编辑品牌
	 * @author chouchong
	 */
	public function edit()
	{
		if($this->request->isAjax()){
		  if(validate('Brand')->scene('edit')->check(input('post.'))){
             $brand = model('brand')->save(input('post.'),['id'=>input('post.id')]);
             return ['status'=>$brand];
		  }
		  return ['status'=>-1,'msg'=>validate('Brand')->scene('edit')->getError()];
		}
	    return view('',['brand'=>model('brand')->find(input('id'))]);
	}
	/**
	 * 编辑品牌
	 * @author chouchong
	 */
	public function delete()
	{
		if(empty(input('id'))){
            return;
		}
        if(model('brand')->find(input('id'))->parent()->count()>0){
        	return ['status'=>-1,'msg'=>'请先删除该品牌下面的车辆信息'];
        }
        else{
        	if(model('brand')->where('id',input('id'))->delete()){
        	   return ['status'=>1,'msg'=>'删除成功'];	
        	}
        	return ['status'=>-1,'msg'=>'操作失败，请重试！'];
        }
	}
}
