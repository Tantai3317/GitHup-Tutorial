<?php
    require_once __DIR__ . "/autoload/autoload.php";
    // Product Detail
    $id = intval(getInput('id'));
    $product = $db->fetchID("product", $id);
    //Count View 
    if ($product['view'] > 0) {
        $sqlcount = "UPDATE product SET view = view + 1 WHERE id = $id ";
        $count_viewer = mysqli_query($con, $sqlcount);
    } else {
        $sqlcount1 = "UPDATE product SET view = 1 WHERE id = $id ";
        $count_viewer1 = mysqli_query($con, $sqlcount1);
    }

    //Count Heart
    if(isset ($_SESSION['name_id']))
    {
        $id_user =$_SESSION['name_id'];
        $id_product = $product['id'];
        $data1=[
            'product_id' => $id_product,
            'user_id' => $id_user,
        ];
        // ============================================================
        $sql_interest = "SELECT * FROM product_interest WHERE user_id = $id_user and  product_id = $id_product";
        $result = $db->fetchsql($sql_interest);
        foreach ($result as $rs):
            $id_rs = $rs['id']; 
        endforeach; 
        if($result)
        {
            // $sqlcount = "UPDATE product_interest SET like_dislike = 1 WHERE user_id = $id_user and  product_id = $id_product";
            // $count_viewer = mysqli_query($con, $sqlcount);
        } else {
            $id_insert =$db->insert("product_interest",$data1);
        }
    }

    // Get_category 
    $cateid = intval($product['category_id']);
    $sql = "SELECT * FROM product ORDER BY ID DESC LIMIT 4  ";
    $productoffer = $db->fetchsql($sql);

    $ratings = "SELECT users.id ,users.name ,ratings.* FROM ratings , users WHERE users.id = ratings.ra_user_id and ra_product_id=$id  ORDER BY updated_at DESC";
    $run_ratings = mysqli_query($con, $ratings);

    $ratingsDashboardsql = "SELECT count(ra_number) as total ,sum(ra_number) as sum ,ra_number  FROM ratings Where ra_product_id=$id GROUP BY ra_number ";
    $ratingsDashboard = mysqli_query($con, $ratingsDashboardsql);

    $arrayRatings = [];
    if (!empty($ratingsDashboard)) {
        for ($i = 1; $i <= 5; $i++) {
            $arrayRatings[$i] = [
                "total" => 0,
                "sum" => 0,
                "ra_number" => 0
            ];
            foreach ($ratingsDashboard as $item) {
                if ($item['ra_number'] == $i) {
                    $arrayRatings[$i] = $item;
                }
            }
        }
    }

?>

<!-- This is HEADER -->
<?php require_once __DIR__ . "/layouts/header.php"; ?>
<?php require_once __DIR__ . "/layouts/banner.php"; ?>
<!-- END HEADER -->
<style>
    .nametext {
        display: block;
        width: 180px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .product-tab-content {
        overflow: hidden;
        font-weight: normal;
    }

    .product-tab-content h2 {
        font-size: 20px;
        font-weight: normal !important;
    }

    .product-tab-content h3 {
        font-size: 18px !important;
    }

    .product-tab-content h4 {
        font-size: 16px !important;
    }

    .product-tab-content img {
        margin: 0 auto;
        text-align: center;
        max-width: 100%;
        display: block;
    }

    .list_start {
        cursor: pointer;
    }

    .list_text {
        display: inline-block;
        margin-left: 10px;
        position: relative;
        background: #52b858;
        color: #fff;
        padding: 2px 8px;
        box-sizing: border-box;
        font-size: 12px;
        border-radius: 2px;
        display: none;
    }

    .list_text::after {
        right: 100%;
        top: 50%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-color: rgba(82, 184, 88, 0);
        border-right-color: #52b858;
        border-width: 6px;
        margin-top: -6px;
    }

    .list_start .rating_active {
        color: #ff9705 !important;
    }

    .pro-rating .active {
        color: #ff9705 !important;
    }

    .ra_comment .active {
        color: #ff9705 !important;
    }
</style>

<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <div style="text-align: right; padding-right: 135px; padding-bottom: 20px;">
        <?php
        if ($product['number'] < 1) {
            echo ' <span style="position: absolute; text-align: center;width: 150px; background: #fbda00;color: #333;font-size: 18px;padding: 4px 6px;">The product is not available</span>';
        }
        ?>
    </div>
    <section class="box-main1">
        <div class="col-md-6 text-center">
            <?php if ($product['sale1'] > 0) : ?>
                <svg style="position: absolute; left: 7px;z-index: 100;" width="185" height="58" viewBox="0 0 185 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g filter="url(#filter0_d)">
                        <path d="M4 45L4 42.5L5.5 41.5L7 40L9 40L9 49.1603L4 45Z" fill="#A00101" />
                        <path d="M181 40.034L11.0845 40.0344C10.2418 39.9334 8.58492 39.8902 6.88521 40.7841C6.25675 41.1157 5.27121 41.6491 4.61418 42.8314C4.12855 43.6965 4.02857 44.5327 4 45.0085V5.02584C4.02857 4.55006 4.12855 3.71382 4.61418 2.84876C5.27121 1.68092 6.25675 1.13305 6.88521 0.801441C8.38495 0.00846523 9.85612 -0.0492044 10.756 0.0228844V0.00846481L181 0.00811768L166.56 20.0211L181 40.034Z" fill="url(#paint0_linear)" />
                    </g>
                    <path d="M37.752 30.264C36.424 30.264 35.168 30.096 33.984 29.76C32.816 29.424 31.84 28.968 31.056 28.392L32.136 25.464C32.888 25.992 33.744 26.408 34.704 26.712C35.68 27.016 36.696 27.168 37.752 27.168C38.904 27.168 39.728 26.992 40.224 26.64C40.736 26.272 40.992 25.816 40.992 25.272C40.992 24.808 40.816 24.44 40.464 24.168C40.112 23.896 39.496 23.664 38.616 23.472L35.904 22.896C32.88 22.256 31.368 20.688 31.368 18.192C31.368 17.12 31.656 16.184 32.232 15.384C32.808 14.568 33.608 13.936 34.632 13.488C35.672 13.04 36.872 12.816 38.232 12.816C39.4 12.816 40.496 12.984 41.52 13.32C42.544 13.656 43.392 14.128 44.064 14.736L42.984 17.472C41.672 16.432 40.08 15.912 38.208 15.912C37.2 15.912 36.416 16.112 35.856 16.512C35.312 16.896 35.04 17.4 35.04 18.024C35.04 18.488 35.208 18.864 35.544 19.152C35.88 19.44 36.464 19.672 37.296 19.848L40.008 20.424C43.112 21.096 44.664 22.616 44.664 24.984C44.664 26.04 44.376 26.968 43.8 27.768C43.24 28.552 42.44 29.168 41.4 29.616C40.376 30.048 39.16 30.264 37.752 30.264ZM44.9709 30L52.7469 13.08H55.7469L63.5229 30H59.7789L58.1949 26.328H50.2989L48.7389 30H44.9709ZM54.2109 17.04L51.5469 23.424H56.9709L54.2589 17.04H54.2109ZM64.9853 30V13.08H68.7053V26.856H76.5293V30H64.9853ZM78.7431 30V13.08H90.3351V15.984H82.2951V19.944H89.8071V22.872H82.2951V27.096H90.3351V30H78.7431ZM107.802 30.264C106.138 30.264 104.674 29.904 103.41 29.184C102.162 28.448 101.186 27.432 100.482 26.136C99.794 24.824 99.45 23.288 99.45 21.528C99.45 19.768 99.794 18.24 100.482 16.944C101.186 15.632 102.162 14.616 103.41 13.896C104.658 13.176 106.122 12.816 107.802 12.816C109.482 12.816 110.946 13.176 112.194 13.896C113.458 14.616 114.434 15.632 115.122 16.944C115.826 18.24 116.178 19.76 116.178 21.504C116.178 23.264 115.826 24.8 115.122 26.112C114.434 27.424 113.458 28.448 112.194 29.184C110.946 29.904 109.482 30.264 107.802 30.264ZM107.802 27.096C109.21 27.096 110.306 26.608 111.09 25.632C111.89 24.64 112.29 23.272 112.29 21.528C112.29 19.768 111.898 18.408 111.114 17.448C110.33 16.472 109.226 15.984 107.802 15.984C106.41 15.984 105.314 16.472 104.514 17.448C103.73 18.408 103.338 19.768 103.338 21.528C103.338 23.272 103.73 24.64 104.514 25.632C105.314 26.608 106.41 27.096 107.802 27.096ZM119.056 30V13.08H130.48V15.984H122.776V20.112H129.952V23.016H122.776V30H119.056ZM132.743 30V13.08H144.167V15.984H136.463V20.112H143.639V23.016H136.463V30H132.743Z" fill="#FFF000" />
                    <defs>
                        <filter id="filter0_d" x="0" y="0" width="185" height="57.1603" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                            <feOffset dy="4" />
                            <feGaussianBlur stdDeviation="2" />
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape" />
                        </filter>
                        <linearGradient id="paint0_linear" x1="4" y1="23" x2="140.988" y2="21.7318" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#CC2525" />
                            <stop offset="1" stop-color="#FF5656" />
                        </linearGradient>
                    </defs>
                </svg>
            <?php else : ?>

            <?php endif ?>
            <img src="<?php echo uploads() ?>product/<?php echo $product['thumbar'] ?>" class="img-responsive bor zoom" id="imgmain" width="100%" height="450px">
            <ul class="text-center bor clearfix" id="imgdetail">
                <li>
                    <img src="<?php echo base_url() ?>public/frontend/images/detail_product/1.jpg" class="img-responsive pull-left zoom" width="70" height="80">
                </li>
                <li>
                    <img src="<?php echo base_url() ?>public/frontend/images/detail_product/2.jpg" class="img-responsive pull-left zoom" width="70" height="80">
                </li>
                <li>
                    <img src="<?php echo base_url() ?>public/frontend/images/detail_product/3.jpg" class="img-responsive pull-left zoom" width="70" height="80">
                </li>
                <li>
                    <img src="<?php echo base_url() ?>public/frontend/images/detail_product/4.jpg" class="img-responsive pull-left zoom" width="70" height="80">
                </li>
                <li>
                    <img src="<?php echo base_url() ?>public/frontend/images/detail_product/5.jpg" class="img-responsive pull-left zoom" width="70" height="80">
                </li>
            </ul>
        </div>
        <div class="col-md-6 " style="margin-top: 20px;padding: 30px;">
            <ul id="right">
                <li>
                    <h2 style="font-weight: bold; text-align: center;"><?php echo $product['name'] ?></h2>
                </li>
                <?php
                $ageDetail = 0;
                if ($product['pro_total_rating']) {
                    $ageDetail = round($product['pro_total_number'] / $product['pro_total_rating'], 2);
                }
                ?>
                <div class="pro-rating" style="text-align: center;">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <?php if ($i <= $ageDetail) : ?>
                            <a href="#" style="color: #333; font-size: 20px; margin-left: 5px; text-align: center;" class="fa fa-star active"></a>
                        <?php else : ?>
                            <a href="#" style="color: #333; font-size: 20px; margin-left: 5px; text-align: center;" class="fa fa-star"></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <h6 style="text-align: center; margin-top: 10px; margin-bottom: 10px; font-size: 15px; color: #FF9705; font-weight: 400;">Lượt xem <a style="font-size: 15px; color: #FF9705;" class="fa fa-eye"></a> : <?php echo $product['view'] ?></h6>
                </div>
                <?php if ($product['bonus'] != '') : ?>
                    <li>
                        <h3 style="color:red;">Phụ kiện đi kèm :</h3>
                        <p style="margin-top: 10px; font-size: 15px;">
                            <?php echo $product['bonus'] ?>
                        </p>
                    </li>
                <?php else : ?>
                    <li style="color:red;"> Sản phẩm không có phụ kiện đi kèm </li>
                <?php endif ?>
                <?php if ($product['sale'] > 0) : ?>
                    <li style="font-size: 30px; text-align: center;">
                        <p><strike style="font-size: 18px;" class="sale"><?php echo formatPrice($product['price']) ?></strike>
                            &emsp;<b class="price" style="font-size: 20px;"><?php echo formatPriceSale($product['price'], $product['sale'] + $product['sale1']) ?></b< /li>
                            <?php else : ?>
                        <li>
                        <p style="text-align: center;"><b class="price" style="font-size: 20px;"><?php echo formatPrice($product['price']) ?></b< /li>
                            <?php endif ?>
                    <li style="text-align: center;">
                        <?php if ($product['number'] > 0) : ?>
                            <a href="addcart.php?id=<?php echo $product['id'] ?>" class="btn btn-default"><i class="fa fa-shopping-cart" style="padding: 2px; margin-right: 5px;"></i> Thêm vào giỏ hàng</a>
                        <?php else : ?>
                            <p style="font-size: 18px; color:#ea3a3c;">Vui lòng chọn sản phẩm khác</p>
                            <a href="index.php" class="btn btn-warning" style="margin-top: 20px;"><i class="fa fa-undo" aria-hidden="true" style="background: none; padding: 0px; margin-right: 10px;"></i> Quay về trang chủ</a>
                        <?php endif; ?>
                        
                        <?php if(isset ($_SESSION['name_id'])):?>
                            <?php foreach($result as $item1) :?>
                                <a href="like_dislike.php?id=<?php echo $item1['id'] ?>"  class="btn btn-heart">
                                    <?php echo $item1['like_dislike'] == 1 ? '<i style="font-size:28px; color:#d11618" class="fa fa-heart"></i>' : '<i style="font-size:28px; color:#333" class="fa fa-heart-o"></i>' ?>
                                </a>
                            <?php endforeach;?>
                        <?php else :?>
                        <?php endif; ?>

                    </li>
            </ul>
        </div>
    </section>
    <div class="col-md-12" id="tabdetail">
        <div class="row">

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Mô tả</a></li>
                <li><a data-toggle="tab" href="#menu0">Chi tiết</a></li>
                <li><a data-toggle="tab" href="#menu1">Đánh giá</a></li>
            </ul>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <p><?php echo $product['content'] ?></p>
                </div>
                <div id="menu0" class="tab-pane fade">
                    <h2 style="text-align: center;">Thông tin chi tiết</h2>
                    <p><?php echo $product['cpu'] ?></p>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <div class="compoment_rating" style="margin-bottom: 20px">
                        <h3>Đánh giá sản phẩm</h3>
                        <div class="compoment_rating_content" style="display:flex;align-items: center; border: 1px solid #dedede;border-radius: 5px;">
                            <div class="rating_item" style="width: 20%;position: relative;">
                                <span class="fa fa-star" style="font-size: 100px;display: block;margin: 0 auto;text-align: center ; color: #ff9705"></span>
                                <b style="position: absolute;top: 50%;left: 50%;transform: translateX(-50%) translateY(-50%);color: white;font-size: 20px;"> <?php echo $ageDetail ?> </b>
                            </div>
                            <div class="list_rating" style="width: 60%;padding: 20px;">
                                <?php foreach ($arrayRatings as $key => $arrayRating) : ?>
                                    <?php if ($product['pro_total_rating'] != 0) : ?>
                                        <?php $itemAge = round(($arrayRating['total'] / $product['pro_total_rating']) * 100, 0); ?>
                                        <div class="item_rating" style="display:flex ;align-items: center">
                                            <div style="width: 10%; font-size: 14px">
                                                <?php echo $key ?><span style="margin-left: 5px" class=" fa fa-star"></span>
                                            </div>
                                            <div style="width: 60%; margin:0 20px">
                                                <span style="width:100%; height: 8px;display: block;border: 1px solid #dedede ; border-radius:5px; ">
                                                    <b style="width:<?php echo $itemAge ?>%; background-color: #ff9705; display: block; border-radius: 5px;height: 100%; "></b>
                                                </span>
                                            </div>
                                            <div style="width:25%;">
                                                <a href=""><?php echo $arrayRating['total'] ?> đánh giá (<?php echo $itemAge ?>%)</a>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="item_rating" style="display:flex ;align-items: center">
                                            <div style="width: 10%; font-size: 14px">
                                                <?php echo $key ?><span style="margin-left: 5px" class=" fa fa-star"></span>
                                            </div>
                                            <div style="width: 60%; margin:0 20px">
                                                <span style="width:100%; height: 8px;display: block;border: 1px solid #dedede ; border-radius:5px; ">
                                                    <b style="width:0%; background-color: #ff9705; display: block; border-radius: 5px;height: 100%; "></b>
                                                </span>
                                            </div>
                                            <div style="width:25%;">
                                                <a href=""><?php echo $arrayRating['total'] ?> đánh giá </a>
                                            </div>
                                        </div>
                                    <?php endif ?>

                                <?php endforeach ?>
                            </div>
                            <div>
                                <a class="js_rating_action" style=" width: 200px;background: #288ad6;padding: 10px;color: white;border-radius:5px ">Đánh giá</a>
                            </div>
                        </div>
                        <?php
                        $listRatingText = [
                            1 => 'Dislike',
                            2 => 'All right',
                            3 => 'Normal',
                            4 => 'Very good',
                            5 => 'Excellent'
                        ];
                        ?>
                        <div class="form_rating hide">
                            <div style="display: flex;margin-top: 15px;font-size: 15px">
                                <p style="margin-bottom:0">Chọn đánh giá:</p>
                                <span style="margin: 0 15 px" class="list_start">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <i class="fa fa-star" data-key="<?php echo $i ?>"></i>
                                    <?php endfor ?>
                                </span>
                                <span class="list_text"></span>
                                <input type="hidden" value="" class="number_rating">
                            </div>
                            <div style="margin-top: 15px">
                                <textarea name="" class="form-control" id="ra_content" cols="30" rows="3"></textarea>
                            </div>
                            <div style="margin-top: 15px;">
                                <a href="" class="js_rating_product" style=" width: 200px;background: #288ad6;padding: 10px;color: white;border-radius:5px ">Gửi đánh giá</a>
                            </div>
                        </div>
                        <div class="component_list_rating" style="margin-top: 30px;">
                            <?php if (isset($run_ratings)) : ?>
                                <?php foreach ($run_ratings as $rating) : ?>
                                    <div class="rating_item" style="margin:15px 0">
                                        <div>
                                            <span style="color: #333; font-weight: bold;text-transform: capitalize; font-size: 15px;"><?php echo $rating['name'] ?></span>
                                            <a href="" style="color: #2ba832 ;font-size: 14px;"><i class="fa fa-check-circle-o"></i> Mua online </a>
                                        </div>
                                        <p style="margin-bottom: 0">
                                            <span class="ra_comment">
                                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                    <?php if ($i <= $rating['ra_number']) : ?>
                                                        <i class="fa fa-star active"></i>
                                                    <?php else : ?>
                                                        <i class="fa fa-star"></i>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </span>
                                            <span style="font-size: 14px;"><?php echo $rating['ra_content'] ?></span>
                                        </p>
                                        <div>
                                            <span style="font-size: 14px;"><i class="fa fa-clock-o"></i><?php echo $rating['created_at'] ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12" style="margin-top: 40px;">
        <h3 style="font-weight: bold; text-align: center; color: #cc0000; ">Sản phẩm liên quan</h3>
        <div class="showitem" style="margin-top: 10px; margin-bottom:10px;">
            <?php foreach ($productoffer as $item) : ?>
                <div class="col-md-3 item-product bor">
                    <a href="detail_product.php?id=<?php echo $item['id'] ?>">
                        <img src="public/uploads/product/<?php echo $item['thumbar'] ?>" class="" width="100%" height="130px">
                    </a>
                    <div class="info-item">
                        <a class="nametext" href="detail_product.php?id=<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a>
                        <p><strike class="sale"><?php echo formatPrice($item['price']) ?></strike> <b class="price"><?php echo formatPriceSale($item['price'], $item['sale'] + $item['sale1']) ?></b></p>
                    </div>
                    <div class="hidenitem">
                    <?php if($item['number'] > 0) :?>
                        <p><a href="detail_product.php?id=<?php echo $item['id'] ?>"><i class="fa fa-search"></i></a></p>
                        <p><a href="like_dislike1.php?id=<?php echo $item['id']?>"><i class="fa fa-heart"></i></a></p>
                        <p><a href="addcart.php?id=<?php echo $item['id'] ?>"><i class="fa fa-shopping-basket"></i></a></p>
                    <?php else : ?>
                        <p><a href="detail_product.php?id=<?php echo $item['id'] ?>"><i class="fa fa-search"></i></a></p>
                        <p><a href="like_dislike1.php?id=<?php echo $item['id']?>"><i class="fa fa-heart"></i></a></p>

                    <?php endif ; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
        let listStart = $(".list_start .fa");

        listRatingText = {
            1: 'Không thích',
            2: 'Tạm ổn',
            3: 'Bình thường',
            4: 'Tốt',
            5: 'Rất tốt',
        }
        listStart.mouseover(function() {
            let $this = $(this);
            let number = $this.attr('data-key');
            listStart.removeClass('rating_active');
            $(".number_rating").val(number);
            $.each(listStart, function(key, value) {
                if (key + 1 <= number) {
                    $(this).addClass('rating_active')
                }
            });

            $(".list_text").text('').text(listRatingText[$this.attr('data-key')]).show();
        });
        $(".js_rating_action").click(function(event) {
            event.preventDefault();
            if ($(".form_rating").hasClass('hide')) {
                $(".form_rating").addClass('active').removeClass('hide')
            } else {
                $(".form_rating").addClass('hide').removeClass('active')
            }
        })
        $(".js_rating_product").click(function(e) {
            event.preventDefault();
            let content = $("#ra_content").val();
            let number = $(".number_rating").val();
            let url = $(this).attr('href');
            if (content && number) {
                $.ajax({
                    url: 'detail_product_ajax.php',
                    type: 'POST',
                    data: {
                        id: <?php echo $id ?>,
                        ra_number: number,
                        ra_content: content,
                    }
                }).done(function(result) {

                    if (result == 1) {
                        alert("Cảm ơn! Đánh giá của bạn đã được gửi đi!");
                        location.reload(true);
                    } else {
                        alert("Xin lỗi! Vui lòng đăng nhập để gửi đánh giá. Hoặc đánh giá của bạn đang gặp lỗi.");
                        location.reload(true);
                    }
                });
            }
        });


        let idProduct = $("#content_product").attr('data-id');

        let products = localStorage.getItem('products');

        if (products == null) {
            arrayProduct = new Array();

            arrayProduct.push(idProduct)

            localStorage.setItem('products', JSON.stringify(arrayProduct))

        } else {
            // Chuyển về mảng
            products = $.parseJSON(products)

            if (products.indexOf(idProduct) == -1) {
                products.push(idProduct);
                localStorage.setItem('products', JSON.stringify(products))
            }
        }

    });
</script>

<!-- This is Footer -->
<?php require_once __DIR__ . "/layouts/chatlive.php"; ?>
<?php require_once __DIR__ . "/layouts/footer.php"; ?>
<!-- END Footer -->