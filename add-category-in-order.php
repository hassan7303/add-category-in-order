<?php
/**
 * Plugin Name: add category in order
 * Description: Customizes the order page by categorizing products based otheir categories.
 * Version: 1.0
 * Author: hassan ali askari 
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
add_filter('woocommerce_my_account_my_orders_columns', 'add_custom_order_category_column');

function add_custom_order_category_column($columns) {
    $columns['order_categories'] = 'دسته‌بندی‌ها';
    return $columns;
}

add_action('woocommerce_my_account_my_orders_column_order_categories', 'display_custom_order_category_column');

function display_custom_order_category_column($order) {
    $categories = [];

    $items = $order->get_items();
    foreach ($items as $item) {
        $product_id = $item->get_product_id();
        $product_categories = get_the_terms($product_id, 'product_cat');

        if ($product_categories && !is_wp_error($product_categories)) {
            foreach ($product_categories as $category) {
                $categories[] = $category->name;
            }
        }
    }

    $categories = array_unique($categories);

    echo implode(', ', $categories);
}
?>
