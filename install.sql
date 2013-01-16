REPLACE INTO cscart_payment_processors (`processor_id`, `processor`,`processor_script`,`processor_template`,`admin_template`,`callback`,`type`) VALUES ('1005', 'PayFast','payfast.php', 'payfast.tpl','payfast.tpl', 'N', 'P');

REPLACE INTO cscart_language_values (`lang_code`,`name`,`value`) VALUES ('EN','text_payfast_status_map','PayFast payment status to CS-Cart order status convertion map');

REPLACE INTO cscart_language_values (`lang_code`,`name`,`value`) VALUES ('EN','text_payfast_sandbox_live','Sandbox/Live');

REPLACE INTO cscart_language_values (`lang_code`,`name`,`value`) VALUES ('EN','sandbox','Sandbox');
REPLACE INTO cscart_language_values (`lang_code`,`name`,`value`) VALUES ('EN','text_payfast_paynow','Pay Now Using PayFast');
REPLACE INTO cscart_language_values (`lang_code`,`name`,`value`) VALUES ('EN','text_payfast_item_name','Your Order');
REPLACE INTO cscart_language_values (`lang_code`,`name`,`value`) VALUES ('EN','text_payfast_item_description','Shipping, Handling, Discounts and Taxes Included');
