<?php
function getJson(){ //json형태의 자료를 PHP에서 받아올때 써야함, json이 문자열이기에 배열,객체 형태로 반환해줌
    return json_decode(file_get_contents('php://input'), true);
}

    function getUrl() {
        return isset($_GET['url']) ? rtrim($_GET['url'], '/') : "";
    }
    function getUrlPaths() {
        $getUrl = getUrl();        
        return $getUrl !== "" ? explode('/', $getUrl) : "";
    }

    function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    function isGetOne() {
        $urlPaths = getUrlPaths();
        if(isset($urlPaths[2])) { //one
            return $urlPaths[2];
        }
        return false;
    }

    function getParam($key) {
        return isset($_GET[$key]) ? $_GET[$key] : "";
    }   
