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


class Inputs {

	public static function text_field( \WP_Post $post, Array $args ) {
		var_dump( $args );
		$metadata = $args['args'];
		$id    = $args['id'] . '[' . $metadata->get_id() . ']'; //$this->options_str . '[' . $args['id'] . '][' . $args['name'] . ']';
		$title = $metadata->get_name(); //$args['title'];
		$value = $metadata->get_value();
		?>
		<div>
			<label for="<?php _e( $id, 'cwg-ps' ); ?>">
				<?php _e( $title, 'cwg-ps' ); ?>
			</label>
			<input type="text" id="<?php _e( $id, 'cwg-ps' ); ?>" class="wide-fat" name="<?php _e( $id, 'cwg-ps' ); ?>"
			       value="<?php _e( $value, 'cwg-ps' ); ?>"/>
		</div>
		<?php

	}

}