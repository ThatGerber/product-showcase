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

Class Widget extends \WP_Widget {

	/**
	 * @TODO     - Rename "widget-name" to the name your your widget
	 *
	 * Unique identifier for your widget.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * widget file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $widget_slug = 'product_showcase_widget';

	protected $fields = array(
		'title'          => array(
			'id' => 'title',
			'name' => 'Title:',
			'type' => 'text'
		),
		'displayType'    => 'select',
		'autoplaySpeed'  => 'text',
		'animationSpeed' => 'text',
	);

	/**
	 * PHP5 Constructor
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		parent::__construct(
		// Base ID of your widget
			$this->get_widget_slug(),
			// Widget name will appear in UI
			__( 'Product Showcase', 'cwg-ps' ),
			array( 'description' => __( 'Showcase of the Latest Products', 'cwg-ps' ), )
		);
	}

	/**
	 * Return the widget slug.
	 *
	 * @since 1.0.0
	 *
	 * @return string Plugin slug variable.
	 */
	public function get_widget_slug() {

		return $this->widget_slug;
	}

	/**
	 * Creating widget front-end
	 *
	 * This is where the action happens
	 *
	 * @TODO     Make this work
	 *
	 * @since    1.0.0
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
	 * @TODO     Make this work
	 *
	 * @since    1.0.0
	 *
	 * @param array $instance
	 *
	 * @return mixed
	 */
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'New title', 'cwg-ps' );
		}
		// Widget admin form
		$this->text_input( 'title', 'Title:', $title );
	}

	public function text_input( $id, $name, $value ) {
		?>
		<p>
			<label for="<?php echo $this->get_field_id( $id ); ?>"><?php _e( $name ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( $id ); ?>"
			       name="<?php echo $this->get_field_name( $id ); ?>" type="text"
			       value="<?php echo esc_attr( $value ); ?>"/>
		</p>
		<?php

	}

	/**
	 * Updating widget replacing old instances with new
	 *
	 * @TODO     Make this work
	 *
	 * @since    1.0.0
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

	protected function displayType() {

	}

}