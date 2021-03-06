<?php
/**
 * A label-only Customizer control for use with Jetpack Search configuration
 *
 * @package automattic/jetpack
 * @since 8.6.0
 */

/**
 * Label Control class.
 */
class Label_Control extends WP_Customize_Control {
	/**
	 * Enqueue styles related to this control.
	 */
	public function enqueue() {
		$style_relative_path = 'modules/search/customize-controls/class-label-control.css';
		$style_version       = Automattic\Jetpack\Search\Helper::get_asset_version( $style_relative_path );
		$style_path          = plugins_url( $style_relative_path, JETPACK__PLUGIN_FILE );
		wp_enqueue_style( 'jetpack-instant-search-customizer-label', $style_path, array( 'customize-controls' ), $style_version );
	}

	/**
	 * Override rendering for custom class name; omit element ID.
	 */
	protected function render() {
		echo '<li class="customize-control customize-label-control">';
		$this->render_content();
		echo '</li>';
	}

	/**
	 * Override content rendering.
	 */
	protected function render_content() {
		if ( ! empty( $this->label ) ) : ?>
			<label class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</label>
		<?php endif; ?>
		<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description">
				<?php echo esc_html( $this->description ); ?>
			</span>
			<?php
		endif;
	}
}
