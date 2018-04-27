<?php
/**
 * 云服务框架后台管理系统-权限管理
 *
 * PermissionController
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\controllers;

use yii;
use app\models\UserService;
use app\models\UserRoleService;
use app\models\PermissionService;
use app\models\RoleService;
use app\models\RolePermissionService;
use app\library\ClassLib;

use yii\web\Controller;

class PermissionController extends AuthController{

	#############################管理员管理#############################
	/**
	 * 管理员列表
	 */
	public function actionAdministrators(){

		$request = Yii::$app->getRequest();

		if ($request->isGet) {
			return $this->renderPartial('administrators');
		}
		if ($request->isAjax) {
			$draw = $request->post('draw');
			$start = $request->post('start');
			$length = $request->post('length');
			$columns = $request->post('columns');
			
			$searching = array();
			foreach ($columns as $value) {
				if ($value['searchable'] && !empty($value['search']['value'])) {
					$searching[$value['data']] = $value['search']['value'];
				}
			}
			
			$user_model = new UserService();
			$user_info = $user_model->getUserList( $start / $length, $length, $searching);
			
			$data = [
				"draw"=> intval($draw),
				"recordsTotal"=> intval($user_info['total']),
				"recordsFiltered"=> intval($user_info['total']),
				"data"=> $user_info['list']
			];

			exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		}
	}

	/**
	 * 新增管理员
	 */
	public function actionAdminAdd(){

		$request = Yii::$app->getRequest();
		
		if ($request->isGet) {
			$role_model = new RoleService();
			$role_list = $role_model->getRoleInfoByIds();

			return $this->renderPartial('admin-add', ['role_list'=>$role_list]);
		}
		if ($request->isPost) {
			$admin_name = $request->post('admin_name');
			$nickname = $request->post('nickname');
			$password = $request->post('password');
			$gender = $request->post('gender');
			$role_id = $request->post('role');
			
			$user_model = new UserService();
			$status = $user_model->insertUser($admin_name, $nickname, $password, $gender, $role_id);

			if($status){
				ClassLib::exit_json(10000);
			}else{
            	ClassLib::exit_json(99999);
            }
		}
	}

	/**
	 * 编辑管理员
	 */
	public function actionAdminEdit(){

		$request = Yii::$app->getRequest();
		
		if ($request->isGet) {
			$id = $request->get('id');
			$nickname = $request->get('nickname');
			$role_id = $request->get('role_id');
			
			$role_model = new RoleService();
			$role_list = $role_model->getRoleInfoByIds();
			
			return $this->renderPartial('admin-edit', ['id'=>$id, 'nickname'=>$nickname, 'role_id'=>$role_id, 'role_list'=>$role_list]);
		}
		if ($request->isPost) {
			$id = $request->post('id');
			$nickname = $request->post('nickname');
			$password = $request->post('password');
			$role_id = $request->post('role_id');
			
			$user_model = new UserService();
			$result = $user_model->updateUser($id, $nickname, $password, $role_id);

			if ($result) {
				ClassLib::exit_json(10000);
			} else {
            	ClassLib::exit_json(99999);
            }
		}
	}

	/**
	 * 冻结解冻管理员
	 */
	public function actionAdminFrozenThaw(){

		$request = Yii::$app->getRequest();
		$id = $request->post('id');
		$status = $request->post('status');

		$user_model = new userService();
		$result = $user_model->frozenThawUser($id, $status);

		if($result){
			ClassLib::exit_json(10000);
		}else{
			ClassLib::exit_json(99999);
		}
	}

	/**
	 * 删除管理员
	 */
	public function actionAdminDelete($id){

		$user_model =  new UserService();
		$result = $user_model->deleteUser($id);

		if ($result) {
			ClassLib::exit_json(10000);
		} else {
			ClassLib::exit_json(10008);
		}
	}

	#############################角色管理#############################
	/**
	 * 角色列表
	 */
	public function actionRoles(){

		$request = Yii::$app->getRequest();
		
		if ($request->isGet) {
			return $this->renderPartial('roles');
		}
		if ($request->isAjax) {
			$draw = $request->post('draw');
			$start = $request->post('start');
			$length = $request->post('length');
			$columns = $request->post('columns');

			$searching = array();
			foreach ($columns as $value) {
				if ($value['searchable'] && !empty($value['search']['value'])) {
					$searching[$value['data']] = $value['search']['value'];
				}
			}

			$role_model = new RoleService();
			$roles = $role_model->getRoleList($start / $length, $length, $searching);

			$data = [
				"draw"=> intval($draw),
				"recordsTotal"=> intval($roles['total']),
				"recordsFiltered"=> intval($roles['total']),
				"data"=> $roles['list']
			];

			exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		}
		
	}

	/**
	 * 新增角色
	 */
	public function actionRoleAdd(){

		$request = Yii::$app->getRequest();
		
		if ($request->isGet) {
			return $this->renderPartial('role-add');
		}
		if ($request->isPost) {
			$role_name = $request->post('role_name');
			
			$role_model = new RoleService();
			$status = $role_model->addRole($role_name);

			if($status){
				ClassLib::exit_json(10000);
			}else{
            	ClassLib::exit_json(99999);
            }
		}		
	}

	/**
	 * 查看角色
	 */
	public function actionRoleShow(){

		$request = Yii::$app->getRequest();

		if ($request->isGet) {
			$role_id = $request->get('id');

			return $this->renderPartial('role-show',['role_id'=>$role_id]);
		}
		if ($request->isAjax) {
			$draw = $request->post('draw');
			$search = $request->post('search');
			
			$role_model = new RoleService();
			$user_list = $role_model->getUserInfoById($search['value']);

			$data = [
				"draw"=> intval($draw),
				"recordsTotal"=> intval(count($user_list)),
				"recordsFiltered"=> intval(count($user_list)),
				"data"=> $user_list
			];

			exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		}
	}

	/**
	 * 编辑角色
	 */
	public function actionRoleEdit(){
		
		$role_permission_model = new RolePermissionService();
		$request = Yii::$app->getRequest();
		
		if ($request->isGet) {
			$id = $request->get('id');
			$role_name = $request->get('name');
			
			$permission_model = new PermissionService();
			$permission_list = $permission_model->getPermissionInfoByids();

			$permission_ids = $role_permission_model->getPermissionIdsByRoleId($id);
			foreach ($permission_list as &$value) {
				$value['is_checked'] = 'false';
				foreach($permission_ids as $id){
					if($id == $value['permission_id']){
						$value['is_checked'] = 'true';
						break;
					}
				}
			}
			unset($value);

			return $this->renderPartial('role-edit', ['id'=>$id, 'role_name'=>$role_name, 'meun_list'=>$permission_list]);
		}
		if ($request->isPost) {
			$role_id = $request->post('role_id');
			$role_name = $request->post('role_name');
			$current_permissions_id = $request->post('chose_list') ? explode('/',$request->post('chose_list')) : [];

			//修改角色名称
			$role_model = new RoleService();
			$update_role_status = $role_model->updateRole($role_id, $role_name);
			//修改角色权限
			$DB_permissions_id = $role_permission_model->getpermissionIdsByRoleId($role_id);
			$delete_permissions = array_diff($DB_permissions_id, $current_permissions_id);
			if (!empty($delete_permissions)) {
				$delete_status = $role_permission_model->deleteRolePermission(array_keys($delete_permissions));
			} else {
				$delete_status = 0;
			}
			$insert_permissions = array_diff($current_permissions_id, $DB_permissions_id);
			if (!empty($insert_permissions)) {
				$role_permission_array = array();
				foreach($insert_permissions as $value) {
					array_push($role_permission_array, [$role_id, $value, date("Y-m-d H:i:s")]);
				}
				$insert_status = $role_permission_model->insertRolePermission($role_permission_array);
			} else {
				$insert_status = 0;
			}

			if($update_role_status && $delete_status == 0 && $insert_status == count($insert_permissions)){
				ClassLib::exit_json(10000);
			}else{
            	ClassLib::exit_json(99999);
            }
		}
	}

	/**
	 * 删除角色
	 */
	public function actionRoleDelete($id){

		if ($id == 1) {
			ClassLib::exit_json(10008);
		}

		$role_model =  new RoleService();
		$result = $role_model->deleteRole($id);

		if (is_array($result) && $result[1] == 1451) {
			ClassLib::exit_json(10009);
		} elseif ($result) {
			ClassLib::exit_json(10000);
		} else {
			ClassLib::exit_json(99999);
		}
	}

	#############################菜单管理#############################
	/**
	 * 菜单列表
	 */
	public function actionMeuns(){

		$request = Yii::$app->getRequest();
		
		if ($request->isGet) {
			return $this->renderPartial('meuns');
		}
		if ($request->isAjax) {
			$draw = $request->post('draw');

			$meun_model = new PermissionService();
			$meuns = $meun_model->getPermissionList();

			$data = [
				"draw"=> intval($draw),
				"recordsTotal"=> intval(count($meuns)),
				"recordsFiltered"=> intval(count($meuns)),
				"data"=> $meuns
			];

			exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		}
	}

	/**
	 * 新增菜单
	 */
	public function actionMeunAdd(){

		$request = Yii::$app->getRequest();
		$permission_model = new PermissionService();

		if ($request->isGet) {
			$parent_permission = $permission_model->getPermissionList(0);

			return $this->renderPartial('meun-add', ['parent_permission' => $parent_permission]);
		}
		if ($request->isPost) {
			$meun_name = $request->post('meun_name');
			$parent_id = $request->post('parent_id');
			$order = $request->post('order');
			$icon = $request->post('icon') ? '&#xe'.$request->post('icon').';' : '&#xe667;';
			$controller = $request->post('controller');
			$action = $request->post('action');

			if ($parent_id == '0') {
				$result = $permission_model->addPermission($order, $meun_name, 0, $icon);
			} else {
				$result = $permission_model->addPermission($order, $meun_name, 1, null, $controller, $action, $parent_id);
			}
			
			if ($result) {
				ClassLib::exit_json(10000);
			} else {
            	ClassLib::exit_json(99999);
            }
		}
	}

	/**
	 * 编辑菜单
	 */
	public function actionMeunEdit(){

		$request = Yii::$app->getRequest();
		$permission_model = new PermissionService();

		if ($request->isGet) {
			$id = $request->get('id');
			$permission_data = $permission_model->getPermissionInfoByids($id);
			// $parent_permission = $permission_model->getPermissionList(0);
			$parent_permission = [];
			
			return $this->renderPartial('meun-edit', ['permission_data' => $permission_data[0], 'parent_permission'=>$parent_permission]);
		}
		if ($request->isPost) {
			$id = $request->post('permission_id');
			$name = $request->post('meun_name');
			$controller = $request->post('controller') ? $request->post('controller') : null;
			$action = $request->post('action') ? $request->post('action') : null;
			$icon = $request->post('icon') ? '&#xe'.$request->post('icon').';' : null;

			$status = $permission_model->updatePermission($id, $name, $icon, $controller, $action);

			if($status){
				ClassLib::exit_json(10000);
			}else{
            	ClassLib::exit_json(99999);
            }
		}
	}

	/**
	 * 启停菜单
	 */
	public function actionMeunStartStop(){

		$request = Yii::$app->getRequest();
		$id = $request->post('id');
		$status = $request->post('status');

		$permission_model = new permissionService();
		$result = $permission_model->startStopPermission($id, $status);

		if($result){
			ClassLib::exit_json(10000);
		}else{
			ClassLib::exit_json(99999);
		}
	}

	/**
	 * 删除菜单
	 */
	public function actionMeunDelete($id){

		$permission_model =  new permissionService();
		$result = $permission_model->deletePermission($id);

		if($result){
			ClassLib::exit_json(10000);
		}else{
			ClassLib::exit_json(99999);
		}
	}
}