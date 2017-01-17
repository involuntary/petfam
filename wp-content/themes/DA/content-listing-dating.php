<?php
/*
* Theme: PREMIUMPRESS CORE FRAMEWORK FILE
* Url: www.premiumpress.com
* Author: Mark Fail
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
?>

<?php global $CORE, $post, $userdata;


ob_start();

            $my_list = get_user_meta($userdata->ID, 'favorite_list',true);

            $btn_text = '';
            $btn_class = '';

            if ( !empty( $my_list ) && in_array($post->ID, $my_list ) ) {
                $btn_text = 'Remove from Favourites';
                $btn_class = 'cpm-btn-remove';
            } else {
                $btn_text = 'Add to Favourites';
                $btn_class = 'btn-success';
            }
?>

<div class="itemdata icons itemid<?php echo $post->ID; ?> <?php hook_item_class(); ?>" <?php echo $CORE->ITEMSCOPE('itemtype'); ?>>

<div class="thumbnail clearfix">

    [IMAGE]

    <div class="content">

        <h4>[TITLE] </h4>

        <small>[GENDER-ICON] [GENDER] / [AGE] / [LOCATION-FLAG] / [DISTANCE] / Joined: [DATE]</small>
        <br>
        <?php $STRING .= 'onclick="WLTAddF(\''.str_replace("http://","",get_home_url()).'\', \'favorite\', '.$post->ID.', \'core_ajax_callback\');"'; ?>
        <a class="btn btn-labeled custom-btn <?php echo $btn_class; ?>" id="cpm-btn-<?php echo $post->ID; ?>" <?php echo $STRING;?>> <span class="btn-label"><i class="fa fa-star"></i></span>
        <span id="cpm-btn-text-<?php echo $post->ID; ?>"><?php echo $btn_text; ?></span></a>

        <small>[EXCERPT size=500]  </small>
    </div>


</div>

</div>


<?php
$SavedContent = ob_get_clean();
?>
<?php echo hook_item_cleanup($CORE->ITEM_CONTENT($post, hook_content_listing($SavedContent))); ?>
