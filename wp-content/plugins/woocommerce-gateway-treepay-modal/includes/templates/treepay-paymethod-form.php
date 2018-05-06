<div id="treepay_paymethods_form">
    <select name="treepay_paymethod" style="width:100%;">
        <?php
        if ( $this->get_option('treepay_pc_paymethods_card') === "yes" )
            echo '<option value="PACA">Credit Card</option>\n';
        if ( $this->get_option('treepay_pc_paymethods_ibnk') === "yes" )
            echo '<option value="PABK">Internet Banking</option>\n';
        if ( $this->get_option('treepay_pc_paymethods_inst') === "yes" )
            echo '<option value="PAIN">Installment</option>\n';
        ?>
    </select>
</div>
