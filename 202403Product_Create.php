<?php
  //新增一筆固定資料


//input: {"Pname":"奶茶","Price":"45", "Sugar":"半糖","Num":"20","Delivery":"true","Added":"波霸","Pay":"刷卡","Total":"900"}
$data = file_get_contents("php://input","r");
if($data !=""){
$mydata = array();
$mydata = json_decode($data , true);
if(isset($mydata["Product"]) && isset($mydata["Price"]) && isset($mydata["Photo"]) && isset($mydata["Num"]) && isset($mydata["Content"]) && $mydata["Product"] !="" && $mydata["Photo"] != "" && $mydata["Price"] != ""  && $mydata["Num"] != "" && $mydata["Content"] != ""){

$p_product = $mydata["Product"];
$p_price = $mydata["Price"];
$p_num = $mydata["Num"];
$p_content = $mydata["Content"];
$p_Photo = $mydata["Photo"];

$servername = "localhost";
$username = "owner01";
$password = "123456";
$dbname= "202403";

$conn = mysqli_connect($servername,$username, $password ,$dbname);
if(!$conn){
    die("連線失敗".mysqli_connect_error());
}
$sql = "INSERT INTO product(Product, Photo, Price, Num, Content) VALUES('$p_product','$p_Photo','$p_price','$p_num','$p_content')";
if(mysqli_query($conn, $sql)){
    //新增成功
    echo '{"state" : true , "message" : "新增成功!"}';
}else{
    //新增失敗
    echo '{"state" : false, "message" : "新增失敗!'.$sql.mysqli_error($conn).'"}';
}
mysqli_close($conn);
}else{
    echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
}
}else{
    echo '{"state" : false, "message" : "未傳遞任何參數!"}';
}
mysqli_close($conn);

?>