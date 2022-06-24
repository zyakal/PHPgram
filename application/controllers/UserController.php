<?php
namespace application\controllers;

class UserController extends Controller {
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
                
                $dbdata = $this->model->selUser($param);

                if(!$dbdata){   
                    return "redirect:signin?email={$email}&err";
                } else if(!password_verify($param["pw"], $dbdata->pw)) {
                    return "redirect:signin?email={$email}&err";
                }
                
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


}