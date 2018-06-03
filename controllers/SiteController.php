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
use yii\helpers\Json;
use app\models\RoleService;
use app\models\LoginLogService;
use Hprose\Http\Client;

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
    public function actionHome() {
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

        $sign_core_rpc = new Client(yii::$app->params['sign_core_rpc'], false);
        $subjects = $sign_core_rpc->getSubjects();

        $teachers = $sign_core_rpc->getTeachers();
        foreach ($teachers as $teacher) {
            foreach ($subjects as $subject) {
                $rates[$teacher][$subject] = 0;
            }
        }
        $attendance_rates = $sign_core_rpc->getAttendanceRate();
        $course_ids = array_keys($attendance_rates);
        $courses_info = $sign_core_rpc->getCourseByIds($course_ids);
        foreach ($courses_info as $value) {
            $rates[$value['teacher']][$value['name']] = $attendance_rates[$value['id']] * 100;
        }

        foreach ($rates as $key => $value) {
			$series[] = [
				'name'=>$key,
				'data'=>array_values($value)
			];
        }
        
        return $this->renderPartial('home', ['last_login_log'=>$last_login_log, 'login_count'=>$login_count, 'subjects'=>Json::encode($subjects), 'series'=>Json::encode($series)]);
    }
}
