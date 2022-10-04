<?php
global $post;
$product_id = $post->ID;
$product = wc_get_product($product_id);
$jewelry_default_option_values = get_option('jp_prices_options');
if (!is_array($jewelry_default_option_values)) {
    $jewelry_default_option_values = [];
}
$wc_product_type = $product->get_meta('wc_product_type');
$daily_price_with_type = $jewelry_default_option_values[$wc_product_type];
$product_gross_weight = $product->get_meta('product_gross_weight');
$product_total_price = $product->get_meta('jp_total_price');
$product_net_weight = $product->get_meta('product_net_weight');
$product_making_charge_percentage = $product->get_meta('product_making_charge_percentage');
$product_other_charge = $product->get_meta('product_other_charge');
$product_making_charge_per_gm = $product->get_meta('product_making_charge_per_gm');
$product_making_charge = $product->get_meta('product_making_charge');
$product_price_with_net_weight = $product->get_meta('product_price_with_net_weight');
$product_gst_tax = $product->get_meta('product_gst_tax');
$product_discount_percentage = $product->get_meta('product_discount_percentage');
$product_discount = $product->get_meta('product_discount');

$product_price = $product->get_regular_price();

?>
<section
        class="elementor-section elementor-top-section elementor-element elementor-element-0425e1c elementor-section-boxed elementor-section-height-default elementor-section-height-default"
        data-id="0425e1c" data-element_type="section">
    <div class="elementor-container elementor-column-gap-default">
        <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-66f5b9c"
             data-id="66f5b9c" data-element_type="column">
            <div class="elementor-widget-wrap elementor-element-populated">
                <div class="elementor-element elementor-element-8d84284 elementor-widget elementor-widget-accordion"
                     data-id="8d84284" data-element_type="widget" data-widget_type="accordion.default">
                    <div class="elementor-widget-container">
                        <div class="elementor-accordion" role="tablist">
                            <div class="elementor-accordion-item">
                                <div id="elementor-tab-title-1481" class="elementor-tab-title" data-tab="1"
                                     role="tab"
                                     aria-controls="elementor-tab-content-1481" aria-expanded="false"
                                     tabindex="-1"
                                     aria-selected="false">
													<span class="elementor-accordion-icon elementor-accordion-icon-left"
                                                          aria-hidden="true">
															<span class="elementor-accordion-icon-closed"><i
                                                                        class="fas fa-plus"></i></span>
								<span class="elementor-accordion-icon-opened"><i class="fas fa-minus"></i></span>
														</span>
                                    <a class="elementor-accordion-title"
                                       href="">PRICE: <?php echo wc_price($product_price) ?></a>
                                </div>
                                <div id="elementor-tab-content-1481"
                                     class="elementor-tab-content elementor-clearfix"
                                     data-tab="1" role="tabpanel" aria-labelledby="elementor-tab-title-1481"
                                     style="display: none;" hidden="hidden">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-8"><label class="product-title">Today’s <?php echo return_actual_name($wc_product_type) ?> Rate /Gm:</label></div>
                                        <div class="col-md-6 col-sm-6 col-4"><span id="metalRatePerGram"
                                                                                   class="price"><?php echo wc_price($daily_price_with_type) ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-8"><label class="product-tit̥le">Gold
                                                Price:</label></div>
                                        <div class="col-md-6 col-sm-6 col-4"><span id="metalRatePerGram2"
                                                                                   class="price"><?php echo wc_price($product_price_with_net_weight) ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-8"><label class="product-title">Making
                                                Charges – <?php echo $product_making_charge_percentage ?>
                                                %:</label></div>
                                        <div class="col-md-6 col-sm-6 col-4">
                                            <span id="makingPerGram2" class="price"><?php echo wc_price($product_making_charge) ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-8"><label class="product-title">Other
                                                Charges:</label></div>
                                        <div class="col-md-6 col-sm-6 col-4"><span id="stonePrice2"
                                                                                   class="price"><?php echo wc_price($product_other_charge) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="elementor-accordion-item">
                                <div id="elementor-tab-title-1482" class="elementor-tab-title" data-tab="2"
                                     role="tab" aria-controls="elementor-tab-content-1482" aria-expanded="false"
                                     tabindex="-1" aria-selected="false">
                                    <span class="elementor-accordion-icon elementor-accordion-icon-left"
                                          aria-hidden="true">
                                        <span class="elementor-accordion-icon-closed">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                    <span class="elementor-accordion-icon-opened">
                                        <i class="fas fa-minus"></i>
                                    </span>
                                    </span>
                                    <a class="elementor-accordion-title"
                                       href="">TAX: <?php echo wc_price($product_gst_tax) ?></a>
                                </div>
                                <div id="elementor-tab-content-1482"
                                     class="elementor-tab-content elementor-clearfix"
                                     data-tab="2" role="tabpanel" aria-labelledby="elementor-tab-title-1482"
                                     style="display: none;" hidden="hidden">
                                    <div class="col-md-6 col-sm-6 col-8"><label class="product-title">CGST –
                                            1.5%:</label></div>
                                    <div class="col-md-6 col-sm-6 col-4"><span id="discount12"
                                                                               class="price"><?php echo wc_price(($product_gst_tax / 2)) ?></span>
                                    </div>
                                    <div>
                                        <div class="col-md-6 col-sm-6 col-8">
                                            <label class="product-title">SGST <label class="product-title">–
                                                    1.5%</label>:</label>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-4"><span id="discount12"
                                                                                   class="price"><?php echo wc_price(($product_gst_tax / 2)) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="elementor-accordion-item">
                                <div id="elementor-tab-title-1483" class="elementor-tab-title" data-tab="3"
                                     role="tab" aria-controls="elementor-tab-content-1483" aria-expanded="false"
                                     tabindex="-1" aria-selected="false">
                                    <span class="elementor-accordion-icon elementor-accordion-icon-left"
                                          aria-hidden="true">
                                        <span class="elementor-accordion-icon-closed">
                                            <i class="fas fa-plus"></i>
                                        </span>
								<span class="elementor-accordion-icon-opened"><i class="fas fa-minus"></i></span>
                                    </span>
                                    <a class="elementor-accordion-title" href="">DISCOUNT ON
                                        MAKING: <?php echo wc_price($product_discount) ?></a>
                                </div>
                                <div id="elementor-tab-content-1483"
                                     class="elementor-tab-content elementor-clearfix"
                                     data-tab="3" role="tabpanel" aria-labelledby="elementor-tab-title-1483"
                                     style="display: none;" hidden="hidden">
                                    <div class="col-md-6 col-sm-6 col-8">
                                        <label class="product-title"><?php echo $product_discount_percentage ?>%
                                            DISCOUNT ON MAKING CHARGES:</label>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-4">
                                                <span id="discount12"
                                                      class="price"><?php echo wc_price($product_discount) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>