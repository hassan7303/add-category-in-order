<?php

/**
 * Plugin Name: add category in order
 *
 * Description: Customizes the order page by categorizing products based otheir categories.
 *
 * Version: 1.0.0
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
add_filter('woocommerce_account_menu_items', 'add_custom_order_categories_link');
add_action('init', 'add_custom_order_categories_endpoint');
add_action('woocommerce_account_order-categories_endpoint', 'display_custom_order_categories_page');

/**
 * Add custom order categories link to the account menu
 * 
 * @param array $menu_links
 * 
 * @return array
 */
function add_custom_order_categories_link(array $menu_links): array {
    $menu_links['order-categories'] = 'دسته‌بندی سفارشات';
    return $menu_links;
}

/**
 * Add custom order categories endpoint
 * 
 * @return void
 */
function add_custom_order_categories_endpoint(): void {
    add_rewrite_endpoint('order-categories', EP_ROOT | EP_PAGES);
}

/**
 * Display custom order categories page
 * 
 * @return void
 */
function display_custom_order_categories_page(): void {
    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ]);

    if (!empty($categories)) {
        echo '<h2>دسته‌بندی‌های سفارشات شما</h2>';
        echo '<ul>';

        foreach ($categories as $category) {
            echo '<li>';
            echo '<a href="' . esc_url(wc_get_endpoint_url('order-categories') . '?category=' . $category->slug) . '">' . esc_html($category->name) . '</a>';
            echo '</li>';
        }

        echo '</ul>';

        if (isset($_GET['category'])) {
            $category_slug = sanitize_text_field($_GET['category']);
            $category = get_term_by('slug', $category_slug, 'product_cat');

            if ($category) {
                echo '<h3>محصولات سفارش‌داده‌شده در دسته‌بندی: ' . esc_html($category->name) . '</h3>';
                $products = get_products_in_category_ordered_by_user($category->term_id);

                if (!empty($products)) {
                    echo '<ul>';
                    foreach ($products as $product) {
                        echo '<li>' . esc_html($product->get_name()) . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p>هیچ محصولی در این دسته‌بندی سفارش داده نشده است.</p>';
                }
            } else {
                echo '<p>دسته‌بندی مورد نظر یافت نشد.</p>';
            }
        }
    } else {
        echo '<p>هیچ دسته‌بندی‌ای یافت نشد.</p>';
    }
}

/**
 * Get products ordered by user in a specific category, ordered by user
 * 
 * @param int $category_id
 * 
 * @return array
 */
function get_products_in_category_ordered_by_user(int $category_id): array {
    $user_id = get_current_user_id();
    $ordered_products = [];

    $orders = wc_get_orders([
        'customer_id' => $user_id,
        'status' => 'completed',
    ]);

    foreach ($orders as $order) {
        $items = $order->get_items();

        foreach ($items as $item) {
            $product_id = $item->get_product_id();
            $product_categories = get_the_terms($product_id, 'product_cat');

            if ($product_categories && !is_wp_error($product_categories)) {
                foreach ($product_categories as $category) {
                    if ($category->term_id == $category_id) {
                        $ordered_products[] = wc_get_product($product_id);
                        break;
                    }
                }
            }
        }
    }

    return $ordered_products;
}

 
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
  