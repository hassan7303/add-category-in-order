<?php
/**
 * Plugin Name: add category in order
 * Description: Customizes the order page by categorizing products based otheir categories.
 * Version: 1.0
 * Author: hassan ali askari 
 */
/**
 * Plugin Name: Custom Product Search
 *
 * Description: A custom search plugin for WooCommerce products with AJAX functionality.
 *
 * Version: 2.0.0
 *
 * Author: hassan Ali Askari
 * Author URI: https://t.me/hassan7303
 * Plugin URI: https://github.com/hassan7303
 *
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 *
 * Email: hassanali7303@gmail.com
 * Domain Path: https://hsnali.ir
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Add custom order category column
 * 
 * @param array $columns
 * 
 * @return array
 */
function add_custom_order_category_column(array $columns):array
{
    $columns['order_categories'] = 'دسته‌بندی‌ها';
    return $columns;
}
add_filter('woocommerce_my_account_my_orders_columns', 'add_custom_order_category_column');

/**
 * Display custom order category column
 * 
 * @param WC_Order $order
 * 
 * @return void
 */
function display_custom_order_category_column(WC_Order $order):void
{
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
add_action('woocommerce_my_account_my_orders_column_order_categories', 'display_custom_order_category_column');

 
 /**
 * Checks for plugin updates from GitHub and notifies WordPress.
 *
 * Fetches the latest release information from GitHub. If a newer version is available,
 * it adds the update to the WordPress update queue.
 *
 * @param object $transient The transient object containing update information.
 * 
 * @return object Modified transient object with update details if available.
 */
function check_for_plugin_update(object $transient):object
{
    if (empty($transient->checked)) {
        return $transient;
    }
  
    $plugin_slug = plugin_basename(__FILE__);
    $github_url = 'https://api.github.com/repos/hassan7303/add-category-in-order/releases/latest';
  
    $response = wp_remote_get($github_url, ['sslverify' => false]);
    if (is_wp_error($response)) {
        return $transient;
    }
  
    $release_info = json_decode(wp_remote_retrieve_body($response), true);
  
    if (isset($release_info['tag_name']) && isset($transient->checked[$plugin_slug])) {
        $new_version = $release_info['tag_name'];
        if (version_compare($transient->checked[$plugin_slug], $new_version, '<')) {
            $transient->response[$plugin_slug] = (object) [
                'slug' => $plugin_slug,
                'new_version' => $new_version,
                'package' => $release_info['zipball_url'],
                'url' => 'https://github.com/hassan7303/add-category-in-order',
            ];
        }
    }
  
    return $transient;
  }
  add_filter('pre_set_site_transient_update_plugins', 'check_for_plugin_update');
  
  /**
  * Adjust plugin folder name after installation to maintain original name.
  *
  * @param array $response
  * @param array $hook_extra
  * @param array $result
  *
  * @return array
  */
  function fix_plugin_folder_name(array $response,array $hook_extra,array $result):array
  {
    global $wp_filesystem;
  
    $plugin_slug = 'add-category-in-order';
    $original_folder = WP_PLUGIN_DIR . '/' . $plugin_slug;
    $new_folder = $result['destination'];
  
    if (basename($new_folder) !== $plugin_slug) {
        $wp_filesystem->move($new_folder, $original_folder);
        $result['destination'] = $original_folder;
    }
  
    return $response;
  }
  add_filter('upgrader_post_install', 'fix_plugin_folder_name', 10, 3);
  