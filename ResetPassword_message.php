
<!-- This is HEADER -->
<?php 
    require_once __DIR__. "/autoload/autoload.php"; 
?>

<?php require_once __DIR__. "/layouts/header.php" ;?>
<?php require_once __DIR__. "/layouts/banner.php" ;?>
<!-- END HEADER -->
<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1" >
        <!-- ----------MAIN-------------- -->
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
            <div class="desktop_screen" style="margin-bottom: 150px;">
                <div class="redirect-page">
                    <div class="content">
                        <div class="title">
                            Thay đổi mật khẩu thành công quay về login để tiếp tục đăng nhập !
                        </div>
                        <button id="redirect-btn" onclick="onRedirect()">
                            Chuyển ngay
                        </button>
                        <div class="counter" id="counterClass">
                            Hệ thống sẽ chuyển sau <span id="counterId">10</span> <span style="color: #008fe5;">giây</span>
                        </div>
                    </div>
                </div>
            </div>
<style>
.redirect-page{
    width: 100%;
    height: 100%;
    box-sizing: border-box;

}
.redirect-page .content{
    width: 40%;
    margin-left: 30%;
    height: 30%;
    margin-top: 20%;
    justify-content: center;
    align-items: center;
    text-align: center;
}
.redirect-page .content button{
    width: 40%;
    height: 50px;
    margin: 15px;
    border: none;
    border-radius: 5px;
    background: #008fe5;
    color: #fff;
}
#counterId{
    color: #008fe5;
}
</style>
<script>
        function onRedirect() {
          location.replace("/Login.php")
        }
        $(screen).ready(function () {
        window.setTimeout(function () {
            location.href = "/Login.php";
        }, 10000);});
        var timeleft = 10;
        var downloadTimer = setInterval(function(){
        timeleft--;
        document.getElementById("counterId").textContent = timeleft;
        if(timeleft <= 0)
            clearInterval(downloadTimer);
        },1000);
    </script>
</form> <!-- /form -->
        <!-- ----------MAIN-------------- -->
    </section>
</div>


<!-- This is Footer -->
<?php require_once __DIR__. "/layouts/chatlive.php" ;?>
<?php require_once __DIR__. "/layouts/footer.php" ;?>
<!-- END Footer -->