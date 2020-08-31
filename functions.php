<?php

	function getParam($page){
	//echo $page;
	if(isset($_REQUEST[$page])){
		$page = $_REQUEST[$page];
	} else {
		$page = '';
	}	
	return $page;
	}
$task= getParam('task'); 

switch($task){
	case 'index':
		index();
	break;

	case 'save':
		save();
		index();
	break;

	default:
		index();
		form();
	break;

	}

?>
<?php
	function index(){
		global $wpdb;
		$results=$wpdb->get_results("select * from wp_before_after Where status='active'");
?>
<table style="width: 95%;">
     <tr> 
     	<th>Id</th>
        <th> Before Image</th>
	    <th> After Image</th>
	    <th colspan="1"> Shortcode</th>
	     <th colspan="2">Action</th>
      </tr>
	<link rel="stylesheet" type="text/css" href="<?php echo plugins_url();?>/before-after-effect-bodino/distr/style.css">
<?php
	foreach ($results as $row ){
?>
<tr style="text-align: center;">
			<td><?php echo $row->id;?></td>
			<td><img src='<?php echo $row->img_url1;?>'width="200px"></td>
            <td><img src='<?php echo $row->img_url2;?>'width="200px"></td>
			<td>before-after id=<?php  echo $row->id; ?></td>
			<td><a href="http://localhost/wordpress-bodino/wp-admin/admin.php?page=before-after-effects&action=edit&id=<?php echo $row->id;?>">Edit</a></td>
<td><a href="http://localhost/wordpress-bodino/wp-admin/admin.php?page=before-after-effects&action=delete&id=<?php echo $row->id;?>" style="color:red;">Delete</a></td>
</tr>
<?php
}
}function form(){
?>
<div class="form">
<form action="<?php echo plugins_url();?>/before-after-effect-bodino/before-after-effect-bodino.php?task=save" method="POST">
<label> Before Image</label> <input type="text" name="before_img_new" id="before_img_new"> <input type="button" name="upload-btn" id="before-btn" class="button-secondary" value="Upload Image"><br>
<label id="after"> After Image</label>   <input type="text" name="after_img_new" id="after_img_new" />
<input type="button" name="upload-btn" id="after-btn" class="button-secondary" value="Upload Image"><br>
<input type="submit" name="submit" value="Save" />
</form>  
</div>
<?php 
	wp_enqueue_script('jquery');
	// This will enqueue the Media Uploader script
	wp_enqueue_media();
?>
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
}function save(){
	if (isset( $_POST['submit'] )){
	global $wpdb;
	$id=$_POST['id'];
	if (isset($id)) {
		$wpdb->update('wp_before_after', array('img_url1' =>$_POST['before_img'],'img_url2' => $_POST['after_img'] ),array('id'=>$id));
	}else{
	$status="active";
	$wpdb->insert( 'wp_before_after', array('img_url1' => $_POST['before_img_new'], 'img_url2' => $_POST['after_img_new'],'status'=>$status ));
    }

}
}
?>