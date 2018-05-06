function m_Completepayment(retObj)
{
    debugger;
    if(retObj.res_cd=="0000")
    {
        var $form = $( 'form.checkout, form#order_review' );
        $form.append( '<input type="hidden" class="treepay_ott" name="treepay_ott" value="' + retObj.ott + '"/>' );

        var isTreepayottSet = document.getElementById("is_treepayott_set");
        console.log('m_Completepayment [ ottSet ]');
        if ( isTreepayottSet == null ) {
            $form.append('<input type="hidden" id="is_treepayott_set" value="Y"/>');
            console.log('m_Completepayment [ not Exist:' + $('#is_treepayott_set').val() + "]");
        } else {
            $('#is_treepayott_set').val('Y');
            console.log('m_Completepayment [ alreadyExist:' + $('#is_treepayott_set').val() + "]");
        }

        $( '#treepayott_card_name' ).val("");
        $( '#treepayott_card_number' ).val("");
        $( '#treepayott_card_expiration_month' ).val("");
        $( '#treepayott_card_expiration_year' ).val("");
        $( '#treepayott_card_security_code' ).val("");
        $form.submit();
        /*
        document.form_pay.treepay_ott.value=retObj.ott;
        document.form_pay.action="./pp_cli_hub.jsp";
        document.form_pay.submit();
        */
    }
    else
    {
        alert("[" + retObj.res_cd + "] " + retObj.res_msg);
    }
}

(function ( $, undefined ) {
    var $form = $( 'form.checkout, form#order_review' );

    function treepayOttFormHandler(){
        function showError(message){
            if(!message){
                return;
            }
            /*
            $(".woocommerce-error, input.treepayott_token").remove();
            */

            $ulError = $("<ul>").addClass("woocommerce-error");

            if($.isArray(message)){
                $.each(message, function(i,v){
                    $ulError.append($("<li>" + v + "</li>"));
                })
            }else{
                $ulError.html("<li>" + message + "</li>");
            }

            $form.prepend( $ulError );
            $("html, body").animate({
                scrollTop:0
            },"slow");
        }

        function hideError(){
            $(".woocommerce-error").remove();
        }

        function validSelection(){
            $card_list = $("input[name='card_id']");
            $selected_card_id = $("input[name='card_id']:checked");
            // there is some existing cards but nothing selected then warning
            if($card_list.size() > 0 && $selected_card_id.size() === 0){
                return false;
            }

            return true;
        }

        function getSelectedCardId(){
            $selected_card_id = $("input[name='card_id']:checked");
            if($selected_card_id.size() > 0){
                return $selected_card_id.val();
            }

            return "";
        }


        if ( $( '#payment_method_treepayott' ).is( ':checked' ) ) {
            if( !validSelection() ){
                showError("Please select a card or enter new payment information");
                return false;
            }

            if( getSelectedCardId() !== "" )
            {
                //submit the form right away if the card_id is not blank
                return true;
            }

            if ( 'Y' != $('#is_treepayott_set').val() ) {
                $form.block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + wc_checkout_params.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '16px 16px',
                        opacity: 0.6
                    }
                });

                var treepayott_card_name   = $( '#treepayott_card_name' ).val(),
                    treepayott_card_number   = $( '#treepayott_card_number' ).val(),
                    treepayott_card_expiration_month   = $( '#treepayott_card_expiration_month' ).val(),
                    treepayott_card_expiration_year = $( '#treepayott_card_expiration_year' ).val(),
                    treepayott_card_security_code    = $( '#treepayott_card_security_code' ).val();

                // Serialize the card into a valid card object.
                var arrCardName = treepayott_card_name.split(' ', 2);
                if ( arrCardName.length < 2 ) {
                    arrCardName[1] = arrCardName[0];
                }
                var card = {
                    "cert_url": $("#cert_url").val(),
                    "pay_type": $("#pay_type").val(),
                    "order_no": $("#order_no").val(),
                    "trade_mony": $("#trade_mony").val(),
                    "tp_langFlag": $("#tp_langFlag").val(),
                    "ret_field": "m_Completepayment",
                    "site_cd": $("#site_cd").val(),
                    "card_number": treepayott_card_number,
                    "expiration_yy": treepayott_card_expiration_year.substr(2,2),
                    "expiration_mm": treepayott_card_expiration_month,
                    "cvn": treepayott_card_security_code,
                    "first_card_holder_name": arrCardName[0],
                    "last_card_holder_name": arrCardName[1]
                };

                debugger;
                TP_Pay_Execute( card );

                return false;
            } else {
                $('#is_treepayott_set').val('N');
            }

        }
    }

    $(function(){
        $( 'body' ).on( 'checkout_error', function () {
            $( '.treepayott_token' ).remove();
        });

        $( 'form.checkout' ).unbind('checkout_place_order_treepayott');
        $( 'form.checkout' ).on( 'checkout_place_order_treepayott', function () {
            return treepayOttFormHandler();
        });

        /* Pay Page Form */
        /*
        $( 'form#order_review' ).on( 'submit', function () {
            return treepayOttFormHandler();
        });
        */

        /* Both Forms */
        $( 'form.checkout, form#order_review' ).on( 'change', '#treepayott_cc_form input', function() {
            $( '.treepayott_token' ).remove();
        });
    })
})(jQuery)
