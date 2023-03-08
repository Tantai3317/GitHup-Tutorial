<?php 
    require_once __DIR__. "/autoload/autoload.php";
    $key=intval(getInput('key'));
    unset($_SESSION['cart'][$key]);
    $_SESSION['success']="Xóa sản phẩm khỏi giỏ hàng thành công!";
    header("location:cart_product.php");
?>