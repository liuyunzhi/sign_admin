<?php
/**
 * 登录记录表管理
 *
 * LoginLogService
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-03-07
 * @version v1.0
 */
namespace app\models;

use Yii;

class LoginLogService{

    /**
     * 新增登录记录信息
     * 
     * @param int $user_id
     * @param string $login_ip
     * @return bool 是否成功
     */
    public static function insertLoginLog( $user_id, $login_ip ) {

        $login_log = new LoginLog();
        $login_log->user_id = $user_id;
        $login_log->login_ip = $login_ip;
        $login_log->login_time = date('Y-m-d H:i:s');
        $login_log->save();
    }

    /**
     * 获取登录记录列表
     * 
     * @param int $page 页码
     * @param int $page_size 每页大小
     * @return array 登录记录列表
     */
    public function getLoginLogList( $page, $page_size ) {

        $login_logs = LoginLog::find();

        $login_logs_count = $login_logs->count();
		$Pagination = new Pagination(['totalCount' => $login_logs_count]);
        $Pagination->SetPageSize($page_size);
        $Pagination->SetPage($page);
        $login_logs_array = $login_logs->offset($Pagination->offset)->limit($Pagination->limit)->orderBy('id asc')->asArray()->all();

		$result = [
            'total' => $login_logs_count,
            'page_size' => $page_size,
            'page' => $page,
            'list' => $login_logs_array
        ];

        return $result;
    }

    /**
     * 根据用户ID获取登录记录信息
     * 
     * @param array $user_ids 用户ID
     * @return array 登录记录信息
     */
    public function getLoginLogByUserIds( $user_ids = null ) {

        if (empty($user_ids)) {
            $login_logs = LoginLog::find();
        } else {
            $login_logs = LoginLog::find()->where(['user_id' => $user_ids]);
        }

        $login_logs_array = $login_logs->orderBy('id desc')->asArray()->all();

        return $login_logs_array;
    }
}