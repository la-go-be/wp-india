<?php
	 woocommerce_form_field('billing_email_ng', array(
	 'type' => 'email',
	 'required' => true,
	 'id' => 'billing_email_ng',
	 'class' => array('form-group'),
	 'label' => __(''),
	 'placeholder' => __('sfsdf'),
	 ), $checkout->get_value('billing_email_ng'));
?>
<?php
	 woocommerce_form_field('billing_email_dd', array(
	 'type' => 'email',
	 'required' => true,
	 'id' => 'billing_email_dd',
	 'class' => array('form-group'),
	 'label' => __(''),
	 'placeholder' => __('zfsdfsdf'),
	 ), $checkout->get_value('billing_email_dd'));
?>