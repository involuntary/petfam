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


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values"); 

// GET SAVED DAT
$tax = get_option('custom_taxonomy');  
  
?> 
   <div class="row-fluid">
      <div class="span6">
      
        <div class="box gradient">
          <div class="title"><h3><i class="icon-download"></i><span>Custom Taxonomies</span></h3></div>
          <div class="content">
          
          <p><span class="label label-warning">Important!</span> Taxonomy keys should NOT contain spaces, special characters or foreign characters and must be greater than 3 characters in length.</p>
          
          
          <hr />
        <?php $i=0; while($i < 10){ ?>
        <!---- FIELD --->
        <div class="form-row control-group row-fluid">
        <label class="control-label span4" for="normal-field"><b>Taxonomy <?php echo ($i)+1; ?> Key</b></label>
        <div class="controls span7">
        <input type="text" name="adminArray[custom_taxonomy][<?php echo $i; ?>]" value="<?php if(isset($tax[$i])){ echo $tax[$i]; } ?>" /> 
        </div>       
        </div>
        <!---- FIELD --->
        <?php $i++; } ?>
      
	</div>
            
 	</div></div>  
    <div class="span6">
    
    
          <div class="box gradient">
      <div class="title"><h3><i class="icon-download"></i><span>What is a taxonomy?</span></h3></div>
      <div class="content">
      
      <h4><b>Taxonomies are used to group things together.</b></h4>
      
      <p>For example, if you want to group together products in a shop by color, you would do this using taxonomies.</p>
      
      <p>We would create a taxonomy key called "color" and then setup the different colors such as red, blue, green etc.</p>
      
      <p>We can then assign products to our new taxonomy which will help users search for products by color allot easier.</p>
      
      <p>More information on taxonomies can be found here;</p>
      
      <p><a href="https://codex.wordpress.org/Taxonomies" target="_blank" style="color:blue; text-decoration:underline;">https://codex.wordpress.org/Taxonomies</a></p>
      
      </div>
      </div>  
    

    
    
    
    
    
    
    
      <div class="box gradient">
      <div class="title"><h3><i class="icon-download"></i><span>Display Taxonomy Data</span></h3></div>
      <div class="content">
      
      <p>To display the data saved in a taxonomy, you can use the shortcodes;</p>
      <p>[CTAX key=XXXX]</p>
      <p>Replace XXXXX with the key you've assigned opposite for your taxonomy.</p>
      
      </div>
      </div>    
   
    </div>  
    
     
    </div> 