<?php
/**
 * 角色权限表模型
 *
 * RolePermission
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class RolePermission extends ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%role_permission}}';
    }
}