<?php

/*
Plugin Name: Before and After Effects 
Plugin URI: http:www.facebook.com/bodino
Description: Creating Before and After Effects Animations  
Author: Brixio Bodino
Version: 1.0
Author URI: http:brixiobodinoprogrammer.com.ph
*/
include_once('shortcode.php');
function AddMenu(){
	add_menu_page("Before & After Dashboard","Before and After Dashboard Page","manage_options","before-after-effects","bodino_dashboard");
}
add_action('admin_menu','AddMenu');

function bodino_dashboard(){
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url();?>/before-after-effect-bodino/distr/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url();?>/before-after-effect-bodino/distr/imgslider.min.css">
    <!--
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url();?>/before-after-effect-bodino/distr/web-fonts-with-css/css/fontawesome-all.css"> -->
    <script src="https://kit.fontawesome.com/a837cb4006.js"></script>
    <script type="text/javascript" src="<?php echo plugins_url();?>/before-after-effect-bodino/distr/imgslider.min.js"></script>
    <div class="wrap">
    <div class="bodino_dashboard">
    <div class="dashboard_title" style="height: auto;">
        <div>
           <h3>Before and After Effects Plugin Dashboard</h3>
        </div>
    </div>
    <?php
    $task=$_REQUEST['task'];
    // saving and updating record
    if (isset($_POST['submit'])){
        global $wpdb;
        $id=$_REQUEST['id'];
        if ($id) {
            $wpdb->update('wp_before_after', array('img_url1' =>$_POST['before_img'],'img_url2' => $_POST['after_img'] ),array('id'=>$id));
        }else{
            $status="active";
            $wpdb->insert( 'wp_before_after', array('img_url1' => $_POST['before_img'], 'img_url2' => $_POST['after_img'],'status'=>$status ));
        }
    }   // end of saving and updating record

    // deleting record
    if ($task=='delete') {
        global $wpdb;
        $id=$_REQUEST['id'];
        $wpdb->delete( 'wp_before_after', array('id'=>$id));
    }   // end of deleting record

    // view slider
    
    if ($task=='view') {
            $id = $_REQUEST['id']; 
            global $wpdb;
            $result=$wpdb->get_row("select * from wp_before_after Where id=$id");
        ?>
      
            <div id="mainDiv" class="main_content" style="margin: 0 auto;width: 40%;">
                <h1>Preview Image Slider <span class='close_preview' title="close preview"><a href="<?php get_admin_url();?>?page=before-after-effects">&times;</a></span></h1>
                <div class="slider responsive">
                    <div class="left image" id="left">
                        <img src="<?php echo $result->img_url1;?>" />
                    </div>
                    <div class="right image" id="right">
                        <img src="<?php echo $result->img_url2;?>"/>
                    </div>
                </div>
            </div>
        
            <script type="text/javascript">
                jQuery('.slider').slider();
            </script>
        

   



     <?php
       }// end of view slider
    // displaying form
    global $wpdb;
    $id = $_GET['id']; 
    $result2=$wpdb->get_row("select * from wp_before_after Where id=".$id);
    $id2=$result2->id;
    if($id2){
        $btn_upload='Change Image';
        $btn_save='Update';
        $id=$result2->id;
        $img_before=$result2->img_url1;
        $img_after=$result2->img_url2;
    }else{
        $btn_upload='Upload Image';
        $btn_save='Save';
        $id='';
        $img_before='';
        $img_after='';
    }
?>
<div class="form">
    <form action="<?php get_admin_url();?>?page=before-after-effects" method="POST">
        <input type="hidden" value="<?php echo $id ?>" name="id" />
        <label> Before Image</label> <input type="text" name="before_img" value="<?php echo $img_before ;?>" id="before_img_new">
        <input type="button" name="upload-btn" id="before-btn" class="button-secondary" value="<?php echo $btn_upload;?>"><br>
        <label id="after"> After Image</label>  
        <input type="text" name="after_img" value="<?php echo $img_after ;?>" id="after_img_new"/>
        <input type="button" name="upload-btn" id="after-btn" class="button-secondary" value="<?php echo $btn_upload;?>"><br>
        <div style="text-align: right;width:99%" >
            <input type="submit" name="submit" value="<?php echo $btn_save;?>"" />
        </div>
    </form>  
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('#before-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#before_img_new').val(image_url);
        });
    });
    $('#after-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#after_img_new').val(image_url);
        });
    });
});
</script>

    <?php 
        wp_enqueue_script('jquery');
        wp_enqueue_media(); // This will enqueue the Media Uploader script
    ?>
<?php

	global $wpdb; // query database
    $results=$wpdb->get_results("select * from wp_before_after Where status='active'");
    ?>
    <!--display table with data from database and form-->
<table>
     <tr> 
        <th>Id</th>
        <th> Before Image</th>
        <th> After Image</th>
        <th colspan="1"> Shortcode</th>
         <th colspan="3">Action</th>
      </tr>
<?php
    foreach ($results as $row ){
?>
<tr style="text-align: center;">
    <td id="bae_id"><?php echo $row->id;?></td>
    <td><img src='<?php echo $row->img_url1;?>'width="100px"></td>
    <td><img src='<?php echo $row->img_url2;?>'width="100px"></td>
    <td id="shortcode_text">[before-after-effects id=<?php  echo $row->id; ?>]</td>
    <td><a href=<?php get_admin_url();?>?page=before-after-effects&id=<?php echo $row->id;?>><i class="fas fa-edit" title="edit"></i></a></td>
     <td><a href="<?php get_admin_url();?>?page=before-after-effects&task=delete&id=<?php echo $row->id;?>" style="color:red;"><i class="fas fa-trash-alt" title="delete"></i></a></td>
    <td><a href="<?php get_admin_url();?>?page=before-after-effects&task=view&id=<?php echo $row->id;?>"><i class="fas fa-eye" title="view"></i></a></td>
</tr>

<?php
} // end of foreach loop
?>
</table>
</div>
</div>
<?php
} // end of bodino dashboard

 ?>


