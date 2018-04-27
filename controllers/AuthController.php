<?php
/**
 * 云服务框架后台管理系统-后台登录认证管理
 *
 * AuthController
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\controllers;

use yii;
use yii\web\Controller;

class AuthController extends Controller{

    //用户
    protected $_user;
    //用户角色
    protected $_role;

	/**
     * 每次请求验证，框架级
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * 每次响应前验证，框架级
     */
    public function beforeAction($action){

        if (!parent::beforeAction($action)) {
            return false;
        }
        
        if (Yii::$app->user->isGuest) {
            if(Yii::$app->request->isAjax){
                return $this->redirect('/login/login');
            }
            exit('<script>top.location.href="/login/login"</script>');
        }else{
            $this->_user = Yii::$app->user->identity;
            $this->_role = $this->_user->role->attributes;
            return true;
        }
    }
}