<?php 
    require_once __DIR__. "/autoload/autoload.php"; 
    $sql ="SELECT * from product WHERE 1";
    $keyword=''; 
    if(isset($_GET['keyword']) && $_GET['keyword'] != NULL)
    {
        $keyword = $_GET['keyword'];
        $sql .=" AND name LIKE '%$keyword%'";
    }
    $resultsearch =$db->fetchsql($sql);
?>
<?php if(isset($resultsearch) && count($resultsearch)> 0):?>
    <ul id="returnsearch">
        <?php foreach($resultsearch as $item) :?>
            <li class="item-product-search">
                <a href="detail_product.php?id=<?php echo $item['id'] ?>">
                    <img src="<?php echo uploads()?>product/<?php echo $item['thumbar']?>" class="" width="30%" height="60px">
                    <a href="detail_product.php?id=<?php echo $item['id'] ?>"><?php echo $item['name']?></a>
                </a>
                <div class="clearfix"></div>
            </li>
        <?php endforeach ;?>
    </ul>
<?php else : ?>
    <ul id="returnsearch">
        <li> Không tìm thấy kết quả! </li>
    </ul>
<?php endif ; ?>
