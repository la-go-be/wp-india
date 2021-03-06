function m_Completepayment(retObj)
{
    debugger;
    if(retObj.res_cd=="0000")
    {
        var $form = $( 'form.checkout, form#order_review' );
        $form.append( '<input type="hidden" class="treepay_ott" name="treepay_ott" value="' + retObj.ott + '"/>' );
        $( '#treepay_card_name' ).val("");
        $( '#treepay_card_number' ).val("");
        $( '#treepay_card_expiration_month' ).val("");
        $( '#treepay_card_expiration_year' ).val("");
        $( '#treepay_card_security_code' ).val("");
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

    function treepayFormHandler(){
        function showError(message){
            if(!message){
                return;
            }
            /*
            $(".woocommerce-error, input.treepay_token").remove();
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


        if ( $( '#payment_method_treepay' ).is( ':checked' ) ) {
            if( !validSelection() ){
                showError("Please select a card or enter new payment information");
                return false;
            }

            if( getSelectedCardId() !== "" )
            {
                //submit the form right away if the card_id is not blank
                return true;
            }

            if ( 0 === $( 'input.treepay_ott' ).size() ) {
                $form.block({
                    message: null,
                    overlayCSS: {
                        background: '#fff url(' + wc_checkout_params.ajax_loader_url + ') no-repeat center',
                        backgroundSize: '16px 16px',
                        opacity: 0.6
                    }
                });

                var treepay_card_name   = $( '#treepay_card_name' ).val(),
                    treepay_card_number   = $( '#treepay_card_number' ).val(),
                    treepay_card_expiration_month   = $( '#treepay_card_expiration_month' ).val(),
                    treepay_card_expiration_year = $( '#treepay_card_expiration_year' ).val(),
                    treepay_card_security_code    = $( '#treepay_card_security_code' ).val();

                // Serialize the card into a valid card object.
                var arrCardName = treepay_card_name.split(' ', 2);
                var card = {
                    "cert_url": $("#cert_url").val(),
                    "pay_type": $("#pay_type").val(),
                    "order_no": $("#order_no").val(),
                    "trade_mony": $("#trade_mony").val(),
                    "tp_langFlag": $("#tp_langFlag").val(),
                    "ret_field": "m_Completepayment",
                    "site_cd": $("#site_cd").val(),
                    "card_number": treepay_card_number,
                    "expiration_yy": treepay_card_expiration_year.substr(2,2),
                    "expiration_mm": treepay_card_expiration_month,
                    "cvn": treepay_card_security_code,
                    "first_card_holder_name": arrCardName[0],
                    "last_card_holder_name": arrCardName[1]
                };

                debugger;
                TP_Pay_Execute( card );

                return false;
                /*
                var errors = OmiseUtil.validate_card(card);
                if(errors.length > 0){
                    showError(errors);
                    $form.unblock();
                    return false;
                }else{
                    hideError();
                    if(Omise){
                        Omise.setPublicKey(treepay_params.key);
                        Omise.createToken("card", card, function (statusCode, response) {
                            if (statusCode == 200) {
                                $form.append( '<input type="hidden" class="treepay_token" name="treepay_token" value="' + response.id + '"/>' );
                                $( '#treepay_card_name' ).val("");
                                $( '#treepay_card_number' ).val("");
                                $( '#treepay_card_expiration_month' ).val("");
                                $( '#treepay_card_expiration_year' ).val("");
                                $( '#treepay_card_security_code' ).val("");
                                $form.submit();
                            } else {
                                if(response.message){
                                    showError( "Unable to process payment with Omise. " + response.message );
                                }else if(response.responseJSON && response.responseJSON.message){
                                    showError( "Unable to process payment with Omise. " + response.responseJSON.message );
                                }else if(response.status==0){
                                    showError( "Unable to process payment with Omise. No response from Omise Api." );
                                }else {
                                    showError( "Unable to process payment with Omise [ status=" + response.status + " ]" );
                                }
                                $form.unblock();
                            };
                        });
                    }else{
                        showError( 'Something wrong with connection to Omise.js. Please check your network connection' );
                        $form.unblock();
                    }

                    return false;
                }
                */
            }

        }
    }

    $(function(){
        $( 'body' ).on( 'checkout_error', function () {
            $( '.treepay_token' ).remove();
        });

        /*
        $( 'form.checkout' ).unbind('checkout_place_order_treepay');
        $( 'form.checkout' ).on( 'checkout_place_order_treepay', function () {
            return treepayFormHandler();
        });
        */

        /* Pay Page Form */
        $( 'form#order_review' ).on( 'submit', function () {
            return treepayFormHandler();
        });

        /* Both Forms */
        $( 'form.checkout, form#order_review' ).on( 'change', '#treepay_cc_form input', function() {
            $( '.treepay_token' ).remove();
        });
    })
})(jQuery)
