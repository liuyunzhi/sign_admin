<?php
/**
 * 权限表管理
 *
 * PermissionService
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\models;

use Yii;

class PermissionService{

    /**
     * 获取权限列表
     * 
     * @param int $type 权限类型
     * @return array 权限列表
     */
    public function getPermissionList($type = null) {

        if (is_null($type)) {
            $permissions = Permission::find();
        } else {
            $permissions = Permission::find()->where(['type' => $type]);
        }

        $permissions_array = $permissions->orderBy('order ASC')->asArray()->all();

        return $permissions_array;
    }

    /**
     * 根据ID获取权限信息
     * 
     * @param array $permission_ids 权限ID
     * @return array 权限信息
     */
    public function getPermissionInfoByIds( $permission_ids = null ) {

        if (empty($permission_ids)) {
            $permissions = Permission::find();
        } else {
            $permissions = Permission::find()->where(['permission_id' => $permission_ids]);
        }

        $permissions_array = $permissions->orderBy('order asc')->asArray()->all();

        return $permissions_array;
    }

    /**
     * 新增权限
     * 
     * @param string $order 权限编号
     * @param string $name 权限名称
     * @param int $type 类型
     * @param string $icon 图标
     * @param string $controller 控制器名
     * @param string $action 动作名
     * @return boolean 是否成功
     */
    public function addPermission($order, $name, $type, $icon, $controller = null, $action = null, $parent_id = null){
        
        $permission = new Permission();
        $permission->order = $order;
        $permission->name = $name;
        $permission->type = $type;
        $permission->icon = $icon;
        $permission->parent_id = $parent_id;
        $permission->controller = $controller;
        $permission->action = $action;
        $permission->status = 1;
        $permission->created_at = date('Y-m-d H:i:s');
        $permission->updated_at = date('Y-m-d H:i:s');

        if ($permission->save()) {
            $role = Role::findOne(1);
            $permission->link('roles',$role,['created_at'=>date('Y-m-d H:i:s')]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 更新权限
     * 
     * @param int $id 权限ID
     * @param string $name 权限名称
     * @return boolean 是否成功
     */
    public function updatePermission($id, $name, $icon, $controller, $action){
        
        $permission = Permission::findOne($id);
        $permission->name = $name;
        $permission->icon = $icon;
        $permission->controller = $controller;
        $permission->action = $action;
        $permission->updated_at = date('Y-m-d H:i:s');

        return $permission->save();
    }

    /**
     * 启停权限
     * 
     * @param int $id 权限ID
     * @param int $status 权限状态
     * @return boolean 是否成功
     */
    public function startStopPermission($id, $status){
        $permission = Permission::findOne($id);
        $permission->status = $status;
        $permission->updated_at = date('Y-m-d H:i:s');

        if ($permission->type == 0) {
            $children_permissions = Permission::find()->where(['parent_id' => $permission->permission_id])->all();
            foreach($children_permissions as $value) {
                $value->status = $status;
                $value->updated_at = date('Y-m-d H:i:s');
                $value->save();
            }
        }

        return $permission->save();
    }

    /**
     * 删除权限
     * 
     * @param int $id 权限ID
     * @return boolean 是否成功
     */
    public function deletePermission($id){

        $permission_data = Permission::findOne($id);
        
        return $permission_data->delete();
    }

}