<?php
//input: {"Username":"XX", "Password":"XXX"}
// {"state" : true, "data": "登入後的帳號資料(密碼除外)", "message" : "登入成功!"}
// {"state" : false, "message" : "登入失敗!"}
// {"state" : false, "message" : "傳遞參數格式錯誤!"}
// {"state" : false, "message" : "未傳遞任何參數!"}

$data = file_get_contents("php://input", "r");
if ($data != "") {
    $mydata = array();
    $mydata = json_decode($data, true);
    if (isset($mydata["Username"]) && isset($mydata["Password"]) && $mydata["Username"] != "" && $mydata["Password"] != "") {
        $p_Username = $mydata["Username"];
        $p_Password = $mydata["Password"];


        $servername = "localhost";
        $username = "owner01";
        $password = "123456";
        $dbname = "202403";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("連線失敗" . mysqli_connect_error());
        }

        $sql = "SELECT Username, Password, Phone, Email FROM member WHERE Username = '$p_Username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($p_Password, $row["Password"])) {
                $uid = substr(hash("sha256", uniqid(time())), 0, 8);
                $sql = "UPDATE member SET UID01 = '$uid' WHERE Username = '$p_Username'";
                if (mysqli_query($conn, $sql)) {
                    $sql = "SELECT Username, Phone, Email, UID01 FROM member WHERE Username = '$p_Username'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $mydata = array();
                    $mydata[] = $row;

                    echo '{"state" : true, "data": ' . json_encode($mydata) . ', "message" : "登入成功!"}';
                } else {
                    echo '{"state" : false, "message" : "登入失敗, uid更新錯誤"}';
                }
            } else {
                echo '{"state" : false, "message" : "登入失敗"}';
            }
        } else {
            echo '{"state" : false, "message" : "登入失敗"}';
        }
        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
    }
} else {
    echo '{"state" : false, "message" : "未傳遞任何參數!"}';
}
?>