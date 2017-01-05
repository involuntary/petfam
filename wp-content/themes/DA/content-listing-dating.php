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

<?php global $CORE, $post;


ob_start();

?>

<div class="itemdata icons itemid<?php echo $post->ID; ?> <?php hook_item_class(); ?>" <?php echo $CORE->ITEMSCOPE('itemtype'); ?>>

<div class="thumbnail clearfix">

    [IMAGE]

    <div class="content">

        <h4>[TITLE] </h4>

        <small>[GENDER-ICON] [GENDER] / [AGE] / [LOCATION-FLAG] / [DISTANCE] / Joined: [DATE]</small>
        <small>[EXCERPT size=500]  </small>
    </div>


</div>

</div>


<?php
$SavedContent = ob_get_clean();
?>
<?php echo hook_item_cleanup($CORE->ITEM_CONTENT($post, hook_content_listing($SavedContent))); ?>
