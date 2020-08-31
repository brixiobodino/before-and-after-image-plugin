<link rel="stylesheet" type="text/css" href="<?php echo plugins_url();?>/before-after-effect-bodino/distr/imgslider.min.css">
        <script type="text/javascript" src="<?php  echo plugins_url();?>/before-after-effect-bodino/distr/imgslider.min.js"></script>
        <div id="mainDiv">
            <h1>Simple Image Slider</h1>
            <div class='slider responsive'>
                <div class='left image'><img src='<?php echo $img_before;?>'></div>
                <div class='right image' ><img src='<?php echo $img_after;?>'></div>
            </div>
        </div>
        <script type="text/javascript">jQuery('.slider').slider();</script>