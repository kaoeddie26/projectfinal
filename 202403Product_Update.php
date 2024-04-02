<?php

$data = file_get_contents("php://input", "r");
if($data != ""){
    $mydata = array();
    $mydata = json_decode($data, true);
    if(isset($mydata["Id"]) && isset($mydata["Product"]) && isset($mydata["Price"]) && isset($mydata["Photo"]) && isset($mydata["Num"]) && isset($mydata["Content"]) && $mydata["Id"] != "" && $mydata["Product"] != "" && $mydata["Photo"] != "" && $mydata["Price"] != "" && $mydata["Content"] != "" ){
        $p_id = $mydata["Id"];
        $p_product = $mydata["Product"];
        $p_photo = $mydata["Photo"];
        $p_price = $mydata["Price"];
        $p_content = $mydata["Content"];

        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $dbname = "202403";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if(!$conn){
            die("連線失敗".mysqli_connect_error());
        }

        $sql = "UPDATE product SET Product = '$p_product', Photo = '$p_photo', Price = '$p_price', Content = '$p_content' WHERE Id = '$p_id'";
        if(mysqli_query($conn, $sql)){
            //更新成功
            echo '{"state" : true, "message" : "更新成功!"}';
        }else{
            //更新失敗
            echo '{"state" : false, "message" : "更新失敗!"}';
        }
        mysqli_close($conn);
    }else{
        echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
    }
}else{
    echo '{"state" : false, "message" : "未傳遞任何參數!"}';
}

?>