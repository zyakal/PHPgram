<?php
namespace application\controllers;

use PDO;

class FeedController extends Controller {
    public function index() {
        $this->addAttribute(_JS, ["feed/index"]);
        $this->addAttribute(_CSS, ["feed/index"]);
        $this->addAttribute(_MAIN, $this->getView("feed/index.php"));
        return "template/t1.php";
    }

    public function rest() {       
        switch(getMethod()) {
            case _POST:
                if(!is_array($_FILES) || !isset($_FILES["imgs"])) {
                    return ["result" => 0];
                }
                $iuser = getIuser();
                $param = [
                    "location" => $_POST["location"],
                    "ctnt" => $_POST["ctnt"],
                    "iuser" => $iuser
                ];                
                $ifeed = $this->model->insFeed($param);

                $paramImg = [ "ifeed" => $ifeed ];
                foreach($_FILES["imgs"]["name"] as $key => $originFileNm) {
                                        
                    $saveDirectory = _IMG_PATH . "/feed/" . $ifeed;
                    if(!is_dir($saveDirectory)) {
                        mkdir($saveDirectory, 0777, true);
                    }
                    $tempName = $_FILES['imgs']['tmp_name'][$key];
                    $randomFileNm = getRandomFileNm($originFileNm);
                    if(move_uploaded_file($tempName, $saveDirectory . "/" . $randomFileNm)) {
                        //chmod($saveDirectory . "/test." . $ext, octdec("0666"));
                        //chmod("C:/Apache24/PHPgram/static/img/profile/1/test." . $ext, 0755);
                        $paramImg["img"] = $randomFileNm;
                        $this->model->insFeedImg($paramImg);
                    }

                }
                return ["result" => 1];
            
            
            case _GET:
                $page = 1;
                if(isset($_GET["page"])) {
                    $page = intval($_GET["page"]);
                }
                $startIdx = ($page - 1) * _FEED_ITEM_CNT;
                $param = [
                    "startIdx" => $startIdx,
                    "iuser" => getIuser()
                ];                
                $list= $this->model->selFeedList($param);
                foreach($list as $item){
                    $item->imgList = $this->model->selFeedImgList($item);
                }
                return $list;
        }
    }
}