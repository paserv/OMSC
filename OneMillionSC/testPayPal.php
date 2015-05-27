<?php session_start(); ?>
<!doctype html>
<head>
<title>Test PayPal</title>
</head>
<body>
<?php var_dump($_REQUEST)?>
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="4YN2L74A47Y78">
<input type="image" src="https://www.sandbox.paypal.com/en_US/IT/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/it_IT/i/scr/pixel.gif" width="1" height="1">
</form>

<script async="async" src="https://www.paypalobjects.com/js/external/paypal-button.min.js?merchant=YG7SPZNQUDZ9W" 
    data-button="buynow" 
    data-name="OMSC" 
    data-amount="1" 
    data-currency="EUR" 
    data-shipping="0" 
    data-tax="0" 
    data-callback="http://localhost.com/OMSC/OneMillionSC/testPayPal.php"
    data-env="sandbox"
></script>


</body>
</html>
