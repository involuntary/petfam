<?php
/*
Plugin Name: [PAYMENT GATEWAY] - stripe
Plugin URI: http://www.premiumpress.com
Description: This plugin will add stripe to your PremiumPress payment gateways list.
Version: 1.1
Author: Mark Fail
Author URI: http://www.premiumpress.com
Updated: 12th April 2014
License:
*/

//1. HOOK INTO THE GATEWAY ARRAY
function wlt_gateway_stripe_admin($gateways){
	$nId = count($gateways)+1;
	$gateways[$nId]['name'] 		= "stripe";
	$gateways[$nId]['logo'] 		= plugins_url()."/wlt_gateway_stripe/img/logo.png";
	$gateways[$nId]['function'] 	= "wlt_gateway_stripe_form";
	$gateways[$nId]['website'] 		= "http://www.stripe.com";
	$gateways[$nId]['callback'] 	= "yes";
	$gateways[$nId]['ownform'] 		= "yes";
	$gateways[$nId]['fields'] 		= array(
	'1' => array('name' => 'Enable Gateway', 'type' => 'listbox','fieldname' => $gateways[$nId]['function'],'list' => array('yes'=>'Enable','no'=>'Disable',) ),
 	
	'2' => array('name' => 'API Secret Key', 'type' => 'text', 'fieldname' => 'stripe_secret'),
 
	'3' => array('name' => 'API Production Key', 'type' => 'text', 'fieldname' => 'stripe_production'),
 	
	'4' => array('name' => 'Currency Code', 'type' => 'text', 'fieldname' => 'stripe_currency', 'default' => 'GBP'),
	 
	'5' => array('name' => 'Display Name', 'type' => 'text', 'fieldname' => 'stripe_displayname', 'default' => 'Pay Now with stripe'),
	 
	
	);
	$gateways[$nId]['notes'] 	= "A list of stripe curreny codes can be found <a href='https://support.stripe.com/questions/which-currencies-does-stripe-support' target='_blank' style='text-decoration:underline;'>here</a>
 
	";
	return $gateways;
}
add_action('hook_payments_gateways','wlt_gateway_stripe_admin');

//2. BUILD THE PAYMENT FORM DATA
function wlt_gateway_stripe_form($data=""){

	global $wpdb;
	
    /* DATA AVAILABLE
   
	$GLOBALS['total'] 	 
	$GLOBALS['subtotal'] 	 
	$GLOBALS['shipping'] 	 
	$GLOBALS['tax'] 		 
	$GLOBALS['discount'] 	 
	$GLOBALS['items'] 		 
	$GLOBALS['orderid'] 	 
	$GLOBALS['description'] 
    
    */
	
	
	
if($GLOBALS['description'] == ""){ $GLOBALS['description'] = $GLOBALS['orderid']; }
	
$gatewaycode = '


<div class="row-old">
					   <div class="col-md-8"><b>'.get_option('stripe_displayname').'</b></div>
					   <div class="col-md-4">
					   
<form action="'.$GLOBALS['CORE_THEME']['links']['callback'].'" method="POST">
<input type="hidden" name="orderid" value="'.$GLOBALS['orderid'] .'" />
<input type="hidden" name="amount" value="'.$GLOBALS['total'] .'" />
<input type="hidden" name="desc" value="'.$GLOBALS['description'] .'" />
<input type="hidden" name="shipping" value="'.$GLOBALS['shipping'] .'" />
<input type="hidden" name="tax" value="'.$GLOBALS['tax'] .'" />
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="'.get_option('stripe_production').'"
    data-amount="'.(str_replace(",","",$GLOBALS['total'])*100).'"
	data-currency="'.get_option('stripe_currency').'"

    >
  </script>
</form>		   
	
	</div> <div class="clearfix"></div></div>'; 

return $gatewaycode;

}
 
// 3. HANDLE THE CALLBACK 
function wlt_gateway_stripe_callback($orderID){ global $CORE, $userdata;
 
	if(isset($_POST['stripeToken']) && strlen($_POST['stripeToken']) > 4 ){		 
		
	 	// INCLUDE STRIPE
		require('lib/Stripe.php');
		
		// Set your secret key: remember to change this to your live secret key in production
		// See your keys here https://manage.stripe.com/account
		Stripe::setApiKey(get_option('stripe_secret'));
		
		// Get the credit card details submitted by the form
		$token = $_POST['stripeToken'];		
		 
		// Create the charge on Stripe's servers - this will charge the user's card
		try {
		$charge = Stripe_Charge::create(array(
		  "amount" => str_replace(",","",$_POST['amount'])*100, // amount in cents, again
		  "currency" => get_option('stripe_currency'),
		  "card" => $token,
		  "description" => $_POST['desc'])
		);
	 	
		core_generic_gateway_callback($_POST['orderid'], array(
		'description' =>  $_POST['desc'], 
		'email' => $userdata->user_email, 
		'shipping' => $_POST['shipping'], 
		'shipping_label' => '', 
		'tax' => $_POST['tax'], 
		'total' => str_replace(",","",$_POST['amount']) ) );
		
		return "success";	
		 
		} catch(Stripe_CardError $e) {
		  // The card has been declined
		  
		  return "error";	
		}		
		
	} 	
}

add_action('hook_callback','wlt_gateway_stripe_callback');
?>