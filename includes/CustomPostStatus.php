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


class CustomPostStatus {

	/**
	 * Identification slug for the post status.
	 *
	 * Generated by ::set_name, and will usually be the $label attribute
	 * sanitized like a title.
	 *
	 * @var string
	 */
	public $slug;

	/**
	 * Name of the Post Status
	 *
	 * This is what is used for user display.
	 *
	 * @var string
	 */
	public $label;

	/**
	 * Array of arguments used to create the post status
	 *
	 * @var array
	 */
	protected $args;

	/**
	 * Array of post types that this is used with.
	 *
	 * @var array
	 */
	protected $post_types;

	/**
	 * Sets the name and label of the post status
	 *
	 * @param string $name
	 */
	public function set_name( $name ) {
		$this->label = $name;
		$this->slug  = sanitize_title_with_dashes( $name );
	}

	/**
	 * Adds a post type to the array
	 *
	 * @param string $name
	 */
	public function add_post_type( $name ) {
		$this->post_types[] = $name;
	}

	/**
	 * $sets the args.
	 *
	 * Does need to have an array supplied, but it can be useful.
	 * Will create its own args from the post status label if none
	 * are supplied
	 *
	 * @param array $args
	 *
	 * @return bool
	 */
	public function set_args( $args ) {
		if ( is_array( $args ) ) {
			$this->args = $args;

			return true;
		} else {

			return false;
		}
	}

	protected function create_args() {

		$args = array(
			'label'                     => _x( $this->label, 'post' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( $this->label . ' <span class="count">(%s)</span>', $this->label . ' <span class="count">(%s)</span>'
			)
		);

		$this->set_args( $args );

		return $this->args;
	}

	/**
	 * Sets up the plugin to run on the front end.
	 */
	public function register_post_status() {
		if ( ! isset( $this->slug ) ) {

			return;
		} elseif ( ! isset( $this->args ) ) {
			$this->args = $this->create_args();
		}
		$this->init();
	}

	/**
	 * Initializes things
	 */
	protected function init() {
		register_post_status( $this->slug, $this->args );
		add_action( 'admin_footer-post.php', array( $this, 'append_post_status_list' ) );
		add_action( 'admin_footer-post-new.php', array( $this, 'append_post_status_list' ) );
		add_filter( 'display_post_states', array( $this, 'display_state' ) );
	}

	/**
	 * Modifies the post status list
	 *
	 * Post Status. They suck. They're a pain in the ass to work with. So, here is
	 * a hacky, terrible way of making them work. Will it be broken in a future
	 * version? Hopefully.
	 *
	 * @return void
	 */
	public function append_post_status_list() {
		global $post;
		$complete = '';
		if ( $post->post_status === $this->slug ) {
			$complete = ' selected="selected"';
		}
		?>
		<script>
			jQuery(document).ready(function ($) {
				var currentPostStatus = '<?php _e( $post->post_status ); ?>',
					$slug = '<?php _e( $this->slug ); ?>',
					$name = '<?php _e( $this->label ); ?>',
					$selected = '<?php _e( $complete ); ?>',
					postStatus = $('#post_status'),
					savePost = $('#save-post'),
					saveCompleted = 'Save as ' + $name;
				postStatus.append('<option value="' + $slug + '"' + $selected + '>' + $name + '</option>');
				if (currentPostStatus == $slug) {
					savePost.val(saveCompleted);
					$('.misc-pub-post-status label').append('<span id="post-status-display"> ' + $name + '</span>');
				}
				$('a.save-post-status').on('click', function () {
					if ($('option:selected', postStatus).val() == $slug) {
						savePost.show().val(saveCompleted);
					}
				});
			});
		</script>
		<?php
	}

	/**
	 * Adds state of custom post status to posts page.
	 *
	 * @param array $states
	 *
	 * @return array
	 */
	public function display_state( $states ) {
		global $post;
		$arg = get_query_var( 'post_status' );
		if ( $arg != $this->slug ) {
			if ( $post->post_status == $this->slug ) {
				return array( $this->label );
			}
		}

		return $states;
	}
}