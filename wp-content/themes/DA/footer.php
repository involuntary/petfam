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

 global $CORE, $userdata; 
 
if(!isset($GLOBALS['wlt_remove_body'])){

?>
 	
        <?php if(!isset($GLOBALS['flag-custom-homepage'])): ?>
        
        <?php echo $CORE->BANNER('middle_bottom'); ?>
        
       </div></article>
        
 
        <?php if(!isset($GLOBALS['nosidebar-right'])): ?>
        
        <?php if(defined('WLT_DEMOMODE') && isset($_SESSION['skin']) && file_exists(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/sidebar-right.php") ){

			include(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/sidebar-right.php");	
			
		}else{ ?>
        
        <?php get_template_part( 'sidebar', 'right' ); ?>
        
        <?php } ?>
        
        <?php endif; ?>       
        
        <?php hook_core_columns_after(); ?>  
    
    <?php endif; ?>
    
    </div>
    
    </div>
    
	</div>

	</div> 

</div>

<?php hook_container_after(); ?> 

<?php get_template_part( 'footer', 'menu' ); ?> 
 
</div>

<?php hook_wrapper_after(); ?>

<?php } // remove body ?>
 
<div id="core_footer_ajax"></div>
  
<?php wp_footer(); ?>

</body> 

</html>