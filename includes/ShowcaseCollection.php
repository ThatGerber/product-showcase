<?php
/**
 * Summary
 *
 * Description.
 *
 * @link       URL
 * @since      x.x.x
 *
 * @package    {WordPress}
 * @subpackage {Component}
 */
namespace ChrisWGerber\ProductShowcase;

use PhpCollection\Sequence as CollectionSequence;

Class ShowcaseCollection extends CollectionSequence implements ICanAccessProducts, IIsPostType {

	/**
	 * Metabox for
	 *
	 * @var MapCollection
	 */
	public $meta_box;

	/**
	 * @var MapCollection
	 */
	public $meta_data;

	/**
	 * Name of the Post Type
	 *
	 * @var string
	 */
	protected $post_type_name;

	/**
	 * Array of arguments for creating the post type.
	 *
	 * @var array
	 */
	protected $post_type_args;

	/**
	 * Array of labels for the post type
	 *
	 * @var array
	 */
	protected $post_type_labels;

	/**
	 * Collection of status for
	 *
	 * @var MapCollection
	 */
	protected $post_statuses;

	/**
	 * Posts before they get turned into products
	 *
	 * @var array
	 */
	private $posts;

	/**
	 * PHP Constructor
	 *
	 * @param array $elements
	 */
	public function __construct( array $elements = array() ) {
		parent::__construct( $elements );

		$this->post_type_labels = $this->get_post_type_labels();
		$this->post_type_args   = $this->get_post_type_args();
	}

	/**
	 * Creates a new metabox
	 *
	 * Metabox is created as a collection. Collection consists of a grouping of
	 * fields to be used.
	 *
	 * @param string $title
	 *
	 * @return $this
	 */
	public function add_meta_box( $title ) {
		$this->meta_box  = array( $title => new Metabox( $title, $this->post_type_name ) );
		if ( ! isset( $this->meta_data ) ) {
			$this->meta_data = $this->create_collection();
		}

		return $this;
	}

	/**
	 * Adds meta field to collection
	 *
	 * @param string   $name
	 * @param Metadata $class_object
	 *
	 * @return $this
	 */
	public function add_meta_field( $name, Metadata $class_object ) {
		$class_object->set_name = $name;
		if ( ! isset( $this->meta_data ) ) {
			$this->meta_data = $this->create_collection();
		}
		$this->meta_data->set( $name, $class_object );

		return $this;
	}

	/**
	 * Loads the products into the collection.
	 *
	 * @return bool
	 */
	public function load_products() {
		$this->get_products_posts();
		if ( $this->posts !== null ) {
			foreach ( $this->posts as $ps_post ) {
				$this->add( new ShowcaseProduct( $ps_post ) );
			}
		}
	}

	/**
	 * Returns the list of currently active products.
	 *
	 * Requires $post_type_name to be set.
	 */
	public function get_products_posts() {
		if ( ! isset( $this->post_type_name ) ) {

			return null;
		}
		$products_query = new \WP_Query( array(
			'post_type'              => array( $this->post_type_name ),
			'post_status'            => array( 'publish' ),
			'posts_per_page'         => - 1,
			'ignore_sticky_posts'    => false,
			'order'                  => 'DESC',
			'orderby'                => 'rand',
			'cache_results'          => true,
			'update_post_meta_cache' => true,
		) );
		$this->posts    = $products_query->posts;
		wp_reset_query();

		return $this->posts;
	}

	/**
	 * Reverse all of the items in the elements array
	 */
	public function reverse() {
		array_reverse( $this->elements );
	}

	/**
	 * Sets the name of the post type and registers it.
	 *
	 * @param string $name
	 *
	 * @return $this
	 */
	public function set_name( $name ) {
		$this->post_type_name = $name;
		$this->register_post_type();

		return $this;
	}

	/**
	 * Returns the name of the post type.
	 *
	 * I'm keeping it hidden because I don't want it to be directly editable,
	 * but sometimes you need to know what it is.
	 *
	 * @return string
	 */
	public function get_name() {

		return $this->post_type_name;
	}


	/**
	 * @inheritdoc
	 */
	public function get_post_type_args() {

		return array(
			'label'               => __( 'showcase_product', 'cwg-ps' ),
			'description'         => __( 'Product Showcase', 'cwg-ps' ),
			'supports'            => array( 'title', 'editor', 'thumbnail', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 15,
			'menu_icon'           => 'dashicons-format-image',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
	}

	/**
	 * @inheritdoc
	 */
	public function get_post_type_labels() {

		return array(
			'name'               => _x( 'Product Showcase', 'Post Type General Name', 'cwg-ps' ),
			'singular_name'      => _x( 'Product Showcase', 'Post Type Singular Name', 'cwg-ps' ),
			'menu_name'          => __( 'Showcases', 'cwg-ps' ),
			'name_admin_bar'     => __( 'Product', 'cwg-ps' ),
			'parent_item_colon'  => __( 'Parent Showcase:', 'cwg-ps' ),
			'all_items'          => __( 'All Product Showcases', 'cwg-ps' ),
			'add_new_item'       => __( 'Add New Showcase', 'cwg-ps' ),
			'add_new'            => __( 'Add New', 'cwg-ps' ),
			'new_item'           => __( 'New Showcase', 'cwg-ps' ),
			'edit_item'          => __( 'Edit Showcase', 'cwg-ps' ),
			'update_item'        => __( 'Update Showcase', 'cwg-ps' ),
			'view_item'          => __( 'View Showcase', 'cwg-ps' ),
			'search_items'       => __( 'Search Showcase', 'cwg-ps' ),
			'not_found'          => __( 'Not found', 'cwg-ps' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'cwg-ps' ),
		);
	}

	/**
	 * @inheritdoc
	 */
	public function post_registration_callback() {
		$args           = $this->post_type_args;
		$args['labels'] = $this->post_type_labels;
		register_post_type( $this->post_type_name, $args );
		$this->load_products();
	}

	/**
	 * Get the post types
	 *
	 * @return array|null;
	 */
	protected function get_post_types() {
		if ( isset( $this->post_type_name ) && is_array( $this->post_type_name ) ) {

			return $this->post_type_name;
		} elseif ( isset( $this->post_type_name ) && is_string( $this->post_type_name ) ) {

			return array( $this->post_type_name );
		} else {

			return null;
		}
	}

	/**
	 * Create a new post status
	 *
	 * @param string           $name
	 * @param CustomPostStatus $status
	 */
	public function new_post_status( $name, CustomPostStatus $status ) {
		$this->post_statuses = $this->create_collection();
		$this->post_statuses->set( $name, $status );
		$this->post_statuses->walk( function ( $post_status, $name ) {
			$post_status->set_name( $name );
			$post_status->add_post_type( $this->get_post_types() );
		} );

	}

	/**
	 * Run to register and add post type
	 */
	public function register_post_type() {
		add_action( 'init', array( $this, 'post_registration_callback' ), 0, 0 );
	}

	/**
	 * Register Post Statuses
	 */
	public function register_post_statuses() {
		$this->post_statuses->walk( function ( $post_status ) {
			add_action( 'init', array( $post_status, 'register_post_status' ), 1 );
		} );
	}

	/**
	 * Creates a map collection.
	 *
	 * @return MapCollection
	 */
	private function create_collection() {

		return new MapCollection();
	}

}