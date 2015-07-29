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
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Publicly usable name for the data.
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Value of the particular meta field. Depends on the post type used
	 * to pull the data.
	 *
	 * @access public
	 * @since 1.0.0
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
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $type;

	/**
	 * Sets the product ID.
	 *
	 * Will attempt to automatically create it from the provided value,
	 * but can also fall back to name/key of the field
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @param null $meta_id
	 *
	 * @return $this
	 */
	protected function set_id( $meta_id = null ) {
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
	 * @since 1.0.0
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
	 * @since 1.0.0
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
	 * @since 1.0.0
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
	 * @since 1.0.0
	 *
	 * @param $value
	 *
	 * @return $this
	 */
	public function set_value( $value ) {
		$this->value = $value;

		return $this;
	}

	/**
	 * @param \WP_Post|int $post_id
	 *
	 * @return mixed
	 */
	public function get_value( $post_id = null ) {

		return $this->value;
	}

	public function get_post() {
	}

	public function set_type( $type ) {
		$this->type = $type;

		return $this;
	}

	public function get_type() {

		return $this->type;
	}

}