<?php
    require_once __DIR__. "/autoload/autoload.php"; 
    if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"]))
    {
        $key = $_GET["key"];
        $email = $_GET["email"];
        $curDate = date("Y-m-d H:i:s");
        $query = mysqli_query($con,
        "SELECT * FROM `password_reset_temp` WHERE `key`='".$key."' and `email`='".$email."';"
    );
    $row = mysqli_num_rows($query);
    if ($row==""){
        $_SESSION['error']="Xin lỗi vì sự bất tiện này. Vui lòng thử lại !";
    }else
    {
        $row = mysqli_fetch_assoc($query);
        $expDate = $row['expDate'];
        if ($expDate >= $curDate) 
        {
            $data =
                [
                    "password" => MD5(postInput("pass1")),
                ];
                if($_SERVER["REQUEST_METHOD"]=="POST")
                {
                    $error=[];
                    if(postInput('pass1')=='')
                    {
                        $error['pass1']="Vui lòng nhập mật khẩu 1";
                    }
                    if(postInput('pass2')=='')
                    {
                        $error['pass2']="Please enter password 2";
                    }
                    if($data['password']!= MD5(postInput("pass2")))
                    {
                        $error['pass2']="Password incorrect";
                    }
                    //The blank is not necessarily faulty
                    if(empty($error))
                    {
                        $id_update =mysqli_query($con,"UPDATE `users` SET `password`='".$data['password']."' WHERE `email`='".$email."';");
                        if($id_update>0)
                        {
                            mysqli_query($con,"DELETE FROM `password_reset_temp` WHERE `email`='".$email."';");
                            header("location: ResetPassword_message.php");
                            $_SESSION['success']="Reset Password Successfully !";
                        }
                        else
                        {
                            $_SESSION['error']="Reset Password NOT Successfully !";
                        }
                    }
                }
            }else
            {
                $_SESSION['error']="You are trying to use the expired link which as valid only 24 hours (1 days after request)";

            }
        }
    }
?>

<!-- This is HEADER -->
<?php require_once __DIR__. "/layouts/header.php" ;?>
<?php require_once __DIR__. "/layouts/banner.php" ;?>
<!-- END HEADER -->
<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1" >
        <!-- ----------MAIN-------------- -->
            <h3 class="title-main"><a href="">Login</a></h3>
            <?php if(isset($_SESSION['success'])) :?>
                <div class="alert alert-success" style="margin-top:20px;">
                    <strong style="color:#155724;">SUCCESS ! </strong><?php echo $_SESSION['success']; unset($_SESSION['success']) ?>
                </div>
            <?php endif ?>
            <?php if(isset($_SESSION['error'])) :?>
                <div class="alert alert-danger" style="margin-top:20px;">
                    <strong style="color:#a94442;">ERROR ! </strong><?php echo $_SESSION['error']; unset($_SESSION['error']) ?>
                </div>
            <?php endif ?>
            <form class="form-horizontal" role="form" style="margin-top:30px" action="" method="POST">
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">New Password</label>
                    <div class="col-sm-6">
                        <input type="password" id="password" placeholder = "*************" class="form-control" name="pass1" >
                        <?php if(isset($error['pass1'])):?>
                            <p class="text-danger">  <?php echo $error['pass1'] ?> </p>
                        <?php endif ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Re-Password</label>
                    <div class="col-sm-6">
                        <input type="password" id="password" placeholder = "*************" class="form-control" name="pass2" >
                        <?php if(isset($error['pass2'])):?>
                            <p class="text-danger">  <?php echo $error['pass2'] ?> </p>
                        <?php endif ?>
                    </div>
                </div>
                <input type="hidden" name="email" value="<?php echo $email;?>"/>
                <button type="submit" class="btn btn-primary col-md-6 col-md-offset-3 ">Reset Password</button>
            </form> <!-- /form -->
        <!-- ----------MAIN-------------- -->
    </section>
</div>
<!-- This is Footer -->
<?php require_once __DIR__. "/layouts/footer.php" ;?>
<!-- END Footer -->