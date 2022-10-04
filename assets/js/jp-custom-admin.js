jQuery(document).ready(function (){
    jQuery('#wc_jp_product_calculation').change(function (){
        $val = jQuery(this).val();
        console.log($val);
        if($val=='enable'){
            jQuery('#product_custom_field').show();
        }
        else {
            jQuery('#product_custom_field').hide();
        }
    });
});