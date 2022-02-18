<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ES_Drag_And_Drop_Editor {

	public static $instance;

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

	public function enqueue_scripts() {

		if ( ! ES()->is_es_admin_screen() ) {
			return;
		}

		//Only for development - this branch only
		//wp_register_script( 'es_editor_js', 'http://localhost:9001/main.js', array(), time(), true );
		wp_register_script( 'es_editor_js', ES_PLUGIN_URL . 'lite/admin/js/editor.js', array( ), ES_PLUGIN_VERSION, true );
		wp_enqueue_script( 'es_editor_js' );
		wp_enqueue_media();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    4.0
	 */
	public function enqueue_styles() {

		if ( ! ES()->is_es_admin_screen() ) {
			return;
		}
		
		//wp_enqueue_style( 'es_editor_css', 'http://localhost:9000/main.css', array(), time(), 'all' );
		wp_enqueue_style( 'es_editor_css', ES_PLUGIN_URL . 'lite/admin/css/editor.css', array(), ES_PLUGIN_VERSION, 'all' );
	}

	public function es_draganddrop_callback() {
		?>
		<div class="mt-6 mr-6 p-2 rounded-lg border-dashed border bg-white">
			<div class="text-xl leading-relaxed ">
				<?php esc_html_e('How to use this?', 'email-subscribers'); ?>
			</div>
			<div class="text-sm">
				<?php esc_html_e('Create the content by dragging elements displayed on the right. After you are done click on "Export HTML" ', 'email-subscribers'); ?><span title="Export HTML " class="fa fa-download"></span>
				<?php esc_html_e(' to get your html content. Use it while sending campaigns.', 'email-subscribers'); ?>
			</div>
		</div>
		<div id="ig-es-dnd-builder"></div>
	   <?php
	}

	public function show_editor( $editor_args = array() ) {
		$editor_attributes = ! empty( $editor_args['attributes'] ) ? $editor_args['attributes'] : array();
		?>
		<div id="ig-es-dnd-builder"
			<?php
			if ( ! empty( $editor_attributes ) ) :
				foreach ( $editor_attributes as $arg_key => $arg_value ) :
					echo esc_attr( $arg_key ) . '="' . esc_attr( $arg_value ) . '" ';
				endforeach;
			endif;
			?>
		>
		</div>
		<?php
	}

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

ES_Drag_And_Drop_Editor::get_instance();
