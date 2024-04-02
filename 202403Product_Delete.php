<?php

$data = file_get_contents("php://input", "r");
    if($data != ""){
        $mydata = array();
        $mydata = json_decode($data, true);
        if(isset($mydata["Id"]) && $mydata["Id"] != ""){
            $p_Id = $mydata["Id"];

            $servername = "localhost";
            $username = "owner01";
            $password = "123456";
            $dbname = "202403";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if(!$conn){
                die("連線失敗".mysqli_connect_error());
            }

            $sql = "DELETE FROM product WHERE Id = '$p_Id'";
            if(mysqli_query($conn, $sql)){
                //刪除成功
                echo '{"state" : true, "message" : "刪除成功!"}';
            }else{
                //刪除失敗
                echo '{"state" : false, "message" : "刪除失敗!"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
        }
    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數!"}';
    }
?>