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


interface IIsPostType {

	/**
	 * Function should return an array of arguments needed to queue up the post
	 * type.
	 *
	 * @return array
	 */
	function get_post_type_args();

	/**
	 * Method should return an array of labels to be used by a post type.
	 *
	 * @return array
	 */
	function get_post_type_labels();

	/**
	 * Registers a post type
	 *
	 * @return void
	 */
	function post_registration_callback();

}