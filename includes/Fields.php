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


class Fields {

	public function __construct( Metabox $metabox, Array $meta_data ) {
		$this->begin();
		foreach ( $meta_data as $name => $field ) {
			self::text_field( $metabox->id, $field );
		}
		self::close();
	}

	public function begin() {
		?>
		<table class="widefat">
		<?php
	}

	public static function text_field( $metabox, Metadata $args ) {
		?>
		<tr>
			<td>
				<p>
					<label for="<?php _e( $metabox . '[' . $args->get_id() . ']', 'cwg-ps' ); ?>">
						<?php _e( $args->get_name(), 'cwg-ps' ); ?>
					</label></p>
			</td>
			<td>
				<p>
					<input type="text" id="<?php _e( $args->get_id(), 'cwg-ps' ); ?>" class="wide-fat"
					       name="<?php _e(  $metabox . '[' . $args->get_id() . ']', 'cwg-ps' ); ?>"
					       value="<?php _e( $args->get_value(), 'cwg-ps' ); ?>"/></p>
			</td>
		</tr>
		<?php
	}

	public function close() {
		?>
		</table>
		<?php
	}

}