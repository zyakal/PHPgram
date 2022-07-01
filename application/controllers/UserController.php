<?php
namespace application\controllers;

class UserController extends Controller {
    //로그인
    public function signin() {
        switch(getMethod()){
            case _GET:
                return "user/signin.php";
            case _POST:

                //아이디, 비번이 하나라도 없거나 틀리면 /user/signin 으로
                $param = [
                    "email" => $_POST["email"],
                    "pw" => $_POST["pw"]
                ];
                $email = $_POST["email"];
                
                $dbUser = $this->model->selUser($param);

                if(!$dbUser){   
                    return "redirect:signin?email={$email}&err";
                } else if(!password_verify($param["pw"], $dbUser->pw)) {
                    return "redirect:signin?email={$email}&err";
                }
                $dbUser->pw = null;
                $dbUser->regdt = null;
                $this->flash(_LOGINUSER, $dbUser);
                return "redirect:/feed/index";
        }
        return "user/signin.php";



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
        $this->addAttribute(_JS, ["user/feedwin", "https://unpkg.com/swiper@8/swiper-bundle.min.js"]);        
        $this->addAttribute(_CSS, ["user/feedwin", "https://unpkg.com/swiper@8/swiper-bundle.min.css"]);        
        $this->addAttribute(_MAIN, $this->getView("user/feedwin.php"));       
        return "template/t1.php"; 
    }
}