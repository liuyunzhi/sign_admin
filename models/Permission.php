<?php
/**
 * 权限表模型
 *
 * Permission
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Permission extends ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%permission}}';
    }

    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['role_id' => 'role_id'])
            ->viaTable(RolePermission::tableName(), ['permission_id' => 'permission_id']);
    }
}