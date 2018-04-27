<?php
/**
 * 云服务框架后台管理系统-登录认证
 *
 * LoginController
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\controllers;

use yii;
use yii\web\Controller;
use app\models\User;
use app\models\LoginLogService;

class LoginController extends Controller{

	public $username;
    public $password;

    private $_user;
	
    /**
     * 每次请求验证，框架级
     * @var bool
     */
    public $enableCsrfValidation = false;

	public function actionLogin(){
		$model = new User();
		$request = Yii::$app->getRequest();

		if($request->isGet){
			return $this->renderPartial('login');
		}
		if($request->isPost){
			$this->username = $request->post('account');
			$this->password = $request->post('password');
			$user = $this->getUser();
			if(!$user || !$user->validatePassword($this->password)){
				return '{"code":"0","messege":"登录失败，输入账号或密码有误！"}';
			}elseif(!$user->validateStatus()){
				return '{"code":"0","messege":"登录失败，此账号已被冻结！"}';
			}else{
				Yii::$app->user->login($user);
				LoginLogService::insertLoginLog($user['user_id'], $_SERVER['REMOTE_ADDR']);
				return '{"code":"200","messege":"登陆成功<br/><br/>欢迎回来"}';
			}
		}
	}

	public function actionLogout(){
        Yii::$app->user->logout();

        return $this->redirect('login');
    }

	/**
     * 根据 user_name 查询身份。
     *
     * @return User|null
     */
    protected function getUser(){
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
	}
}