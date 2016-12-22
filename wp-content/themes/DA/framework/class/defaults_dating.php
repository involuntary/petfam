<?php

 
function _hook_admin_2_homeedit1($c){

$c['t3']['data']['img1'] = array( "t" => "Box 1 Image<br><small>(size: 350px / 150px )</small>", 	"type" => "upload", "d" => "https://placeholdit.imgix.net/~text?txtsize=62&txt=Image+Here&w=350&h=150" ); 
$c['t3']['data']['img2'] = array( "t" => "Box 2 Image<br><small>(size: 350px / 150px )</small>", 	"type" => "upload", "d" => "https://placeholdit.imgix.net/~text?txtsize=62&txt=Image+Here&w=350&h=150" ); 
$c['t3']['data']['img3'] = array( "t" => "Box 3 Image<br><small>(size: 350px / 150px )</small>", 	"type" => "upload", "d" => "https://placeholdit.imgix.net/~text?txtsize=62&txt=Image+Here&w=350&h=150" ); 

$c['t3']['data']['link1'] = array( "t" => "Box 1 Link", "d" => "http://www.google.com" ); 
$c['t3']['data']['link2'] = array( "t" => "Box 1 Link", "d" => "http://www.google.com" ); 
$c['t3']['data']['link3'] = array( "t" => "Box 1 Link", "d" => "http://www.google.com" ); 

return $c;
}
add_action('hook_admin_2_homeedit', '_hook_admin_2_homeedit1');



 



class core_dating extends white_label_themes {
 

	function __construct(){ global $wpdb;	
	
	// INSTALL DATABASE TABLES
	$this->INSTALLTABLES();
 
	
	// CHECK FOR ACTIONS
	add_action('init', array($this, '_actions' ) );
	
	// ADD FIELDS TO THE ADMIN
	add_action('hook_fieldlist_0', array($this, '_hook_adminfields' ) );
	
	// ADD IN NEW CUSTOM FIELDS
	add_action('hook_add_fieldlist',  array($this, '_hook_customfields' ) );
	
	// SHORTCODES	
	add_shortcode( 'PROFILEBUTTONS', array($this,'wlt_shortcode_profilebuttons') );
	add_shortcode( 'GENDER', array($this,'wlt_shortcode_gender') );
	add_shortcode( 'GENDER-ICON', array($this,'wlt_shortcode_gender_icon') );
	
	add_shortcode( 'ONLINESTATUS', array($this,'wlt_shortcode_onlinestatus') );
	add_shortcode( 'LISTINGDATA', array($this,'wlt_shortcode_listingdata') );
	
	add_shortcode( 'AGE',  array($this, 'wlt_shortcode_age' ) );
 	
 	add_shortcode( 'PROFILEDATA',  array($this, 'wlt_shortcode_profiledata' ) );
  
 	// ADD ON CHATROOM PAGE LINK
	add_action('hook_admin_1_tab1_subtab2_pagelist', array($this,'_updatepagelist' ));
 	
	// ADD FOOTER MODALS
	add_action('wp_footer', array($this, 'modals')); 
	
	// SEARCH FORM
	add_action('hook_gallerypage_searchform', array($this, 'extrasearch'));

	// ADDIN TO LIST
	add_action('hook_shortcodelist',array($this, '_hook_shortcodelist') );	
	
	// HOOK IN LANGUAGE TEXT
	add_action('hook_language_array', array($this,'_hook_language_array') );
	
	// HOOK DASHBOARD ITEMS
	add_action('hook_account_dashboard_items',  array($this, '_hook_account_dashboard_items' ) );
	
	// ADD IN NEW MEMBER AREA OPTIONS
	 add_action('hook_account_dashboard_before', array($this, '_visitorcounter' ) );
	
	// RESET DATABASE
	if(isset($_GET['resetchat']) && current_user_can('administrator') ){
	
		$wpdb->query("DROP TABLE ".$wpdb->prefix."core_useronline");		
		$wpdb->query("DROP TABLE ".$wpdb->prefix."core_chat_messages");		
		$wpdb->query("DROP TABLE ".$wpdb->prefix."core_chat_users");
		delete_option( "datingtabledinstalled1" );
	
	}
	
	 
	
    }
	
	 
	 

	function wlt_shortcode_profiledata($atts, $content = null){ global $CORE, $post, $wpdb, $userdata; 
	
		extract( shortcode_atts( array('key' => ''  ), $atts ) );	
		
		if($key == ""){ return; } 
		 
		$data = get_post_meta($post->ID,$key,true);
		if($age == ""){
		$age = $CORE->_e(array('single','57'));
		}
		
		switch($key){
		
			case "daeth": {
			
				$values =  array( 
			
				"1" => $CORE->_e(array('dating','46')), 
				"2" => $CORE->_e(array('dating','47')), 
				"3" => $CORE->_e(array('dating','48')),
				"4" => $CORE->_e(array('dating','49')),
				"5" => $CORE->_e(array('dating','50')),	
				"6" => $CORE->_e(array('dating','51')),	
				"7" => $CORE->_e(array('dating','52')),
				"8" => $CORE->_e(array('dating','53')),	
				"9" => $CORE->_e(array('dating','54')),
				"10" => $CORE->_e(array('dating','55')),
				
				);		
			
			} break;
			case "daeyes": {
			
				$values = array(
				"1" => $CORE->_e(array('dating','66')), 
				"2" => $CORE->_e(array('dating','67')), 
				"3" => $CORE->_e(array('dating','68')),
				"4" => $CORE->_e(array('dating','69')),
				"5" => $CORE->_e(array('dating','70')),	
				"6" => $CORE->_e(array('dating','71')),
				"7" => $CORE->_e(array('dating','72')),
				);
			
			} break;
			case "dahair": {
						
				$values = array(
				"1" => $CORE->_e(array('dating','61')), 
				"2" => $CORE->_e(array('dating','62')), 
				"3" => $CORE->_e(array('dating','63')),
				"4" => $CORE->_e(array('dating','64')),
				"5" => $CORE->_e(array('dating','65')),	
				);
			
			} break;
			case "dabody": {
			
				$values = array(
				"1" => $CORE->_e(array('dating','56')), 
				"2" => $CORE->_e(array('dating','57')), 
				"3" => $CORE->_e(array('dating','58')),
				"4" => $CORE->_e(array('dating','59')),
				"5" => $CORE->_e(array('dating','60')),	
				);
			
			} break;
		
			case "dasmoke":
			case "dadrink": {
			
				$values = array(
				"1" => $CORE->_e(array('dating','40')), 
				"2" => $CORE->_e(array('dating','41')), 
				"3" => $CORE->_e(array('dating','42')),
				"4" => $CORE->_e(array('dating','43')),
				"5" => $CORE->_e(array('dating','44')),	
				"6" => $CORE->_e(array('dating','45')),
				);
			
			} break;
		
		}
		
		return $values[$data];
	
	}	
    
    
	function wlt_shortcode_age(){ global $CORE, $post, $wpdb, $userdata; 
	
	$age = get_post_meta($post->ID,'daage',true);
	if($age == ""){
	$age = $CORE->_e(array('single','57'));
	}
	return $age;
	
	}	
	
	
	function _visitorcounter(){ global $CORE, $post, $wpdb, $userdata; 
	
	
	// SEE IF WE HAVE ANY OTHER LISTINGS ALREADY
	$SQL = "SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type='".THEME_TAXONOMY."_type' and post_status='publish' AND post_author='".$userdata->ID."' ORDER BY ID DESC LIMIT 1";	
	$result = $wpdb->get_results($SQL);
 
	if(!empty($result)){	
	$hits_data = get_post_meta($result[0]->ID,'hits_array',true);
	}
 
	ob_start();
	?>
    
<div class="row">

 <div class="col-md-6">

    <div class="panel panel-default">
    
    <div class="panel-heading"><?php echo $CORE->_e(array('dating','79')); ?></div> 
   
    <div class="panel-body" style="min-height:400px;">     
    
     
     <a href="javascript:void(0);" class="btn btn-lg btn-success mplinks clearfix"  onclick="jQuery('#MyAccountBlock').hide();jQuery('#MyDetailsBlock').show(); jQuery('#MyFeedback').hide(); jQuery('#MyMsgBlock').hide(); jQuery('#MyDashboardBlock').hide();  jQuery('#MySubscriptionBlock').hide();">
     
     <span class="btn-label"><i class="fa fa-user"></i></span>
     
     <span class="btn-txt"><?php echo $CORE->_e(array('dating','80')); ?></span> 
     
     </a>
     
     <hr />
     <?php if(!empty($result)){ ?>
     <a href="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>?eid=<?php echo $result[0]->ID; ?>" class="btn btn-lg btn-success mplinks">
     
     <span class="btn-label"><i class="fa fa-pencil"></i></span>
     
     <span class="btn-txt"><?php echo $CORE->_e(array('dating','81')); ?></span> 
     
     </a>
     <hr />
     

     <a href="<?php echo get_permalink($result[0]->ID); ?>" class="btn btn-lg btn-warning mplinks">
     
     <span class="btn-label"><i class="fa fa-desktop"></i></span>
     
     <span class="btn-txt"><?php echo $CORE->_e(array('dating','82')); ?></span> 
     
     </a>
     
     <hr />
	<?php }else{ ?>

     <a href="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>" class="btn btn-lg btn-success mplinks">
     
     <span class="btn-label"><i class="fa fa-pencil"></i></span>
     
     <span class="btn-txt"><?php echo $CORE->_e(array('dating','81')); ?></span> 
     
     </a>
     <hr />

	<?php } ?>

     <a href="javascript:void(0);" class="btn btn-lg btn-info mplinks" onclick="jQuery('#MyDetailsBlock').hide();jQuery('#MyMsgBlock').show(); jQuery('#MyFeedback').hide(); jQuery('#MyDashboardBlock').hide(); jQuery('#MySubscriptionBlock').hide();">
     
     <span class="btn-label"><i class="fa fa-envelope"></i></span>
     
     <span class="btn-txt"><?php echo $CORE->_e(array('account','26')); ?></span>
     
     </a>
     
     <hr />

      <a href="<?php echo $GLOBALS['CORE_THEME']['links']['chatroom']; ?>" class="btn btn-lg btn-danger mplinks">
      
     <span class="btn-label"><i class="fa fa-comments"></i></span>
     
     <span class="btn-txt"><?php echo $CORE->_e(array('dating','83')); ?></span> 
     
     </a>
     
     <hr />    
     
         
    </div>
    
    </div>

 </div>
 
 
  <div class="col-md-6">
        
	
    <div class="panel panel-default">
    
    <div class="panel-heading"><?php echo $CORE->_e(array('dating','84')); ?></div> 
   
    <div class="panel-body" style="min-height:400px;">     
    <?php if(!empty($result)){ ?>
    <?php echo do_shortcode('[VISITORCHART postid="'.$result[0]->ID.'"]'); ?>
    <?php }else{ ?>
    No visitors yet
    <?php } ?>
    </div>
    
    </div>
 
 </div>
 
</div>
 
            

	
    
    <?php 
	//}
	}
	
	function _hook_account_dashboard_items($c){ global $userdata, $wpdb, $CORE;
	
	// GET PROFILE ID
	$SQL = "SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type='".THEME_TAXONOMY."_type' and post_status='publish' AND post_author='".$userdata->ID."' ORDER BY ID DESC LIMIT 1";	
	$result = $wpdb->get_results($SQL);
	
	if(!empty($result)){
	$profileID = $result[0]->ID;
	}else{
	$profileID = 0;
	}
	
	// CURRENT RATING
	$rating 	= get_post_meta($profileID, 'ratingup', true);
	if($rating == ""){ $rating = 0; }else{ $rating = number_format($rating); }
	
	// GET MESSAGE COUNT
	$mc = $CORE->MESSAGECOUNT($userdata->user_login);
	if($mc == ""){ $mc = 0; }
	
	// HITS
	$hits = get_post_meta($profileID,'hits',true);
	if($hits == ""){ $hits = 0; }else{ $hits = number_format($hits); }

ob_start();
?>

<li class="list-group-item col-md-3 col-sm-12 col-xs-12 text-center col-md-offset-1">
        <a href="javascript:void(0);" onclick="jQuery('#MyDetailsBlock').hide();jQuery('#MyMsgBlock').show(); jQuery('#MyFeedback').hide(); jQuery('#MyDashboardBlock').hide();">
        <span><?php echo $mc; ?></span> <?php echo $CORE->_e(array('account','113')); ?></a>
</li>

<li class="list-group-item col-md-2 col-sm-12 col-xs-12 text-center">
       
        <span><?php echo $rating; ?></span> <?php echo $CORE->_e(array('single','54')); ?> 
</li>
<li class="list-group-item col-md-2 col-sm-12 col-xs-12 text-center">
         
        <span><?php echo $hits; ?></span> <?php echo $CORE->_e(array('graphs','4')); ?> 
</li>
        

<?php
return ob_get_clean();
}	
	
	
	
	
	
	
	function _hook_language_array($c){
	
		$d = array(	
		"1" 			=> __("Chat Invitation Sent","premiumpress"),
		"2" 			=> __("has sent you a gift.","premiumpress"),
		"3" 			=> __("You've received a new gift!","premiumpress"),
		"4" 			=> __("Your gift has been sent!","premiumpress"),
		"5" 			=> __("Send a free gift!","premiumpress"),
		"6" 			=> __("Making the first move can often be difficult so why not send a free gift instead!","premiumpress"),
		"7" 			=> __("Send Gift","premiumpress"),
		"8" 			=> __("Invite Member to Chat","premiumpress"),
		"9" 			=> __("Meet me in the chatroom!","premiumpress"),
		"10" 			=> __("We will send a chat request to this user to meet you in the chat room.","premiumpress"),
		"11" 			=> __("Send Chat Request","premiumpress"),
		"12" 			=> __("Chat Invitation","premiumpress"),
		"13" 			=> __("Meet me in the chatroom!","premiumpress"),
		"14" 			=> __("would like to chat with you.","premiumpress"),
		"15" 			=> __("Go To Chatroom","premiumpress"),		
		"16" 			=> __("Gender","premiumpress"),
		"17" 			=> __("Age","premiumpress"),
		"18" 			=> __("Country","premiumpress"),
		"19" 			=> __("City","premiumpress"),
		"20" 			=> __("Distance","premiumpress"),
		"21" 			=> __("Status","premiumpress"),		
		"22" 			=> __("Online Now","premiumpress"),
		"23" 			=> __("Offline","premiumpress"),		
		"24" 			=> __("Invite Chat","premiumpress"),		
			"25" 			=> __("Male","premiumpress"),
			"26" 			=> __("Female","premiumpress"),
			"27" 			=> __("Couple","premiumpress"),
			"28" 			=> __("Group","premiumpress"),
 
 	
		"29" 			=> __("Looking For","premiumpress"),
		"30" 			=> __("I'm a","premiumpress"),	
		"31" 			=> __("Background &amp; Heritage","premiumpress"),
		"32" 			=> __("Hobbies &amp; Leisure","premiumpress"),
		"33" 			=> __("My Appearance","premiumpress"),
		"34" 			=> __("My Lifestyle","premiumpress"),


		//DASMOKE
		"40" 			=> __("Never","premiumpress"),
		"41" 			=> __("Rarely","premiumpress"),
		"42" 			=> __("Quit","premiumpress"),
		"43" 			=> __("Socially","premiumpress"),
		"44" 			=> __("Often","premiumpress"),
		"45" 			=> __("Very often","premiumpress"),
		// DARTH
		"46" 			=> __("African","premiumpress"),
		"47" 			=> __("American","premiumpress"), 
		"48" 			=> __("Arab","premiumpress"),
		"49" 			=> __("Asian","premiumpress"),
		"50" 			=> __("Caucasian","premiumpress"),
		"51" 			=> __("Hispanic","premiumpress"),
		"52" 			=> __("Indian","premiumpress"),
		"53" 			=> __("Mixed","premiumpress"),
		"54" 			=> __("Native","premiumpress"),
		"55" 			=> __("Other","premiumpress"),
	 	// DABODYY
		"56" 			=> __("Slim","premiumpress"),
		"57" 			=> __("Average","premiumpress"),
		"58" 			=> __("A little plump","premiumpress"),
		"59" 			=> __("Big and lovely","premiumpress"),
		"60" 			=> __("Other","premiumpress"),
		 // DAHAIR
		"61" 			=> __("Blond","premiumpress"),
		"62" 			=> __("Brown","premiumpress"),
		"63" 			=> __("Red","premiumpress"),
		"64" 			=> __("Black","premiumpress"),
		"65" 			=> __("Other","premiumpress"),
		// DAEYES
		"66" 			=> __("Amber","premiumpress"),
		"67" 			=> __("Brown","premiumpress"),
		"68" 			=> __("Green","premiumpress"),
		"69" 			=> __("Blue","premiumpress"),
		"70" 			=> __("Gray","premiumpress"),
		"71" 			=> __("Hazel","premiumpress"),
		"72" 			=> __("Other","premiumpress"),
		
		// LABELS
		"73" 			=> __("Ethnicity","premiumpress"),
		"74" 			=> __("Body type","premiumpress"),
		"75" 			=> __("Hair color","premiumpress"),
		"76" 			=> __("Eye color","premiumpress"),
		"77" 			=> __("Smoking","premiumpress"),
		"78" 			=> __("Drinking","premiumpress"),
		
		"79" 			=> __("Quick Links","premiumpress"),
		"80" 			=> __("Change My Photo","premiumpress"),
		"81" 			=> __("Edit My Profile","premiumpress"),
		"82" 			=> __("View My Profile","premiumpress"),
		"83" 			=> __("Chatroom","premiumpress"),
		"84" 			=> __("Profile Visitor Tracker","premiumpress"),
		 
		 
 
			
		);
	
		$c['english']['dating'] = $d;

		return $c;
	
	}
	
function extrasearch(){ global $CORE;

ob_start();
 

?>
        <select class="form-control" name="dagender">
        <option value="">---------</option>
      <?php
	  
	  foreach(array(					
					"1" => $CORE->_e(array('dating','25')), 
					"2" => $CORE->_e(array('dating','26')), 
					"3" => $CORE->_e(array('dating','27')), 
					"4" => $CORE->_e(array('dating','28')),
				 			
					) as $k => $t){
				
					// HIDE IF BLANK
					$t = trim($t);
					if($t == ""){ continue; }
						
					if($k == $_GET['dagender']){
					echo '<option value="'.$k.'" selected=selected>'.$t.'</option>';
					}else{
					echo '<option value="'.$k.'">'.$t.'</option>';
					}
				
				}
	  ?>
        </select>
         
        
        <select class="form-control" name="daage">
        <option value="">---------</option>
        <?php foreach(array(1825,2632,3340,4145,4651,5258,5965,7090) as $age){ ?>
        <option value="<?php echo $age; ?>" <?php echo selected( $_GET['daage'], $age ); ?>><?php echo substr($age,0,2)." - ".substr($age,2,2); ?></option>
        <?php } ?>
        </select>
        

<?php 
echo ob_get_clean();

}
	
	
	// ADD-ON CHATROOM PAGE
	function _updatepagelist($c){
		$c['chatroom'] = array("name" => "Chatroom");
		return $c;
	}
	
	function _actions(){ global $userdata, $CORE;
		
		// INVITE USER TO CHAT
		if(isset($_POST['action']) && $_POST['action'] == "invitechat" &&  is_numeric($_POST['user_id']) && $userdata->ID ){
		
			// SET NEW VALUE IN THE USERS ACCOUNT
			update_user_meta($_POST['user_id'],"chatinvite", array("asker_id" => $userdata->ID, "asker_name" => $userdata->user_nicename));
			 
			// LEAVE MSG	
			$GLOBALS['error_message'] = $CORE->_e(array('dating','1'));		
		}		
		
		// SEND GIFT MESSAGE
		if(isset($_POST['action']) && $_POST['action'] == "sendgift" && is_numeric($_POST['gift']) && $userdata->ID ){
	 
	 	// SAVE MESSAGE
		$Message = "
		 
		<div class='text-center'><img src='".ACTIVE_THEME_URI."icons/".$_POST['gift'].".png' alt='gift' /></div>
		
		<p><b><a href='".get_author_posts_url( $userdata->ID )."'>".$userdata->user_nicename."</a></b> ".$CORE->_e(array('dating','2'))."</p>
		
		".$CORE->_e(array('single','30')).": <a href='".get_permalink($_POST['pid'])."'>".get_permalink($_POST['pid'])."</a>\r\n"; 
	 
		// SENDER			 
		if(!$userdata->ID){ $userid = 1; }else{	$userid = $userdata->ID; }
		
		// SENT TO USER
		$user_info = get_userdata($_POST['user_id']);		
		$my_post = array();
		$my_post['post_title'] 		= $userdata->user_nicename." ".$CORE->_e(array('dating','2'));
		$my_post['post_content'] 	= $Message;
		$my_post['post_excerpt'] 	= "";
		$my_post['post_status'] 	= "publish";
		$my_post['post_type'] 		= "wlt_message";
		$my_post['post_author'] 	= $userid;
		$POSTID = wp_insert_post( $my_post );
		
		// ADD SOME EXTRA CUSTOM FIELDS
		add_post_meta($POSTID, "username", $user_info->user_login );	
		add_post_meta($POSTID, "userID", $user_info->ID);	
		add_post_meta($POSTID, "status", "unread" );
		add_post_meta($POSTID, "ref", get_permalink($_POST['pid']) );

		// SEND EMAIL	 
		$_POST['message'] = $_POST['contact_m1'];
		$_POST['phone'] = $_POST['contact_p1'];
		$_POST['email'] = $_POST['contact_e1'];
		$_POST['name'] = $_POST['contact_n1'];
		$CORE->SENDEMAIL($post->post_author,'contact');
		 
		// ADD LOG ENTRY
		$CORE->ADDLOG("<a href='(ulink)'>".$userdata->user_nicename.'</a> used the send gift feature: <a href="(plink)"><b>['.get_the_title($_POST['pid']).']</b></a>.', $userdata->ID, $_POST['pid'] ,'label-info');
		 
		// LEAVE MSG	
		$GLOBALS['error_message'] = $CORE->_e(array('dating','4'));	
		
		}
	
	}
	
	
	function modals(){ global $CORE, $userdata;
	
	?>
 

<!-- SEND GIFT MODAL -->
<div class="modal fade" id="giftmodal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo $CORE->_e(array('dating','5')); ?></h4>
      </div>
      <div class="modal-body">
      
      <p><?php echo $CORE->_e(array('dating','6')); ?></p>
      
      <ul class="giftideas clearfix">
      <?php $i=1; while($i < 9){ ?>
      <li class="gifti<?php echo $i; ?>"> 
      <a href="javascript:void(0);" onclick="jQuery('#daGift').val('<?php echo $i; ?>');jQuery('.giftideas li').removeClass('selected');jQuery('.gifti<?php echo $i; ?>').addClass('selected');"><img src="<?php echo ACTIVE_THEME_URI."icons/".$i; ?>.png" alt="gif" class="img-responsive" /></a>
      </li>
	  <?php $i++; } ?>
      </ul>
      
      <div class="clearfix"></div>
      
      </div>
      <div class="modal-footer">
      
      <form method="post" action="" onsubmit="<?php if(!$userdata->ID){ ?>alert('<?php echo strip_tags($CORE->_e(array('validate','25'))); ?>'); return false;<?php } ?>">
      <input type="hidden" name="action"  value="sendgift" />
      <input type="hidden" name="gift" id="daGift" value="" />
      <input type="hidden" name="user_id" id="daGiftUid" value="" />
      <input type="hidden" name="pid" id="daGiftPid" value="" />
      <button type="submit" class="btn btn-primary"><?php echo $CORE->_e(array('dating','7')); ?></button>
      </form>
      
      </div>
    </div>
  </div>
</div>



<!-- SEND GIFT MODAL -->
<div class="modal fade" id="invitemodal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo $CORE->_e(array('dating','8')); ?></h4>
      </div>
      <div class="modal-body">
      
      
      <div class="col-md-3">
      <i class="fa fa-comments" style="font-size:100px;"></i>
      </div>
      
      <div class="col-md-9">
      
      <h3><?php echo $CORE->_e(array('dating','9')); ?></h3>
      
      <p><?php echo $CORE->_e(array('dating','10')); ?></p>
      
      </div>
       
      <div class="clearfix"></div>
      
      </div>
      <div class="modal-footer">
      
      <form method="post" action="" onsubmit="<?php if(!$userdata->ID){ ?>alert('<?php echo strip_tags($CORE->_e(array('validate','25'))); ?>'); return false;<?php } ?>">
      <input type="hidden" name="action"  value="invitechat" />
      <input type="hidden" name="user_id" id="daInviteUid" value="" />      
      <button type="submit" class="btn btn-primary"><?php echo $CORE->_e(array('dating','11')); ?></button>
      </form>
      
      </div>
    </div>
  </div>
</div>


<?php 

// CHAT REQUEST POP-UP
if($userdata->ID){ $ff = get_user_meta($userdata->ID, 'chatinvite',true); if(is_array($ff)){ ?>
<!-- CHAT REQUEST MODEAL -->
<div class="modal fade" id="chatroominvite" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><?php echo $CORE->_e(array('dating','12')); ?></h4>
      </div>
      <div class="modal-body">
      
      
      <div class="col-md-3">
      <a href='<?php echo get_author_posts_url( $ff['asker_id']  ); ?>'><?php echo get_avatar( $ff['asker_id'], 180 ); ?></a>
      </div>
      
      <div class="col-md-9">
            
      <h3><?php echo $CORE->_e(array('dating','13')); ?></h3>
      
      <p><?php echo $ff['asker_name']; ?> <?php echo $CORE->_e(array('dating','14')); ?> </p>
      
      </div>
       
      <div class="clearfix"></div>
      
      </div>
      <div class="modal-footer">   
           
      <a href="<?php echo $GLOBALS['CORE_THEME']['links']['chatroom']; ?>" class="btn btn-primary"><?php echo $CORE->_e(array('dating','15')); ?></a>     
      
      </div>
    </div>
  </div>
</div>
<script>
jQuery(document).ready(function($) {
    jQuery('#chatroominvite').modal()
});
</script>
<?php 
// blank it out so it doesnt keep poping-up
update_user_meta($userdata->ID, 'chatinvite', ''); 
} } ?>
    
    <?php 
	
	}
	
	function _hook_shortcodelist($c){
	
	return array_merge($c,array(
	'PROFILEBUTTONS' => array('desc' => 'Display Profile Buttons', 'type' => 'inner'),
 
	));
	
	}

	function USERONLINE($userid){ global $wpdb, $CORE, $userdata;
			
			if(!is_numeric($userid)){ return false; }
		
			 // CHECK IF THE USER EXISTS OTHERWISE ADD THEM
			 $result = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."core_useronline WHERE user_id= ('".$userid."') LIMIT 1");
			 if(empty($result)){
			 return false;
			 }else{
			 return true;
			 }
	} 
		
		
	function wlt_shortcode_listingdata($atts, $content = null){  global $userdata, $wpdb, $CORE, $post; $STRING = "";
	
	// EXTRACT
	extract( shortcode_atts( array('type' => ''  ), $atts ) );
	
	ob_start();
	?>
    <ul class="list-group profiledata listtype<?php echo $type; ?> clearfix">
    
    <?php if($type == ""){ ?>
    
        <li class="list-group-item clearfix"><span><?php echo $CORE->_e(array('dating','16')); ?></span> [GENDER]  </li>
        
        <li class="list-group-item clearfix"><span><?php echo $CORE->_e(array('dating','17')); ?></span> [AGE] </li>
        
        <li class="list-group-item clearfix"><span><?php echo $CORE->_e(array('dating','18')); ?></span> [COUNTRY] </li>
        
        <li class="list-group-item clearfix"><span><?php echo $CORE->_e(array('dating','19')); ?></span> [CITY] </li>
        
        <?php if( isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != ""){ ?>
                
        <li class="list-group-item clearfix"><span><?php echo $CORE->_e(array('dating','20')); ?></span> [DISTANCE text_before=""] </li>
              
        <?php } ?>
    
    <?php } ?>
    
  	<?php if($type == "1"){ ?>
 
    
    <li class="list-group-item clearfix"> <span><?php echo $CORE->_e(array('dating','73')); ?></span> [PROFILEDATA key="daeth"]</li>
  
    <li class="list-group-item clearfix"> <span><?php echo $CORE->_e(array('dating','74')); ?></span> [PROFILEDATA key="dabody"]</li>
    
    <li class="list-group-item clearfix"> <span><?php echo $CORE->_e(array('dating','75')); ?></span> [PROFILEDATA key="dahair"]</li>
    
    <li class="list-group-item clearfix"> <span><?php echo $CORE->_e(array('dating','76')); ?></span> [PROFILEDATA key="daeyes"]</li>
    
    <?php } ?>
    
    <?php if($type == "2"){ ?>
        
    <li class="list-group-item clearfix"> <span><?php echo $CORE->_e(array('dating','77')); ?></span> [PROFILEDATA key="dasmoke"]</li>
     
    <li class="list-group-item clearfix"> <span><?php echo $CORE->_e(array('dating','78')); ?></span> [PROFILEDATA key="dadrink"]</li>
     
   	<?php } ?>
    
    </ul>
    
    <?php
	$STRING =  ob_get_clean();
	
	return do_shortcode($STRING);
	
	}
		
 

	function wlt_shortcode_onlinestatus($atts, $content = null){  global $userdata, $wpdb, $CORE, $post; $STRING = "";
		
		// EXTRACT
		extract( shortcode_atts( array('user_id' => ''  ), $atts ) );
	
		// GET USER ID
		if($user_id == ""){ $user_id = $post->post_author; }
		 	  
		// CHECK IF THE USER EXISTS OTHERWISE ADD THEM		
		if($this->USERONLINE($user_id)){
			  return '<span class="wlt_shortcode_onlinestatus"><i class="fa fa-circle profileonline" title="'.$CORE->_e(array('dating','22')).'"></i> <span>'.$CORE->_e(array('dating','22')).'</span></span>';
		}else{
			return '<span class="wlt_shortcode_onlinestatus"><i class="fa fa-circle profileoffline" title="'.$CORE->_e(array('dating','23')).'"></i> <span>'.$CORE->_e(array('dating','23')).'</span></span>';
		}
 
 	}
	
	function wlt_shortcode_profilebuttons($atts, $content = null){  global $userdata, $CORE, $post; $STRING = "";
	
	extract( shortcode_atts( array('id' => '', 'style' => 0 ), $atts ) );	
	
 
	
	// FAVS BUTTON
	$show_add = true;
	if($userdata->ID){
		$my_list = get_user_meta($userdata->ID, 'favorite_list',true);
		if(is_array($my_list) && array_key_exists("ID:".$post->ID, $my_list) ){
			$show_add = false;
		}		 
	
		if($show_add){
			$FAVS = '<a class="list_favorites_add" href="#top" onclick="WLTAddF(\''.str_replace("http://","",get_home_url()).'\', \'favorite\', '.$post->ID.', \'core_ajax_callback\');">
			 <span>'.$CORE->_e(array('button','32')).'</span> <i class="glyphicon glyphicon-star"></i> </a>'; 
		}else{
			$FAVS = '<a class="list_favorites_remove" href="#top" onclick="WLTAddF(\''.str_replace("http://","",get_home_url()).'\', \'favorite\', '.$post->ID.', \'core_ajax_callback\');">
			 <span>'.$CORE->_e(array('button','33')).'</span> <i class="glyphicon glyphicon-remove"></i></a>'; 
		} 
	}else{
	
	$FAVS = '<a class="list_favorites_add" href="javascript:void(0);" onclick="alert(\''.strip_tags($CORE->_e(array('validate','25'))).'\')" >
		<i class="glyphicon glyphicon-star"></i> <span>'.$CORE->_e(array('button','32')).'</span></a>'; 
	}
	
	// MESSAGE BUTTON
	if($userdata->ID){
		$MSG = $GLOBALS['CORE_THEME']['links']['myaccount'].'?tab=msg&show=1&u='.$post->post_author;
	}else{
		$MSG = '" onclick="alert(\''.strip_tags($CORE->_e(array('validate','25'))).'\')';
	}
	
	// ONLINE CHAT BUTTON
	if($this->USERONLINE($post->post_author)){
		$ONLINE = "";
	}else{
		$ONLINE = "";
	}
	
	if($style == 1){
	ob_start();
	?>
    
    
    <li class="list-group-item"><?php echo $FAVS; ?></li>
    
    <li class="list-group-item"><a href="javascript:void(0);" onclick="jQuery('#daGiftPid').val('<?php echo $post->ID; ?>');jQuery('#daGiftUid').val('<?php echo $post->post_author; ?>');" data-toggle="modal" data-target="#giftmodal"> <span><?php echo $CORE->_e(array('dating','7')); ?></span> <i class="fa fa-gift"></i> </a></li>
    
    <li class="list-group-item"><a href="<?php echo $MSG; ?>"> <span><?php echo $CORE->_e(array('single','7')); ?></span> <i class="fa fa-envelope"></i> </a></li>
    
    <li class="list-group-item"><a href="javascript:void(0);" onclick="jQuery('#daInviteUid').val('<?php echo $post->post_author; ?>');" data-toggle="modal" data-target="#invitemodal">
    <span><?php echo $CORE->_e(array('dating','24')); ?></span> <i class="fa fa-comments"></i>  </a></li>
    
    
    <?php 
	return ob_get_clean();
	
	}elseif($style == 3){
	
	$show_add = true;
	if($userdata->ID){
		$my_list = get_user_meta($userdata->ID, 'favorite_list',true);
		if(is_array($my_list) && array_key_exists("ID:".$post->ID, $my_list) ){
			$show_add = false;
		}		 
	
		if($show_add){
			$FAVS = '<a class="btn btn-default" href="#top" onclick="WLTAddF(\''.str_replace("http://","",get_home_url()).'\', \'favorite\', '.$post->ID.', \'core_ajax_callback\');">
			 <i class="fa fa-star fa-3x"></i> <span>'.$CORE->_e(array('button','32')).'</span>  </a>'; 
		}else{
			$FAVS = '<a class="btn btn-default" href="#top" onclick="WLTAddF(\''.str_replace("http://","",get_home_url()).'\', \'favorite\', '.$post->ID.', \'core_ajax_callback\');">
			 <i class="fa fa-cross fa-3x"></i> <span>'.$CORE->_e(array('button','33')).'</span> </a>'; 
		} 
	}else{
	
	$FAVS = '<a class="btn btn-default" href="javascript:void(0);" onclick="alert(\''.strip_tags($CORE->_e(array('validate','25'))).'\')" >
		<i class="fa fa-star fa-3x"></i> <span>'.$CORE->_e(array('button','32')).'</span></a>'; 
	}
	ob_start();
	?>
    
      <?php echo $FAVS; ?>
       
       
       <a href="javascript:void(0);" onclick="jQuery('#daGiftPid').val('<?php echo $post->ID; ?>');jQuery('#daGiftUid').val('<?php echo $post->post_author; ?>');" data-toggle="modal" data-target="#giftmodal" class="btn btn-default"> <i class="fa fa-gift fa-3x"></i> <span><?php echo $CORE->_e(array('dating','7')); ?></span> </a>
        
        
      
       <a href="javascript:void(0);" class="btn btn-default" onclick="jQuery('#daInviteUid').val('<?php echo $post->post_author; ?>');" data-toggle="modal" data-target="#invitemodal">
    <i class="fa fa-comments fa-3x"></i> <span><?php echo $CORE->_e(array('dating','24')); ?></span>   </a>
              
    
    
    <?php 
	return ob_get_clean();
	
	}else{
	
 
    $STRING ='<div class="clearfix profilebuttons">
    <div class="col-md-3 col-sm-3 col-xs-12">'.$FAVS.' </div>
    <div class="col-md-3 col-sm-3 col-xs-12"><a href="javascript:void(0);" onclick="jQuery(\'#daGiftPid\').val('.$post->ID.');jQuery(\'#daGiftUid\').val('.$post->post_author.');" data-toggle="modal" data-target="#giftmodal"><i class="fa fa-gift"></i> <span>'.$CORE->_e(array('dating','7')).'</span></a></div>
    <div class="col-md-3 col-sm-3 col-xs-12"><a href="'.$MSG.'"><i class="fa fa-envelope"></i> <span>'.$CORE->_e(array('single','7')).'</span> </a></div>
    <div class="col-md-3 col-sm-3 col-xs-12"><a href="javascript:void(0);" onclick="jQuery(\'#daInviteUid\').val('.$post->post_author.');" data-toggle="modal" data-target="#invitemodal"><i class="fa fa-comments"></i> <span>'.$CORE->_e(array('dating','24')).'</span> </a></div>
    </div>';   
	
	} 
	
	return $STRING;	
	
	}
	
	function wlt_shortcode_gender($atts, $content = null){  global $userdata, $CORE, $post; $STRING = "";
	
	extract( shortcode_atts( array('id' => ''  ), $atts ) );	
	
	$gender = get_post_meta($post->ID,'dagender',true);
    
	switch($gender){
		case "1": { $STRING = $CORE->_e(array('dating','25')); } break;
		case "2": { $STRING = $CORE->_e(array('dating','26')); } break;
		case "3": { $STRING = $CORE->_e(array('dating','27')); } break;
		case "4": { $STRING = $CORE->_e(array('dating','28')); } break;
 
	}
	
	return $STRING;	
	
	}
	
	function wlt_shortcode_gender_icon($atts, $content = null){  global $userdata, $CORE, $post; $STRING = "";
	
	extract( shortcode_atts( array('id' => ''  ), $atts ) );	
	
	$gender = get_post_meta($post->ID,'dagender',true);
    
	switch($gender){
		case "1": { $STRING = '<i class="fa fa-male daiconmale"></i>'; } break;
		case "2": { $STRING = '<i class="fa fa-female daiconfemale"></i>'; } break;
		case "3": { $STRING = '<i class="fa fa-street-view daiconcoupole"></i>'; } break;
		case "4": { $STRING = '<i class="fa fa-users daicongroup"></i>'; } break;
		
		case "5": { $STRING = $CORE->_e(array('dating','31')); } break;
		case "6": { $STRING = $CORE->_e(array('dating','32')); } break;
		case "7": { $STRING = $CORE->_e(array('dating','33')); } break;
		case "8": { $STRING = $CORE->_e(array('dating','34')); } break;
		case "9": { $STRING = $CORE->_e(array('dating','35')); } break;
	}
	
	return $STRING;	
	
	}
	
	// ADD IN CORE FIELDS TO THE ADMIN
	function _hook_adminfields($c){ global $CORE;
	
		$CORE->Language();
		
		// DATA
		$fields = array(
		
		"tab4" => array("tab" => true, "title" => "Dating Theme Extras" ),		
		"dagender" 		=> array("label" => $CORE->_e(array('dating','16')),  "values" => array(		
			"1" => $CORE->_e(array('dating','25')), 
			"2" => $CORE->_e(array('dating','26')), 
			"3" => $CORE->_e(array('dating','27')), 
			"4" => $CORE->_e(array('dating','28')),	 
 
		)),
		"daage" 		=> array("label" => $CORE->_e(array('dating','17')), ),
 		"daseeking" 		=> array("label" => $CORE->_e(array('dating','29')),  "values" => array(		
			"1" => $CORE->_e(array('dating','25')), 
			"2" => $CORE->_e(array('dating','26')), 
			"3" => $CORE->_e(array('dating','27')), 
			"4" => $CORE->_e(array('dating','28')), 		
		) ),
		
		
		"daeth" => array("label" => $CORE->_e(array('dating','73')),  "values" => array(		 
				"1" => $CORE->_e(array('dating','46')), 
				"2" => $CORE->_e(array('dating','47')), 
				"3" => $CORE->_e(array('dating','48')),
				"4" => $CORE->_e(array('dating','49')),
				"5" => $CORE->_e(array('dating','50')),	
				"6" => $CORE->_e(array('dating','51')),	
				"7" => $CORE->_e(array('dating','52')),
				"8" => $CORE->_e(array('dating','53')),	
				"9" => $CORE->_e(array('dating','54')),
				"10" => $CORE->_e(array('dating','55')),			
		) ),
		
		"dabody" => array("label" => $CORE->_e(array('dating','74')), "values" => array(
				"1" => $CORE->_e(array('dating','56')), 
				"2" => $CORE->_e(array('dating','57')), 
				"3" => $CORE->_e(array('dating','58')),
				"4" => $CORE->_e(array('dating','59')),
				"5" => $CORE->_e(array('dating','60')),		
		) ),
		
		"dahair" => array("label" => $CORE->_e(array('dating','75')), "values" => array(
				 
				"1" => $CORE->_e(array('dating','61')), 
				"2" => $CORE->_e(array('dating','62')), 
				"3" => $CORE->_e(array('dating','63')),
				"4" => $CORE->_e(array('dating','64')),
				"5" => $CORE->_e(array('dating','65')),		
		) ),
		
		"daeyes" => array("label" => $CORE->_e(array('dating','76')), "values" => array(
				 
			"1" => $CORE->_e(array('dating','66')), 
				"2" => $CORE->_e(array('dating','67')), 
				"3" => $CORE->_e(array('dating','68')),
				"4" => $CORE->_e(array('dating','69')),
				"5" => $CORE->_e(array('dating','70')),	
				"6" => $CORE->_e(array('dating','71')),
				"7" => $CORE->_e(array('dating','72')),		
		) ),
		
		"dasmoke" => array("label" => $CORE->_e(array('dating','77')), "values" => array(
				 
			"1" => $CORE->_e(array('dating','40')), 
			"2" => $CORE->_e(array('dating','41')), 
			"3" => $CORE->_e(array('dating','42')),
			"4" => $CORE->_e(array('dating','43')),
			"5" => $CORE->_e(array('dating','44')),	
			"6" => $CORE->_e(array('dating','45')),
		) ),
		
		"dadrink" => array("label" => $CORE->_e(array('dating','78')), "values" => array(
				 
			"1" => $CORE->_e(array('dating','40')), 
			"2" => $CORE->_e(array('dating','41')), 
			"3" => $CORE->_e(array('dating','42')),
			"4" => $CORE->_e(array('dating','43')),
			"5" => $CORE->_e(array('dating','44')),	
			"6" => $CORE->_e(array('dating','45')),
		) ),
			
		
		

		
		
		"tab5" => array("tab" => true, "title" => "Custom Fields" ),	
 
		);
 
	 
	return array_merge($c,$fields);
	}
	
	
		// ADD IN FRONT END FIELDS
	function _hook_customfields($c){ global $CORE;
	
		$o = 50;
		$ageArray = array(); $i = 18;
		while($i < 101){
		$ageArray[$i] = $i;
		$i++;
		}
 
		$c[$o]['title'] 			= $CORE->_e(array('dating','30'));
		$c[$o]['type'] 				= "select";
 		$c[$o]['name']				= "dagender";
		$c[$o]['listvalues']		= array(
		"1" => $CORE->_e(array('dating','25')), 
		"2" => $CORE->_e(array('dating','26')), 
		"3" => $CORE->_e(array('dating','27')), 
		"4" => $CORE->_e(array('dating','28')),
 
		);
		$c[$o]['class'] 			= "form-control";		 
		$o++;
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','17'));
		$c[$o]['type'] 				= "select";
 		$c[$o]['name']				= "daage";
		$c[$o]['listvalues']		= $ageArray;
		$c[$o]['class'] 			= "form-control";		 
		$o++;
		
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','29'));
		$c[$o]['type'] 				= "select";
 		$c[$o]['name']				= "daseeking";
		$c[$o]['listvalues']		= array(
		"1" => $CORE->_e(array('dating','25')), 
		"2" => $CORE->_e(array('dating','26')), 
		"3" => $CORE->_e(array('dating','27')), 
		"4" => $CORE->_e(array('dating','28')),
 
		);
		$c[$o]['class'] 			= "form-control";		 
		$o++;		
		 
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','33'));
		$c[$o]['type'] 				= "title"; 
		$o++;
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','31'));
		$c[$o]['type'] 				= "post_content"; 
 		$c[$o]['name']				= "dabackground";
 		$o++;
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','73'));
		$c[$o]['type'] 				= "select";
 		$c[$o]['name']				= "daeth";
		$c[$o]['listvalues']		= array(
				"1" => $CORE->_e(array('dating','46')), 
				"2" => $CORE->_e(array('dating','47')), 
				"3" => $CORE->_e(array('dating','48')),
				"4" => $CORE->_e(array('dating','49')),
				"5" => $CORE->_e(array('dating','50')),	
				"6" => $CORE->_e(array('dating','51')),	
				"7" => $CORE->_e(array('dating','52')),
				"8" => $CORE->_e(array('dating','53')),	
				"9" => $CORE->_e(array('dating','54')),
				"10" => $CORE->_e(array('dating','55')),			
		);		
		$c[$o]['class'] 			= "form-control";		 
		$o++;
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','74'));
		$c[$o]['type'] 				= "select";
 		$c[$o]['name']				= "dabody";
		$c[$o]['listvalues']		= array(
				"1" => $CORE->_e(array('dating','56')), 
				"2" => $CORE->_e(array('dating','57')), 
				"3" => $CORE->_e(array('dating','58')),
				"4" => $CORE->_e(array('dating','59')),
				"5" => $CORE->_e(array('dating','60')),		
		);
		$c[$o]['class'] 			= "form-control";		 
		$o++;
		
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','75'));
		$c[$o]['type'] 				= "select";
 		$c[$o]['name']				= "dahair";
		$c[$o]['listvalues']		= array(		 
				"1" => $CORE->_e(array('dating','61')), 
				"2" => $CORE->_e(array('dating','62')), 
				"3" => $CORE->_e(array('dating','63')),
				"4" => $CORE->_e(array('dating','64')),
				"5" => $CORE->_e(array('dating','65')),		
		);
		$c[$o]['class'] 			= "form-control";		 
		$o++;
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','76'));
		$c[$o]['type'] 				= "select";
 		$c[$o]['name']				= "daeyes";
		$c[$o]['listvalues']		= array(
				"1" => $CORE->_e(array('dating','66')), 
				"2" => $CORE->_e(array('dating','67')), 
				"3" => $CORE->_e(array('dating','68')),
				"4" => $CORE->_e(array('dating','69')),
				"5" => $CORE->_e(array('dating','70')),	
				"6" => $CORE->_e(array('dating','71')),
				"7" => $CORE->_e(array('dating','72')),	
		);
		$c[$o]['class'] 			= "form-control";		 
		$o++;
		
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','34'));
		$c[$o]['type'] 				= "title"; 
		$o++;	
		
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','32'));
		$c[$o]['type'] 				= "post_content"; 
 		$c[$o]['name']				= "dahobbies";
 		$o++;
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','77'));
		$c[$o]['type'] 				= "select";
 		$c[$o]['name']				= "dasmoke";
		$c[$o]['listvalues']		= array(
		"1" => $CORE->_e(array('dating','40')), 
		"2" => $CORE->_e(array('dating','41')), 
		"3" => $CORE->_e(array('dating','42')),
		"4" => $CORE->_e(array('dating','43')),
		"5" => $CORE->_e(array('dating','44')),	
		"6" => $CORE->_e(array('dating','45')),
		);
		$c[$o]['class'] 			= "form-control";		 
		$o++;
		
		$c[$o]['title'] 			= $CORE->_e(array('dating','78'));
		$c[$o]['type'] 				= "select";
 		$c[$o]['name']				= "dadrink";
		$c[$o]['listvalues']		= array(
		"1" => $CORE->_e(array('dating','40')), 
		"2" => $CORE->_e(array('dating','41')), 
		"3" => $CORE->_e(array('dating','42')),
		"4" => $CORE->_e(array('dating','43')),
		"5" => $CORE->_e(array('dating','44')),	
		"6" => $CORE->_e(array('dating','45')),
		);
		$c[$o]['class'] 			= "form-control";		 
		$o++;
		
		
		    
		
		return $c;
		
		}
		

		
		function INSTALLTABLES(){ global $wpdb, $CORE, $userdata;
	
		
		if(get_option("datingtabledinstalled1") == ""){
		 $wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_useronline` (	 
		  `id` int(10) NOT NULL auto_increment, 
		  `user_id` int(10) NOT NULL, 
		  `session` char(100) NOT NULL default '',
		  `ip` varchar(15) NOT NULL default '', 
		  `timestamp` varchar(15) NOT NULL default '', 
		  PRIMARY KEY (`id`), 
		  UNIQUE KEY `id`(`id`) );");		  


		$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_chat_messages` (
		  `username` varchar(50) DEFAULT NULL,
		  `user_id` int(10) NOT NULL,
		  `message` text,
		  `date` datetime DEFAULT NULL
		)");
		
		$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_chat_users` (
		  `username` varchar(50) DEFAULT NULL,
		  `user_id` int(10) NOT NULL,
		  `last_activity` datetime DEFAULT NULL,
		  `is_kicked` int(11) DEFAULT '0',
		  `is_banned` int(11) DEFAULT '0',
		  `kick_ban_message` varchar(100) DEFAULT NULL,
		  UNIQUE KEY `username` (`username`)
		)");
		update_option("datingtabledinstalled1", true);
		}
		 
		 // USER SESSION
		$session = session_id();
		  
		 // CHECK IF THE USER EXISTS OTHERWISE ADD THEM
		 $result = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."core_useronline WHERE session='".$session."' LIMIT 1");
		 if(empty($result)){

			$wpdb->query("INSERT INTO  ".$wpdb->prefix."core_useronline (`user_id` ,`session` ,`ip` ,`timestamp`) 
			VALUES ( '".$userdata->ID."',  '".$session."',  '".$this->get_client_ip()."',  '".date('Y-m-d H:i:s')."');");			 
			
		}else{
		
			$wpdb->query("UPDATE ".$wpdb->prefix."core_useronline SET timestamp='".date('Y-m-d H:i:s')."', user_id='".$userdata->ID."' WHERE session='".$session."' LIMIT 1");			
		}
		
		// DELETE USERS AFTER 10 MINUTES 
		$wpdb->query("DELETE FROM ".$wpdb->prefix."core_useronline WHERE timestamp < '".date('Y-m-d H:i:s', strtotime("-10 minutes"))."' ");
   
   
		}
		
	
 
} 

?>