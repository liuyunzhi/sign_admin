<?php
/**
 * 用户表管理
 *
 * UserService
 * 
 * @copyright chinamcloud.com
 * @author liuyunzhi
 * @time 2018-02-12
 * @version v1.0
 */
namespace app\models;

use Yii;
use yii\data\Pagination;

class UserService{

    /**
     * 按条件查找用户
     * [
     *  'user_id' => ,
     *  'user_name' => ,
     *  'nickname' => ,
     *  'created_date' => ['start' => ,'end' => ],
     *  'update_date' => ['start' => ,'end' => ]
     * ]
     * 按需添加
     * 
     * @param array $search_array 查找条件
     * @return object Query对象
     */
    public static function searchUsers($search_array) {

        if (empty($search_array)) {
            return array();
        } else {
            $users = User::find();
            foreach ($search_array as $key => $value) {
                switch ($key) {
                    case 'user_id':
                        $users->andWhere(['user_id'=>$value]);
                        break;
                    case 'user_name':
                        $users->andWhere(['like','user_name',$value]);
                        break;
                    case 'nickname':
                        $users->andWhere(['like','nickname',$value]);
                        break;
                    case 'created_date':
                        $users->andWhere(['between','created_at',$value['start'],$value['end']]);
                        break;
                    case 'update_date':
                        $users->andWhere(['between','update_at',$value['start'],$value['end']]);
                        break;
                }
            }
        }

        return $users;
    }

    /**
     * 获取角色列表
     * 
     * @param int $page 页码
     * @param int $page_size 每页大小
     * @param array $searching 检索条件
     * @return array 角色列表
     */
    public function getUserList( $page, $page_size, $searching ) {

        if (empty($searching)) {
            $users = User::find();
        } else {
            $users = self::searchUsers($searching);
        }

		$users_count = $users->count();
		$Pagination = new Pagination(['totalCount' => $users_count]);
        $Pagination->SetPageSize($page_size);
        $Pagination->SetPage($page);
        $users_array = $users->offset($Pagination->offset)->limit($Pagination->limit)->orderBy('user_id asc')->all();

        $list = array();
        foreach ($users_array as $user) {
            $list[] = [
            	'user_id' => $user->user_id,
            	'user_name' => $user->user_name,
                'nickname' => $user->nickname,
                'role_id' => $user->role->role_id,
                'role_name' => $user->role->role_name,
            	'gender' => $user->gender,
            	'user_status' => $user->user_status,
            	'created_at' => $user->created_at,
            	'updated_at' => $user->updated_at
            ];
        }

		$result = [
            'total' => $users_count,
            'page_size' => $page_size,
            'page' => $page,
            'list' => $list
        ];

        return $result;
    }

	/**
     * 根据ID获取用户信息
     * 
     * @param array|int $user_ids 用户ID
     * @return array 用户信息
     */
    public function getUserInfoByIds( $user_ids = null ){
        
        if (empty($user_ids)) {
            $users = User::find();
        } else {
            $users = self::searchUsers(['user_id' => $user_ids]);
        }

        $users_data = $users->orderBy('user_id asc')->all();

        $result = array();
        foreach ($users_data as $user) {
            $result[] = [
            	'user_id' => $user->user_id,
            	'user_name' => $user->user_name,
                'nickname' => $user->nickname,
                'role_id' => $user->role->role_id,
                'role_name' => $user->role->role_name,
            	'gender' => $user->gender,
            	'user_status' => $user->user_status,
            	'created_at' => $user->created_at,
            	'updated_at' => $user->updated_at
            ];
        }
		
        return $result;
    }

    /**
     * 新增用户
     * 
     * @param string $user_name 用户名
     * @param string $nickname 昵称
     * @param string $password 密码
     * @param int $gender 性别
     * @param int $role_id 用户角色ID
     * @return boolean 是否成功
     */
    public function insertUser($user_name, $nickname, $passwork, $gender, $role_id){
        
        $user = new User();
    	$user->user_name = $user_name;
    	$user->nickname = $nickname;
    	$user->gender = $gender;
    	$user->user_status = 1;
    	$user->created_at = date('Y-m-d H:i:s');
    	$user->updated_at = date('Y-m-d H:i:s');
        $user->setPassword($passwork);
        
    	if ($user->save()) {
            $role = Role::findOne($role_id);
            $user->link('role',$role,['created_at'=>date('Y-m-d H:i:s')]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 更新用户
     * 
     * @param int $id 用户ID
     * @param string $nickname 昵称
     * @param string $password 密码
     * @param int $role_id 用户角色ID
     * @return boolean 是否成功
     */
    public function updateUser($id, $nickname, $passwork, $role_id){
        
    	$user = User::findOne($id);
		$user->nickname = $nickname;
		if (!empty($passwork)) {
			$user->setPassword($passwork);
		}
        $user->updated_at = date('Y-m-d H:i:s');
        
    	if ($user->save()) {
            $user_role = UserRole::findOne(['user_id'=>$id]);
            $user_role->role_id = $role_id;
            return $user_role->save();
        } else {
            return false;
        }
    }

    /**
     * 冻结解冻用户
     * 
     * @param int $id 用户ID
     * @param int $status 用户状态
     * @return boolean 是否成功
     */
    public function frozenThawUser($id, $status){
        
        $user = User::findOne($id);
        $user->user_status = $status;
        $user->updated_at = date('Y-m-d H:i:s');

        return $user->save();
    }

    /**
     * 删除用户
     * 
     * @param int $id 用户ID
     * @return boolean 是否成功
     */
    public function deleteUser($id){
        
    	$user = User::findOne($id);
        if ($user->role->role_id == 1) {
            return false;
        } else {
            return $user->delete();
        }
    }
}