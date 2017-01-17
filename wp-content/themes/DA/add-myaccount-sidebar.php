<aside class="core_sidebar" id="core_left_column">

<?php
global  $userdata, $CORE; $CORE->Authorize(); $GLOBALS['flag-myaccount'] = 1;
    // USER LOGIN COUNT
    $logincount = get_user_meta($userdata->ID,'login_count',true);
    if($logincount == "" || $logincount == 0){ $logincount = 1; }

    // REGISTERED
    $seconds_offset = get_option( 'gmt_offset' ) * 3600;
    $dateoffset = date("Y-m-d H:i:s", strtotime($userdata->user_registered) + $seconds_offset );

    $date = $CORE->TimeDiff($dateoffset);
    if(trim($date['date']) == ""){ $date['date'] = "a few seconds"; }

    // PROFILE BACKGROUND
    $pbg = get_user_meta($userdata->ID,'pbg',true);
    if($pbg == ""){ $pbg = 1; }

    // USER COUNTRY
    $selected_country = get_user_meta($userdata->ID,'country',true);


?>
<?php if( !defined('WLT_CART') && isset($GLOBALS['CORE_THEME']['show_account_photo']) && $GLOBALS['CORE_THEME']['show_account_photo'] == 1){ ?>

<div class="panel wlt_widget_authorbox_wrapper">
<div class="wlt_widget_authorbox hoverwlt_widget_authorbox">
    <div class="wlt_widget_authorboxheader" style="background:url('<?php echo FRAMREWORK_URI; ?>/img/profile/1_small.jpg');background-size: cover; height:300px; margin-bottom: -50px; ">

    </div>
    <div class="avatar" style="top:-170px;">

       <a href="javascript:void(0);" onclick="jQuery('#MyAccountBlock').hide();jQuery('#MyDetailsBlock').show(); jQuery('#MyFeedback').hide(); jQuery('#MyMsgBlock').hide(); jQuery('#MyDashboardBlock').hide(); jQuery('#MySubscriptionBlock').hide(); jQuery('form#SUBMISSION_FORM').hide(); jQuery('article#core_middle_column').show();">
       <?php echo str_replace("avatar "," ",get_avatar( $userdata->ID, 150 )); ?>
       </a>

    </div>

   <?php if(!defined('WLT_DATING') ){ ?>

        <div class="panel-footer">
        <a href="<?php echo get_author_posts_url( $userdata->ID ); ?>" ><?php echo get_the_author_meta( 'display_name', $userdata->ID); ?></a>

        <?php if(strlen($selected_country) > 0){ ?>

                <div class="flag flag-<?php echo strtolower($selected_country); ?> wlt_locationflag"></div>

           <?php } ?>

        </div>


        <?php if(isset($GLOBALS['CORE_THEME']['feedback_trustbar']) && $GLOBALS['CORE_THEME']['feedback_trustbar'] == '1' && !defined('WLT_CART') ){ ?>

        <div class="panel-footer">

                <a href="javascript:void(0);" onclick="jQuery('#MyDetailsBlock').hide();jQuery('#MyFeedback').show(); jQuery('#MyMsgBlock').hide(); jQuery('#MyDashboardBlock').hide(); jQuery('#MySubscriptionBlock').hide(); jQuery('form#SUBMISSION_FORM').hide(); jQuery('article#core_middle_column').show();">
                <?php echo _user_trustbar($userdata->ID, 'inone'); ?>
                </a>

        </div>

        <?php } ?>

    <?php } ?>





    </div>
</div>

<?php } ?>



<div class="core_widgets_categories_list normallayout">

<div class="panel panel-default">

<div class="panel-heading"><?php echo $CORE->_e(array('account','116')); ?></div>



<ul class="list-group clearfix">


<?php

$ex = ""; // extra

$AFIELDS[] = array(
    "l" => "#top",
    "oc" => "jQuery('#MyAccountBlock').hide();jQuery('#MyDetailsBlock').hide(); jQuery('#MyFeedback').hide(); jQuery('#MyMsgBlock').hide(); jQuery('#mediauploadblock').hide(); jQuery('#MyDashboardBlock').show(); jQuery('#MySubscriptionBlock').hide(); jQuery('form#SUBMISSION_FORM').hide(); jQuery('article#core_middle_column').show();",
    "i" => "glyphicon glyphicon-dashboard",
    "t" => $CORE->_e(array('head','4')),
    "d" => "",
    "e" => $ex,
);

if($GLOBALS['CORE_THEME']['show_account_edit'] == '1'){
$AFIELDS[] = array(
    "l" => "#top",
    "oc" => "jQuery('#MyAccountBlock').hide();jQuery('#MyDetailsBlock').show(); jQuery('#MyFeedback').hide(); jQuery('#MyMsgBlock').hide(); jQuery('#MyDashboardBlock').hide(); jQuery('#mediauploadblock').hide(); jQuery('#MySubscriptionBlock').hide(); jQuery('form#SUBMISSION_FORM').hide(); jQuery('article#core_middle_column').show();",
    "i" => "glyphicon glyphicon-user",
    "t" => $CORE->_e(array('account','2')),
    "d" => $CORE->_e(array('account','3')),
    "e" => $ex,
);
}


if($GLOBALS['CORE_THEME']['show_account_create'] == '1' && !defined('WLT_CART') && !defined('WLT_DATING') ){
    if(isset($membershipfields[$GLOBALS['current_membership']]['submissionamount']) && $membershipfields[$GLOBALS['current_membership']]['submissionamount']  == "0" ){ }else{
$AFIELDS[] = array(
    "l" => $GLOBALS['CORE_THEME']['links']['add'],
    "oc" => "",
    "i" => "glyphicon glyphicon-pencil",
    "t" => $CORE->_e(array('account','4')),
    "d" => $CORE->_e(array('account','5')),
    "e" => $ex,
);
    }
}

if($GLOBALS['CORE_THEME']['show_account_viewing'] == '1' && !defined('WLT_CART') ){
$AFIELDS[] = array(
    "l" => get_home_url()."/?s=&uid=".$userdata->ID,
    "oc" => "",
    "i" => "glyphicon glyphicon-search",
    "t" => $CORE->_e(array('account','6')),
    "d" => $CORE->_e(array('account','7')),
    "e" => $ex,
);
}

if($GLOBALS['CORE_THEME']['message_system'] == '1' && !defined('WLT_CART') ){

$AFIELDS[] = array(
    "l" => "#top",
    "oc" => "jQuery('#MyDetailsBlock').hide();jQuery('#MyMsgBlock').show(); jQuery('#MyFeedback').hide(); jQuery('#MyDashboardBlock').hide(); jQuery('#MySubscriptionBlock').hide(); jQuery('form#SUBMISSION_FORM').hide(); jQuery('article#core_middle_column').show();",
    "i" => "glyphicon glyphicon-envelope",
    "t" => $CORE->_e(array('account','26')),
    "d" => $CORE->_e(array('account','27')),
    "e" => $ex,
);
$ex = "";
}

if(isset($GLOBALS['CORE_THEME']['feedback_enable']) && $GLOBALS['CORE_THEME']['feedback_enable'] == '1' && !defined('WLT_CART')){
$AFIELDS[] = array(
    "l" => "#top",
    "oc" => "jQuery('#MyDetailsBlock').hide();jQuery('#MyFeedback').show(); jQuery('#MyMsgBlock').hide(); jQuery('#MyDashboardBlock').hide(); jQuery('#MySubscriptionBlock').hide(); jQuery('#mediauploadblock').hide(); jQuery('form#SUBMISSION_FORM').hide(); jQuery('article#core_middle_column').show();",
    "i" => "glyphicon glyphicon-comment",
    "t" => $CORE->_e(array('account','81')),
    "d" => $CORE->_e(array('account','82')),
    "e" => $ex,
);
}

if($GLOBALS['CORE_THEME']['show_account_subscriptions'] == '1'){
$AFIELDS[] = array(
    "l" => "#top",
    "oc" => "jQuery('#MyDetailsBlock').hide();jQuery('#MySubscriptionBlock').show(); jQuery('#MyFeedback').hide(); jQuery('#MyMsgBlock').hide(); jQuery('#MyDashboardBlock').hide(); jQuery('form#SUBMISSION_FORM').hide(); jQuery('article#core_middle_column').show();",
    "i" => "glyphicon glyphicon-book",
    "t" => $CORE->_e(array('account','44')),
    "d" => $CORE->_e(array('account','45')),
    "e" => $ex,
);
}

 if($GLOBALS['CORE_THEME']['show_account_favs'] == '1'){
$AFIELDS[] = array(
    "l" => home_url()."/?s=&favs=1",
    "oc" => "",
    "i" => "glyphicon glyphicon-star",
    "t" => $CORE->_e(array('account','46')),
    "d" => $CORE->_e(array('account','47')),
    "e" => $ex,
);
}

if($GLOBALS['CORE_THEME']['show_account_withdraw'] == '1'){
$AFIELDS[] = array(
    "l" => "#top",
    "oc" => "jQuery('#MyDetailsBlock').hide();jQuery('#MyWidthdrawlBlock').show(); jQuery('#MyFeedback').hide(); jQuery('#MyMsgBlock').hide(); jQuery('#MyDashboardBlock').hide(); jQuery('#MySubscriptionBlock').hide(); jQuery('form#SUBMISSION_FORM').hide(); jQuery('article#core_middle_column').show();",
    "i" => "glyphicon glyphicon-usd",
    "t" => $CORE->_e(array('account','54')),
    "d" => $CORE->_e(array('account','55')),
    "e" => "<span class='label label-danger'>".$CORE->_e(array('order_status','title4'))." ".hook_price($GLOBALS['usercredit'])."</span>",
);
}

if( isset($GLOBALS['CORE_THEME']['sellspace_enable']) && $GLOBALS['CORE_THEME']['sellspace_enable'] == 1 ){
$AFIELDS[] = array(
    "l" => "#top",
    "oc" => "jQuery('#MyDetailsBlock').hide();jQuery('#MyAdvertising').show(); jQuery('#MyFeedback').hide(); jQuery('#MyMsgBlock').hide(); jQuery('#MyDashboardBlock').hide(); jQuery('#MySubscriptionBlock').hide(); jQuery('form#SUBMISSION_FORM').hide(); jQuery('article#core_middle_column').show();",
    "i" => "glyphicon glyphicon-list-alt",
    "t" => "Premium Advertising",
    "d" => "Here you can purchase additional advertising.",
    "e" => "",
);
}


?>

<?php

$AFIELDS = hook_account_pagelist($AFIELDS);

if(is_array($AFIELDS)){
foreach($AFIELDS as $key => $account){

?>

<li class="list-group-item">

    <?php if($account['e'] == ""){ ?> <i class="<?php echo $account['i']; ?>"></i>   <?php }else{ ?> <span><?php echo $account['e']; ?></span><?php } ?>

    <a href="<?php echo $account['l']; ?>" onclick="<?php echo $account['oc']; ?>"> <?php echo $account['t']; ?></a>


</li>

<?php } } ?>

<?php if($GLOBALS['CORE_THEME']['show_profilelinks'] == 1 && !defined('WLT_DATING') && !defined('WLT_CART') ){ ?>
<li class="list-group-item">
     <i class="glyphicon glyphicon-bookmark"></i>
    <a href="<?php echo get_author_posts_url( $userdata->ID ); ?>">
        <?php echo $CORE->_e(array('widgets','24')); ?>
    </a>
</li>
<?php } ?>

<li class="list-group-item"> <div class="text-center">
    <a class="btn btn-warning" style="float:none;display:block;" href="<?php echo wp_logout_url(); ?>">
        <?php echo $CORE->_e(array('account','8')); ?>
    </a>
</div> </li>

</ul><div class="clearfix"></div></div></div>






<div class="text-center hidden-xs" style="margin-bottom:30px; padding:10px;"><small>
<?php echo str_replace("%a", $date['date'], $CORE->_e(array('account','88')) ); ?> <?php echo number_format($logincount); ?>  <?php echo $CORE->_e(array('account','87')); ?>  </small>
</div>




</aside>
