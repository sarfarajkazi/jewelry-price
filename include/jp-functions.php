<?php

if (!defined('ABSPATH')) {
	die('-1');
}
function dd($data = false, $flag = false, $display = false)
{
	if (empty($display)) {
		echo "<pre class='direct_display'>";
		if ($flag == 1) {
			print_r($data);
			die;
		} else {
			print_r($data);
		}
		echo "</pre>";
	} else {
		echo "<div style='display:none' class='direct_display'><pre>";
		print_r($data);
		echo "</pre></div>";
	}
}

add_action('admin_menu', 'theme_options_panel');
add_action('admin_notices', 'general_admin_notice_dd');
add_action('admin_init', 'jp_custom_setting');

function general_admin_notice_dd()
{
	if (isset($_REQUEST['jp-msg'])) {
		if ($_REQUEST['jp-msg'] == 'success') {
			$message = 'Price updated';
			$classes = 'notice-success is-dismissible';
		}
		printf('<div class="notice %2$s"><p>%1$s</p></div>', $message, $classes);
	}
}

function section_callback()
{
	echo '<p>Set daily prices</p>';
	
}

function jp_custom_setting()
{
	
	$jewelry_option_name = 'jp_prices_options';
	$jewelry_default_option_values = get_option($jewelry_option_name);
	register_setting('jp-settings-group-section', $jewelry_option_name);
	
	add_settings_section('jp_settings_options', __('Set daily prices', 'jewelry-prices'), 'section_callback', 'set-jewelry-prices');
	
	add_settings_field('jp_18_gold_price', __('18 carat Gold Price', 'jewelry-prices'), 'jp_input_callback', 'set-jewelry-prices', 'jp_settings_options', [
		'label_for' => 'jp_18_gold_price',
		'option_name' => $jewelry_option_name,
		'input_name' => 'jp_18_gold_price',
		'input_value' => @$jewelry_default_option_values['jp_18_gold_price'],
		'placeholder' => 'Enter 18 carat gold price',
		'description' => '₹',
	]);
	
	add_settings_field('jp_22_gold_price', __('24 carat Gold Price', 'jewelry-prices'), 'jp_input_callback', 'set-jewelry-prices', 'jp_settings_options', [
		'label_for' => 'jp_22_gold_price',
		'option_name' => $jewelry_option_name,
		'input_name' => 'jp_22_gold_price',
		'input_value' => @$jewelry_default_option_values['jp_22_gold_price'],
		'placeholder' => 'Enter 22 carat gold price',
		'description' => '₹',
	]);
	
	add_settings_field('jp_silver_price', __('Silver Price', 'jewelry-prices'), 'jp_input_callback', 'set-jewelry-prices', 'jp_settings_options', [
		'label_for' => 'jp_silver_price',
		'option_name' => $jewelry_option_name,
		'input_name' => 'jp_silver_price',
		'input_value' => @$jewelry_default_option_values['jp_silver_price'],
		'placeholder' => 'Enter silver price',
		'description' => '₹',
	]);
	
	
}

function jp_input_callback($args)
{
	printf('<input name="%1$s[%2$s]" value="%3$s" placeholder="%4$s" class="input-text" id="%5$s">&nbsp;%6$s', $args['option_name'], $args['input_name'], $args['input_value'], $args['placeholder'],
		$args['label_for'], $args['description'],);
}

function theme_options_panel()
{
	add_submenu_page('edit.php?post_type=product', __('Price Options', 'jewelry-prices'), __('Set Jewelry Prices', 'jewelry-prices'), 'manage_options', 'set-jewelry-prices',
		'jp_theme_price_page', 999);
}

function jp_theme_price_page()
{
	?>
    <div class="wrap property-imports">
        <div id="poststuff wrap">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content"><?php settings_errors(); ?>
                    <form method="post" action="options.php" id="jp-custom-setting">
						<?php settings_fields('jp-settings-group-section'); ?>
						<?php do_settings_sections('set-jewelry-prices'); ?>
						<?php submit_button(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<?php
}

add_action('woocommerce_product_options_pricing', 'woocommerce_product_custom_fields', 1);

function woocommerce_product_custom_fields()
{
	global $woocommerce, $post;
	$on_off_options_val = get_post_meta($post->ID, 'wc_jp_product_calculation', true);
	$on_off_options[''] = __('Select option', 'jewelry-prices');
	$on_off_options['enable'] = __('Yes', 'jewelry-prices');
	$on_off_options['disable'] = __('No', 'jewelry-prices');
	woocommerce_wp_select([
		'id' => 'wc_jp_product_calculation',
		'label' => __('Enable calculation?', 'woocommerce'),
		'options' => $on_off_options,
		'value' => $on_off_options_val,
	]);
	
	$jewelry_default_option_values = get_option('jp_prices_options');
	if (!is_array($jewelry_default_option_values)) {
		$jewelry_default_option_values = [];
	}
	?>
    <div style="display: <?php echo ($on_off_options_val == 'enable') ? 'block' : 'none' ?> "
         class="product_custom_field" id="product_custom_field">
        <div class="jp-prices-wrap">
            <p class="jp-display-inline">
				<?php _e("18 carat gold price") ?>&nbsp;<small>per/gm</small> :
                <strong><u><?php echo $jewelry_default_option_values['jp_18_gold_price'] ?></u></strong>
            </p>
            <p class="jp-display-inline">
				<?php _e("22 carat gold price") ?>&nbsp;<small>per/gm</small> :
                <strong><u><?php echo $jewelry_default_option_values['jp_22_gold_price'] ?></u></strong>
            </p>
            <p class="jp-display-inline">
				<?php _e("Silver") ?>&nbsp;<small>per/gm</small> :
                <strong><u><?php echo $jewelry_default_option_values['jp_silver_price'] ?></u></strong>
            </p>
        </div>
		<?php
		$options[''] = __('Select Type', 'jewelry-prices');
		$options['jp_18_gold_price'] = __('18 carat gold', 'jewelry-prices');
		$options['jp_22_gold_price'] = __('22 carat gold', 'jewelry-prices');
		$options['jp_silver_price'] = __('Silver', 'jewelry-prices');
		$value = get_post_meta($post->ID, 'wc_product_type', true);
		if (empty($value)) {
			$value = '';
		}
		
		woocommerce_wp_select([
			'id' => 'wc_product_type',
			'label' => __('Select Product Type', 'woocommerce'),
			'options' => $options,
			'value' => $value,
		]);
		
		
		woocommerce_wp_text_input([
			'id' => 'product_gross_weight',
			'placeholder' => __('Enter Product Gross Weight', 'jewelry-prices'),
			'label' => __('Enter Product Gross Weight', 'jewelry-prices'),
			'type' => 'text',
			'data_type' => 'decimal',
			'custom_attributes' => [
				'step' => 'any',
				'min' => '0',
			],
		]);
		
		woocommerce_wp_text_input([
			'id' => 'product_net_weight',
			'placeholder' => __('Enter Product Net Weight', 'jewelry-prices'),
			'label' => __('Enter Product Net Weight', 'jewelry-prices'),
			'type' => 'text',
			'data_type' => 'decimal',
			'custom_attributes' => [
				'step' => 'any',
				'min' => '0',
			],
		]);
		
		woocommerce_wp_text_input([
			'id' => 'product_making_charge_percentage',
			'placeholder' => __('Enter Product Making Charge in percentage', 'jewelry-prices'),
			'label' => __('Product Making Charge in percentage', 'jewelry-prices'),
			'type' => 'text',
			'data_type' => '',
			'description' => '%',
			'custom_attributes' => [
				'step' => 'any',
				'min' => '0',
			],
		]);
		
		
		woocommerce_wp_text_input([
			'id' => 'product_other_charge',
			'placeholder' => __('Enter Other charges', 'jewelry-prices'),
			'label' => __('Other charges', 'jewelry-prices'),
			'type' => 'text',
			'data_type' => 'price',
			'custom_attributes' => [
				'step' => 'any',
				'min' => '0',
			],
		]);
		
		woocommerce_wp_text_input([
			'id' => 'product_discount_percentage',
			'placeholder' => __('Enter Product Discount in percentage', 'jewelry-prices'),
			'label' => __('Product Discount percentage', 'jewelry-prices'),
			'type' => 'text',
			'data_type' => '',
			'description' => '%',
			'custom_attributes' => [
				'step' => 'any',
				'min' => '0',
			],
		]);
		
		echo '<div class="product-auto-calculate-fields">';
		woocommerce_wp_text_input([
			'id' => 'product_price_with_net_weight',
			'placeholder' => __('0', 'jewelry-prices'),
			'label' => __('Product Price', 'jewelry-prices'),
			'type' => 'text',
			'data_type' => 'price',
			'class' => 'jp-disable',
		]);
		
		woocommerce_wp_text_input([
			'id' => 'product_making_charge_per_gm',
			'placeholder' => __('0', 'jewelry-prices'),
			'label' => __('Product Making Charge per Gram', 'jewelry-prices'),
			'type' => 'text',
			'data_type' => 'price',
			'class' => 'jp-disable',
		]);
		
		
		woocommerce_wp_text_input([
			'id' => 'product_making_charge',
			'placeholder' => __('0', 'jewelry-prices'),
			'label' => __('Total Product Making Charge', 'jewelry-prices'),
			'type' => 'text',
			'data_type' => 'price',
			'class' => 'jp-disable',
		]);
		
		woocommerce_wp_text_input([
			'id' => 'product_discount',
			'placeholder' => __('0', 'jewelry-prices'),
			'label' => __('Product Discount', 'jewelry-prices'),
			'type' => 'text',
			'class' => 'jp-disable',
		
		]);
		
		woocommerce_wp_text_input([
			'id' => 'product_gst_tax',
			'placeholder' => __('GST (3%)', 'jewelry-prices'),
			'label' => __('GST (3%)', 'jewelry-prices'),
			'type' => 'text',
			'data_type' => 'price',
			'class' => 'jp-disable',
		
		]);
		
		echo '</div>';
		
		?>
    </div>
	<?php
	
	
}

add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save', 9999);

function woocommerce_product_custom_fields_save($post_id)
{
	$product = wc_get_product($post_id);
	
	$on_off_options_val = get_post_meta($post_id, 'wc_jp_product_calculation', true);
	$wc_jp_product_calculation = isset($_REQUEST['wc_jp_product_calculation']) ? $_REQUEST['wc_jp_product_calculation'] : 'disable';
	$product->update_meta_data('wc_jp_product_calculation', $wc_jp_product_calculation);
	
	if ($on_off_options_val == 'enable' || (isset($_REQUEST['wc_jp_product_calculation']) && $_REQUEST['wc_jp_product_calculation'] == 'enable')) {
		
		$jewelry_default_option_values = get_option('jp_prices_options');
		if (!is_array($jewelry_default_option_values)) {
			$jewelry_default_option_values = [];
		}
		
		
		$wc_product_type = (isset($_POST['wc_product_type']) && !empty($_POST['wc_product_type'])) ? $_POST['wc_product_type'] : 'jp_22_gold_price';
		
		$product->update_meta_data('wc_product_type', $wc_product_type);
		
		$daily_price_with_type = $jewelry_default_option_values[$wc_product_type];
		
		$product_gross_weight = isset($_POST['product_gross_weight']) ? $_POST['product_gross_weight'] : 0;
		$product->update_meta_data('product_gross_weight', $product_gross_weight);
		
		$product_net_weight = isset($_POST['product_net_weight']) ? $_POST['product_net_weight'] : 0;
		$product->update_meta_data('product_net_weight', $product_net_weight);
		
		$product_making_charge_percentage = isset($_POST['product_making_charge_percentage']) ? $_POST['product_making_charge_percentage'] : 0;
		$product->update_meta_data('product_making_charge_percentage', $product_making_charge_percentage);
		
		
		$product_other_charge = isset($_POST['product_other_charge']) ? $_POST['product_other_charge'] : 0;
		$product->update_meta_data('product_other_charge', $product_other_charge);
		
		$product_discount_percentage = isset($_POST['product_discount_percentage']) ? (float)$_POST['product_discount_percentage'] : 0;
		
		$product->update_meta_data('product_discount_percentage', $product_discount_percentage);
		
		
		$product_making_charge_per_gm = ceil(($product_making_charge_percentage * $daily_price_with_type) / 100);
		
		$product->update_meta_data('product_making_charge_per_gm', $product_making_charge_per_gm);
		
		$product_making_charge = $product_net_weight * $product_making_charge_per_gm;
		
		$total_discount = ($product_discount_percentage * $product_making_charge) / 100;
		
		$product->update_meta_data('product_discount', ceil($total_discount));
		
		$product->update_meta_data('product_making_charge', wc_round_tax_total($product_making_charge));
		
		$total_gold_price = $product_net_weight * $daily_price_with_type;
		
		$product->update_meta_data('product_price_with_net_weight', $total_gold_price);
		
		$total_new_price = ($total_gold_price + $product_making_charge + $product_other_charge) - $total_discount;
		
		$product->update_meta_data('jp_total_price', $total_new_price);
		
		$gst_on_price = ($total_new_price * 3) / 100;
		
		$product->update_meta_data('product_gst_tax', wc_round_tax_total($gst_on_price));
		
		$regular_price = $total_new_price + $gst_on_price;
		
		$product->set_regular_price(wc_round_tax_total($regular_price));
		
		$product->set_price(wc_round_tax_total($regular_price));
		$description = '[display_price_breakup]';
		$product->set_description($description);
		$product->save();
	}
}

add_action('admin_enqueue_scripts', 'jp_front_enqueue');
function jp_front_enqueue()
{
	wp_enqueue_style('jp_admin_enqueue', JP_PLUGIN_NAME_URL . 'assets/css/jp-custom-admin.css');
	wp_enqueue_script('jp_admin_enqueue', JP_PLUGIN_NAME_URL . 'assets/js/jp-custom-admin.js', array('jquery'), time(), true);
}

add_action('add_meta_boxes', 'jp_add_additional_fields');

function jp_add_additional_fields()
{
	$screens = ['product'];
	foreach ($screens as $screen) {
		add_meta_box(
			'jp_cpt_meta_boxes',
			'Additional fields',
			'jp_custom_box_html',
			$screen,
			'advanced',
			'high'
		);
	}
}

function jp_custom_box_html()
{
	global $post;
	$product_meta_values = get_post_meta($post->ID, 'product_meta_values', true);
	?>
    <div class="wrap">
        <table class="form-table" id="tbl_images">
            <tr>
                <th><label for="delivery_in"><?php esc_html_e("Delivery In :", "jewelry-prices"); ?></label></th>
                <td>
                    <input type="text" name="product_meta_values[delivery_in]" id="delivery_in"
                           value="<?php echo isset($product_meta_values['delivery_in']) ? $product_meta_values['delivery_in'] : '' ?>"/>
                </td>
            </tr>
            <tr>
                <th><label for="metal_type"><?php esc_html_e("Metal Type:", "jewelry-prices"); ?></label></th>
                <td>
                    <input type="text" name="product_meta_values[metal_type]" id="metal_type"
                           value="<?php echo isset($product_meta_values['metal_type']) ? $product_meta_values['metal_type'] : '' ?>"/>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="metal_color"><?php esc_html_e("Color", "jewelry-prices"); ?></label>
                </th>
                <td>
                    <input type="text" name="product_meta_values[metal_color]" id="metal_color"
                           value="<?php echo isset($product_meta_values['metal_color']) ? $product_meta_values['metal_color'] : '' ?>"/>
                </td>
            </tr>
            <tr>
                <th><label for="waste_in_gram"><?php esc_html_e("Wastage in Gram", "jewelry-prices"); ?></label></th>
                <td>
                    <input type="text" name="product_meta_values[waste_in_gram]" id="waste_in_gram"
                           value="<?php echo isset($product_meta_values['waste_in_gram']) ? $product_meta_values['waste_in_gram'] : '' ?>"/>
                </td>
            </tr>
            <tr>
                <th><label for="metal_purity"><?php esc_html_e("Metal Purity", "jewelry-prices"); ?></label></th>
                <td>
                    <input type="text" name="product_meta_values[metal_purity]" id="metal_purity"
                           value="<?php echo isset($product_meta_values['metal_purity']) ? $product_meta_values['metal_purity'] : '' ?>"/>
                </td>
            </tr>
            <tr>
                <th><label for="stone_name"><?php esc_html_e("Stone Name :", "jewelry-prices"); ?></label></th>
                <td>
                    <input type="text" name="product_meta_values[stone_name]" id="stone_name"
                           value="<?php echo isset($product_meta_values['stone_name']) ? $product_meta_values['stone_name'] : '' ?>"/>
                </td>
            </tr>
            <tr>
                <th><label for="stone_weight"><?php esc_html_e("Stone weight :", "jewelry-prices"); ?></label></th>
                <td>
                    <input type="text" name="product_meta_values[stone_weight]" id="stone_weight"
                           value="<?php echo isset($product_meta_values['stone_weight']) ? $product_meta_values['stone_weight'] : '' ?>"/>
                </td>
            </tr>
            <tr>
                <th><label for="stone_cut"><?php esc_html_e("Stone cut :", "jewelry-prices"); ?></label></th>
                <td>
                    <input type="text" name="product_meta_values[stone_cut]" id="stone_cut"
                           value="<?php echo isset($product_meta_values['stone_cut']) ? $product_meta_values['stone_cut'] : '' ?>"/>
                </td>
            </tr>
            <tr>
                <th><label for="stone_clarity"><?php esc_html_e("Stone clarity :", "jewelry-prices"); ?></label></th>
                <td>
                    <input type="text" name="product_meta_values[stone_clarity]" id="stone_clarity"
                           value="<?php echo isset($product_meta_values['stone_clarity']) ? $product_meta_values['stone_clarity'] : '' ?>"/>
                </td>
            </tr>
        </table>
    </div>
	<?php
}

add_action( 'save_post', 'jp_save_additional_fields' , 99);

function jp_save_additional_fields($post_id){
	
	if ( array_key_exists( 'product_meta_values', $_POST ) ) {
		
		update_post_meta(
			$post_id,
			'product_meta_values',
			$_POST['product_meta_values']
		);
	}
	
}