<?php
/**
 * Product Showcase Widget
 *
 * Description.
 *
 * @link       URL
 * @since      1.0.0
 */
namespace ChrisWGerber\ProductShowcase;

Class ProductShowcaseWidget extends \WP_Widget {

	public function __construct() {
		parent::__construct(
			// Base ID of your widget
			'product_showcase_widget',
			// Widget name will appear in UI
			__( 'Product Showcase', 'cwg-ps' ),
			// Widget description
			array( 'description' => __( 'Showcase of the latest products', 'cwg-ps' ), )
		);
	}

	/**
	 * Creating widget front-end
	 *
	 * This is where the action happens
	 *
	 * @param $args
	 * @param $instance
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo $args['after_widget'];
	}

	/**
	 * Widget Backend
	 *
	 * @param $instance
	 */
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'New title', 'cwg-ps' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<?php
	}

	/**
	 * Updating widget replacing old instances with new
	 *
	 * @param $new_instance
	 * @param $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}