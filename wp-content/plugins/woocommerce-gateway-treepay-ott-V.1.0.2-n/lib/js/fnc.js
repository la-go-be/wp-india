/**
 * Created by mabbacc on 2016. 8. 11..
 */


function  jsf__pay_v3d( v_frm )
{
    TP_Pay_Execute( v_frm );
}

// 리턴유알엘 설정시 실행 안됨..
function m_Completepayment( frm_mpi, closeEvent )
{
    var frm = document.tp_form;

    if( frm_mpi.res_cd.value == "0000" )
    {
        GetField(frm, frm_mpi);

        alert($( frm ).serialize());
        //frm.submit();

        closeEvent();
    }
    else
    {
        closeEvent();

        setTimeout( "alert( \"[" + frm_mpi.res_cd.value + "]" + frm_mpi.res_msg.value  + "\");", 1000 );
    }
}

$(document).ready(function() {
    jsf__pay_v3d(document.treepay_payment_form);
})

