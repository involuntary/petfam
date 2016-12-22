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

global $CORE;

// GET HOME PAGE CUSTOM DATA
$HDATA = $GLOBALS['CORE_THEME']['hdata'];





function _hook_header_after(){

// TEXT
$HDATA = $GLOBALS['CORE_THEME']['hdata'];

// MAIN IMAGE
if(isset($HDATA['j1']['img']) && $HDATA['j1']['img'] != ""){ 
	
	$img1 = $HDATA['j1']['img']; 
}else{

	$img1 = get_template_directory_uri()."/templates/".$GLOBALS['CORE_THEME']['template']."/img/main.png";
}

?>

<?php if(!isset($GLOBALS['CORE_THEME']['home_section1']) || (isset($GLOBALS['CORE_THEME']['home_section1']) && $GLOBALS['CORE_THEME']['home_section1'] == '1' ) ){  ?>

<?php if(isset($GLOBALS['CORE_THEME']['homesliderid']) && $GLOBALS['CORE_THEME']['homesliderid'] != "" && $GLOBALS['CORE_THEME']['homeslider'] == 1 ){  

echo do_shortcode(stripslashes("[rev_slider ".$GLOBALS['CORE_THEME']['homesliderid']."]")); 

}else{ ?>

   <div id="mainbox">  
        
        <div class="container"><div class="row">
        
        	<div class="col-md-4 col-sm-6">
            
            <div class="block">
             
            	<div class="block-content"> 
                   
            		<h1><?php echo stripslashes($HDATA['j1']['title1']); ?></h1>
                    
                    <p><?php echo stripslashes($HDATA['j1']['title2']); ?></p>
                
                <?php echo core_search_form(null,'home'); ?>
                
                </div>
                
            </div> 
            
            </div>
            
            <div class="col-md-8 col-sm-6">
            
            	  <div id="mainphoto"><img src="<?php echo $img1; ?>" alt="main" class="img-responsive" /></div>
                 
            </div>
        
         
        </div></div>
        
        </div> 
        

<?php } ?>

<?php } ?>
   
<?php
}
add_action('hook_header_after', '_hook_header_after');



 
// HEADER
get_header($CORE->pageswitch()); 



?> 

 
















<?php if(!isset($GLOBALS['CORE_THEME']['home_section2']) || (isset($GLOBALS['CORE_THEME']['home_section2']) && $GLOBALS['CORE_THEME']['home_section2'] == '1' ) ){  ?>

<div id="car1" class="owl-carousel wlt_search_results grid_style style1">
<?php echo do_shortcode('[LISTINGS dataonly=1 show=10]'); $GLOBALS['imagecount']=6; ?> 
</div>
<hr />
<script> 
jQuery(document).ready(function() {  
jQuery("#car1").owlCarousel({ items : 4, autoPlay : true,  }); 
});
</script>
<?php } ?>

<?php if(!isset($GLOBALS['CORE_THEME']['home_section3']) || (isset($GLOBALS['CORE_THEME']['home_section3']) && $GLOBALS['CORE_THEME']['home_section3'] == '1' ) ){  ?>

<div class="row">
  
<div class="col-md-4">
<a href="<?php echo $HDATA['t3']['link1']; ?>"><img src="<?php if(isset($HDATA['t3']['img1']) && strlen($HDATA['t3']['img1']) > 2){ echo $HDATA['t3']['img1']; }else{ ?>http://placehold.it/350x150&text=males<?php } ?>" class="r1" alt="males"></a>
</div>

<div class="col-md-4">
<a href="<?php echo $HDATA['t3']['link2']; ?>"><img src="<?php if(isset($HDATA['t3']['img2']) && strlen($HDATA['t3']['img2']) > 2){ echo $HDATA['t3']['img2']; }else{ ?>http://placehold.it/350x150&text=females<?php } ?>" class="r2" alt="females"></a>
</div>

<div class="col-md-4">
<a href="<?php echo $HDATA['t3']['link3']; ?>"><img src="<?php if(isset($HDATA['t3']['img3']) && strlen($HDATA['t3']['img3']) > 2){ echo $HDATA['t3']['img3']; }else{ ?>http://placehold.it/350x150&text=couples<?php } ?>" class="r3" alt="couples"></a>
</div>

</div>

<hr />

<?php } ?>

<?php if(!isset($GLOBALS['CORE_THEME']['home_section4']) || (isset($GLOBALS['CORE_THEME']['home_section4']) && $GLOBALS['CORE_THEME']['home_section4'] == '1' ) ){  ?>

<div id="car2" class="owl-carousel wlt_search_results grid_style style1">
<?php echo do_shortcode('[LISTINGS dataonly=1 show=10 custom="random"]'); $GLOBALS['imagecount']=6; ?> 
</div>
<script> 
jQuery(document).ready(function() {  
jQuery("#car2").owlCarousel({ items : 4, autoPlay : true,  }); 
});
</script>
<?php } ?>

  

<?php get_footer($CORE->pageswitch()); ?>