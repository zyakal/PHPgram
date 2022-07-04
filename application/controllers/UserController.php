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
                $startIdx = ($page - 1) * _FEED_ITEM_CNT;
                $param = [
                    "startIdx" => $startIdx,
                    "iuser" => $_GET["iuser"]
                ];        
                $list= $this->model->selFeedList($param);
                foreach($list as $item){
                    $item->imgList = Application::getModel("feed")->selFeedImgList($item);
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
}