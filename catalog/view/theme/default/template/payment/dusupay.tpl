<?php if ($testmode) { ?>
<div class="warning"><?php echo $text_testmode; ?></div>
<?php } ?>
<form action="<?php echo $action; ?>" method="post">
  <input type="hidden" name="dusupay_merchantId" value="<?php echo $merchantId; ?>" required>
  <input type="hidden" name="dusupay_itemId" value="<?php echo $item_id; ?>" required>
  <input type="hidden" name="dusupay_itemName" value="<?php echo $item_name; ?>" required>
  <input type="hidden" name="dusupay_currency" value="<?php echo $currency_code; ?>" required>
  <input type="hidden" name="dusupay_redirectURL" value="<?php echo $return; ?>" optional>
  <input type="hidden" name="dusupay_successURL" value="<?php echo $notify_url; ?>" optional>
  <input type="hidden" name="dusupay_transactionReference" value="<?php echo $custom; ?>" required>
  <input type="hidden" name="dusupay_amount" value="<?php echo $amt; ?>" optional>
  <input type="hidden" name="dusupay_logo" value="https://paytrade.co.ke/final3.jpg" optional>
  <div class="buttons">
    <div class="right">
      <input type="image" name="submit" src="https://www.dusupay.com/img/paybuttons/dusupaybtn6.png" />
    </div>
  </div>
</form>
