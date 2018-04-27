<?php
/**
 * 角色表管理
 *
 * RoleService
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\db\Exception;

class RoleService{

    /**
     * 按条件查找角色
     * [
     *  'role_id' => ,
     *  'role_name' => ,
     *  'created_date' => ['start' => ,'end' => ],
     *  'update_date' => ['start' => ,'end' => ]
     * ]
     * 按需添加
     * 
     * @param array $search_array 查找条件
     * @return object Query对象
     */
    public static function searchRoles($search_array) {

        if (empty($search_array)) {
            return array();
        } else {
            $roles = Role::find();
            foreach ($search_array as $key => $value) {
                switch ($key) {
                    case 'role_id':
                        $roles->andWhere(['role_id'=>$value]);
                        break;
                    case 'role_name':
                        $roles->andWhere(['like','role_name',$value]);
                        break;
                    case 'created_date':
                        $roles->andWhere(['between','created_at',$value['start'],$value['end']]);
                        break;
                    case 'update_date':
                        $roles->andWhere(['between','update_at',$value['start'],$value['end']]);
                        break;
                }
            }
        }

        return $roles;
    }

	/**
     * 获取角色列表
     * 
     * @param int $page 页码
     * @param int $page_size 每页大小
     * @param array $searching 检索条件
     * @return array 角色列表
     */
    public function getRoleList( $page, $page_size, $searching ) {

        if (empty($searching)) {
            $roles = Role::find();
        } else {
            $roles = self::searchRoles($searching);
        }

		$roles_count = $roles->count();
		$Pagination = new Pagination(['totalCount' => $roles_count]);
        $Pagination->SetPageSize($page_size);
        $Pagination->SetPage($page);
        $roles_array = $roles->offset($Pagination->offset)->limit($Pagination->limit)->orderBy('role_id asc')->asArray()->all();

		$result = [
            'total' => $roles_count,
            'page_size' => $page_size,
            'page' => $page,
            'list' => $roles_array
        ];

        return $result;
    }

	/**
     * 根据ID获取角色信息
     * 
     * @param array $role_ids 角色ID
     * @return array 角色信息
     */
    public function getRoleInfoByIds( $role_ids = null ) {

        if (empty($role_ids)) {
            $roles = Role::find();
        } else {
            $roles = self::searchRoles(['role_id' => $role_ids]);
        }

        $roles_array = $roles->orderBy('role_id asc')->asArray()->all();

        return $roles_array;
    }

	/**
     * 根据ID获取用户信息
     * 
     * @param array $role_id 角色ID
     * @return array 角色信息
     */
    public function getUserInfoById( $role_id ) {

        $users = Role::findOne($role_id)->users;

        $users_data = array();
        foreach ($users as $user) {
            $users_data[] = [
                'user_id' => $user->user_id,
                'user_name' => $user->user_name,
                'nickname' => $user->nickname,
                'user_status' => $user->user_status,
                'gender' => $user->gender,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ];
        }

        return $users_data;
    }

	/**
     * 根据ID获取权限信息
     * 
     * @param array $role_id 角色ID
     * @return array 权限信息
     */
    public function getPermissionInfoById( $role_id ) {

        $permissions = Role::findOne($role_id)->getPermissions()->orderBy('order ASC')->all();

        $permissions_data = array();
        foreach ($permissions as $permission) {
            $permissions_data[] = $permission->attributes;
        }

        return $permissions_data;
    }

    /**
     * 新增角色
     * 
     * @param string $role_name 角色名
     * @return boolean 是否成功
     */
    public function addRole($role_name){

        $role = new Role();
        $role->role_name = $role_name;
        $role->created_at = date('Y-m-d H:i:s');
        $role->updated_at = date('Y-m-d H:i:s');

        return $role->save();
    }

    /**
     * 更新角色
     * 
     * @param int $id 角色ID
     * @param string $role_name 角色名
     * @return boolean 是否成功
     */
    public function updateRole($id, $role_name){

        $role_data = Role::findOne($id);

        $role_data->role_name = $role_name;
        $role_data->updated_at = date('Y-m-d H:i:s');  
        
        return $role_data->save();
    }

    /**
     * 删除角色
     * 
     * @param int $id 角色ID
     * @return boolean 是否成功
     */
    public function deleteRole($id){
        
        try{
            $role_data = Role::findOne($id);

            return $role_data->delete();
        }catch(Exception $e){
            return $e->errorInfo;
        }
    }
}