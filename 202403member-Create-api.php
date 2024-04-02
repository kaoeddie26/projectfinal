<?php
$data = file_get_contents("php://input","r"); 
if($data !=""){
$mydata = array();
$mydata = json_decode($data , true);
if(isset($mydata["Username"]) && isset($mydata["Password"]) && isset($mydata["Phone"]) && isset($mydata["Email"])  && $mydata["Username"] !="" && $mydata["Password"] != "" && $mydata["Phone"] != "" && $mydata["Email"] != "" ){
$p_Username = $mydata["Username"];
$p_Password = password_hash($mydata["Password"],PASSWORD_DEFAULT);
$p_Phone = $mydata["Phone"];
$p_Email = $mydata["Email"];
$p_Lv = $mydata["Lv"];


$servername = "localhost";
$username = "owner01";
$password = "123456";
$dbname= "202403";


$conn = mysqli_connect($servername,$username, $password ,$dbname);
echo $p_Pro;
if(!$conn){
    die("連線失敗".mysqli_connect_error());
}
$sql = "INSERT INTO member(Username, Password, Phone, Email, UID01, Lv) VALUES('$p_Username','$p_Password','$p_Phone','$p_Email', '' , '$p_Lv')";
if(mysqli_query($conn, $sql)){
    echo '{"state" : true , "message" : "註冊成功!"}';
}else{
    echo '{"state" : false, "message" : "註冊失敗!'.$sql.mysqli_error($conn).'"}';
}
mysqli_close($conn);
}else{
    echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
}
}else{
    echo '{"state" : false, "message" : "未傳遞任何參數!"}';
}

?>