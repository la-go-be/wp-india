<div id="treepay_cc_form">
<?php 
	// $showExistingCards = $viewData["user_logged_in"] && isset($viewData["existingCards"]->data) && sizeof($viewData["existingCards"]->data) > 0;
	// if($showExistingCards){
     $showExistingCards = false;
     if (0) {
?>
<p class="form-row form-row-wide">
	Select card : <br/>
		<?php 
			foreach($viewData["existingCards"]->data as $card){
				echo "<input type='radio' name='card_id' value='{$card->id}' />Card ends with {$card->last_digits}<br/>";
			}
		?>
</p>
&nbsp;<input type='radio' id='new_card_info' name='card_id' value='' />New payment information
<?php } ?>
<fieldset id="new_card_form" class="<?php echo $showExistingCards ? 'treepay-hidden':''; ?>">
	<?php 
		require_once('treepay-cc-form.php');
		if($viewData["user_logged_in"]){
	?>
    <!--
	<p class="form-row form-row-wide">
		<input type='checkbox' name='treepay_save_customer_card' id='treepay_save_customer_card' />
		<label for="treepay_save_customer_card" class="inline">Save card for next time</label>
	</p>
	-->
	<?php
		}
	?>
	<input type="hidden" id="cert_url" name="cert_url" 			value="<?php echo $this->cert_url;?>"/>
	<input type="hidden" id="pay_type" name="pay_type" 			value="<?php echo $this->pay_type;?>"/>
	<input type="hidden" id="order_no" name="order_no" 			value="<?php echo $this->order_no;?>"/>
	<input type="hidden" id="trade_mony" name="trade_mony" 		value="<?php echo $this->trade_mony;?>"/>
	<input type="hidden" id="tp_langFlag" name="tp_langFlag" 	value="<?php echo $this->tp_langFlag;?>"/>
	<input type="hidden" id="site_cd" name="site_cd" 			value="<?php echo $this->site_cd;?>"/>

	<div class="clear"></div>
</fieldset>
</div>