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

class ShowcaseProduct {

	public $id;

	public $title;

	public $description;

	public $image;

	/**
	 * @param \WP_Post $post
	 */
	public function __construct( \WP_Post $post ) {
		$this->id          = $post->ID;
		$this->title       = $post->post_title;
		$this->description = $post->post_content;
		$this->image       = '';

	}

	public function get_title() {
	}

	public function get_image() {
	}

	public function get_description() {
	}

	public function the_title() {
	}

	public function the_image() {
	}

	public function the_description() {
	}
}