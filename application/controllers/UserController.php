<?php
namespace application\controllers;
use application\libs\Application;

class UserController extends Controller {
    //로그인
    public function signin() {
        switch(getMethod()){
            case _GET:
                return "user/signin.php";
            case _POST:

                //아이디, 비번이 하나라도 없거나 틀리면 /user/signin 으로
                $email = $_POST["email"];
                $pw = $_POST["pw"];
                $param = [ "email" => $email ];
                $dbUser = $this->model->selUser($param);

                if(!$dbUser || !password_verify($pw, $dbUser->pw)) {                                                        
                    return "redirect:signin?email={$email}&err";
                }
                $dbUser->pw = null;
                $dbUser->regdt = null;
                $this->flash(_LOGINUSER, $dbUser);
                return "redirect:/feed/index";
        }

    }

    public function signup() {
        // if(getMethod()===_GET) {
        //     return "user/signup.php";
        // }else if(getMethod()===_POST) {
        //     return "redirect:sighin";
        // }
        switch(getMethod()){
            case _GET:
                return "user/signup.php";
            case _POST:
                $param = [
                "email" => $_POST['email'],
                "pw" => $_POST['pw'],
                "nm" => $_POST['nm']
                ];
                $param["pw"] = password_hash($param["pw"], PASSWORD_BCRYPT);
                $this->model->insUser($param);
                return "redirect:signin";
        }
        
    }

    public function logout(){
        $this->flash(_LOGINUSER);
        return "redirect:/user/signin";
    }

    public function feedwin() {
        $iuser = isset($_GET["iuser"]) ? intval($_GET["iuser"]) : 0;
        $param = [ 
            "feediuser" => $iuser,
            "loginiuser" => getIuser() 
        ];
        $this->addAttribute(_DATA, $this->model->selUserProfile($param));
        $this->addAttribute(_JS, ["user/feedwin", "https://unpkg.com/swiper@8/swiper-bundle.min.js" ]);        
        $this->addAttribute(_CSS, ["user/feedwin", "https://unpkg.com/swiper@8/swiper-bundle.min.css", "feed/index"]);        
        $this->addAttribute(_MAIN, $this->getView("user/feedwin.php"));       
        return "template/t1.php"; 
    }
    public function feed(){
            $page = 1;
                if(isset($_GET["page"])) {
                    $page = intval($_GET["page"]);
                }
                $startIdx = ($page - 1) * $_GET["limit"];
                $param = [
                    "startIdx" => $startIdx,
                    "toiuser" => $_GET["iuser"],
                    "loginiuser" => getIuser(),
                    "limit" => $_GET["limit"]

                ];        
                $list= $this->model->selFeedList($param);
                foreach($list as $item){
                    $param2 = [ "ifeed" => $item->ifeed];
                    $item->imgList = Application::getModel("feed")->selFeedImgList($param2);
                    $item->cmt = Application::getModel("feedcmt")->selFeedCmt($param2);
                }
                return $list;
        
    }

    public function follow(){
        //toIuser
        
        $param = ["fromiuser" => getiuser()];
        
        switch(getMethod()){
            case _POST: //$_REQUEST를 쓰면 get, post구분하지 않고 받는다    
                $json = getJson();  //post로 json을 보낼때는 이렇게 받아야한다.(urlutils참고)
                $param["toiuser"] = $json["toiuser"];                
                return [_RESULT => $this->model->insUserFollow($param)];
            case _DELETE:
                $param["toiuser"] = $_GET["toiuser"];   
                return [_RESULT => $this->model->delUserFollow($param)];
        }
    }
    
    public function profile(){
        switch(getMethod()){
            case _DELETE:
                $loginUser = getLoginUser();
                if($loginUser) {
                    $path = "static/img/profile/{$loginUser->iuser}/{$loginUser->mainimg}";
                    if(file_exists($path) && unlink($path)){
                        $param = [ "iuser" => $loginUser->iuser, "delMainImg" => 1];
                        if($this->model->updUser($param)){
                            $loginUser->mainimg = null;
                            return [_RESULT => 1];
                        }
                    }
                }
                return [_RESULT => 0];
            case _POST:
                $loginUser = getLoginUser();
                $preProfileImg = $loginUser->mainimg;
                
                $paramImg["iuser"] = $loginUser->iuser;
                if(!is_array($_FILES) || !isset($_FILES["imgs"])) {
                    return ["result" => 0];
                }
                
                $saveDirectory = _IMG_PATH . "/profile/" . $loginUser->iuser;
                if(!is_dir($saveDirectory)) {
                    mkdir($saveDirectory, 0777, true);
                }
                $tempName = $_FILES['imgs']['tmp_name'];
                $fileNm = $_FILES["imgs"]["name"];
                $randomFileNm = getRandomFileNm($fileNm);
                $fullDirectory = $saveDirectory . "/" . $randomFileNm;
                
                $preProfileImgDir = $saveDirectory . "/" . $preProfileImg;
                    if(move_uploaded_file($tempName, $fullDirectory)) {
                        if(file_exists($preProfileImgDir)){
                            unlink($preProfileImgDir);
                        }
                        $paramImg["mainimg"] = $randomFileNm;
                        $this->model->updUser($paramImg);
                        $loginUser->mainimg = $randomFileNm;

                    }
                    
                
                return  [_RESULT => $fullDirectory];
        }
    }
}