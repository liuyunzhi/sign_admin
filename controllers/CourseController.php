<?php
/**
 * 后台管理系统-课程管理
 *
 * CourseController
 * 
 * @copyright cdut
 * @author liuyunzhi
 * @time 2018-05-24
 * @version v1.0
 */
namespace app\controllers;

use yii;
use yii\web\Controller;
use app\models\CourseService;
use app\library\ClassLib;
use Hprose\Http\Client;

class CourseController extends AuthController{

	/**
	 * 课程列表
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
            $course_list = $sign_core_rpc->getCourseList('0','3',$searching);

			$data = [
				"draw"=> intval($draw),
				"recordsTotal"=> intval($course_list['total']),
				"recordsFiltered"=> intval($course_list['total']),
				"data"=> $course_list['list']
			];

			exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		}
    }

    /**
	 * 新增课程
	 */
	public function actionAdd(){

		$request = Yii::$app->getRequest();

		if ($request->isGet) {

			return $this->renderPartial('add');
		}
		if ($request->isPost) {
			$name = $request->post('course_name');
			$position = $request->post('course_position');
			$time = $request->post('time');
			$teacher = $request->post('teacher');
			$longitude = $request->post('longitude');
			$latitude = $request->post('latitude');

            $sign_core_rpc = new Client(yii::$app->params['sign_core_rpc'], false);
			$result = $sign_core_rpc->addCourse($name, $position, $longitude, $latitude, $time, $teacher);
			
			if ($result) {
				ClassLib::exit_json(10000);
			} else {
            	ClassLib::exit_json(99999);
            }
		}
    }

    /**
	 * 编辑课程
	 */
	public function actionEdit(){

		$request = Yii::$app->getRequest();
		$sign_core_rpc = new Client(yii::$app->params['sign_core_rpc'], false);

		if ($request->isGet) {
			$id = $request->get('id');
			$course_data = $sign_core_rpc->getCourseByIds($id);
			
			return $this->renderPartial('edit', ['course_data' => $course_data[0]]);
		}
		if ($request->isPost) {
			$id = $request->post('course_id');
			$name = $request->post('meun_name');
			$controller = $request->post('controller') ? $request->post('controller') : null;
			$action = $request->post('action') ? $request->post('action') : null;
			$icon = $request->post('icon') ? '&#xe'.$request->post('icon').';' : null;

			$status = $course_model->updatecourse($id, $name, $icon, $controller, $action);

			if($status){
				ClassLib::exit_json(10000);
			}else{
            	ClassLib::exit_json(99999);
            }
		}
	}
    
    /**
	 * 删除课程
	 */
	public function actionDelete($id){

		$sign_core_rpc = new Client(yii::$app->params['sign_core_rpc'], false);
        $result = $sign_core_rpc->deleteCourse($id);

		if($result){
			ClassLib::exit_json(10000);
		}else{
			ClassLib::exit_json(99999);
		}
	}
}