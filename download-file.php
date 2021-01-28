<?php
session_start();
if (isset($_SESSION['id'])){
    if($_SESSION['agent'] != $_SERVER['HTTP_USER_AGENT']) {
        Header("Location: https://www.codelportal.com/product_center/index.php?e=1");
        die();
    }
    if($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
         Header("Location: https://www.codelportal.com/product_center/index.php?e=1");
        die();
    }
    $pid = $_SESSION['prod_id'];
}
else{
 Header("Location: https://www.codelportal.com/product_center/index.php?e=1");
}
include("../pages/config.php");

//get filename
if ($_GET['f']){
     $f = strip_tags($_GET['f']);
}

//Get category
if ($_GET['c']){
     $c = strip_tags($_GET['c']);
}

//Get category
if ($_GET['id']){
     $id = strip_tags($_GET['id']);
}


//get dir from category
$fd = "";

$conn = new DBConnect();
$conn->connect();

$query = "UPDATE downloads SET count=count+1 WHERE id=$id";
        $result = mysql_query($query);

//close conn
$conn->disconnect();

//images.php
$path = "https://www.codelportal.com/downloads/manuals/".$f;
header('Location: '.$path);
exit;

?>