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

	/**
	 * @var string
	 */
	public $metabox_id;

	/**
	 * @param string $metabox_id
	 * @param array  $meta_data
	 */
	public function __construct( $metabox_id, Array $meta_data ) {
		$this->metabox_id = $metabox_id;

		$this->begin();
		foreach ( $meta_data as $name => $field ) {
			$this->create_field( $field );
		}
		self::close();
	}

	public function begin() {
		?>
		<table class="widefat">
		<?php
	}

	public function create_field( Metadata $metadata ) {
		call_user_func_array(
			array( $this, "{$metadata->get_type()}_field" ),
			array( $this->metabox_id, $metadata )
		);
	}

	/**
	 * @param string   $metabox_id
	 * @param Metadata $args
	 */
	public static function text_field( $metabox_id, Metadata $args ) {
		?>
		<tr>
			<td>
				<p>
					<label for="<?php _e( $metabox_id . '[' . $args->get_id() . ']', 'cwg-ps' ); ?>">
						<?php _e( $args->get_name(), 'cwg-ps' ); ?>
					</label></p>
			</td>
			<td>
				<p>
					<input type="text" id="<?php _e( $args->get_id(), 'cwg-ps' ); ?>"
					       class="regular-text"
					       name="<?php _e( $metabox_id . '[' . $args->get_id() . ']', 'cwg-ps' ); ?>"
					       value="<?php _e( $args->get_value(), 'cwg-ps' ); ?>"/></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * @param string   $metabox_id
	 * @param Metadata $args
	 */
	public static function datepicker_field( $metabox_id, Metadata $args ) {
		$value = date( 'Y-m-d', strtotime( ( null != $args->get_value() ? $args->get_value() : 'mm/dd/yyyy' ) ) );
		?>
		<tr>
			<td>
				<p>
					<label for="<?php _e( $metabox_id . '[' . $args->get_id() . ']', 'cwg-ps' ); ?>">
						<?php _e( $args->get_name(), 'cwg-ps' ); ?>
					</label></p>
			</td>
			<td>
				<p>
					<input type="date" id="<?php _e( $args->get_id(), 'cwg-ps' ); ?>"
					       class="regular-text"
					       name="<?php _e( $metabox_id . '[' . $args->get_id() . ']', 'cwg-ps' ); ?>"
					       value="<?php _e( $value, 'cwg-ps' ); ?>"/></p>
			</td>
		</tr>
		<?php
	}

	/**
	 *
	 */
	protected function close() {
		?>
		</table>
		<?php
	}

}