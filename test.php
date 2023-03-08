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
        <li> No results match! </li>
    </ul>
<?php endif ; ?>

<!-- <div class="compoment_rating_content" style="display:flex;align-items: center; border: 1px solid #dedede;border-radius: 5px;">
    <div class="rating_item" style="width: 20%;position: relative;">
        <span class="fa fa-star" style="font-size: 100px;display: block;margin: 0 auto;text-align: center ; color: #ff9705"></span>
        <b style="position: absolute;top: 50%;left: 50%;transform: translateX(-50%) translateY(-50%);color: white;font-size:20px;"><?php echo $ageDetail ?></b>
    </div> -->




<!-- <div class="list_rating" style="width: 60%;padding: 20px;" >
    <div class="item_rating" style="display:flex ;align-items: center">
        <div style="width: 10%; font-size: 14px">
            1 <span style="margin-left: 5px" class=" fa fa-star"></span>
        </div>
        <div style="width: 70%; margin:0 20px">
            <span style="width:100%; height: 8px;display: block;border: 1px solid #dedede ; border-radius:5px; " >
            <b style="width: 0%; background-color: #ff9705; display: block; border-radius: 5px;height: 100%; "></b>
            </span>
        </div>
        <div style="width: 20%;">
            <a href=""> 0 Rating</a>
        </div>
    </div>
    <div class="item_rating" style="display:flex ;align-items: center">
        <div style="width: 10%; font-size: 14px">
            2 <span style="margin-left: 5px" class=" fa fa-star"></span>
        </div>
        <div style="width: 70%; margin:0 20px">
            <span style="width:100%; height: 8px;display: block;border: 1px solid #dedede ; border-radius:5px; " >
            <b style="width: 0%; background-color: #ff9705; display: block; border-radius: 5px;height: 100%; "></b>
            </span>
        </div>
        <div style="width: 20%;">
            <a href=""> 0 Rating</a>
        </div>
    </div>
    <div class="item_rating" style="display:flex ;align-items: center">
        <div style="width: 10%; font-size: 14px">
            3 <span style="margin-left: 5px" class=" fa fa-star"></span>
        </div>
        <div style="width: 70%; margin:0 20px">
            <span style="width:100%; height: 8px;display: block;border: 1px solid #dedede ; border-radius:5px; " >
            <b style="width: 0%; background-color: #ff9705; display: block; border-radius: 5px;height: 100%; "></b>
            </span>
        </div>
        <div style="width: 20%;">
            <a href=""> 0 Rating</a>
        </div>
    </div>
    <div class="item_rating" style="display:flex ;align-items: center">
        <div style="width: 10%; font-size: 14px">
            4 <span style="margin-left: 5px" class=" fa fa-star"></span>
        </div>
        <div style="width: 70%; margin:0 20px">
            <span style="width:100%; height: 8px;display: block;border: 1px solid #dedede ; border-radius:5px; " >
            <b style="width: 80%; background-color: #ff9705; display: block; border-radius: 5px;height: 100%; "></b>
            </span>
        </div>
        <div style="width: 20%;">
            <a href=""> 1 Rating</a>
        </div>
    </div>
    <div class="item_rating" style="display:flex ;align-items: center">
        <div style="width: 10%; font-size: 14px">
            5 <span style="margin-left: 5px" class=" fa fa-star"></span>
        </div>
        <div style="width: 70%; margin:0 20px">
            <span style="width:100%; height: 8px;display: block;border: 1px solid #dedede ; border-radius:5px; " >
            <b style="width: 90%; background-color: #ff9705; display: block; border-radius: 5px;height: 100%; "></b>
            </span>
        </div>
        <div style="width: 20%;">
            <a href=""> 2 Rating</a>
        </div>
    </div> 
</div> -->
















<option value="2" <?php echo isset($data['level']) && $data['level'] == 2 ? "selected='selected'":''?> > CTV </option>