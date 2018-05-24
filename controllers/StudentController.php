<?php
/**
 * 后台管理系统-学生管理
 *
 * StudentController
 * 
 * @copyright cdut
 * @author liuyunzhi
 * @time 2018-05-24
 * @version v1.0
 */
namespace app\controllers;

use yii;
use yii\web\Controller;
use app\models\studentService;
use app\library\ClassLib;
use Hprose\Http\Client;

class StudentController extends AuthController{

	/**
	 * 学生列表
	 */
    public function actionList(){
        $request = Yii::$app->getRequest();

		if ($request->isGet) {
			return $this->renderPartial('list');
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
            
			$sign_core_rpc = new Client(yii::$app->params['sign_core_rpc'], false);
            $student_list = $sign_core_rpc->getStudentList($start / $length, $length, $searching);

			$data = [
				"draw"=> intval($draw),
				"recordsTotal"=> intval($student_list['total']),
				"recordsFiltered"=> intval($student_list['total']),
				"data"=> $student_list['list']
			];

			exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		}
    }

    /**
	 * 新增学生
	 */
	public function actionAdd(){

		$request = Yii::$app->getRequest();

		if ($request->isGet) {

			return $this->renderPartial('add');
		}
		if ($request->isPost) {
			$student_id = $request->post('student_id');
			$person_id = $request->post('person_id');
			$name = $request->post('name');
			$gender = $request->post('gender');
			$college = $request->post('college');
			$faculty = $request->post('faculty');
			$phone = $request->post('phone');

            $sign_core_rpc = new Client(yii::$app->params['sign_core_rpc'], false);
			$result = $sign_core_rpc->registerStudent($student_id, $person_id, $person_id, $name, $gender, $college, $faculty, $phone);
			
			if ($result) {
				ClassLib::exit_json(10000);
			} else {
            	ClassLib::exit_json(99999);
            }
		}
    }

    /**
	 * 编辑学生
	 */
	public function actionEdit(){

		$request = Yii::$app->getRequest();
		$sign_core_rpc = new Client(yii::$app->params['sign_core_rpc'], false);

		if ($request->isGet) {
			$id = $request->get('id');
			$student_data = $sign_core_rpc->getStudentByIds($id);
			
			return $this->renderPartial('edit', ['student_data' => $student_data[0]]);
		}
		if ($request->isPost) {
			$id = $request->post('id');
			$student_id = $request->post('student_id');
			$college = $request->post('college');
			$faculty = $request->post('faculty');
			$phone = $request->post('phone');

			$status = $sign_core_rpc->updateStudent($id, $student_id, $college, $faculty, $phone);

			if($status){
				ClassLib::exit_json(10000);
			}else{
            	ClassLib::exit_json(99999);
            }
		}
	}
    
    /**
	 * 删除学生
	 */
	public function actionDelete($id){

		$sign_core_rpc = new Client(yii::$app->params['sign_core_rpc'], false);
        $result = $sign_core_rpc->deleteStudent($id);

		if($result){
			ClassLib::exit_json(10000);
		}else{
			ClassLib::exit_json(99999);
		}
	}
}