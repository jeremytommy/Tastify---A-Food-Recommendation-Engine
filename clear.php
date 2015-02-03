<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">
<?php
//將session清空
unset($_SESSION['cart']);
echo 'Thank you for your review, now jumping back to index.....';
echo '<meta http-equiv=REFRESH CONTENT=1;url=member.php>';
?>
