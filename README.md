mod-cscart
==========
PayFast module for CSCart

PayFast CSCart Module v1.1.1 for CSCart v3.0.6
-------------------------------------------------------
Copyright (c) 2011 - 2016 PayFast (Pty) Ltd

LICENSE:
 
This payment module is free software; you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published
by the Free Software Foundation; either version 3 of the License, or (at
your option) any later version.

This payment module is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public
License for more details.

Please see http://www.opensource.org/licenses/ for a copy of the GNU Lesser
General Public License.

INTEGRATION:
1. Unzip the module to a temporary location on your computer
2. Copy the ‘payments’, ‘skins’ and ‘vars’ folders in the archive to your base ‘CSCart’ folder
- This should not overwrite any existing files or folders and merely supplement them with the PayFast files, this is however, dependent on the FTP program you use
3. Login to your Database Management System of choice and run the install.sql file
4. Login to the admin section of your CSCart installation
5. Navigate to the Administration ? Payment Methods page
6. Click the ‘Add Payment’ button
7. Input a Name?’PayFast’, select Template?’payfast.tpl’, select Processor?’PayFast’, select Icon?Url and input https://www.payfast.co.za/images/logo.png, complete the form accordingly and click ‘Create’.
8. Once the payment method is created, click on it’s ‘Edit’ button.
9. Click the ‘Configure’ button, the PayFast options will then be shown, select the payment status for ‘completed’ and ‘failed’ payments, select the sandbox mode and click ‘Save’.
10. The module is now ready to be tested with the Sandbox. To test with the sandbox, use the following login credentials when redirected to the PayFast site:
- Username: sbtu01@payfast.co.za
- Password: clientpass
Once you are ready to go live change the ‘sandbox/live mode to ‘live’ and insert your PayFast merchant ID and Key and click save

******************************************************************************
*                                                                            *
*    Please see the URL below for all information concerning this module:    *
*                                                                            *
*                 https://www.payfast.co.za/shopping-carts/cs-cart/          *
*                                                                            *
******************************************************************************