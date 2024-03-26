<?php
/**
 * Plugin Name: MB Term Meta
 * Plugin URI: https://metabox.io/plugins/mb-term-meta/
 * Description: Add custom fields (meta data) for terms.
 * Version: 1.0.1
 * Author: Rilwis
 * Author URI: http://www.deluxeblogtips.com
 * License: GPL2+
 * Text Domain: mb-term-meta
 * Domain Path: /lang/
 */

// Prevent loading this file directly.
defined( 'ABSPATH' ) || exit;

define( 'MB_TERM_META_URL', plugin_dir_url( __FILE__ ) );
define( 'MB_TERM_META_DIR', plugin_dir_path( __FILE__ ) );

add_action( 'plugins_loaded', 'mb_term_meta_load' );

/**
 * Load plugin files after Meta Box is loaded
 * @return void
 */
function mb_term_meta_load()
{
	if ( ! class_exists( 'RW_Meta_Box' ) )
	{
		return;
	}
	require_once MB_TERM_META_DIR . 'inc/term-meta-box.php';
	require_once MB_TERM_META_DIR . 'inc/init.php';
}
