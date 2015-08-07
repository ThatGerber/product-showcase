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

class Metabox {

	/**
	 * Metabox ID. Used for referencing metaboxes and specific data
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Title to appear above the metabox
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @var string
	 */
	public $title;

	/**
	 * Where the box should appear
	 *
	 * Describes what type of box it is. This will
	 * help determine where it appears on the page.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @var string
	 */
	public $context = 'advanced';

	/**
	 * Where it should appear
	 *
	 * By default, it'll appear lower in the page.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @var string
	 */
	public $priority = 'default';

	/**
	 * method or function to run for the callback to display
	 * the field
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @var string
	 */
	public $callback;

	/**
	 * Meta key
	 *
	 * Name that the metadata is stored in the database under.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @var string
	 */
	public $meta_key;

	/**
	 * Array of post types that the metabox is queued with.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @var array
	 */
	public $post_types;

	/**
	 * Current screen (post type) in the array
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @var string
	 */
	protected $current_post_type;

	/**
	 * Fields to populate the metabox
	 *
	 * Each item in the array should be an instance
	 * of Metadata
	 *
	 * @see \ChrisWGerber\ProductShowcase\Metadata
	 *
	 * @var array
	 */
	public $fields;

	/**
	 * String used to store metabox's value
	 *
	 * @var string
	 */
	public $options_string;

	/**
	 * PHP5 Constructor
	 *
	 * @param $title
	 * @param $post_types
	 */
	public function __construct( $title, $post_types ) {
		$this->title      = $title;
		$this->id         = sanitize_title_with_dashes( $title );
		$this->post_types = $post_types;
	}


	/**
	 * @param $callback
	 *
	 * @return $this
	 */
	public function set_callback( $callback ) {
		$this->callback = $callback;

		return $this;
	}

	/**
	 * Registers metaboxes for each of the supplied post types
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register_metabox() {
		if ( is_array( $this->post_types ) ) {
			foreach ( $this->post_types as $screen ) {
				$this->current_post_type = $screen;
				add_action( "add_meta_boxes_{$screen}", array( $this, 'add_metabox' ) );
			}
		} else {
			add_action( "add_meta_boxes_{$this->post_types}", array( $this, 'add_metabox' ) );
		}
		$this->register_save_data();
	}

	/**
	 * Registers save function with each of the post types this is enqueued on
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register_save_data() {
		if ( is_array( $this->post_types ) ) {
			foreach ( $this->post_types as $screen ) {
				add_action( 'save_' . $screen, array( $this, 'save_data' ), 10, 2 );
			}
		} else {
			add_action( "save_{$this->post_types}", function () {
				set_transient( 'Showcase/Save_Data/Test', 'Is it registering?' );
			} );
			add_action( "save_post_{$this->post_types}", array( $this, 'save_data' ), 10, 2 );
		}
	}

	/**
	 * Adds metabox to current post type
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function add_metabox() {
		add_meta_box(
			$this->id,
			$this->title,
			$this->callback,
			$this->current_post_type,
			$this->context,
			$this->priority,
			$this->fields
		);
	}

	/**
	 * Saves the metabox data
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param  \WP_POST::ID $post_id
	 * @param  \WP_POST $post
	 *
	 * @return void|mixed
	 */
	public function save_data( $post_id, $post ) {
		$post_type = get_post_type_object( $post->post_type );
		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */
		if (
			! isset( $_POST[ $this->id . '_meta_box_nonce' ] ) ||
			! wp_verify_nonce( $_POST[ $this->id . '_meta_box_nonce' ], $this->id . '_meta_box' ) ||
			defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ||
			! current_user_can( $post_type->cap->edit_post, $post_id )
		) {
			return $post_id;
		}
		foreach ( $this->fields as $name => $field ) {
			$value = sanitize_text_field( $_POST[ $this->id ][ $field->get_id() ] );
			$field->set_value( $value );
		}
	}

}