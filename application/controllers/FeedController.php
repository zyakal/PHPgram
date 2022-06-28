<?php

namespace application\controllers;

class FeedController extends Controller
{
    public function index()
    {
        $this->addAttribute(_JS, ["feed/index"]);
        $this->addAttribute(_MAIN, $this->getView("feed/index.php"));
        return "template/t1.php";

        return "feed/index.php";
    }

    public function rest()
    {
        // print "method:" . getMethod() . "<br>";
        // print getIuser();
        // if (is_array($_FILES)) {
        //     foreach ($_FILES['imgs']['name'] as $key => $value) {
        //         print "key: {$key}, value: {$value} <br>";
        //     }
        // }
        // // $countfiles = count($_FILES['imgs']['']);
        // print "ctnt: " . $_POST["ctnt"] . "<br>";
        // print "location : " . $_POST["location"] . "<br>";
        switch (getMethod()) {
            case _POST:
                //insFeed 메소드 호출하고 리턴값 받은다음 $result=호출;
                // session_start();
                // $loginuser = $_SESSION[_LOGINUSER];

                if (!is_array($_FILES) || !isset($_FILES["imgs"])) {
                    return ["result" => 0];
                }
                $iuser = getIuser();
                $param = [
                    "location" => $_POST["location"],
                    "ctnt" => $_POST["ctnt"],
                    "iuser" => $iuser
                ];

                $ifeed = $this->model->insFeed($param);

                foreach ($_FILES["imgs"]["name"] as $key => $orginFileNm) {
                    $saveDirectory = _IMG_PATH . "/feed/" . $ifeed;
                    if (!is_dir($saveDirectory)) {
                        mkdir($saveDirectory, 0777, true);
                    }
                    $tempName = $_FILES["imgs"]["tmp_name"][$key];
                    $randomFileNm = getRandomFileNm($orginFileNm);
                    if(move_uploaded_file($tempName, $saveDirectory . "/" . $randomFileNm)){
                      $param = [
                        "ifeed" => $ifeed,
                        "img" => $randomFileNm,
                      ];
                      $this->model->insFeedImg($param);
                    }
                }

                return ["result" => 1];
        }
    }
}