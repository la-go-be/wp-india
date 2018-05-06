<?php
/*
template name: Promotion Page (Man)
*/

global $redux_demo;

$banner_2_img = $redux_demo['banner-2-img'];
?>

<style>
    @import url("https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css");
    
    body {
        background-color: lightsteelblue;
    }
    
    .promotion-container {
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: center;
        align-items: center;
    }
</style>

<div class="promotion-container">
    <img src="<?php echo $banner_2_img['url']; ?>" class="img-responsive" />
</div>