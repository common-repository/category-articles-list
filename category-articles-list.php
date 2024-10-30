<?php
/**
 * The plugin bootstrap file
 *
 * @link              http://www.easantos.net/wordpress/category-articles-list/
 * @since             1.0.0
 * @package           Category Articles List
 *
 * @wordpress-plugin
 * Plugin Name:       Category Articles List
 * Plugin URI:        http://www.easantos.net/wordpress/category-articles-list/
 * Description:       TODO
 * Version:           1.0.1
 * Author:            Easantos
 * Author URI:        http://www.easantos.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       category-articles-list
 * Domain Path:       /languages
 */

if (!defined('WPINC')) {
    die;
}

add_shortcode('category-articles-list', 'calCategoryArticlesList');
add_action('admin_menu', 'calAddMenuItems');

function calPluginData()
{
    return array(
        'name' => 'Category Articles List',
        'slug' => 'category-articles-list',
    );
}

function calAddMenuItems()
{
    add_menu_page(
        'Category Articles List',
        'Category Articles List',
        10,
        'calMain',
        'calMain',
        plugins_url('images/icon.png', __FILE__)
    );
}

function calMain()
{
    $pluginData = calPluginData();

    require_once 'views/main.php';
}

function calSettings()
{
    $pluginData = calPluginData();

    require_once 'views/settings.php';
}

function calCategoryArticlesList($attributes)
{
    $categoryId = $attributes['category'];

    $category = get_the_category_by_ID($categoryId);
    $articlesHtml = '<h2>Pages in ' . $category . '</h2>';
    $posts = get_posts([
        'order' => 'ASC',
        'orderby' => 'title',
        'numberposts' => 10000,
        'category' => $categoryId
    ]);
    foreach ($posts as $eas_post) {
        $articlesHtml .= '<a title="' . $eas_post->post_title . '" href="' . get_permalink($eas_post->ID) . '">' . $eas_post->post_title . '</a><br />';
    }
    $articlesHtml .= '<br /><small>There are ' . count($posts) . ' post(s) in this category.</small>';

    return $articlesHtml;
}
