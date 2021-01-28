<?php
session_start();
/*include("mail.php");*/
require_once("../pages/config.php");

//Get function type
if (isset($_POST['f'])){
    $f = htmlspecialchars($_POST['f']);
}

if ($f == 'manual_dl'){  
    $pid = htmlspecialchars($_POST['prod_id']);
    $sn = htmlspecialchars($_POST['sn']);
    $name = htmlspecialchars($_POST['name']);
    $cname = htmlspecialchars($_POST['cname']);
    manual_dl($pid,$sn,$name,$cname);
}

function manual_dl($pid,$sn,$name,$cname){
    if (check_sn($pid,$sn)){
        
        $bytes = openssl_random_pseudo_bytes(32);
        $hash = bin2hex($bytes);
        
        session_regenerate_id();
        $_SESSION['id'] = $hash;
        $_SESSION['prod_id'] = $pid;
        $_SESSION['agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        echo "OK";
    } else {
        echo "E1";
    }
}

function check_sn($pid,$sn){
    global $username;
    global $password;
    global $db_name;
    
    $conn = new mysqli("localhost", $username, $password, $db_name);
                                    
    //Get main reports (Query 1) 
    $sql = "SELECT id,prod_id,sn FROM serial_log WHERE prod_id='$pid' AND sn='$sn'";
    $result = $conn->query($sql);
    
    $r_state = false;
    if ($result->num_rows == 1) {
        $r_state = true;
    }
    else {
        $r_state = false;
    }

    //close conn
    $conn->close();
    
    return $r_state;
}

?>