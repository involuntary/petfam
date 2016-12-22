<?php

// DATABASE CONNECTION
$te = explode("wp-content",$_SERVER['SCRIPT_FILENAME']);
$SERVER_PATH_HERE = $te[0];// <-- EDIT THE VALUE HERE.  $SERVER_PATH_HERE = "/my/server/path/here/";

// LOAD IN WP CORE
if(file_exists($SERVER_PATH_HERE.'/wp-config.php')){				 
	require( $SERVER_PATH_HERE.'/wp-config.php' );		
}else{	
		die('<h1>Chatroom Load Errror</h1>
		<p>The script could not generate the correct server path to your chatroom file.</p>
		<p>Please edit the file below and manually set the correct server path.</p>
		<p>'.$_SERVER['SCRIPT_FILENAME'].'</p>');
}

global $wpdb, $CORE, $userdata;

// 
define ('ADMIN_PASSWORD', '');
 
// CORE DATABASE QUERY
function runQuery($sql, $type = "update"){ global $wpdb;
	 //echo $sql."<br>";
	if($type == "query"){
		 $wpdb->query($sql);
		 return;
	}elseif($type == "select"){	
		$result = $wpdb->get_results($sql, OBJECT);
		return $result[0];
	}else{		
		$result = $wpdb->get_results($sql, OBJECT);
		return $result;		 
		
	}
} 

////////////////////////////////////////////
// Maximum user's inactivity (in seconds) //
////////////////////////////////////////////

// `inactivity` does NOT mean "not typing for X seconds"
// but is the amount of time that user's browser does not 
// send PING message
//
// normally it pings every 2 seconds, so every reasonable
// time period above these 2 seconds (e.g. 5 or 10 seconds)
// should be enough to mark the user as inactive
 
//////////////////////////////
// Choose action to perform //
//////////////////////////////
if(isset($_GET['action'])){ $action = $_GET['action']; }
if(isset($_POST['action'])){ $action = $_POST['action']; }
 
switch ($action)
{
	case 'ping': {
		// validation
		if (!isset ($_GET['username'])) die('0');
		if (!isset ($_GET['last_message_date'])) die('0');
		
		$username = $_GET['username'];
		$username = str_replace("\t", ' ', $username);
		
		$last_message_date = trim($_GET['last_message_date']);
		 
		// check if user is kicked
		$sql = "SELECT username, is_kicked, is_banned, kick_ban_message FROM ".$wpdb->prefix."core_chat_users WHERE username = '".mysql_escape_string($username)."'";
		$result = runQuery($sql,"select");
 
		if($result->is_kicked == 1){
		 die ("kicked"."\t".$result->kick_ban_message);
		}elseif($result->is_banned == 1){
		die ("banned"."\t".$result->kick_ban_message);
		}
				
		// update user's last_activity
		$sql = "UPDATE ".$wpdb->prefix."core_chat_users SET last_activity = '".date("Y-m-d h:i:s")."' WHERE username = '".mysql_escape_string($username)."' LIMIT 1";
		runQuery($sql,"query");
 		
		// get new messages
		if(strlen($last_message_date) > 4){
		$sql = "SELECT * FROM ".$wpdb->prefix."core_chat_messages WHERE date > '".strip_tags($last_message_date)."' ORDER BY date DESC";		
		$result = runQuery($sql);		
	 	 
		// ARRANGE DATA
		if(!empty($result)){
			$s = '';		 
			foreach($result as $row){ 
			
			if($_SESSION['LASTDATE'] >=  date('Y-m-d H:i:s',strtotime($row->date) - 2) && $_SESSION['LASTDATE'] <= date('Y-m-d H:i:s',strtotime($row->date) + 2) ){ continue; }
			
			$_SESSION['LASTDATE'] = date('Y-m-d H:i:s',strtotime($row->date) );
	 
				// SETUP DISPLAY CLASS
				if($row->user_id == $userdata->ID){ $css = "me"; }else{ $css = "notme"; }
			   
				$s .= $row->date;
				$s .= "\t";
				$s .= get_avatar( $row->user_id, 30 );
				$s .= "\t";
				$s .= $row->username;
				$s .= "\t";
				$s .= $row->message;
				$s .= "\t";
				$s .= hook_date($row->date);
				$s .= "\t";
				$s .= $css;			
				$s .= "\t\t";
			}
		}
		// OUTPUT
		$s = preg_replace ("/\t\t$/", '', $s);		
		die($s);
		}else{
		die(0);
		}
	}
	break;
 

	case 'check_username': {
 
		$username = $_POST['username'];
		
		// remove inactive users
		$sql = "DELETE FROM ".$wpdb->prefix."core_chat_users WHERE last_activity < '".date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-10 seconds"))."'";		 
		$result = runQuery($sql, "query");
		
		// delete user if exists already
		$sql = "DELETE FROM ".$wpdb->prefix."core_chat_users WHERE username='".mysql_escape_string($username)."'";		 
		$result = runQuery($sql, "query");
 		
		// return ok
	 	die('1');

	}
	break;

	case 'get_date': {		  
		die(date("Y-m-d h:i:s"));
	} break;

	case 'get_users': {
 		
		// load users
		$sql = "SELECT username, user_id FROM ".$wpdb->prefix."core_chat_users WHERE last_activity > '".date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-1 hour"))."' AND is_kicked=0 AND is_banned=0  ORDER BY username ASC";
		$result = runQuery($sql);
		// ARRANGE DATA		
		if(!empty($result)){ 
			$s = '';
			foreach($result as $row){
			 		
				$s .= get_avatar( $row->user_id, 30 );				
				$s .= "\t";
				$s .= $row->username;
				$s .= "\t";
				$s .= get_author_posts_url( $row->user_id );
				$s .= "\t";
				$s .= $row->user_id;
				$s .= "\t\t";
			}
		}
		
		$s = preg_replace ("/\t\t$/", '', $s);		
		die($s);
	
	} break;

	case 'send_message': {
		// validation
		if (!isset($_POST['username']) || !isset($_POST['message'])) die('0');
		
		// username
		$username = mb_substr ($_POST['username'], 0, 20);
		$username = str_replace("\t", ' ', $username);
		
		// check if user is kicked
		$sql = "SELECT username, is_kicked, is_banned FROM ".$wpdb->prefix."core_chat_users WHERE username = '".mysql_escape_string($username)."'";
		$result = runQuery( $sql);
		if($result->is_kicked == 1 ||  $result->is_banned == 1){
		die(0);
		}
		 
		// chat message
		$message = mb_substr ($_POST['message'], 0, 2000);
		$message = wordwrap ($message, 90, ' ', true);
		$message = str_replace("\t", ' ', $message);
		
		// insert new message
		$sql = "INSERT INTO ".$wpdb->prefix."core_chat_messages (username, user_id, message, date) VALUES ('".mysql_escape_string($username)."', '".$userdata->ID."', '".mysql_escape_string($message)."', '".date("Y-m-d h:i:s")."');";
		runQuery($sql,"query");
		
		// remove old messages
		$sql = "DELETE FROM ".$wpdb->prefix."core_chat_messages WHERE date < '".date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-1 minute"))."';";
		runQuery($sql,"query");
		
		die('1');
	}
	break;

	case 'login': {
		
		$username = $_POST['username'];
		$username = str_replace("\t", " ", $username);
		
		// remove old messages
		$sql = "DELETE FROM ".$wpdb->prefix."core_chat_messages WHERE date < '".date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")."-1 minute"))."';";
		runQuery($sql,"query");
		
		// CHECK IF USER ALREADY EXISTS OTHERWISE ADD THEM
		$sql = "SELECT * FROM ".$wpdb->prefix."core_chat_users WHERE username = '".mysql_escape_string($username)."'";
		$result = runQuery( $sql);
		if(empty($result)){
  	
			// add user
			$sql = "INSERT INTO ".$wpdb->prefix."core_chat_users (username, user_id, last_activity) VALUES ('".mysql_escape_string($username)."', '".$userdata->ID."', '".strtotime(date("Y-m-d h:i:s"))."')";
			runQuery($sql,"query");
		
		}else{
		
			// update user
			$sql = "UPDATE ".$wpdb->prefix."core_chat_users SET last_activity = '".strtotime(date("Y-m-d h:i:s"))."' WHERE username = '".mysql_escape_string($username)."' ";
			runQuery($sql,"query");
		}
		die('1');
		
	}
	break;

	case 'kick': {
		
		if(!current_user_can('administrator')){ die(0); }
		 
		// validation
		if (!isset($_POST['username'])) die('0');
		if (!isset($_POST['message'])) die('0');
		
		$username = $_POST['username'];
		$username = str_replace("\t", " ", $username);
		$message  = $_POST['message'];
		
		// kick the user
		$sql = "UPDATE ".$wpdb->prefix."core_chat_users SET is_kicked=1, kick_ban_message = ('".mysql_escape_string($message)."') WHERE username = '".mysql_escape_string($username)."'";
		runQuery($sql,"query");
		
		die('1');
	} 
	break;

	case 'ban': {
	
		if(!current_user_can('administrator')){ die(0); }
		 
		// validation
		if (!isset($_POST['username'])) die('0');
		if (!isset($_POST['message'])) die('0');
		
		$username = $_POST['username'];
		$username = str_replace("\t", " ", $username);
		$message  = $_POST['message'];
		
		// ban the user
		$sql = "UPDATE ".$wpdb->prefix."core_chat_users SET is_banned=1, kick_ban_message = ('".mysql_escape_string($message)."') WHERE username = '".mysql_escape_string($username)."'";
		runQuery($sql,"query");
		
		die('1');
	} 
	break;
}

die('0');

?>