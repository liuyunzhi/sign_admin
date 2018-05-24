<?php
/**
 * 云服务框架后台管理系统-公共资源管理
 *
 * CommonController
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\controllers;

use yii;

class CommonController extends AuthController{
	
	/**
	 * 系统标准图标
	 */
	public function actionIcon(){
        return $this->renderPartial('icon');
	}
	
	/**
	 * 地图
	 */
	public function actionMap() {
		return $this->renderPartial('map');
	}
}