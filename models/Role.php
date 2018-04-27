<?php
/**
 * 角色表模型
 *
 * Role
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Role extends ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%role}}';
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_id' => 'user_id'])
            ->viaTable(UserRole::tableName(), ['role_id' => 'role_id']);
    }

    public function getPermissions()
    {
        return $this->hasMany(Permission::className(), ['permission_id' => 'permission_id'])
            ->viaTable(RolePermission::tableName(), ['role_id' => 'role_id']);
    }
}