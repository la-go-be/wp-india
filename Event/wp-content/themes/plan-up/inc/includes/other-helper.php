<?php
/**
Singular - Plural
 */
function fw_singular_plural( $reference, $zero, $one, $more ){
    if( $reference == 0 || $reference == '' || empty($reference) )
        return $zero;
    if( $reference == '1' )
        return $one;
    return $more;
}

function mauris_categories_postcount_filter ($variable) {
   $variable = str_replace('</a> (', '<span class="post_count"> ', $variable);
   $variable = str_replace(')', ' </span> </a>', $variable);
   return $variable;
}
add_filter('wp_list_categories','mauris_categories_postcount_filter');

add_filter('wp_generate_tag_cloud', 'mauris_tag_cloud',10,3);

function mauris_tag_cloud($tag_string){
   return preg_replace("/style='font-size:.+pt;'/", '', $tag_string);
}
// Currency symbol map
//
function mauris_currency_symbol($currency_name) {
    switch ($currency_name) {
        case 'ALL':
            return 'Lek';
            break;

        case 'AFN':
            return '؋';
            break;

        case 'ARS':
            return '$';
            break;

        case 'AWG':
            return 'ƒ';
            break;

        case 'AUD':
            return '$';
            break;

        case 'AZN':
            return 'ман';
            break;

        case 'BSD':
            return '$';
            break;

        case 'BBD':
            return '$';
            break;

        case 'BYR':
            return 'p.';
            break;

        case 'BZD':
            return 'BZ$';
            break;

        case 'BMD':
            return '$';
            break;

        case 'BOB':
            return '$b';
            break;

        case 'BAM':
            return 'KM';
            break;

        case 'BWP':
            return 'P';
            break;

        case 'BGN':
            return 'лв';
            break;

        case 'BRL':
            return 'R$';
            break;

        case 'BND':
            return '$';
            break;

        case 'KHR':
            return '៛';
            break;

        case 'CAD':
            return '$';
            break;

        case 'KYD':
            return '$';
            break;

        case 'CLP':
            return '$';
            break;

        case 'CNY':
            return '¥';
            break;

        case 'COP':
            return '$';
            break;

        case 'CRC':
            return '₡';
            break;

        case 'HRK':
            return 'kn';
            break;

        case 'CUP':
            return '₱';
            break;

        case 'CZK':
            return 'Kč';
            break;

        case 'DKK':
            return 'kr';
            break;

        case 'DOP':
            return 'RD$';
            break;

        case 'EGP':
            return '£';
            break;

        case 'SVC':
            return '$';
            break;

        case 'EEK':
            return 'kr';
            break;

        case 'EUR':
            return '€';
            break;

        case 'FKP':
            return '£';
            break;

        case 'FJD':
            return '$';
            break;

        case 'GHC':
            return '¢';
            break;

        case 'GIP':
            return '£';
            break;

        case 'GTQ':
            return 'Q';
            break;

        case 'GGP':
            return '£';
            break;

        case 'GYD':
            return '$';
            break;

        case 'HNL':
            return 'L';
            break;

        case 'HKD':
            return '$';
            break;

        case 'HUF':
            return 'Ft';
            break;

        case 'ISK':
            return 'kr';
            break;

        case 'INR':
            return '₹';
            break;

        case 'IDR':
            return 'Rp';
            break;

        case 'IRR':
            return '﷼';
            break;

        case 'MP<':
            return '£';
            break;

        case 'ILS':
            return '₪';
            break;

        case 'JMD':
            return 'J$';
            break;

        case 'JPY':
            return '¥';
            break;

        case 'JEP':
            return '£';
            break;

        case 'KZT':
            return 'лв';
            break;

        case 'KPW':
            return '₩';
            break;

        case 'KRW':
            return '₩';
            break;

        case 'KGS':
            return 'лв';
            break;

        case 'LAK':
            return '₭';
            break;

        case 'LVL':
            return 'Ls';
            break;

        case 'LBP':
            return '£';
            break;

        case 'LRD':
            return '$';
            break;

        case 'LTL':
            return 'Lt';
            break;

        case 'MKD':
            return 'ден';
            break;

        case 'MYR':
            return 'RM';
            break;

        case 'MUR':
            return '₨';
            break;

        case 'MXN':
            return '$';
            break;

        case 'MNT':
            return '₮';
            break;

        case 'MZN':
            return 'MT';
            break;

        case 'NAD':
            return '$';
            break;

        case 'NPR':
            return '₨';
            break;

        case 'ANG':
            return 'ƒ';
            break;

        case 'NZD':
            return '$';
            break;

        case 'NIO':
            return 'C$';
            break;

        case 'NGN':
            return '₦';
            break;

        case 'NOK':
            return 'kr';
            break;

        case 'OMR':
            return '﷼';
            break;

        case 'PKR':
            return '₨';
            break;

        case 'PAB':
            return 'B/.';
            break;

        case 'PYG':
            return 'Gs';
            break;

        case 'PEN':
            return 'S/.';
            break;

        case 'PHP':
            return '₱';
            break;

        case 'PLN':
            return 'zł';
            break;

        case 'QAR':
            return '﷼';
            break;

        case 'RON':
            return 'lei';
            break;

        case 'RUB':
            return 'руб';
            break;

        case 'SHP':
            return '£';
            break;

        case 'SAR':
            return '﷼';
            break;

        case 'RSD':
            return 'Дин.';
            break;

        case 'SCR':
            return '₨';
            break;

        case 'SGD':
            return '$';
            break;

        case 'SBD':
            return '$';
            break;

        case 'SOS':
            return 'S';
            break;

        case 'ZAR':
            return 'S';
            break;

        case 'LKR':
            return '₨';
            break;

        case 'SEK':
            return 'kr';
            break;

        case 'CHF':
            return 'CHF';
            break;

        case 'SRD':
            return '$';
            break;

        case 'SYP':
            return '£';
            break;

        case 'TWD':
            return 'NT$';
            break;

        case 'THB':
            return '฿';
            break;

        case 'TTD':
            return 'TT$';
            break;

        case 'TRL':
            return '₤';
            break;

        case 'TVD':
            return '$';
            break;

        case 'UAH':
            return '₴';
            break;

        case 'GBP':
            return '£';
            break;

        case 'USD':
            return '$';
            break;

        case 'UYU':
            return '$U';
            break;

        case 'UZS':
            return 'лв';
            break;

        case 'VEF':
            return 'Bs';
            break;

        case 'VND':
            return '₫';
            break;

        case 'YER':
            return '﷼';
            break;

        case 'ZWD':
            return 'Z$';
            break;

        default:
            return $currency_name;
            break;
    }
}
?>