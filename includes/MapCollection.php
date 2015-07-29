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

use PhpCollection\Map;

class MapCollection extends Map {

	/**
	 * Array walk against the correct class with the selected callback.
	 *
	 * Selected callback can take two arguments: 1. Value, 2: Key. One
	 * or both can be passed through the callback to be walked.
	 *
	 * @param $callback
	 *
	 * @return $this
	 */
	public function walk( $callback ) {
		array_walk( $this->elements, $callback );

		return $this;
	}

	/**
	 * Returns all elements from the collection as an array, if they need to be
	 * returned as an array for whatever reason.
	 *
	 * @return array
	 */
	public function all() {

		return $this->elements;
	}

}