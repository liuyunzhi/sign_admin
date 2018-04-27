<?php
/**
 * 角色权限表管理
 *
 * RolePermissionService
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\models;

use Yii;

class RolePermissionService{

	/**
     * 获取角色对应的权限ID
     * @param int $role_id 角色id
     * @return array 角色对应的权限ID数组
     */
    public function getPermissionIdsByRoleId($role_id){

        $permissions = RolePermission::find()->select(['id','permission_id'])->where(['role_id' => $role_id])->all();

        $permissions_data = array();
        foreach($permissions as $permission){
            $permissions_data[$permission->id] = $permission->permission_id;
        }

        return $permissions_data;
    }
    /**
     * 新增角色权限记录
     * @param array $role_permission_array 角色权限对应数组
     * @return int 影响的行数
     */
    public function insertRolePermission($role_permission_array){

    	return Yii::$app->db->createCommand()->batchInsert(RolePermission::tableName(),['role_id', 'permission_id', 'created_at'],$role_permission_array)->execute();
    }

    /**
     * 删除角色权限记录
     * @param array $ids 记录id
     * @return int 失败次数
     */
    public function deleteRolePermission($ids){

    	$role_permission_recodes = RolePermission::findAll($ids);
    	$failure = 0;
    	
    	foreach ($role_permission_recodes as $recode) {
		    $status = $recode->delete();
		    if($status === false){
				$failure++;
			}
		}

        return $failure;
    }
}