<?php
/*
Template Name: [Chatroom]
*/
 
global  $userdata; get_currentuserinfo(); // grabs the user info and puts into vars

// REDIRECT IF NOT LOGGED IN
$CORE->Authorize();
 
// MAKE IT FULL PAGE
$GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true;

 
	// CHECK USER ACCESS FOR MEMBERSHIP LEVELS
	$canView = $CORE->MEMBERSHIPACCESS($post->ID);
	 
	get_header($CORE->pageswitch());
	
	// CAN WE ACCESS THIS PAGE?
	if($canView){ ?>
    
    	<?php			
					
		// CLEAR OUR KICKED USERS AFTER 1 HOUR
		$wpdb->query("UPDATE ".$wpdb->prefix."core_chat_users SET is_kicked ='' WHERE last_activity < '".date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-1 hour"))."'");
		 
		// CLEAR OUR BANNED USERS AFTER 1 WEEK
		$wpdb->query("UPDATE ".$wpdb->prefix."core_chat_users SET is_banned ='' WHERE last_activity < '".date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-1 week"))."'");


		// CHECK IF THIS USER HAS BEEN KICKED OR BANNED
		$sql = "SELECT is_kicked, is_banned, kick_ban_message FROM ".$wpdb->prefix."core_chat_users WHERE username = '".mysql_escape_string($userdata->user_nicename)."'";	 
		$result = $wpdb->get_results($sql);
	
		$blocked_message = "";
			if($result[0]->is_kicked == 1){
				$blocked_title = "You've been kicked!";
				$blocked_message = $result[0]->kick_ban_message;
			}elseif($result[0]->is_banned == 1){
				$blocked_title = "You've been banned!";
				$blocked_message = $result[0]->kick_ban_message;
			}
		
		// CHECK FOR BLOCKED MESSAGE
		if($blocked_message == ""){
		?>
	 
		<link rel="stylesheet" type="text/css" href="<?php echo FRAMREWORK_URI; ?>chat/css/chat.css">
		<script type="text/javascript" src="<?php echo FRAMREWORK_URI; ?>chat/js/chat.js"></script>
		<div id="wlt_chatwindow">
		<p id="error"></p>
		</div>
		<script>
		// Binds login window elements
		jQuery(document).ready(function(){
			window.server_path = '<?php echo FRAMREWORK_URI; ?>chat/';
			<?php if(current_user_can('administrator')){ ?>
			window.is_admin = true;
			<?php }else{ ?>
			window.is_admin = false;
			<?php } ?>
			Chat.init('<?php echo $userdata->user_nicename; ?>');
		});
		</script>
		
		<?php }else{ ?>
		
		<div class="well">
			<div class="text-center"><h1><?php echo $blocked_title; ?></h1><p><?php echo $blocked_message; ?></p></div>
		</div>
		<?php } ?>

	<?php }else{ // ELSE CANNOT VIEW SO SHOW NO ACCESS CODE
	
		$BODY_CONTENT = stripslashes($GLOBALS['CORE_THEME']['noaccesscode']);

		// INCLUDE CORE HOOK FUNCTION
		echo hook_item_cleanup($CORE->ITEM_CONTENT($post,hook_content_single_listing($BODY_CONTENT)));	
	 } ?>
 
<?php get_footer($CORE->pageswitch());   ?>