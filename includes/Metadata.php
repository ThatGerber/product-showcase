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

class Metadata {

	/**
	 * Key used to idenitify the data.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Publicly usable name for the data.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Value of the particular meta field. Depends on the post type used
	 * to pull the data.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var mixed
	 */
	public $value;

	/**
	 * Type of data
	 *
	 * text string, url, text area, email address, image, etc.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @var string
	 */
	public $type;

	public function __construct( $type = null ) {
		$this->set_type( $type );
	}

	/**
	 * Sets the product ID.
	 *
	 * Will attempt to automatically create it from the provided value,
	 * but can also fall back to name/key of the field
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @param null $meta_id
	 *
	 * @return $this
	 */
	public function set_id( $meta_id = null ) {
		if ( $meta_id == null && isset( $this->name ) ) {
			$new_id = $this->name;
		} elseif ( $meta_id !== null ) {
			$new_id = $meta_id;
		}
		$this->id = sanitize_title_with_dashes( $new_id );

		return $this;
	}

	/**
	 * Returns the ID of the metadata
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return string
	 */
	public function get_id() {

		return $this->id;
	}

	/**
	 * Sets the name of the metadata
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @param $name
	 *
	 * @return $this
	 */
	public function set_name( $name ) {
		$this->name = $name;
		$this->set_id();

		return $this;
	}

	/**
	 * Returns the name of the meta field/key
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return string
	 */
	public function get_name() {

		return $this->name;
	}

	/**
	 * Sets the value of the field
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @param mixed $value
	 * @param int $post_id
	 *
	 * @return $this
	 */
	public function set_value( $value, $post_id = null ) {
		if ( null === $post_id ) {
			global $post;
			$post_id = $post->ID;
		}
		$success = update_post_meta( $post_id, $this->name, $value );
		if ( $success ) {
			$this->value = get_post_meta( $post_id, $this->name, true );
		}

		return $this;
	}

	/**
	 * @param \WP_Post|int $post_id
	 *
	 * @return mixed
	 */
	public function get_value( $post_id = null ) {
		if ( null === $post_id ) {
			global $post;
			$post_id = $post->ID;
		}
		$this->value = get_post_meta( $post_id, $this->name, true );

		return $this->value;
	}

	public function get_post() {
	}

	public function set_type( $type = null ) {
		if ( null == $type ) {
			$this->type = 'text';
		} else {
			$this->type = $type;
		}

		return $this;
	}

	public function get_type() {

		return $this->type;
	}

}