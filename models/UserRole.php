<?php
/**
 * 用户角色表模型
 *
 * UserRole
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class UserRole extends ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_role}}';
    }
}