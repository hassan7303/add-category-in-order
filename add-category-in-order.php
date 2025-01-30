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
    ?>
    <style>
        .co_categories-title {
            background: white;
            padding: 10px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 1px 0px #dddd;
        }
        .co_categories-list{
            list-style: none;
            display: flex;
            justify-content: center;
            margin-top: 50px;
            gap: 3%;
        }
        .co_categories-list li{
            background: white;
            padding: 10px 50px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 1px 0px #dddd;
            margin-bottom: 20px;
        }
        .co_categories-list li a:hover{
            color: black;
            font-weight: bold;
        }
        .co_products-in-category{
            background: white;
            padding: 10px 26px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 1px 0px #dddd;
        }
        .co_products-in-category ul{
            list-style: none;
            display: flex;
            justify-content: start;
            padding-right: 0;
            margin-right: 4.1%;
            gap: 7%;
            flex-wrap: wrap;
        }
        .co_products-in-category ul li{
            position: relative;
            display: inline-block;
            margin-top: 15px;
        }
        .co_categories-list li.active-category {
            font-weight: bold;
            box-shadow: 0 4px 19px 1px #ddd;
        }
        .co_products-in-category ul li div{
            width: 160px;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: #dddddd4a;
        }
        .co_products-in-category h3{
            font-size: 20px;
            margin-top: 5px;
        }
        .co_products-in-category ul li div img{
            width: 100%;
            height: auto;
            border-radius: 4px;
        }
        .co_products-in-category ul li div p{
            margin: 10px 0 0;
            font-size: 14px;
            color: #333;
            font-weight: bold;
        }

        @media screen and (max-width: 780px) {
            .co_categories-list {
                margin-top: unset;
                gap: 6%;
                padding-right: 0;
                flex-wrap: wrap;
            }
            .co_categories-list li {
                margin-bottom: 15px;
                width: 47%;
                height: 50px;
            }
            .co_categories-list li a{
                text-wrap-mode: nowrap;
            }
            .co_products-in-category h3{
                font-size: 16px;
            }
        }
        @media screen and (max-width: 500px) {
            .co_products-in-category ul li div {
                width: 140px;
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 10px;
                text-align: center;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                background: #dddddd4a;
            }
            .co_products-in-category ul {
                list-style: none;
                display: flex;
                justify-content: center;
                padding-right: 0;
                margin-right: unset;
                gap: 3%;
                flex-wrap: wrap;
            }
        }
        @media screen and (max-width: 380px) {
            .co_products-in-category ul li div {
                width: 125px;
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 10px;
                text-align: center;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                background: #dddddd4a;
            }
        }
        
    </style>
    <?php
    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ]);
    
    echo '<h2 class="co_categories-title">دسته‌بندی‌ سفارشات شما </h2>';
    echo '<ul class="co_categories-list">';
    
    echo '<li class="' . (empty($_GET['category']) ? 'active-category' : '') . '">';
    echo '<a href="' . esc_url(wc_get_endpoint_url('order-categories')) . '">همه سفارشات</a>';
    echo '</li>';
    
    foreach ($categories as $category) {
        if (esc_html($category->name) !== "همه دسته‌ها") {
            $is_active = isset($_GET['category']) && $_GET['category'] === $category->slug ? 'active-category' : '';
            echo '<li class="' . esc_attr($is_active) . '">';
            echo '<a href="' . esc_url(wc_get_endpoint_url('order-categories') . '?category=' . $category->slug) . '">' . esc_html($category->name) . '</a>';
            echo '</li>';  
        }
    }
    
    echo '</ul>';
    
    echo '<div class="co_products-in-category">';
    
    if (isset($_GET['category'])) {
        $category_slug = sanitize_text_field($_GET['category']);
        $category = get_term_by('slug', $category_slug, 'product_cat');
        
        if ($category) {
            echo '<h3>محصولات سفارش‌داده‌شده در دسته‌بندی: ' . esc_html($category->name) . '</h3>';
            $products = get_products_in_category_ordered_by_user($category->term_id);
        } else {
            echo '<p>دسته‌بندی مورد نظر یافت نشد.</p>';
            return;
        }
    } else {
        echo '<h3>همه محصولات سفارش داده‌شده</h3>';
        $products = get_all_ordered_products_by_user();
    }
    
    if (!empty($products)) {
        echo '<ul>';
        foreach ($products as $product) {
            $img_src = esc_url(get_the_post_thumbnail_url($product->get_id(), 'medium'));
            if(empty($img_src)){
                $img_src = "https://hezartoo.media/wp-content/uploads/logo-white-1.png";
            }
            echo "<li><div><img src='$img_src'><p>" . esc_html($product->get_name()) . '</p></div></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>هیچ محصولی در این دسته‌بندی سفارش داده نشده است.</p>';
    }
    
    echo '</div>';
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
        foreach ($order->get_items() as $item) {
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
 * Get products All ordered by user in a specific category, All ordered by user
 *
 * @return array
 */
function get_all_ordered_products_by_user(): array {
    $user_id = get_current_user_id();
    $ordered_products = [];

    $orders = wc_get_orders([
        'customer_id' => $user_id,
        'status' => 'completed',
    ]);

    foreach ($orders as $order) {
        foreach ($order->get_items() as $item) {
            $ordered_products[] = wc_get_product($item->get_product_id());
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
  