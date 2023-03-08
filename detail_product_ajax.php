<?php 
    require_once __DIR__. "/autoload/autoload.php"; 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data =[
            "ra_product_id" => postInput("id"),
            "ra_number"     => postInput("ra_number"),
            "ra_content"    => postInput("ra_content"),
            "ra_user_id "   => $_SESSION['name_id'],
        ];
        $id_insert =$db->insert("ratings",$data);
        if($id_insert)
        {
           echo 1;
        }
        else
        {
            echo 0;
        }
    }
   
?>

