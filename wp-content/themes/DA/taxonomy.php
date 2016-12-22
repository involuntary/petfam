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

$GLOBALS['flag-search'] = 1;

$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
 
if(defined('WLT_DEMOMODE') && isset($_SESSION['skin']) && file_exists(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/taxonomy.php") ){

			include(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/taxonomy.php");	
			return "";
			
}else{

?>

<?php get_header($CORE->pageswitch());  ?>

<?php ob_start(); ?>

<?php hook_taxonomy_title_before(); ?>

<div class="taxonomytitle">

    <h1><?php echo $term->name; ?></h1>
  
    <h4><?php echo hook_gallerypage_results_text(str_replace("%a",number_format($wp_query->found_posts),$CORE->_e(array('gallerypage','1')))); ?></h4>
    
    <?php if(strlen($term->description) > 3){ echo wpautop(do_shortcode($term->description)); } ?>
    
    <?php echo hook_taxonomy_content_top(ob_get_clean()); ?>
 

<div class="clearfix"></div>


<?php if(have_posts() && $GLOBALS['CORE_THEME']['search_sortby'] == '1'){ ?>
 
<ul class="list-inline orderby clearfix">

    <li><strong><?php echo $CORE->_e(array('gallerypage','9')); ?>: </strong></li>
    
    <?php echo $CORE->OrderBy(); ?>
    
    <li class="pull-right hidden-xs hidden-sm">
    
     <a href="#" id="wlt_search_tab1" class="btn btn-default btn-sm <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] == "list"){ echo "active"; }?>">
                    <i class="fa fa-list"></i> <?php echo $CORE->_e(array('button','50')); ?></a>
                    
                    <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] != "listonly"){ ?>
                    <a href="#" id="wlt_search_tab2" class="btn btn-default btn-sm <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] == "grid"){ echo "active"; }?>">
                    <i class="fa fa-th-large"></i> <?php echo $CORE->_e(array('button','51')); ?></a>
                    <?php } ?>
                    
                    <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] != "listonly" && $GLOBALS['CORE_THEME']['google'] == 1){ ?>
                    <a href="#" id="wlt_search_tab3" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $CORE->_e(array('button','52')); ?></a>
                    <?php } ?> 
                    
                    <?php hook_gallerypage_results_btngroup(); ?>    
    </li>
    
</ul>

</div>
 
<?php } ?> 

<?php hook_taxonomy_title_after(); ?>

<?php get_template_part( 'search', 'results' ); ?>

<?php get_footer($CORE->pageswitch()); ?>

<?php } ?>