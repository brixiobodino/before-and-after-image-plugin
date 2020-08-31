<?php
function beforeafterview($atts){ 

    ob_start();
    extract(shortcode_atts(array('id'=> ''),$atts));
    global $wpdb;
    $result=$wpdb->get_row("select * from wp_before_after where id=$id");
    if($id){
        $img_before=$result->img_url1;
        $img_after=$result->img_url2;  
    }else{
        $img_before=plugins_url()."/before-after-effect-bodino/img/before.jpg";
        $img_after=plugins_url()."/before-after-effect-bodino/img/after.jpg";
    }
    ?>
  
    <?php
   
    include_once('template1.php');

    return ob_get_clean();
}

add_shortcode("before-after-effects","beforeafterview");