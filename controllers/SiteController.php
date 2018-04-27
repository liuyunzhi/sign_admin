<?php
/**
 * 云服务框架后台管理系统-主页管理
 *
 * SiteController
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\controllers;

use Yii;
use app\models\RoleService;
use app\models\LoginLogService;

class SiteController extends AuthController
{

    public function actionIndex() {
        
		$role = new RoleService();
		$permissions = $role->getPermissionInfoById($this->_role['role_id']);

		$admin_info = Array(
            'nickname' => $this->_user['nickname'],
            'role_name' => $this->_role['role_name'],
            'permission_list' => $permissions
        );

		return $this->renderPartial('index', ['admin_info' => $admin_info]);
	}

    /**
     * 概览
     */
    public function actionHome()
    {
        $login_log_model = new LoginLogService();
        $login_logs = $login_log_model->getLoginLogByUserIds($this->_user['user_id']);
        $login_count = count($login_logs);
        if ($login_count <= 1) {
            $last_login_log = [
                'login_ip' => '无记录',
                'login_time' => '无记录',
                'is_first_login' => true
            ];
        } else {
            $last_login_log = $login_logs[1];
        }

        return $this->renderPartial('home', ['last_login_log'=>$last_login_log, 'login_count'=>$login_count]);
    }
}
