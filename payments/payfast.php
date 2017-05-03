<?php
/**
 * payment/payfast.php
 *
 * Copyright (c) 2008 PayFast (Pty) Ltd
 * You (being anyone who is not PayFast (Pty) Ltd) may download and use this plugin / code in your own website in conjunction with a registered and active PayFast account. If your PayFast account is terminated for any reason, you may not use this plugin / code or part thereof.
 * Except as expressly indicated in this licence, you may not use, copy, modify or distribute this plugin / code or part thereof in any way.
 * 
 * @author     Ron Darby
 * @version    1.2.0
 */
if ( !defined('AREA') ) { die('Access denied'); }

include('payfast/payfast_common.inc');

define( 'PF_DEBUG', $processor_data['params']['debug'] );
$payfast_merchant_id = $processor_data['params']['merchant_id'];
$payfast_merchant_key = $processor_data['params']['merchant_key'];
$payfast_passphrase = $processor_data['params']['passphrase'];  

$current_location = Registry::get('config.current_location');
if ($processor_data['params']['mode'] == 'sandbox') {
	$pfHost = "sandbox.payfast.co.za";
    $payfast_merchant_id = "10000100";
    $payfast_merchant_key = "46f0cd694581a";
} else {
    $pfHost = "www.payfast.co.za";
}
 
	//$pfHost = 'www.payfast.local'; //Local Testing

// Return from paypal website
if (defined('PAYMENT_NOTIFICATION')) {
      
    
	if ($mode == 'notify' && !empty($_REQUEST['m_payment_id'])) {

        $order_id = $_POST['m_payment_id'];
		// Get order data
        $order_info = fn_get_order_info($order_id);

        $preHost = $order_info['payment_method']['params']['mode'] == 'sandbox' ? 'sandbox' : 'www' ;
        $pfHost = $preHost.'.payfast.co.za';

        if (fn_check_payment_script('payfast.php', $order_id, $processor_data)) {
            
            if (empty($processor_data)) {
				$processor_data = fn_get_processor_data($order_info['payment_id']);
			}
           } 
           $pp_response = array();
		   $payfast_statuses = $processor_data['params']['statuses'];
           $pfError = false;
           $pfErrMsg = '';
           $pfDone = false;
           $pfData = array();	   
           $pfParamString = '';
            pflog($pfHost);
            pflog( 'PayFast ITN call received' );
    
            //// Notify PayFast that information has been received
            if( !$pfError && !$pfDone )
            {
                header( 'HTTP/1.0 200 OK' );
                flush();
            }
        
            //// Get data sent by PayFast
            if( !$pfError && !$pfDone )
            {
                pflog( 'Get posted data' );
            
                // Posted variables from ITN
                $pfData = pfGetData();
            
                pflog( 'PayFast Data: '. print_r( $pfData, true ) );
            
                if( $pfData === false )
                {
                    $pfError = true;
                    $pfErrMsg = PF_ERR_BAD_ACCESS;
                }
            }
           
            //// Verify security signature
            if( !$pfError && !$pfDone )
            {
                pflog( 'Verify security signature' );

                $pfPassphrase = $processor_data['params']['mode'] == 'sandbox' ? null : ( !empty( $payfast_passphrase ) ? $payfast_passphrase : null );
            
                // If signature different, log for debugging
                if( !pfValidSignature( $pfData, $pfParamString, $pfPassphrase ) )
                {
                    $pfError = true;
                    $pfErrMsg = PF_ERR_INVALID_SIGNATURE;
                }
            }
        
            //// Verify source IP (If not in debug mode)
            if( !$pfError && !$pfDone && !PF_DEBUG )
            {
                pflog( 'Verify source IP' );
            
                if( !pfValidIP( $_SERVER['REMOTE_ADDR'] ) )
                {
                    $pfError = true;
                    $pfErrMsg = PF_ERR_BAD_SOURCE_IP;
                }
            }
            //// Get internal cart
            if( !$pfError && !$pfDone )
            {           
        
                pflog( "Purchase:\n". print_r( $order_info, true )  );
            }
            
            //// Verify data received
            if( !$pfError )
            {
                pflog( 'Verify data received' );
            
                $pfValid = pfValidData( $pfHost, $pfParamString );
            
                if( !$pfValid )
                {
                    $pfError = true;
                    $pfErrMsg = PF_ERR_BAD_ACCESS;
                }
            }
            
            //// Check data against internal order
            if( !$pfError && !$pfDone )
            {
               // pflog( 'Check data against internal order' );
        
                // Check order amount
                if( !pfAmountsEqual( $pfData['amount_gross'],$order_info['total'] ) )
                {
                    $pfError = true;
                    $pfErrMsg = PF_ERR_AMOUNT_MISMATCH;
                }          
                
            }
            
            //// Check status and update order
            if( !$pfError && !$pfDone )
            {
                pflog( 'Check status and update order' );
        
                
                $transaction_id = $pfData['pf_payment_id'];
        
        		switch( $pfData['payment_status'] )
                {
                    case 'COMPLETE':
                        pflog( '- Complete' );
                        $pp_response['order_status'] = $payfast_statuses['completed'];                        
                        break;
        
        			case 'FAILED':
                        pflog( '- Failed' );                       
                        $pp_response['order_status'] = $payfast_statuses['denied'];        
            			break;
        
        			case 'PENDING':
                        pflog( '- Pending' );                   
                        $pp_response['order_status'] = $payfast_statuses['pending'];
            			break;
        
        			default:
                        // If unknown status, do nothing (safest course of action)
        			break;
                }
                
                
                $pp_response['reason_text'] = $pfData['payment_status'];
                $pp_response['transaction_id'] = $transaction_id;
                $pp_response['customer_email'] = $pfData['email_address'];
           if ($pp_response['order_status'] == $paypal_statuses['pending']) {
				fn_change_order_status($order_id, $pp_response['order_status']);
			} else {
				fn_finish_payment($order_id, $pp_response);
                                
			}
		 }
		exit;

	} elseif ($mode == 'return') {
	   $order_id = $_GET['order_id'];
		if (fn_check_payment_script('paypal.php', $order_id)) {
			$order_info = fn_get_order_info($order_id, true);
			if ($order_info['status'] == 'N') {
				fn_change_order_status($order_id, 'O', '', false);
			}
		}
		fn_order_placement_routines($order_id, false);

	} elseif ($mode == 'cancel') {
	    $order_id = $_GET['order_id'];
		$order_info = fn_get_order_info($order_id);

		$pp_response['order_status'] = 'N';
		$pp_response["reason_text"] = fn_get_lang_var('text_transaction_cancelled');

		
		fn_finish_payment($order_id, $pp_response, false);
		fn_order_placement_routines($order_id);
	}

} else {

    $secure = ''; 
    $secure .= 'merchant_id='.urlencode($payfast_merchant_id);
    $secure .= '&merchant_key='.urlencode($payfast_merchant_key);  
    $return = "$current_location/$index_script?dispatch=payment_notification.return&payment=payfast&order_id=$order_id";    
    $secure .= '&return_url='.urlencode($return);
    $cancel = "$current_location/$index_script?dispatch=payment_notification.cancel&payment=payfast&order_id=$order_id";
    $secure .= '&cancel_url='.urlencode($cancel);
    $notify =  "$current_location/$index_script?dispatch=payment_notification.notify&payment=payfast&order_id=$order_id";
    $secure .= '&notify_url='.urlencode($notify);    
    $name_first = html_entity_decode($order_info['b_firstname'], ENT_QUOTES, 'UTF-8');    
    $secure .= '&name_first='.urlencode($name_first);
    $name_last = html_entity_decode($order_info['b_lastname'], ENT_QUOTES, 'UTF-8');	
    $secure .= '&name_last='.urlencode($name_last);
    $secure .= '&email_address='.urlencode($order_info['email']);    
    $secure .= '&m_payment_id='.urlencode($order_id);
    $payfast_total = $order_info['total'];
    $secure .= '&amount='.urlencode($payfast_total);
    $payfast_item_name = fn_get_lang_var('text_payfast_item_name').' - '. $order_id;    
    $secure .= '&item_name='.urlencode($payfast_item_name);
    $payfast_item_description = fn_get_lang_var('text_payfast_item_description');
    $secure .= '&item_description='.urlencode($payfast_item_description);	


    if( !empty( $payfast_passphrase ) && $processor_data['params']['mode'] != 'sandbox' )
    {
        $secureString = $secure.'passphrase=' . urlencode( $payfast_passphrase  );
    }
    else
    {
        $secureString = substr( $secureString, 0, -1 );
    }   
	$securityHash = md5( $secure );
	//Order Total
	
	
	


	$msg = fn_get_lang_var('text_cc_processor_connection');
	$msg = str_replace('[processor]', 'PayFast', $msg);
	echo <<<EOT
	<html>
	<body onLoad="document.payfast_form.submit();">
	<form action="https://{$pfHost}/eng/process" method="post" name="payfast_form">
    <input type="hidden" name="merchant_id" value="{$payfast_merchant_id}" />
    <input type="hidden" name="merchant_key" value="{$payfast_merchant_key}" />
    <input type="hidden" name="return_url" value="{$return}" />
	<input type="hidden" name="cancel_url" value="{$cancel}" />
	<input type="hidden" name="notify_url" value="{$notify}">	
	<input type="hidden" name="name_first" value="{$name_first}" />
	<input type="hidden" name="name_last" value="{$name_last}" />
    <input type="hidden" name="email_address" value="{$order_info['email']}">
    <input type="hidden" name="m_payment_id" value="{$order_id}" />
    <input type="hidden" name="amount" value="{$payfast_total}" />
	<input type="hidden" name="item_name" value="{$payfast_item_name}" />
    <input type="hidden" name="item_description" value="{$payfast_item_description}" />
	
    <input type="hidden" name="signature" value="{$securityHash}" />
   
	</form>
	<div align=center>{$msg}</div>
	</body>
	</html>
EOT;

	fn_flush();
}
exit;
?>