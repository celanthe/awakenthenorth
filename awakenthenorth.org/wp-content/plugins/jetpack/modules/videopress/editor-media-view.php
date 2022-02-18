<?php

use Automattic\Jetpack\Assets;

/**
 * WordPress Shortcode Editor View JS Code
 */
function videopress_handle_editor_view_js() {
	global $content_width;
	$current_screen = get_current_screen();
	if ( ! isset( $current_screen->id ) || $current_screen->base !== 'post' ) {
		return;
	}

	add_action( 'admin_print_footer_scripts', 'videopress_editor_view_js_templates' );

	wp_enqueue_style( 'videopress-editor-ui', plugins_url( 'css/editor.css', __FILE__ ) );
	wp_enqueue_script(
		'videopress-editor-view',
		Assets::get_file_url_for_environment(
			'_inc/build/videopress/js/editor-view.min.js',
			'modules/videopress/js/editor-view.js'
		),
		array( 'wp-util', 'jquery' ),
		false,
		true
	);
	wp_localize_script(
		'videopress-editor-view',
		'vpEditorView',
		array(
			'home_url_host'     => wp_parse_url( home_url(), PHP_URL_HOST ),
			'min_content_width' => VIDEOPRESS_MIN_WIDTH,
			'content_width'     => $content_width,
			'modal_labels'      => array(
				'title'     => esc_html__( 'VideoPress Shortcode', 'jetpack' ),
				'guid'      => esc_html__( 'Video ID', 'jetpack' ),
				'w'         => esc_html__( 'Video Width', 'jetpack' ),
				'w_unit'    => esc_html__( 'pixels', 'jetpack' ),
				/* Translators: example of usage of this is "Start Video After 10 seconds" */
				'at'        => esc_html__( 'Start Video After', 'jetpack' ),
				'at_unit'   => esc_html__( 'seconds', 'jetpack' ),
				'hd'        => esc_html__( 'High definition on by default', 'jetpack' ),
				'permalink' => esc_html__( 'Link the video title to its URL on VideoPress.com', 'jetpack' ),
				'autoplay'  => esc_html__( 'Autoplay video on page load', 'jetpack' ),
				'loop'      => esc_html__( 'Loop video playback', 'jetpack' ),
				'freedom'   => esc_html__( 'Use only Open Source codecs (may degrade performance)', 'jetpack' ),
				'flashonly' => esc_html__( 'Use legacy Flash Player (not recommended)', 'jetpack' ),
			),
		)
	);

	add_editor_style( plugins_url( 'css/videopress-editor-style.css', __FILE__ ) );
}
add_action( 'admin_notices', 'videopress_handle_editor_view_js' );

/**
 * WordPress Editor Views
 */
function videopress_editor_view_js_templates() {
	/**
	 * This template uses the following parameters, and displays the video as an iframe:
	 *  - data.guid     // The guid of the video.
	 *  - data.width    // The width of the iframe.
	 *  - data.height   // The height of the iframe.
	 *  - data.urlargs  // Arguments serialized into a get string.
	 *
	 * In addition, the calling script will need to ensure that the following
	 * JS file is added to the header of the editor iframe:
	 *  - https://s0.wp.com/wp-content/plugins/video/assets/js/next/videopress-iframe.js
	 */
	?>
	<script type="text/html" id="tmpl-videopress_iframe_vnext">
		<div class="tmpl-videopress_iframe_next" style="max-height:{{ data.height }}px;">
			<div class="videopress-editor-wrapper" style="padding-top:{{ data.ratio }}%;">
				<iframe style="display: block; max-width: 100%; max-height: 100%;" width="{{ data.width }}" height="{{ data.height }}" src="https://videopress.com/embed/{{ data.guid }}?{{ data.urlargs }}" frameborder='0' allowfullscreen></iframe>
			</div>
		</div>
	</script>
	<?php
}

/*************************************************\
| This is the chunk that handles overriding core  |
| media stuff so VideoPress can display natively. |
\*/

/**
 * Media Grid:
 * Filter out any videopress video posters that we've downloaded,
 * so that they don't seem to display twice.
 */
add_filter( 'ajax_query_attachments_args', 'videopress_ajax_query_attachments_args' );
function videopress_ajax_query_attachments_args( $args ) {
	$meta_query = array(
		array(
			'key'     => 'videopress_poster_image',
			'compare' => 'NOT EXISTS',
		),
	);

	// If there was already a meta query, let's AND it via
	// nesting it with our new one. No need to specify the
	// relation, as it defaults to AND.
	if ( ! empty( $args['meta_query'] ) ) {
		$meta_query[] = $args['meta_query'];
	}
	$args['meta_query'] = $meta_query;

	return $args;
}

/**
 * Media List:
 * Do the same as ^^ but for the list view.
 */
add_action( 'pre_get_posts', 'videopress_media_list_table_query' );
function videopress_media_list_table_query( $query ) {

	if (
		! function_exists( 'get_current_screen' )
		|| is_null( get_current_screen() )
	) {
		return;
	}

	if ( is_admin() && $query->is_main_query() && ( 'upload' === get_current_screen()->id ) ) {
		$meta_query = array(
			array(
				'key'     => 'videopress_poster_image',
				'compare' => 'NOT EXISTS',
			),
		);

		if ( $old_meta_query = $query->get( 'meta_query' ) ) {
			$meta_query[] = $old_meta_query;
		}

		$query->set( 'meta_query', $meta_query );
	}
}

/**
 * Make sure that any Video that has a VideoPress GUID passes that data back.
 */
add_filter( 'wp_prepare_attachment_for_js', 'videopress_prepare_attachment_for_js' );
function videopress_prepare_attachment_for_js( $post ) {
	if ( 'video' === $post['type'] ) {
		$guid = get_post_meta( $post['id'], 'videopress_guid' );
		if ( $guid ) {
			$post['videopress_guid'] = $guid;
		}
	}
	return $post;
}

/**
 * Wherever the Media Modal is deployed, also deploy our overrides.
 */
add_action( 'wp_enqueue_media', 'add_videopress_media_overrides' );
function add_videopress_media_overrides() {
	add_action( 'admin_print_footer_scripts', 'videopress_override_media_templates', 11 );
}

/**
 * Our video overrides!
 *
 * We have a template for the iframe to get injected.
 */
function videopress_override_media_templates() {
	?>
	<script type="text/html" id="tmpl-videopress_iframe_vnext">
		<iframe class="videopress-iframe" style="display: block; max-width: 100%; max-height: 100%;" width="{{ data.width }}" height="{{ data.height }}" src="https://videopress.com/embed/{{ data.guid }}?{{ data.urlargs }}" frameborder='0' allowfullscreen></iframe>
	</script>
	<script>
		(function( media ){
			// This handles the media library modal attachment details display.
			if ( 'undefined' !== typeof media.view.Attachment.Details.TwoColumn ) {
				var TwoColumn   = media.view.Attachment.Details.TwoColumn,
					old_render  = TwoColumn.prototype.render,
					vp_template = wp.template('videopress_iframe_vnext');

				TwoColumn.prototype.render = function() {
					// Have the original renderer run first.
					old_render.apply( this, arguments );

					// Now our stuff!
					if ( 'video' === this.model.get('type') ) {
						if ( this.model.get('videopress_guid') ) {
							this.$('.attachment-media-view .thumbnail-video').html( vp_template( {
								guid   : this.model.get('videopress_guid'),
								width  : this.model.get('width') > 0 ? this.model.get('width') : '100%',
								height : this.model.get('height') > 0 ? this.model.get('height') : '100%'
							}));
						}
					}
				};
			} else { /* console.log( 'media.view.Attachment.Details.TwoColumn undefined' ); */ }

			// This handles the recreating of the core video shortcode when editing the mce embed.
			if ( 'undefined' !== typeof media.video ) {
				media.video.defaults.videopress_guid = '';

				// For some reason, even though we're not currently changing anything, the following proxy
				// function is necessary to include the above default `videopress_guid` param. ¯\_(ツ)_/¯
				var old_video_shortcode = media.video.shortcode;
				media.video.shortcode = function( model ) {
					// model.videopress_guid = 'FOOBAR';
					return old_video_shortcode( model );
				};
			} else { /* console.log( 'media.video undefined' ); */ }

			// override the media modal in order to extend the escape method to unload the player on hide
			var BaseMediaModal = wp.media.view.Modal;

			wp.media.view.Modal = BaseMediaModal.extend( {
				escape: function () {
					BaseMediaModal.prototype.escape.apply( this );
					var playerIframe = document.getElementsByClassName( "videopress-iframe" )[0];
					playerIframe.parentElement.removeChild( playerIframe );
				}
			} );
		})( wp.media );
	</script>
	<?php
}

/**
 * Properly inject VideoPress data into Core shortcodes, and
 * generate videopress shortcodes for purely remote videos.
 */
add_filter( 'media_send_to_editor', 'videopress_media_send_to_editor', 10, 3 );
function videopress_media_send_to_editor( $html, $id, $attachment ) {
	$videopress_guid = get_post_meta( $id, 'videopress_guid', true );
	if ( $videopress_guid && videopress_is_valid_guid( $videopress_guid ) ) {
		if ( '[video ' === substr( $html, 0, 7 ) ) {
			$html = sprintf( '[videopress %1$s]', esc_attr( $videopress_guid ) );

		} elseif ( '<a href=' === substr( $html, 0, 8 ) ) {
			// We got here because `wp_attachment_is()` returned false for
			// video, because there isn't a local copy of the file.
			$html = sprintf( '[videopress %1$s]', esc_attr( $videopress_guid ) );
		}
	} elseif ( videopress_is_attachment_without_guid( $id ) ) {
		$html = sprintf( '[videopress postid=%d]', $id );
	}
	return $html;
}
