<?php include "files/header.php"?>
<?php session_start();?>
<link rel="stylesheet" type="text/css" href="https://citycenter.jo/image/cache/tb/main.d60ce69b242ee9fe8408d682abe66a8d.css" media="all">
<link rel="stylesheet" type="text/css" href="https://citycenter.jo/image/cache/tb/dynamic.c4a4fc9c61162d0ea6422965989ba0b0.css" media="all">
<form method="post" action="">
<table style="background:#e9e9e9;border-bottom: 1px solid #cccccc;" border="0" width="100%">
<tr>
    <td class="imagea">الصورة</td>
    <td class="titlea">إسم المنتج</td>
    <td class="modela">الموديل</td>
    <td class="qtya">الكمية</td>
    <td class="pricea">سعر المنتج</td>
    <td class="tota">السعر الإجمالي</td>
    </tr>
    <?php 
    global $connect;
        $ip=getIp();
        $total = 0;
        $t_price = "select * from cart where ip_add = '$ip'";
        $run_price = mysqli_query($connect, $t_price);
    while($row_t_price = mysqli_fetch_array($run_price)){
        $pro_id_t = $row_t_price['p_id'];
        $price_pro = "select * from product where p_id = '$pro_id_t'";
        $run_price_pro = mysqli_query($connect, $price_pro);
        while($row_price_pro = mysqli_fetch_array($run_price_pro)){
            $pro_price = array($row_price_pro['p_price']);
            $pro_title = $row_price_pro['p_title'];
            $pro_img = $row_price_pro['p_img'];
            $pro_price_single = $row_price_pro['p_price'];
            $pro_model = $row_price_pro['p_model'];
            $pro_id_z =(int) $row_price_pro['p_id'];
            $values = array_sum($pro_price);
            $total +=$values;
        }
        $get_pro_q = "select * from product";
    $run_pro_q = mysqli_query($connect, $get_pro_q);
    while($row_pro_q = mysqli_fetch_array($run_pro_q)){
        echo '<a href="more.php?id='.$row_pro_q['p_id'].'"></a>';
    }
    ?>
    
    <tr>
    <td class="imageb"><div><img width="80%" src="admin/images/<?php echo $pro_img;?>"></div></td>
    <td class="titleb"><div><a href="<?php echo 'more.php?id='.$pro_id_z.'';?>"><?php echo $pro_title; ?></a></div></td>
    <td class="modelb"><div><?php echo $pro_model;?></div></td>
        
    <div class="cart-info tb_min_w_500">
        
     <!-- problem start / by 3bada-19 -->     
    <td class="quantity"><div class="input-group btn-block" style="max-width: 200px;">
    <input type="text" name="obd[]" size="5" value="<?php print_r($_SESSION['obd'])?>" class="form-control"/>
        
        
        
    <span class="input-group-btn">
    <button type="submit" title="Update" class="btn btn-default tb_no_text" name="update_car"><i class="fa fa-refresh"></i></button>
        
        
    <?php 
        global $connect;
    $ip=getIp();

    if (isset($_POST['update_cart'])) {
      foreach($_POST['obd'] as $key => $rev) {
       $update_rev = "update cart set raw='$rev' where p_id = '$key' AND ip_add = '$ip'";
       $run_u_rev = mysqli_query($connect, $update_rev);
       $_SESSION['obd'][] = $rev;
        
    } }?>
        
        
    <button class="btn btn-danger tb_no_text" type="submit" name="remove[]" value="<?php echo $pro_id_t;?>"><i class="fa fa-times-circle"></i></button></span></div>
    </td>             
   </div>
    <!-- problem end / by 3bada-19 -->
    <td class="priceb"><div><?php echo $pro_price_single;?> د.أ</div></td>
    <td class="totb"></td>
    </tr>
    
    <?php
    }   
    

    ?>
    <tr><th>السعر الكامل: <?php echo $total;?></th></tr>
    
    <tr>
    <th><input type="submit" name="update_cart" value="refresh"></th>
    </tr>
    <?php
    $ip=getIp();
    if(isset($_POST['remove'])){
        foreach($_POST['remove'] as $id_remove){
            $delete_pro = "delete from cart where p_id = '$id_remove' AND ip_add = '$ip'";
            $run_delete = mysqli_query($connect, $delete_pro);
            if($run_delete){
            echo("<meta http-equiv='refresh' content='0'>");
            }
        }
    }
    
    ?>
    
</table>
    
</form>
<?php include "files/footer.php"?>