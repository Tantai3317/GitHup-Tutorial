<?php 
    require_once __DIR__. "/autoload/autoload.php";
    $key=intval(getInput('key'));
    $qty=intval(getInput('qty'));
    $_SESSION['cart'][$key]['qty'] = $qty;


    $con = mysqli_connect("jtb9ia3h1pgevwb1.cbetxkdyhwsb.us-east-1.rds.amazonaws.com","qx90vr3q7ax8qzxv","zm328w8rqn9sjn0i","py76hrif35ykycfy");

    $get_products = "select number from product where id = {$key} ";

    $run_products = mysqli_query($con,$get_products);

    $qty_products = mysqli_fetch_assoc($run_products)['number'];
    
    $n=(int)$qty_products;
    if($n<$qty)
    {
        $_SESSION['cart'][$key]['qty'] = $n;
        echo 0;
    }
    else
    {
        echo 1;
    }

?>