<?php
namespace app\admin\controller;

use \think\Config;
use \think\Controller;

class Base extends Controller
{

	public function __construct()
	{
		parent::__construct();
		defined('STATIC_PATH') or define('STATIC_PATH', dirname(ROOT_PATH) . DS . 'static');

		Config::set('default_return_type','json');
		$this->isUser();

		$module = $this->request->module();
		$controller = $this->request->controller();
		$action = $this->request->action();

		$activeRouter = $module.'/'.$controller.'/'.$action;
		$this->getIsBar($activeRouter);
		$this->assign('uri', $activeRouter);
		$this->assign('userInfo', session('userInfo.username'));
		$this->getBreadcrumb();
		$this->getAuth();
	}

	/**
	 * 判断用户登录
	 * @author chouchong
	 */
	protected function isUser()
	{
		if(session('userInfo.id') == null){
			$this->redirect(url('/admin/login'));
		}
	}
	/**
     * 获取菜单
     * @author chouchong
     */
    protected function getBreadcrumb()
    {
        $ruleData = model('Rule')->getMenusByRoleId(session('userInfo.role_id'));
        $this->assign('navBar', $ruleData);
    }
    /**
     * 获取用户的权限
     * @author chouchong
     */
    protected function getAuth()
    {
        $rule = array_column(model('Rule')->getRulesByRoleId(session('userInfo.role_id')), 'id');
        $this->assign('auth', $rule);
    }
    /**
     * 获取菜单
     * @author chouchong
     */
    protected function getIsBar($activeRouter)
    {
    	$pid1 = db('rule')->field('id,name,title,parent_id')->where('name',$activeRouter)->find();
		$pid2 = db('rule')->field('id,name,title,parent_id')->where('id',$pid1['parent_id'])->find();
		$this->assign('pid1', $pid1['parent_id']);
		$this->assign('pid2', $pid2['parent_id']);
    }
}