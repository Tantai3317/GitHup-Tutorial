<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require './libraries/Composer/src/Exception.php';
    require './libraries/Composer/src/PHPMailer.php';
    require './libraries/Composer/src/SMTP.php';

    $open = "contacts";
    require_once __DIR__. "/autoload/autoload.php"; 
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $data =
        [
            "c_name" => postInput('c_name'),
            "c_email" => postInput("c_email"),
            "c_phone" => postInput("c_phone"),
            "c_title" => postInput("c_title"),
            "c_content" => postInput("c_content"),
        ];
        $error=[];

        if(empty($error))
        {
            $id_insert =$db->insert("contacts",$data);
            if($id_insert > 0)
            {
                // ==========================================================
                $account_sent_mail = "tuananh112k@gmail.com";
                $password_account_sent_mail = "nhatbaulam11";
                // ==========================================================
                $output='<p>Chào '.$users['name'].',</p>';
                $output.='<p>Cảm ơn bạn đã gửi câu hỏi cho chúng tôi, chúng tôi sẽ liên hệ với bạn trong vòng 24h.</p>';
                $output.='<p>Admin HoangTo</p>';
                $body = $output; 
                $subject = to_slug($data['c_title']);
                $email_to = $data['c_email'];
                $fromserver = $account_sent_mail; 
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host = "ssl://smtp.gmail.com"; // Enter your host here
                $mail->SMTPAuth = true;
                $mail->Username = $email_account_sent_mail; // Enter your email here
                $mail->Password = $password_account_sent_mail;; //Enter your password here
                $mail->Port = 25;
                $mail->IsHTML(true);
                $mail->From = $account_sent_mail;
                $mail->FromName = "Ho Tro Khach Hang HoangTo"; //Title subject
                $mail->Sender = $fromserver; // indicates ReturnPath header
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($email_to);
                if(!$mail->Send())
                {
                    $_SESSION['error']="Lỗi: $mail->ErrorInfo";
                }else
                {
                    $_SESSION['error']="Gửi thắc mắc KHÔNG thành công !";
                }
            }
            else
            {
                
                $_SESSION['success']="Thắc mắc của bạn đã được gửi đi" . $data['c_name'] . ", Chúng tôi sẽ sớm liên lạc lại với bạn. !";
            }
            
        }
    }
?>

<!-- This is HEADER -->
<?php require_once __DIR__. "/layouts/header.php" ;?>
<?php require_once __DIR__. "/layouts/banner.php" ;?>
<!-- END HEADER -->
<div class="col-md-9 bor" style="padding-bottom: 15px;">
<div>
        <div class="row" >
            <div>
                <div class="contact-us-area">
                    <?php if(isset($_SESSION['success'])) :?>
                        <div class="alert alert-success" style="margin-top:20px;">
                            <strong style="color:#155724;">THÀNH CÔNG ! </strong><?php echo $_SESSION['success']; unset($_SESSION['success']) ?>
                        </div>
                    <?php endif ?>
                    <?php if(isset($_SESSION['error'])) :?>
                        <div class="alert alert-danger" style="margin-top:20px;">
                            <strong style="color:#a94442;">LỖI ! </strong><?php echo $_SESSION['error']; unset($_SESSION['error']) ?>
                        </div>
                    <?php endif ?>
                    <!-- google-map-area start -->
                    <div class="google-map-area">
                        <!--  Map Section -->
                        <div id="contacts" class="map-area">
                            <div id="map" class="map" data-lat="43.6532" data-lng="-79.3832">
                                <div id="contacts" class="map-area">
                                    <div id="map" class="map">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3916.7725940023897!2d106.67329091407238!3d10.98052995839743!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d1085e2b1c37%3A0x73bfa5616464d0ee!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBUaOG7pyBE4bqndSBN4buZdA!5e0!3m2!1svi!2s!4v1651913126327!5m2!1svi!2s"  width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- google-map-area end -->
                    <!-- contact us form start -->
                    <div class="contact-us-form">
                    <form action="" method="POST">
                        <div class="sec-heading-area" style="margin-top: 50px; margin-bottom: 40px; text-align: center;">
                            <h2>GIẢI ĐÁP THẮC MẮC</h2>
                        </div>
                        <div class="contact-form">
                                <div class="form-top">
                                    <div class="form-group col-sm-12">
                                        <label>Họ và tên<sup style="color:#BB0000 ;">*</sup></label>
                                        <input type="text" name="c_name" class="form-control" required>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Số Điện Thoại<sup style="color:#BB0000 ;">*</sup></label>
                                        <input type="text" name="c_phone" class="form-control" required>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Email<sup style="color:#BB0000 ;">*</sup></label>
                                        <input type="email" name="c_email" class="form-control" required>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Thắc mắc <sup style="color:#BB0000 ;">*</sup></label>
                                        <input type="text" name="c_title" class="form-control" required>
                                    </div>												
                                    <!--<div class="form-group col-sm-12">
                                        <label>Bình luận <sup style="color:#BB0000 ;">*</sup></label>
                                        <input type="text" name="c_content" class="form-control" required>
                                    </div>	-->											
                                </div>
                                <div class="submit-form form-group col-sm-12 submit-review">
                                    <button type="submit" class="btn btn-success">Gửi yêu cầu</button>
                                </div>
                        </div>
                        </form>
                    </div>
                    <!-- contact us form end -->
                </div>					
            </div>
        </div>
    </div>	
</div>
<!-- This is Footer -->
<?php require_once __DIR__. "/layouts/chatlive.php" ;?>
<?php require_once __DIR__. "/layouts/footer.php" ;?>
<!-- END Footer -->