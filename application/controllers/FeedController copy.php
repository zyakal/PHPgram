<?php
namespace application\controllers;

class FeedController extends Controller {
    public function index(){
        $this->addAttribute(_JS, ["feed/index"]);
        $this->addAttribute(_MAIN, $this->getView("feed/index.php"));
        return "template/t1.php";
    }

    public function rest(){        
        switch(getMethod()){
            case _POST:                 
                if(!is_array($_FILES)|| !isset($_FILES["imgs"])){
                    return ["result" => 0];
                }
                $iuser =  getIuser();
                // insFeed 메소드 호출하고 리턴값 받은 다음
                // $result = 호출;
                $param = [
                    "location" => $_POST["location"],
                    "ctnt" => $_POST["ctnt"],
                    "iuser" => $iuser
                ];
                
                
                $ifeed = $this->model->insFeed($param);              
                foreach($_FILES["imgs"]["name"] as $key => $value){                                           
                    
                    // $file_name[count($file_name)-1]; //확장자1
                    //확장자2
                    $saveDirec = _IMG_PATH . "/feed/" . $ifeed;                                    
                    if(!is_dir($saveDirec)){
                        mkdir($saveDirec, 0777, true);
                    }
                    $tempName = $_FILES['imgs']['tmp_name'][$key];   
                    $randomFileNm = getRandomFileNm($value);
                    move_uploaded_file($tempName, $saveDirec . "/" . $randomFileNm);
                 
                    // $param2 = [
                    //     "ifeed" => $ifeed,
                    //     "img" => "$randomFileNm." . $ext
                    // ];
                    // $this->model->insImgFeed($param2);
                }

                
                return ["result2" => $tempName];
               
        }
    }
}
