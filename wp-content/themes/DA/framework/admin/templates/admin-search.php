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

global $wpdb, $CORE, $CORE_ADMIN, $advance_search;
		
$core_admin_values = get_option("core_admin_values");

$fields = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}core_search ORDER BY `order` ASC" );

?>
        <input type="hidden" name="searchform" value="1" />
    <div class="row-fluid">

    <div class="box gradient span8">
    <div class="title">
            <div class="row-fluid">
          
          
<div class="btn-group pull-right" style="margin-top: 5px;    margin-right: 15px;">
  <a class="btn dropdown-toggle btn-success" data-toggle="dropdown" href="#">
   Add New Field
    <span class="caret"></span>
  </a>
  <ul class="dropdown-menu asw-elements">
      <li style="margin:0px;"><a href="#" onclick="window.scrollTo(0,document.body.scrollHeight);" id="asw-search-add-btn">Search Field</a></li>
      <li style="margin:0px;"><a href="#" onclick="window.scrollTo(0,document.body.scrollHeight);" id="asw-custom-add-btn">Custom Field</a></li>
      <li style="margin:0px;"><a href="#" onclick="window.scrollTo(0,document.body.scrollHeight);" id="asw-tax-add-btn">Taxonomy Field</a></li>        
      <li style="margin:0px;"><a href="#" onclick="window.scrollTo(0,document.body.scrollHeight);" id="asw-head-add-btn">Heading Separator</a></li> 
  </ul>
</div>
          
          
          
            
            <h3><i class="gicon-search"></i>Advanced Search Fields</h3></div>
    </div>
    <div class="content">
    
     <div id="asw-ajax-response"></div>
	
    	<ul class="asw-form-elements">
                            <?php
                            if ( $fields ) {
                                echo $advance_search->build_builder_form( $fields );
                            } else {
                                $advance_search->search_field();
                            }
                            ?>
         </ul>
        <?php //submit_button(); ?>
            <?php do_action('hook_admin_1_tab4_left'); ?>            
    
    </div> 
 
    
    </div>            
	 

    <div class="span4">
    
      <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('oh1UP9fpYDw','videoboxplayer','479','350');" style="width:100%; margin-bottom:10px; ">Watch Video Tutorial</a>
 
    
    
     <div class="box gradient">
     <div class="title"><div class="row-fluid"><h3><i class="gicon-retweet"></i> Search Data</h3></div></div>
     <div class="content">
     
    
     <p>Select the content you wish to include in search results.</p>
 
     
     <div class="checkbox"> <input name="admin_values[dstypes][]" type="checkbox" value="<?php echo THEME_TAXONOMY; ?>_type" checked="checked" /> Listings (on by default) </div>
     <div class="checkbox"> <input name="admin_values[dstypes][]" type="checkbox" value="page" <?php if(isset($core_admin_values['dstypes']) && is_array($core_admin_values['dstypes']) && in_array("page",$core_admin_values['dstypes'])){ echo "checked=checked"; } ?> /> Pages </div>
     <div class="checkbox"> <input name="admin_values[dstypes][]" type="checkbox" value="post" <?php if(isset($core_admin_values['dstypes']) && is_array($core_admin_values['dstypes']) && in_array("post",$core_admin_values['dstypes'])){ echo "checked=checked"; } ?> /> Blog Posts </div>
     
     
     
     
  
    
    
     </div></div> 
       
    
   </div>
             
  </div><!-- end fluid -->

    <div class="clear"></div>
	<script type="text/html" id="asw-search-template">
    <?php $advance_search->search_field(); ?>
    </script>
            
            <script type="text/html" id="asw-custom-template">
        <?php $advance_search->custom_field(); ?>
            </script>

            <script type="text/html" id="asw-tax-template">
        <?php $advance_search->taxonomy_field(); ?>
            </script>
            
            
            <script type="text/html" id="asw-head-template">
        <?php $advance_search->head_field(); ?>
            </script>
  