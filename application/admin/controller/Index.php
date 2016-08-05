<?php
namespace app\admin\controller;

use \think\Session;

class Index extends Base
{
	public function index()
	{
		return view('index');
	}
}