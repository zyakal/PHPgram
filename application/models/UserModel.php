<?php
namespace application\models;
use PDO;
//$pdo -> lastInsertId();

class UserModel extends Model {
    public function insUser(&$param) {
        $sql = "INSERT INTO t_user
                ( email, pw, nm ) 
                VALUES 
                ( :email, :pw, :nm )";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":email", $param["email"]);
        $stmt->bindValue(":pw", $param["pw"]);
        $stmt->bindValue(":nm", $param["nm"]);
        $stmt->execute();
        return $stmt->rowCount();

    }
    public function selUser(&$param) {
        $sql = "SELECT * FROM t_user
                WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":email", $param["email"]);        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // public function selUserByIuser(&$param) {
    //     $sql = "SELECT iuser, email, nm, cmt, mainimg, regdt 
    //               FROM t_user
    //              WHERE iuser = :iuser";
    //     $stmt = $this->pdo->prepare($sql);
    //     $stmt->bindValue(":iuser", $param["iuser"]);
    //     $stmt->execute();
    //     return $stmt->fetch(PDO::FETCH_OBJ);
    // }

    // public function selUserFollow(&$param){
    //     $sql = "";
    //     $stmt = $this->pdo->prepare($sql);
    //     $stmt->bindValue(":iuser", $param["iuser"]);
    //     $stmt->execute();
    //     return $stmt->fetch(PDO::FETCH_OBJ);
    // }
    
    public function selUserProfile(&$param){
        $feediuser = $param["feediuser"];
        $loginiuser = $param["loginiuser"];
        $sql = "SELECT iuser, email, nm, cmt, mainimg
                ,(SELECT COUNT(ifeed) FROM t_feed WHERE iuser= {$feediuser}) AS feedcnt 
                ,(SELECT COUNT(fromiuser) FROM t_user_follow where fromiuser ={$feediuser} AND toiuser = {$loginiuser}) AS youme
                ,(SELECT COUNT(fromiuser) FROM t_user_follow where fromiuser ={$loginiuser} AND toiuser = {$feediuser}) AS meyou
                ,(SELECT COUNT(toiuser) AS Follower FROM t_user_follow WHERE toiuser={$loginiuser}) AS Follower
                ,(SELECT COUNT(fromiuser) AS Follow FROM t_user_follow WHERE fromiuser={$loginiuser}) AS Follow
                FROM t_user 
                WHERE iuser= {$feediuser}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}