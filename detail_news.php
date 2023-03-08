<?php 
    require_once __DIR__. "/autoload/autoload.php"; 
    // articles Detail
    $id = intval(getInput('id'));
    $articles = $db->fetchID("articles" ,$id);
    if($articles['a_view']>0)
    {
        $sqlcount = "UPDATE articles SET a_view = a_view + 1 WHERE id = $id ";
        $count_viewer = mysqli_query($con,$sqlcount);

    }
    else
    {
        $sqlcount1 = "UPDATE articles SET a_view = 1 WHERE id = $id ";
        $count_viewer1 = mysqli_query($con,$sqlcount1);
    }
?>
<!-- This is HEADER -->
<?php require_once __DIR__. "/layouts/header.php" ;?>
<?php require_once __DIR__. "/layouts/articlehot.php" ;?>
<!-- END HEADER -->
<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1" >
        <!-- ITEM PRODUCT -->
        <div class="col-md-12 ">
            <h2 style="text-align: center; margin-top: 10px;margin-bottom: 10px; font-weight: bolder;">BÀI VIẾT HAY NHẤT </h2>
            <h6 style="text-align: right; margin-top: 10px; margin-bottom: 10px; font-size: 18px; color: #FF9705; font-weight: 500;">Số người xem <i style="font-size: 18px; color: #FF9705;" class="fa fa-eye"></i> : <?php echo $articles['a_view'] ?></h6>
            <div class="col-md-12 bor">
                <div class="article_content" style="margin-bottom: 20px">
                    <h1 style="text-align: center;"><?php echo $articles['a_name'] ?></h1>
                    <p style="font-size: 12px;margin-top: 40px;"><?php echo $articles['a_content'] ?></p>
                </div>
            </div>
            </div>
        </div>
        <!-- ITEM PRODUCT -->
    </section>
</div>
<!-- This is Footer -->
<?php require_once __DIR__. "/layouts/footer.php" ;?>
<!-- END Footer -->