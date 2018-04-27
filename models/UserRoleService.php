<?php
/**
 * 用户角色表管理
 *
 * UserRoleService
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\models;

use Yii;

class UserRoleService{

    /**
     * 删除用户角色关系
     * @param int $id 关系ID
     * @return int 失败次数
     */
    public function deleteUserRole($ids){
    	$user_role_recodes = UserRole::findAll($ids);
    	$failure = 0;
    	
    	foreach ($user_role_recodes as $recode) {
		    $status = $recode->delete();
		    if($status === false){
				$failure++;
			}
		}

        return $failure;
    }
}