<?php
session_start();
include("../pages/config.php");
$prod_id = htmlspecialchars($_GET['pid']);

$sn = "";
if (isset($_GET['sn'])){
    $sn = htmlspecialchars($_GET['sn']);
}

$conn = new mysqli("localhost", $username, $password, $db_name);
                                    
        //Get main reports (Query 1) 
        $sql = "SELECT id,prod_name,prod_img FROM barcode WHERE prod_id='$prod_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {

                $pname = $row["prod_name"];
                $pimg = $row["prod_img"];
            }
        }
        else {}

        //close conn
        $conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>

        <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex">

    <title>CODEL Product Center</title>
    
    <!-- Custom CSS -->
    <link href="css/mystyles.css?v=269" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;1,100&display=swap" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

   <div class="center content_center header"><img src="img/CODEL_title_white.png" class="responsive">
    <div class="header_title"><h4><?php echo $pname; ?></h4></div></div>
    <div class="spacer_200"></div>
    <div class="center content_center">
    <img src="<?php echo $pimg; ?>" class="responsive product_img">
    <button class="btn" onclick="location.href='https://www.codelportal.com/product_center/product_manuals_form.php?pid=<?php echo $prod_id; ?>'">Manuals</button>
<button class="btn" onclick="location.href='https://www.codelportal.com/product_center/product_register.php?pid=<?php echo $prod_id; ?>&sn=<?php echo $sn; ?>'"> Register Product</button>
   <button class="btn" onclick="location.href='https://www.codelportal.com/product_center/index.php?pid=<?php echo $prod_id; ?>'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to products</button>
   <div class="spacer_200"></div>
    </div>
    
<div class="footer content_center">
<button class="btn_footer" onclick="location.href='tel:+441629814351'"><i class="fa fa-phone-square"></i></button>
<button class="btn_footer" onclick="location.href='email:sales@codel.co.uk'"><i class="fa fa-envelope" ></i></button>
<button class="btn_footer" onclick="location.href='https://www.codel.co.uk'"><i class="fa fa-external-link-square"></i></button>
<button class="btn_footer"><i class="fa fa-facebook-square"></i></button>
<button class="btn_footer"><i class="fa fa-linkedin-square"></i></button>
</div>
<!-- jQuery -->
<script
src="https://code.jquery.com/jquery-3.5.1.min.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
crossorigin="anonymous"></script>
</body>

</html>
