<?php
    //input: {"Username":"XX"}
    // {"state" : true, "message" : "帳號不存在, 可以使用!"}
    // {"state" : false, "message" : "帳號已存在,不可以使用!"}
    // {"state" : false, "message" : "傳遞參數格式錯誤!"}
    // {"state" : false, "message" : "未傳遞任何參數!"}
    
    //file_get_contents函數為用於讀取文件內容，整行為讀取POST請求的數據並儲存在變數$data裡
    $data = file_get_contents("php://input", "r");
    if($data != ""){
        $mydata = array();
        $mydata = json_decode($data, true);
        if(isset($mydata["Username"]) && $mydata["Username"] != "" ){
            $p_Username = $mydata["Username"];

            $servername = "localhost";
            $username = "owner01";
            $password = "123456";
            $dbname = "202403";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if(!$conn){
                die("連線失敗".mysqli_connect_error());
            }
            $sql = "SELECT Username FROM member WHERE Username = '$p_Username'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) == 0){
                echo '{"state" : true, "message" : "帳號不存在, 可以使用!"}';
            }else{
                echo '{"state" : false, "message" : "帳號已存在,不可以使用!"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
        }
    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數!"}';
    }
?>