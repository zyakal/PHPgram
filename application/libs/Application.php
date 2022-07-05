<?php
namespace application\libs;

require_once "application/utils/UrlUtils.php";
require_once "application/utils/SessionUtils.php";
require_once "application/utils/FileUtils.php";

class Application{
    
    public $controller;
    public $action;
    private static $modelList = []; // static을 사용하면 안되는 경우 -> 
    //1. 객체의 멤버필드를 사용할 때 그 멤버필드에 static이 안붙어있는 경우 객체에 static을 붙일 수 없다
    //2. 멤버필드의 값이 변경이 필요할 경우 static을 쓰면 안된다. 새로운 객체를 생성할때마다 
    //   static이 있는 경우엔 새로운 멤버필드를 생성하지 않고 그대로 사용하기 때문

    public function __construct() {        
        $urlPaths = getUrlPaths();
        $controller = isset($urlPaths[0]) && $urlPaths[0] != '' ? $urlPaths[0] : 'board';
        $action = isset($urlPaths[1]) && $urlPaths[1] != '' ? $urlPaths[1] : 'index';

        if (!file_exists('application/controllers/'. $controller .'Controller.php')) {
            echo "해당 컨트롤러가 존재하지 않습니다.";
            exit();
        }

        $controllerName = 'application\controllers\\' . $controller . 'controller';                
        $model = $this->getModel($controller);
        new $controllerName($action, $model); //컨트롤러 객체 생성
    }

    public static function getModel($key) {
        if(!in_array($key, static::$modelList)) {
            $modelName = 'application\models\\' . $key . 'model';
            static::$modelList[$key] = new $modelName(); //모델 객체 생성
        }
        return static::$modelList[$key];
    }
}