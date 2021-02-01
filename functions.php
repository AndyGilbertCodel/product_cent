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
    $pname = htmlspecialchars($_POST['prod_name']);
    $sn = htmlspecialchars($_POST['sn']);
    $email = htmlspecialchars($_POST['email']);
    $cname = htmlspecialchars($_POST['cname']);
    manual_dl($pid,$sn,$email,$cname,$pname);
}

//Cross Check Function
// function manual_dl($pid,$sn,$name,$cname){
//     if (check_sn($pid,$sn)){
        
//         $bytes = openssl_random_pseudo_bytes(32);
//         $hash = bin2hex($bytes);
        
//         session_regenerate_id();
//         $_SESSION['id'] = $hash;
//         $_SESSION['prod_id'] = $pid;
//         $_SESSION['agent'] = $_SERVER['HTTP_USER_AGENT'];
//         $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
//         echo "OK";
//     } else {
//         echo "E1";
//     }
// }

//NO Cross Check Function
function manual_dl($pid,$sn,$email,$cname,$pname){
        
        $bytes = openssl_random_pseudo_bytes(32);
        $hash = bin2hex($bytes);
        
        session_regenerate_id();
        $_SESSION['id'] = $hash;
        $_SESSION['prod_id'] = $pid;
        $_SESSION['agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

        notif($email,$cname,$sn,$pname);
        save_capture($pname,$email,$cname,$sn);
        echo "OK";
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

//New opportunity mail
function notif($mail_user,$comp_name,$serial_num,$product){
    
    $subject = "Product Center - Barcode Scanned by ".$comp_name;
    
    $message = "
    <html>
    <head>
    <title>New Barcode Scan</title>
    </head>
    <body>
    <h1>Barcode has been scanned</h1>
    <p>The following product barcode has been scanned ".$product."</p>
    <p><b>Company Name: </b>".$comp_name."</p>
    <p><b>Email: </b>".$mail_user."</p>
    <p><b>Serial Number: </b>".$serial_num."</p>
    </body>
    </html>";
    
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    
    
    mail('andy.gilbert@codel.co.uk,sales@codel.co.uk', $subject, $message, $headers);
    }

    //Add to DB
    function save_capture($prod,$email,$comp_name,$serial_num){

        global $username;
        global $password;
        global $db_name;
        $conn = new mysqli("localhost", $username, $password, $db_name);
        
        $sql = "INSERT INTO barcode_contacts
        (company,
        email,
        product,
        sn,
        capture_date) 
        VALUES('$comp_name',
        '$email',
        '$prod',
        '$serial_num',
        NOW())";
        
        $result = $conn->query($sql);

        //close conn
        $conn->close();
    }

?>