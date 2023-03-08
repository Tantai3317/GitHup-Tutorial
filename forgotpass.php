
<!-- This is HEADER -->
<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once __DIR__. "/autoload/autoload.php"; 
    require './libraries/Composer/src/Exception.php';
    require './libraries/Composer/src/PHPMailer.php';
    require './libraries/Composer/src/SMTP.php';
    
    $data =
    [
        "email" => postInput("email"),
    ];
    $error=[];
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(postInput('email')=='')
        {
            $error['email']="Vui lòng nhập Email";
        }
        else
        {
            $is_check = $db->fetchOne("users","email='".$data['email']."' ");
            if($is_check==NULL)
            {
                $error['email']="Email của bạn không hợp lệ ";
            }
        }
        if(empty($error))
        {

            // ==========================================================
            $account_sent_mail = "tuananh112k@gmail.com";
            $password_account_sent_mail = "nhatbaulam11";
            // ==========================================================

            $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
            $expDate = date("Y-m-d H:i:s",$expFormat);
            $key = md5($data['email']);
            $addKey = substr(md5(uniqid(rand(),1)),3,10);
            $key = $key . $addKey;
            mysqli_query($con,"INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)VALUES ('".$data['email']."', '".$key."', '".$expDate."');");
            $output='<p>chào bạn,</p>';
            $output.='<p>Hãy nhấp vào link phía bên dưới để thay đổi mật khẩu.</p>';
            $output.='<p>-------------------------------------------------------------</p>';
            $output.='<p><a href="http://leminhnhat.herokuapp.com/reset-password.php?key='.$key.'&email='.$data['email'].'&action=reset" target="_blank">
            http://leminhnhat.herokuapp.com/reset-password.php?key='.$key.'&email='.$data['email'].'&action=reset</a></p>';		
            $output.='<p>-------------------------------------------------------------</p>';
            $output.='<p>Hãy thay đổi mật khẩu trong một ngày. 
            vì liên kết sẽ hết hạn sau 1 ngày vì lý do bảo mật</p>';
            $output.='<p>Nếu bạn không yêu cầu email quên mật khẩu này, không cần thực hiện hành động nào, mật khẩu của bạn sẽ không được đặt lại. Tuy nhiên, bạn có thể muốn đăng nhập vào tài khoản của mình và thay đổi mật khẩu bảo mật vì ai đó có thể đã đoán ra..</p>';   	
            $output.='<p>Cám ơn,</p>';
            $output.='<p>Admin HoangTo</p>';
            $body = $output; 
            $subject = "Password Recovery - USERS";
            $email_to = $data['email'];
            $fromserver = $account_sent_mail; 
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com"; // Enter your host here
            $mail->SMTPAuth = true;
            $mail->Username = $account_sent_mail;  // Enter your email here
            $mail->Password = $password_account_sent_mail;  //Enter your password here
            $mail->Port = 25;
            $mail->IsHTML(true);
            $mail->From = $account_sent_mail;;
            $mail->FromName = "Ho tro khach hang";
            $mail->Sender = $fromserver; // indicates ReturnPath header
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AddAddress($email_to);
            if(!$mail->Send())
            {
                $_SESSION['error']="Lỗi không gửi được thư: $mail->ErrorInfo";
            }else
            {
                echo "<script>alert('Một email đã được gửi cho bạn, vui lòng kiểm tra email của bạn.');location.href='login.php'</script>'";
            }
        }
    }       
?>
<?php require_once __DIR__. "/layouts/header.php" ;?>
<?php require_once __DIR__. "/layouts/banner.php" ;?>
<!-- END HEADER -->
<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1" >
        <!-- ----------MAIN-------------- -->
            <h3 class="title-main"><a href="">Quên Mật Khẩu</a></h3>
            <?php if(isset($_SESSION['success'])) :?>
                <div class="alert alert-success" style="margin-top:20px;">
                    <strong style="color:#155724;">Thành Công ! </strong><?php echo $_SESSION['success']; unset($_SESSION['success']) ?>
                </div>
            <?php endif ?>
            <?php if(isset($_SESSION['error'])) :?>
                <div class="alert alert-danger" style="margin-top:20px;">
                    <strong style="color:#a94442;">Lỗi ! </strong><?php echo $_SESSION['error']; unset($_SESSION['error']) ?>
                </div>
            <?php endif ?>
            
            <form class="form-horizontal" role="form" style="margin-top:30px" action="" method="POST">
                <div class="form-group">
                    <div style="text-align: center; margin-top: 10px;margin-bottom: 10px;">Vui lòng nhập Email bạn muốn lấy lại mật khẩu.</div>
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-6">
                        <input type="email" id="email" placeholder="Email@gmail.com" class="form-control" name="email">
                        <?php if(isset($error['email'])):?>
                            <p class="text-danger" style="font-size: 20px; margin-top: 20px;">  <?php echo $error['email'] ?> </p>
                        <?php endif ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary col-md-6 col-md-offset-3 ">Gửi</button>
                <a href="login.php" class= "col-md-2 col-md-offset-5 " style="margin-top:10px;" id="forgot_pswd">Quay lại đăng nhập</a>
            </form> <!-- /form -->
        <!-- ----------MAIN-------------- -->
    </section>
</div>
<!-- This is Footer -->
<?php require_once __DIR__. "/layouts/chatlive.php" ;?>
<?php require_once __DIR__. "/layouts/footer.php" ;?>
<!-- END Footer -->