<?php
/**
 * 登录记录表模型
 *
 * LoginLog
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-03-07
 * @version v1.0
 */
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class LoginLog extends ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%login_log}}';
    }
}