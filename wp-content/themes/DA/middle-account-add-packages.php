<article id="core_middle_column" style="display: none;"><div class="core_middle_wrap">
<div id="core_ajax_callback"></div>
<?php
    global  $userdata, $CORE; $CORE->Authorize(); $GLOBALS['flag-myaccount'] = 1;
/* =============================================================================
   USER ACTIONS
   ========================================================================== */

$GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true;
    if(isset($_POST['action']) && $_POST['action'] !=""){

    switch($_POST['action']){

    case "sellspace_set": {

        if(!is_numeric($_POST['cid'])){ return; }

        // SET NEW BANNER ID
        update_post_meta($_POST['cid'], 'bannerid', esc_attr($_POST['bannerid']));

        // UPDATE LINK
        update_post_meta($_POST['cid'], 'url', esc_attr($_POST['camurl']) );

        // IF THE EXISTING VALUE IS BLANK THEN LETS ASUME THIS IS THE FIRST TIME WE'VE UPLOAD
        // SO WE SHOULD START THE ADVERTISING PERIOD FROM NOW ON

        $timeleft = get_post_meta($_POST['cid'], 'listing_expiry_date', true);
        if($timeleft == ""){
            $campaign = get_post_meta($_POST['cid'], 'campaign', true);
            $DAYS = $sellspacedata[$campaign."_days"];
            if($DAYS == ""){ $DAYS = 30; }
            $sellspacedata = $GLOBALS['CORE_THEME']['sellspace'];
            update_post_meta( $_POST['cid'], 'listing_expiry_date', date("Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s") . " +".$DAYS." days")) );
        }

        // MSG
        $GLOBALS['error_message'] = $CORE->_e(array('account','105'))."<script>jQuery(document).ready(function() { jQuery('#MyAccountBlock').hide();jQuery('#MyAdvertising').show(); jQuery('#SellSpaceTabs a[href=\"#a3\"]').tab('show'); });</script>";

    } break;

    case "sellspace_delete": {

        // DELETE FILES
        @unlink(get_post_meta($_POST['delid'],'path', true));

        // NOW LETS SAVE THE NEW ONE
        wp_delete_post( $_POST['delid'], true );

        // MSG
        $GLOBALS['error_message'] = $CORE->_e(array('account','106'))."<script>jQuery(document).ready(function() { jQuery('#MyAccountBlock').hide();jQuery('#MyAdvertising').show(); jQuery('#SellSpaceTabs a[href=\"#a2\"]').tab('show');  });</script>";


    } break;

    case "sellspace": {

        if(is_array($_FILES['wlt_banner'])){
            $i = 0;
            foreach($_FILES['wlt_banner'] as $banner){

            if($_FILES['wlt_banner']['name'][$i] == ""){ $i++; continue; }

                if(in_array($_FILES['wlt_banner']['type'][$i],$CORE->allowed_image_types) ){

                    // INCLUDE UPLOAD SCRIPTS
                    $dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
                    if(!function_exists('wp_handle_upload')){
                    require $dir_path . "/wp-admin/includes/file.php";
                    }

                    // GET WORDPRESS UPLOAD DATA
                    $uploads = wp_upload_dir();

                    // UPLOAD FILE
                    $file_array = array(
                        'name'      => $_FILES['wlt_banner']['name'][$i], //$userdata->ID."_userphoto",//
                        'type'      => $_FILES['wlt_banner']['type'][$i],
                        'tmp_name'  => $_FILES['wlt_banner']['tmp_name'][$i],
                        'error'     => $_FILES['wlt_banner']['error'][$i],
                        'size'      => $_FILES['wlt_banner']['size'][$i],
                    );
                    //die(print_r($file_array));
                    $uploaded_file = wp_handle_upload( $file_array, array( 'test_form' => FALSE ));

                    // CHECK FOR ERRORS
                    if(isset($uploaded_file['error']) ){
                        $GLOBALS['error_message'] .= $uploaded_file['error'];
                    }else{

                    // GET SIZES
                    list($width, $height) = getimagesize($uploaded_file['file']);

                    $my_post = array();
                    $my_post['post_title']      = strip_tags($_FILES['wlt_banner']['name'][$i]);
                    $my_post['post_content']    = $width."X".$height."=".$_FILES['wlt_banner']['size'][$i];
                    $my_post['post_excerpt']    = $uploaded_file['url'];
                    $my_post['post_status']     = "publish";
                    $my_post['post_type']       = "wlt_banner";
                    $my_post['post_author']     = $userdata->ID;
                    $POSTID                     = wp_insert_post( $my_post );

                    // ADD CUSTOM FIELDS
                    add_post_meta($POSTID,'img', $uploaded_file['url']);
                    add_post_meta($POSTID,'path', $uploaded_file['file']);
                    add_post_meta($POSTID,'size', $_FILES['wlt_banner']['size'][$i]);
                    add_post_meta($POSTID,'width', $width);
                    add_post_meta($POSTID,'height', $height);

                    }

                    $i++;

                }else{
                $GLOBALS['error_message'] .= $CORE->_e(array('account','107'))." (".$_FILES['wlt_banner']['name'][$i].")<br>";
                }
            }
        }

        // MSG
        if($GLOBALS['error_message'] == ""){
        $GLOBALS['error_message'] = $CORE->_e(array('account','108'));
        }

        $GLOBALS['error_message'] .= "<script>jQuery(document).ready(function() { jQuery('#MyAccountBlock').hide();jQuery('#MyAdvertising').show(); jQuery('#SellSpaceTabs a[href=\"#a2\"]').tab('show');   });</script>";


    } break;

    case "withdraw": {

        if(is_numeric($_POST['amount']) && $_POST['amount'] > 0){

            $subject  = $CORE->_e(array('account','62'));
            $msg     .= "Username: ".$userdata->display_name."\r\n";
            $msg     .= "User ID: ".$userdata->ID."\r\n";
            $msg     .= "Email: ".$userdata->user_email."\r\n";
            $msg     .= "Amount: ".hook_price($_POST['amount'])."\r\n";
            $msg     .= "Preferences: ".$_POST['message']."\r\n";

            // SAVE A COPY TO THE DATABASE

            $SQL = "INSERT INTO `".$wpdb->prefix."core_withdrawal` (
            `user_id` ,
            `user_ip` ,
            `user_name` ,
            `datetime` ,
            `withdrawal_comments` ,
            `withdrawal_status` ,
            `withdrawal_total`
            )
            VALUES ('".$userdata->ID."',  '".$CORE->get_client_ip()."',  '".$userdata->user_login."',  '".date('Y-m-d H:i:s') ."',  '".strip_tags($_POST['message'])."',  '0',  '".strip_tags($_POST['amount'])."')";

            $wpdb->query($SQL);

            // SEND EMAIL TO ADMIN
            $CORE->SENDEMAIL('admin','custom',$subject,$msg);

            $GLOBALS['error_message']   = $CORE->_e(array('account','63'));
        }

    } break;

    case "subscrption": {

        $selstring = "";

        // LOOP THROUGH AND SAVE DATA
        if(isset($_POST['selsubs'])){

            foreach($_POST['selsubs'] as $val){

                $selstring .= "*".$val."*";

            }
        }

        update_user_meta($userdata->ID,'email_subscriptions',$selstring);

        $GLOBALS['error_message']   = $CORE->_e(array('account','42'));

    } break;

    case "deletemsgs": {

        if(isset($_POST['check']) && is_array($_POST['check']) ){

            foreach($_POST['check'] as $msgid){

            update_post_meta($msgid,'status','delete');

            }

            $GLOBALS['error_message']   = $CORE->_e(array('account','16'))."<script>jQuery(document).ready(function() { jQuery('#MyAccountBlock').hide();jQuery('#MyMsgBlock').show(); });</script>";

        }


    } break;
    case "deletemsg": {

        update_post_meta($_POST['messageID'],'status','delete');

        $GLOBALS['error_message']   = $CORE->_e(array('account','16'))."<script>jQuery(document).ready(function() { jQuery('#MyAccountBlock').hide();jQuery('#MyMsgBlock').show(); });</script>";

    } break;

    case "delfeedback": {

        // CHECK FEEDBACK BELONGS TO THIS USER?

        wp_delete_post( $_POST['fid'], true);

        $GLOBALS['error_message']   = $CORE->_e(array('feedback','6'))."<script>jQuery(document).ready(function() { jQuery('#MyAccountBlock').hide();jQuery('#MyFeedback').show(); });</script>";


    } break;

    case "addfeedback": {

                $my_post = array();
                $my_post['post_title']      = strip_tags(strip_tags($_POST['subject']));
                $my_post['post_content']    = strip_tags(strip_tags($_POST['message']));
                $my_post['post_excerpt']    = "";
                $my_post['post_status']     = "publish";
                $my_post['post_type']       = "wlt_feedback";
                $my_post['post_author']     = $userdata->ID;
                $POSTID                     = wp_insert_post( $my_post );

                // GET THE LISTING DATA
                $feedback_postdata = get_post($_POST['pid']);

                // CUSTOM FIELDS
                add_post_meta($POSTID, "pid", $_POST['pid']);
                add_post_meta($POSTID, "score", $_POST['score']);
                add_post_meta($POSTID, "uid", $feedback_postdata->post_author);
                add_post_meta($POSTID, "auid", $userdata->ID);


                // ADD FEEDBACK RATING TO THE POST ITSELF
                $fback = $CORE->FEEDBACKSCORE($_POST['pid']);

                $tscore =  $fback['score']*5/100;

                update_post_meta($_POST['pid'], 'rating_total', $tscore);

                // SEND EMAIL
                $_POST['title'] = $feedback_postdata->post_title;
                $_POST['link'] = get_permalink($feedback_postdata->ID);
                $CORE->SENDEMAIL($feedback_postdata->post_author,'newfeedback');

                // GO BACK TO LISTING
                header("location:".get_permalink($_POST['pid'])."?ftyou=1");


    } break;

    case "sendmsg": {

        $dd = get_userdatabylogin( $_POST['username'] );

        // ADDED TO FIX HYPEN USERNAMES
        if($dd == ""){
        $dd = get_userdatabylogin( str_replace("-"," ",$_POST['username']) );
        }

        if(!isset($dd->ID)){

            $GLOBALS['error_type']      = "danger"; //ok,warn,error,info
            $GLOBALS['error_message']   = $CORE->_e(array('account','18'));

        }elseif(isset($dd->ID)){

            // CHECK HOW MANY MESSAGES HAVE BEEN SENT ALREADY FROM THIS USER
            $SQL = "SELECT count(*) AS total FROM $wpdb->posts WHERE post_type = 'wlt_message' AND post_author = '".$userdata->ID."' AND post_date LIKE ('".date("Y-m-d")."%')";
            $found = (array)$wpdb->get_results($SQL);

            if($found[0]->total < 20){ // LIMIT 10 PER DAY

                $my_post = array();
                $my_post['post_title']      = strip_tags(strip_tags($_POST['subject']));
                $my_post['post_content']    = strip_tags(strip_tags($_POST['message']));
                $my_post['post_excerpt']    = "";
                $my_post['post_status']     = "publish";
                $my_post['post_type']       = "wlt_message";
                $my_post['post_author']     = $userdata->ID;
                $POSTID                     = wp_insert_post( $my_post );

                add_post_meta($POSTID, "username", $dd->user_login);
                add_post_meta($POSTID, "userID", $dd->ID);
                add_post_meta($POSTID, "status", "unread");


                $GLOBALS['error_type']      = "success"; //ok,warn,error,info
                $GLOBALS['error_message']   = $CORE->_e(array('account','17'));

                // SEND EMAIL
                $_POST['username'] = $dd->display_name;
                $_POST['from_username'] = $userdata->display_name;

                $CORE->SENDEMAIL($dd->ID,'msg_new');

                // CLEAR MESSSAGE VALUES
                $_POST['subject'] = "";
                $_POST['message'] = "";

                $GLOBALS['showmesgbox']= 1;

            }else{

                $GLOBALS['error_type']      = "danger"; //ok,warn,error,info
                $GLOBALS['error_message']   = "Too Many Messages Sent - Please wait 24 hours.";
                $GLOBALS['showmesgbox']=1;
            }
        }

    } break;

    case "update": {

            // SAVE THE CUSTOM PROFILE DATA
            if(isset($_POST['custom']) && is_array($_POST['custom'])){
                foreach($_POST['custom'] as $key=>$val){
                    // SAVE DATA
                    if(is_array($val)){
                        update_user_meta($userdata->ID, strip_tags($key), $val);
                    }else{
                        update_user_meta($userdata->ID, strip_tags($key), esc_html(strip_tags($val)));
                    }
                } // end foreach
            }// end if

            $data = array();
            $data['ID']             = $userdata->ID;
            // CHECK IF WE ARE CHANGING PASSWORDS
            if(!defined('WLT_DEMOMODE')){
                if( ( $_POST['password'] == $_POST['password_r'] ) && $_POST['password'] !=""){

                    $data['user_pass']      = $_POST['password'];
                    // ERROR MESSAGE
                    $GLOBALS['error_message'] = $CORE->_e(array('account','19'));

                } elseif(isset($_POST['password']) && strlen($_POST['password']) > 1){

                    // PASSWORD CHECK ERROR
                    $GLOBALS['error_message'] = $CORE->_e(array('account','20'));

                }else{
                    // ERROR MESSAGE
                    $GLOBALS['error_message'] = $CORE->_e(array('account','21'));
                }
            }// end if

            // CHECK EMAIL IS VALID
            update_user_meta($userdata->ID, 'url', strip_tags($_POST['url']));
            update_user_meta($userdata->ID, 'phone', strip_tags($_POST['phone']));

            // SOCIAL
            update_user_meta($userdata->ID, 'facebook', strip_tags($_POST['facebook']));
            update_user_meta($userdata->ID, 'twitter', strip_tags($_POST['twitter']));
            update_user_meta($userdata->ID, 'linkedin', strip_tags($_POST['linkedin']));
            update_user_meta($userdata->ID, 'skype', strip_tags($_POST['skype']));

            // PROFILE BG
            if(isset($_POST['pbg'])){
            update_user_meta($userdata->ID, 'pbg', strip_tags($_POST['pbg']));
            }

            // COUNTRY
            update_user_meta($userdata->ID, 'country', strip_tags($_POST['country']));

            // UPLOAD USER PHOTO
            if(isset($_FILES['wlt_userphoto']) && strlen($_FILES['wlt_userphoto']['name']) > 2 && in_array($_FILES['wlt_userphoto']['type'],$CORE->allowed_image_types) ){

                // INCLUDE UPLOAD SCRIPTS
                $dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
                if(!function_exists('wp_handle_upload')){
                require $dir_path . "/wp-admin/includes/file.php";
                }

                // GET WORDPRESS UPLOAD DATA
                $uploads = wp_upload_dir();

                // UPLOAD FILE
                $file_array = array(
                    'name'      => $_FILES['wlt_userphoto']['name'], //$userdata->ID."_userphoto",//
                    'type'      => $_FILES['wlt_userphoto']['type'],
                    'tmp_name'  => $_FILES['wlt_userphoto']['tmp_name'],
                    'error'     => $_FILES['wlt_userphoto']['error'],
                    'size'      => $_FILES['wlt_userphoto']['size'],
                );
                //die(print_r($file_array));
                $uploaded_file = wp_handle_upload( $file_array, array( 'test_form' => FALSE ));

                // CHECK FOR ERRORS
                if(isset($uploaded_file['error']) ){
                    $GLOBALS['error_message'] = $uploaded_file['error'];
                }else{

                // NOW LETS SAVE THE NEW ONE
                update_user_meta($userdata->ID, "userphoto", array('img' => $uploaded_file['url'], 'path' => $uploaded_file['file'] ) );

                }
            }

            // EXTRA
            $data['first_name']         = strip_tags($_POST['fname']);
            $data['last_name']          = strip_tags($_POST['lname']);
            $data['description']        = strip_tags($_POST['description']);
            wp_update_user( $data );

            // FUNCTION FOR PLUGINS
            //do_action('profile_update');
            hook_account_update();

        } break;

        default: {

        hook_account_save();

        } break;

    }

}
if(isset($_GET['did']) && is_numeric($_GET['did']) ){

    // CHECK THE POST AUTHOR AGAINST THE USER LOGGED IN
    $post_data = get_post($_GET['did']);
    if($post_data->post_author == $userdata->ID){
    $my_post = array();
    $my_post['ID']                  = $_GET['did'];
    $my_post['post_status']         = "trash";
    wp_update_post( $my_post  );
    // DELETE ALL ATTACHMENTS
    $CORE->UPLOAD_DELETEALL($_GET['did']);
    // ADD LOG ENTRY
    $CORE->ADDLOG("<a href='(ulink)'>".$userdata->user_nicename.'</a> deleted listing <b>['.get_the_title($_GET['did']).']</b>', $userdata->ID,$_GET['did'],'label-important');
    // ERROR MESSAGE
    $GLOBALS['error_message'] = $CORE->_e(array('account','22'));
    }else{
    $GLOBALS['error_message'] = "no access";
    }
}

if(isset($_GET['claime']) && is_numeric($_GET['claime']) ){

    // CHECK IF THE USER HAS CLAIMED ANY LISTINGS BEFORE
    if(get_user_meta($userdata->ID, "claimed_listing",true) == ""){
        // ALLOW CLAIM
        $my_post = array();
        $my_post['ID']                  = $_GET['claime'];
        $my_post['post_status']         = "publish";
        $my_post['post_author']         = $userdata->ID;
        wp_update_post( $my_post  );
        // ADD CUSTOM FIELD SO WE KNOW IT WAS CLAIMED
        $_POST['title'] = get_the_title($_GET['claime']);
        // SET USER FLAG
        update_user_meta($userdata->ID, "claimed_listing", $_GET['claime']);
        // REMOVE CLAIM
        $CORE->SENDEMAIL('admin','admin_newclaim');
        // ADD LOG ENTRY
        $CORE->ADDLOG("<a href='(ulink)'>".$userdata->user_nicename.'</a> claimed listing <b>['.get_the_title($_GET['claime']).']</b>', $userdate->ID,$_GET['claime'],'label-important');

    // ERROR MESSAGE
    $GLOBALS['error_message'] = $CORE->_e(array('account','23'));
    }else{

    // ADD LOG ENTRY
    $CORE->ADDLOG("<a href='(ulink)'>".$userdata->user_nicename.'</a> tried to claim listing <b>['.get_the_title($_GET['claime']).']</b> but was denied! (too many claims)', $userdate->ID,$_GET['claime'],'label-info');

    $GLOBALS['error_message'] = $CORE->_e(array('account','24'));
    $GLOBALS['error_type'] = "error";
    }

}

if(isset($_GET['submissionlimit'])){

    $GLOBALS['error_message'] = $CORE->_e(array('account','25'));
    $GLOBALS['error_type'] = "bs-callout bs-callout-success";
}
?>
    <div id="core_ajax_callback"></div>

        <?php echo $CORE->BANNER('middle_top'); ?>

        <?php get_template_part( 'account', 'overview' ); ?>

        <?php do_action('hook_account_after'); ?>


        <?php if($GLOBALS['CORE_THEME']['show_account_withdraw'] == '1'){ ?>

            <?php get_template_part( 'account', 'withdrawal' ); ?>

        <?php } ?>

        <?php if($GLOBALS['CORE_THEME']['show_account_subscriptions'] == '1'){ ?>

            <?php get_template_part( 'account', 'subscriptions' ); ?>

        <?php } ?>

        <?php if($GLOBALS['CORE_THEME']['show_account_edit'] == '1'){ ?>

            <?php get_template_part( 'account', 'details' ); ?>

        <?php } ?>

        <?php if($GLOBALS['CORE_THEME']['message_system'] == '1'){ ?>

            <?php get_template_part( 'account', 'messages' ); ?>

        <?php } ?>

        <?php if(!defined('WLT_CART') && $GLOBALS['CORE_THEME']['feedback_enable'] == '1'){  ?>

         <?php //get_template_part( 'account', 'feedback' );
            get_template_part( 'account', 'testimonial');
         ?>

        <?php } ?>

        <?php if(isset($GLOBALS['CORE_THEME']['sellspace_enable']) && $GLOBALS['CORE_THEME']['sellspace_enable'] == 1 ){ ?>

            <?php get_template_part( 'account', 'sellspace' ); ?>

        <?php } ?>

</div>

</article>