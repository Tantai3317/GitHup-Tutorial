<?php
require_once __DIR__ . "/autoload/autoload.php";
$sum = 0;
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<script>alert('Hiện không có sản phẩm trong giỏ hàng !');location.href='index.php'</script>";
}
$sql = "SELECT * FROM product ORDER BY ID DESC LIMIT 4  ";
$productoffer = $db->fetchsql($sql);
?>

<!-- This is HEADER -->
<?php require_once __DIR__ . "/layouts/header.php"; ?>
<?php require_once __DIR__ . "/layouts/banner.php"; ?>
<!-- END HEADER -->


<div class="col-md-9 bor" style="padding-bottom: 15px;">
    <section class="box-main1">
        <!-- NOTIFiCATION -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="alert alert-success" style="margin-top:20px;">
                <strong style="color:#155724;">Thành công ! </strong><?php echo $_SESSION['success'];
                                                                    unset($_SESSION['success']) ?>
            </div>
        <?php endif ?>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger" style="margin-top:20px;">
                <strong style="color:#a94442;">Lỗi ! </strong><?php echo $_SESSION['error'];
                                                                unset($_SESSION['error']) ?>
            </div>
        <?php endif ?>
        <!-- NOTIFiCATION -->
        <!-- ----------MAIN-------------- -->
        <h3 class="title-main"><a href="">Giỏ hàng của bạn</a></h3>
        <table class="table table-hover" style="margin-bottom: 25px;" id="shoppingcart_info">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên sản phẩm</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Đơn giá</th>
                    <th scope="col">Thành tiền</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1;
                foreach ($_SESSION['cart'] as $key => $value) : ?>
                    <tr>
                        <td><?php echo $stt ?></td>
                        <td><?php echo $value['name'] ?></td>
                        <td>
                            <img src="<?php echo uploads() ?>product/<?php echo $value['thumbar'] ?>" width="80px" height="60px">
                        </td>
                        <td style="text-align: center;">
                            <input type="number" class="qty" value="<?php echo $value['qty'] ?>" min="0" max="10" step="1" name="qty" />
                        </td>
                        <td><?php echo formatPrice($value['price']) ?></td>
                        <td><?php echo formatPrice($value['qty'] * $value['price']) ?></td>
                        <td>
                            <a href="#" class="btn btn-xs btn-info updatecart" data-key=<?php echo $key ?>>
                                <i style="color: #fff;" class="fa fa-refresh"></i>
                                Cập nhật
                            </a>
                            <a href="remove_cart.php?key=<?php echo $key ?>" class="btn btn-xs btn-danger">
                                <i style="color: #fff;" class="fa fa-times"></i>
                                Xóa
                            </a>
                        </td>
                    </tr>
                    <?php $sum += $value['price'] * $value['qty'];
                    $_SESSION['total'] = $sum; ?>
                <?php $stt++;
                endforeach ?>
            </tbody>
        </table>
        <div>
            <div class="col-md-6 pull-right">
                <ul class="list-group">
                    <li class="list-group-item">
                        <h3>Thông tin thanh toán</h3>
                    </li>
                    <li class="list-group-item">
                        <span class=" badge"><?php echo formatPrice($_SESSION['total']) ?></span> Tổng tiền (chưa tính VAT)
                    </li>
                    <li class="list-group-item">
                        <span class=" badge"><?php echo formatPrice($_SESSION['total'] * 3 / 100)  ?></span> VAT 3%
                    </li>
                    <li class="list-group-item">
                        <span class=" badge"><?php echo formatPrice($_SESSION['total'] * 103 / 100)  ?></span> Thành tiền
                    </li>
                    <li class="list-group-item">
                        <span class=" badge"> - <?php echo formatPrice($_SESSION['total'] * (sale($_SESSION['total']) / 100)) ?> </span> Giảm giá <?php echo sale($_SESSION['total']) ?>%
                    </li>
                    <li class="list-group-item" style="font-size:16px; font-weight: 700;">
                        <span class=" badge" style="font-size:16px;"><?php $_SESSION['total_bill'] = $_SESSION['total'] * 110 / 100;
                                                                        echo formatPrice($_SESSION['total_bill'] - ($_SESSION['total'] * (sale($_SESSION['total']) / 100))) ?></span> Thanh toán
                    </li>
                    <li class="list-group-item">
                        <a href="index.php" class="btn btn-warning">Tiếp tục mua</a>
                        <a href="payment.php" class="btn btn-success">Thanh toán ngay</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ----------MAIN-------------- -->
    </section>
</div>
<div class="col-md-9 bor" style="margin-top: 15px;">
    <div class="col-md-12" style="margin-top: 40px;">
        <h3 style="font-weight: bold; text-align: center; color: #cc0000; ">SẢN PHẨM LIÊN QUAN</h3>
        <div class="showitem" style="margin-top: 10px; margin-bottom:10px;">
            <?php foreach ($productoffer as $item) : ?>
                <div class="col-md-3 item-product bor">
                    <a href="detail_product.php?id=<?php echo $item['id'] ?>">
                        <img src="<?php echo uploads() ?>product/<?php echo $item['thumbar'] ?>" class="" width="100%" height="130px">
                    </a>
                    <div class="info-item">
                        <a class="nametext" href="detail_product.php?id=<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a>
                        <p><strike class="sale"><?php echo formatPrice($item['price']) ?></strike> <b class="price"><?php echo formatPriceSale($item['price'], $item['sale']+$item['sale1']) ?></b></p>
                    </div>
                    <div class="hidenitem">
                        <p><a href="detail_product.php?id=<?php echo $item['id'] ?>"><i class="fa fa-search"></i></a></p>
                        <p><a href=""><i class="fa fa-heart"></i></a></p>
                        <p><a href=""><i class="fa fa-shopping-basket"></i></a></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php require_once __DIR__ . "/layouts/footer.php"; ?>