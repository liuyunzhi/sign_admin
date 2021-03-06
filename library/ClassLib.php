<?php
/**
 * 自定类方法
 *
 * ClassLib
 * @copyright chinamcloud.com
 * @author liuranggang
 * @time 2018-02-01
 * @version v1.0
 */
namespace app\library;

use yii;
use yii\helpers\Json;
use Hprose\Http\Client;

class ClassLib{

    /**
     * 测试打印方法
     * @param string $string
     * @param int $return
     */
    public static function pre( $string = null, $return = 1 ){
        echo '<pre>';
        print_r($string);
        echo '</pre>';
        if($return == 1){
            exit;
        }
    }

    /**
     * 调试日志记录
     * @param unknown $message
     */
    public static function debug_log($message){
        $logfile = yii::$app->basePath . '/runtime/' . date("Ymd") . ".log";
        $time = date("Y-m-d H:i:s", time());
        $fp = @fopen($logfile, 'a');
        @fwrite($fp, $time . "\r\n");
        @fwrite($fp, var_export($message, true) . "\r\n" . "\r\n");
        @fclose($fp);
    }

    /**
     * 系统返回json格式化方法
     * @param int $code
     * @param string $message
     * @param array $params
     */
    public static function exit_json( $code = 0, $params = NULL, $message = '系统错误!' ){
        $data = array('code' =>$code , 'message' => ApiCode::$code[$code], 'params' => $params);
        exit(Json::encode($data));
    }

    /**
     * 生成guid
     * @return string
     */
    public static function guid()
    {
        mt_srand((double)microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $uuid = substr($charid, 0, 8) . substr($charid, 8, 4) . substr($charid, 12, 4) . substr($charid, 16, 4) . substr($charid, 20, 12);
        return $uuid;
    }

    /**
     * curl请求
     * @param string $url
     * @param int $url_type 1http，2https
     * @param int $response_type 请求类型 0为GET，1为POST
     * @param string $params
     * @return string $json
     */
    public static function response_curl( $url = null, $url_type = 1, $response_type = 1, $params = null, $is_header = 0 ){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if($is_header == 1){
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'X-AjaxPro-Method:ShowList',
                    'Content-Type: application/json; charset=utf-8',
                    'Content-Length: ' . strlen($params))
            );
        }else{
            curl_setopt($ch, CURLOPT_HEADER, 0);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        if($response_type == 1){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        if($url_type == 2){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }

        $return_data = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);
        if($curl_errno > 0){
            return "cURL Error ($curl_errno): $curl_error\n";
        }else{
            return $return_data;
        }
    }

    /**
     * 获取UTC时间
     * @param int $num 多少小时后
     * @return strint $time
     */
    public static function get_utc_time( $num = 0, $time = NULL, $type = NULL ){
        $time_data = $time ? $time : time();
        if($num == 0){
            $utc_time = $time_data - 28800;
        }else{
            $utc_time = $time_data - 3600 * (8 + $num);
        }
        if($type == 1){
            $timestamp = (new \DateTime(date("Y-m-d H:i", $utc_time)))->format('Y-m-d\TH:i\Z');
        }else{
            $timestamp = (new \DateTime(date("Y-m-d H:i:s", $utc_time)))->format('Y-m-d\TH:i:s\Z');
        }

        return $timestamp;
    }

    /**
     * UTC时间转换为北京时间
     * @param string $utc_time UTC时间
     * @return string $time
     */
    public static function utc_time_to_now( $utc_time = NULL ){
        if($utc_time != NULL){
            $timestamp = str_replace('T', ' ', $utc_time);
            $timestamp = str_replace('Z', '', $timestamp);
            $timestamp = strtotime($timestamp) + (3600 * 8);
            return ['datetime' => date("Y-m-d H:i:s", $timestamp), 'timestamp' => $timestamp];
        }
        return false;
    }
    /**
     * 秒数转换为时长
     * @param string $second 秒数
     * @param string $time
     */
    public static function second_to_time($second = 0){  
        $result = '00:00:00';  
        if ($second>0) {  
                $hour = floor($second/3600);  
                $minute = floor(($second-3600 * $hour)/60);  
                $second = floor((($second-3600 * $hour) - 60 * $minute) % 60);
                
                $hour = $hour >= 10 ? $hour : '0'.$hour;
                $minute = $minute >= 10 ? $minute : '0'.$minute;
                $second = $second >= 10 ? $second : '0'.$second;
                $result = $hour.':'.$minute.':'.$second;  
        }  
        return $result;  
    }

    /**
     *验证参数
     *@param $template
     * $template=["uid","username","pic","email","note"];
     */
    public static function verify_param($template = null){
        $request = yii::$app->getRequest();
        $request_data = $request->post('params');
        if($request_data == ''){
            self::exit_json(10012);
        }

        $data = Json::decode($request_data, true);
        if(!is_array($data)){
            self::exit_json(10013);
        }
        $template_data = array_flip($template);
        foreach ($data as $key => $value) {
            if ($data["$key"] == "" && $data["$key"] != 0) {
                self::exit_json(10025, ['errorMsg' => $key]);
            }else{
                $res    = array_diff_key($template_data, $data);
                foreach ($res as $ke => $val) {
                    self::exit_json(10026, ['errorMsg' => $ke]);
                }
            }
        }
        return $data;
    }

    /**
     *公用验证POST参数
     *@param $params
     * $params=["uid","username","pic","email","note"];
     */
    public static function verify_post_params($params)
    {
        $request = yii::$app->getRequest();
        if($request->isPost == false){
            ClassLib::exit_json(10001);
        }
        $request_data = $request->post('params');
        if($request_data == ''){
            self::exit_json(10012);
        }

        $data = Json::decode($request_data, true);
        if(!is_array($data)){
            self::exit_json(10009);
        }
        $template_data = array_flip($params);
        foreach ($data as $key => $value) {
            if ($data["$key"] == "" && $data["$key"] != 0) {
                self::exit_json(10010, ['errorMsg' => $key]);
            }else{
                $res    = array_diff_key($template_data, $data);
                foreach ($res as $ke => $val) {
                    self::exit_json(10011, ['errorMsg' => $ke]);
                }
            }
        }
        return $data;
    }

    /**
     * 返回随机数
     * @param type $length 随机数长度
     * @param type $numeric 是否只为数字
     * @return type String
     */
    public static function random( $length, $numeric = 0 ) {
        $string = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '',$seed) . '012340567890') : ($string . 'zZ' . strtoupper($string));
        $hash = '';
        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $seed{mt_rand(0, $max)};
        }
        return $hash;
    }

    /**
     * 根据字节大小返回标准大小
     * @param int $size
     * @return string
     */
    public static function byte_change($size, $type = 0)
    {
        if($type == 1){
            if ($size <= 1024) {
                $num = floor ( $size * 100 ) / 100;
                $ext = "K";
            } else{
                $num = floor( floor ( ($size / 1024) * 100 ) / 100 ) / 800;
                $ext = "minute";
            }
            return floor($num) . " " . $ext;
        }else{
            if ($size <= 1024) {
                $num = floor ( $size * 100 ) / 100;
                $ext = "K";
            } elseif ($size <= 1048576 and $size > 1024) {
                $num = floor ( ($size / 1024) * 100 ) / 100;
                $ext = "KB";
            } elseif ($size <= 1073741824 and $size > 1048576) {
                $num = floor ( ($size / 1048576) * 100 ) / 100;
                $ext = "MB";
            }
            return $num;
        }
    }

    /**
     * 返回dwz_json格式化方法
     * @param int $code
     * @param array $params
     * @return string $json 
     */
    public static function dwz_json( $code_id = 0, $params = array() ){

        $navTabId = "";
        $rel = "";
        $callbackType = "closeCurrent";
        $forwardUrl = "";
        $confirmMsg = "";
        $message = '操作异常！';

        if($params){
            foreach ($params as $key => $value) {
                if($key == 'message'){
                	if(is_int($value)){
                		$message = ApiCode::$code[$value];
                	}else{
                		$message = $value;
                	}
                    
                }elseif($key == 'navTabId'){
                    $navTabId = $value;
                }elseif($key == 'rel'){
                    $rel = $value;
                }elseif($key == 'callbackType'){
                    $callbackType = $value;
                }elseif($key == 'forwardUrl'){
                    $forwardUrl = $value;
                }elseif($key == 'confirmMsg'){
                    $confirmMsg = $value;
                }
            }
        }

        $data = array(
            "statusCode" => $code_id,
            "message" => $message,
            "navTabId" => $navTabId,
            "rel" => $rel,
            "callbackType" => $callbackType,
            "forwardUrl" => $forwardUrl,
            "confirmMsg" => $confirmMsg
        );

        return Json::encode($data);
    }

    /**
     * 生成md5加密串(刘老师用)
     * @param $request_data
     * @param $secret_key
     * @return string
     */
    public static function make_md5_sign($request_data, $secret_key){
        ksort($request_data);
        $stringA = "";
        foreach ($request_data as $k => $value)
        {
            if(is_array($value)){
                $value = self::make_md5_sign($value, $secret_key);
            }
            if(strlen($stringA) > 0)
            {
                $stringA .= "&";
            }
            $stringA .= $k . '=' . $value;
        }
        $stringTemp = $stringA . '&key=' . $secret_key;
        $token = md5($stringTemp);
        return $token;
    }
}