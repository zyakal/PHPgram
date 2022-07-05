<?php
        // 처음은 Apache에서 설정한 PHPgram/index.php 가 실행, 거기서 config, autoload 불러오고 Apllication 객체 생성
    spl_autoload_register(function ($path) { //$path에는 생성될 객체주소가 담긴다. 
        // 주소창에 localhost/+알파 를 검색한 경우 1차로 application\libs\Application가 담김.
        // 밑에 해당하는 조건이 없으므로 application/libs/Application.php 가 실행
       
        $path = str_replace('\\','/',$path);
        $paths = explode('/', $path);
        if (preg_match('/model/', strtolower($paths[1]))) {
            $className = 'models';
        } else if (preg_match('/controller/',strtolower($paths[1]))) {
            $className = 'controllers';
        } else {
            $className = 'libs';
        }

        $loadpath = $paths[0].'/'.$className.'/'.$paths[2].'.php';
        
       // echo 'autoload $path : ' . $loadpath . '<br>';
        
        if (!file_exists($loadpath)) {
            echo " --- autoload : file not found. ($loadpath) ";
            exit();
        }
        require_once $loadpath;
    });
