<?php
/**
 * 后台管理系统-考勤管理
 *
 * SignController
 * 
 * @copyright cdut
 * @author liuyunzhi
 * @time 2018-05-24
 * @version v1.0
 */
namespace app\controllers;

use yii;
use yii\web\Controller;
use app\models\RecordService;
use app\library\ClassLib;
use Hprose\Http\Client;

class SignController extends AuthController{

	/**
	 * 考勤记录
	 */
    public function actionRecords(){
        $request = Yii::$app->getRequest();

		if ($request->isGet) {
			return $this->renderPartial('records');
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
            $record_list = $sign_core_rpc->getRecordList($start / $length, $length, $searching);

			$data = [
				"draw"=> intval($draw),
				"recordsTotal"=> intval($record_list['total']),
				"recordsFiltered"=> intval($record_list['total']),
				"data"=> $record_list['list']
			];

			exit(json_encode($data,JSON_UNESCAPED_UNICODE));
		}
    }

    /**
	 * 编辑考勤记录
	 */
	public function actionEdit(){

		$request = Yii::$app->getRequest();
        
		if ($request->isGet) {
            $id = $request->get('id');
            $result = $request->get('result');
			
			return $this->renderPartial('edit', ['id'=>$id, 'result'=>$result]);
		}
		if ($request->isPost) {
            $id = $request->post('id');
			$result = $request->post('result');
            
            $sign_core_rpc = new Client(yii::$app->params['sign_core_rpc'], false);
			$status = $sign_core_rpc->updateRecord($id, $result);

			if($status){
				ClassLib::exit_json(10000);
			}else{
            	ClassLib::exit_json(99999);
            }
		}
	}
    
}