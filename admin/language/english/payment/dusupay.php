<?php
// Heading
$_['heading_title']					 = 'Dusupay';

// Text
$_['text_payment']					 = 'Payment';
$_['text_success']					 = 'Success: You have modified Dusupay account details!';
//$_['text_edit']             		 = 'Dusupay';
$_['text_dusupay']				 = '<a onclick="window.open(\'https://dusupay.com/\');"><img src="view/image/payment/dusupay.png" alt="Dusupay" title="Dusupay" style="border: 1px solid #EEEEEE;" /></a>';

// Entry
$_['entry_merchantId']				 = 'Merchant ID:';
$_['entry_currency']				 = 'Currency:';
$_['entry_test']					 = 'Sandbox Mode:';

$_['entry_debug']					 = 'Debug Mode:<br/><span class="help">Logs additional information to the system log.</span>';
$_['entry_total']                    = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';

$_['entry_pending_status'] 		 	 = 'Pending Status:<br/><span class="help">Transaction is pending.</span>';
$_['entry_complete_status'] 		 = 'Complete Reversal Status:<br/><span class="help">Transaction completed successfully.</span>';
$_['entry_notverified_status']       = 'Not Verified Status:<br/><span class="help">Transaction completed but waiting user validation via phone and email. Status will change to either REFUNDED or COMPLETE</span>';
$_['entry_refunded_status']			 = 'Refunded Status:<br/><span class="help">Transaction was detected as a fraud transaction. Cash was refunded.</span>';
$_['entry_failed_status']			 = 'Failed Status:<br/><span class="help">Transaction failed.</span>';
$_['entry_cancelled_status']		 = 'Cancelled Status:<br/><span class="help">Transaction was cancelled</span>';
$_['entry_invalid_status']			 = 'Invalid Status:<br/><span class="help">Transaction may not have been found</span>';

$_['entry_geo_zone']				 = 'Geo Zone:';
$_['entry_status']					 = 'Status:';
$_['entry_sort_order']				 = 'Sort Order:';

// Error
$_['error_permission']				 = 'Warning: You do not have permission to modify payment Dusupay!';
$_['error_merchantId']		 = 'Merchant ID required!';
?>
