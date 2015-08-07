<?php
/**
 * Product Showcase Bootstrap File
 *
 * @wordpress-plugin
 * Plugin Name:       Product Showcase
 * Plugin URI:        https://github.com/ThatGerber/product-showcase
 * Description:       Showcase top products through a carousel widget
 * Author:            Chris W. Gerber
 * Author URI:        http://www.chriswgerber.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       45n-ps
 * Github Plugin URI: https://github.com/ThatGerber/product-showcase
 * GitHub Branch:     stable
 * Version:           1.0.0.dev
 *
 * The Plugin File
 *
 * @link              https://github.com/ThatGerber/product-showcase
 * @since             1.0.0
 */
namespace ChrisWGerber\ProductShowcase;
// Autoloader
spl_autoload_register( function ( $class ) {
	$prefix   = 'ChrisWGerber\\ProductShowcase\\';
	$base_dir = __DIR__ . '/includes/';
	$len      = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		return;
	}
	$relative_class = substr( $class, $len );
	$file           = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';
	if ( file_exists( $file ) ) {
		require $file;
	}
} );
include 'vendor/autoload.php';
// Products Showcase
$ps_products = new ShowcaseCollection();
add_action( 'plugins_loaded', function () {
	global $ps_products;
	// Post Type
	$ps_products->set_name( 'showcase-product' );
	$ps_products->register_post_type();
	// Fields
	$ps_products->add_meta_field( 'Showcase Link', new Metadata() );
	$ps_products->add_meta_field( 'End Date', new Metadata() );
	$ps_products->meta_data->get( 'End Date' )->get()->set_type( 'datepicker' );
	// Post Statuses
	$ps_products->new_post_status( 'Completed', new CustomPostStatus );
	$ps_products->register_post_statuses();
	// Metabox
	$ps_products->add_meta_box( 'Product Information' );
	// Create Fields
	$ps_products->meta_box['Product Information']->fields = $ps_products->meta_data->all();
	// Set Callback to create metabox
	$ps_products->meta_box['Product Information']->set_callback( function ( $wp_post_obj, $metabox ) {
		global $ps_products;
		wp_nonce_field(
			$ps_products->meta_box['Product Information']->id . '_meta_box',
			$ps_products->meta_box['Product Information']->id . '_meta_box_nonce'
		);
		new Fields( $metabox['id'], $ps_products->meta_data->all() );
	} );
	// Register
	$ps_products->meta_box['Product Information']->register_metabox();
	get_transient( 'Showcase/Save_Data/Test' );
	// Widget
} );

add_action( 'widgets_init', function() {
	include 'templates/showcase-widget.php';
	register_widget( "ChrisWGerber\ProductShowcase\Widget" );
} );