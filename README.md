mod-cscart
==========

====== CSCart ======
====== Installation and Testing ======
To install the PayFast payment module, follow the instructions below: 

  - [[https://www.payfast.co.za/c/std/shopping-carts|Download the payment module]] from our site
  - Unzip the module to a temporary location on your computer
  - Copy the “payments”, “skins” and “vars” folders in the archive to your base “CSCart” folder
    * This should NOT overwrite any existing files or folders and merely supplement them with the PayFast files
    * This is however, dependent on the FTP program you use
    * If you are concerned about this, rather copy the individual files across as per instructions below
  - Login to your Database Management System of choice and run the install.sql file 
  - Login to the admin section of your CSCart installation
  - Navigate to the Administration => Payment Methods page
  - Click the “Add Payment” button
  - Input a Name->“PayFast”, select Template->“payfast.tpl”, select Processor->“PayFast”, select Icon->Url and input https://www.payfast.co.za/images/logo.png, complete the form accordingly and click “Create”. 
  - Once the payment method is created, click on it's “Edit” button.
  - Click the “Configure” button, the PayFast options will then be shown, select the payment status for “completed” and “failed” payments, select the sandbox mode and click “Save”.  
  - The module is now ready to be tested with the Sandbox. To test with the sandbox, use the following login credentials when redirected to the PayFast site:
    * Username: sbtu01@payfast.co.za
    * Password: clientpass

===== How do I copy the individual files across? =====

If you are concerned that copying the entire folder from the downloaded module may overwrite files in your installation, rather copy the files from the extracted module individually into your installation.

Be sure to copy the files from the downloaded module to their **corresponding** locations within your installation:

The list of files needed in your online installation are as follows:

  payments/payfast.php
  payments/payfast/payfast_common.inc
  payments/payfast/payfast.png
  payments/payfast/payfastlogo.gif
  skins/basic/admin/views/payments/components/cc_processors/payfast.tpl
  skins/basic/views/orders/components/payments/payfast.tpl
  vars/skins_repository/basic/admin/views/payments/components/cc_processors/payfast.tpl
 
 
===== How can I test that it is working correctly? =====

If you followed the installation instructions above, the module is in “test” mode and you can test it by purchasing from your site as a buyer normally would. You will be redirected to PayFast for payment and can login with the user account detailed above and make payment using the balance in their wallet. 

You will not be able to directly “test” a credit card, Instant EFT or Ukash payment in the sandbox, but you don't really need to. The inputs to and outputs from PayFast are exactly the same, no matter which payment method is used, so using the wallet of the test user will give you exactly the same results as if you had used another payment method.

===== I'm ready to go live! What do I do? =====

In order to make the module "LIVE", follow the instructions below:

  - Login to the admin section of your CSCart system
  - Navigate to the Administration => Payment Methods page
  - Under PayFast, click on the "Edit" link
  - In the Configure section, use the following settings:
    * Set Sandbox/Live = "Live"
    * Merchant ID = <Merchant ID as given on your [[https://www.payfast.co.za/acc/integration|Integration Page]]>
    * Merchant Key = <Merchant Key as given on your [[https://www.payfast.co.za/acc/integration|Integration Page]]>
  - Click Save

====== Upgrading ======
=== Standard Upgrade Procedure ===
  - [[https://www.payfast.co.za/c/std/shopping-carts|Download the payment module]] from our site
  - Unzip the module to a temporary location on your computer
  - Copy the "modules" folder in the archive to your base "CSCart" folder

====== Frequently Asked Questions (FAQs) ======
===== What is the payment flow? =====

PayFast works on browser redirection and will redirect the user to PayFast for payment after they click the "Confirm Order" button on the Checkout page. 

At this stage, the order has NOT been created in CSCart, but the shopping cart details will be used. 

If the payment is CANCELLED during processing on PayFast:
  * The user will be returned to the "Shopping Cart" page to either correct their shopping cart or to choose another payment gateway.

If the payment is SUCCESSFUL through PayFast:
  * The user will be returned to the "Order Confirmation" page
  * The order will be created and will have a status of "Confirmed"

====== Useful links ======

  * [[http://forum.cs-cart.com/]]
    * Support forums for CSCart
  * [[http://www.cs-cart.com]]
    * The CSCart website