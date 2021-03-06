<?php
/**
 * Uninstall My Calendar.
 *
 * @category Core
 * @package  My Calendar
 * @author   Joe Dolson
 * @license  GPLv2 or later
 * @link     https://www.joedolson.com/my-calendar/
 */

if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
} else {

	/**
	 * Delete all custom templates.
	 */
	function mc_delete_templates() {
		global $wpdb;
		$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . "options WHERE option_name LIKE '%mc_ctemplate_%'" );
		foreach ( $results as $result ) {
			$key = str_replace( 'mc_ctemplate_', '', $result->option_name );
			delete_option( "mc_template_desc_$key" );
			delete_option( "mc_ctemplate_$key" );
		}
		$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . "options WHERE option_name LIKE '%mc_category_icon_%'" );
		foreach ( $results as $result ) {
			delete_option( $result->option_name );
		}
	}

	if ( get_option( 'mc_drop_settings' ) === 'true' ) {
		delete_option( 'mc_can_manage_events' );
		delete_option( 'mc_style' );
		delete_option( 'mc_display_author' );
		delete_option( 'mc_display_host' );
		delete_option( 'mc_version' );
		delete_option( 'mc_use_styles' );
		delete_option( 'mc_show_months' );
		delete_option( 'mc_show_map' );
		delete_option( 'mc_show_address' );
		delete_option( 'mc_display_more' );
		delete_option( 'mc_today_template' );
		delete_option( 'mc_upcoming_template' );
		delete_option( 'mc_today_title' );
		delete_option( 'ko_calendar_imported' );
		delete_option( 'mc_show_heading' );
		delete_option( 'mc_listjs' );
		delete_option( 'mc_caljs' );
		delete_option( 'mc_calendar_javascript' );
		delete_option( 'mc_list_javascript' );
		delete_option( 'mc_minijs' );
		delete_option( 'mc_mini_javascript' );
		delete_option( 'mc_notime_text' );
		delete_option( 'mc_hosted_by' );
		delete_option( 'mc_posted_by' );
		delete_option( 'mc_event_accessibility' );
		delete_option( 'mc_hide_icons' );
		delete_option( 'mc_caption' );
		delete_option( 'mc_event_link_expires' );
		delete_option( 'mc_apply_color' );
		delete_option( 'mc_date_format' );
		delete_option( 'mc_no_events_text' );
		delete_option( 'mc_show_css' );
		delete_option( 'mc_apply_color' );
		delete_option( 'mc_next_events' );
		delete_option( 'mc_previous_events' );
		delete_option( 'mc_input_options' );
		delete_option( 'mc_input_options_administrators' );
		delete_option( 'mc_event_mail' );
		delete_option( 'mc_event_mail_subject' );
		delete_option( 'mc_event_mail_to' );
		delete_option( 'mc_event_mail_message' );
		delete_option( 'mc_event_mail_bcc' );
		delete_option( 'mc_event_approve' );
		delete_option( 'mc_event_approve_perms' );
		delete_option( 'mc_no_fifth_week' );
		delete_option( 'mc_user_settings' );
		delete_option( 'mc_ajaxjs' );
		delete_option( 'mc_ajax_javascript' );
		delete_option( 'mc_templates' );
		delete_option( 'mc_user_settings_enabled' );
		delete_option( 'mc_user_location_type' );
		delete_option( 'mc_show_js' );
		delete_option( 'mc_event_open' );
		delete_option( 'mc_event_closed' );
		delete_option( 'mc_event_registration' );
		delete_option( 'mc_short' );
		delete_option( 'mc_desc' );
		delete_option( 'mc_image' );
		delete_option( 'mc_location_type' );
		delete_option( 'mc_skip_holidays_category' );
		delete_option( 'mc_skip_holidays' );
		delete_option( 'mc_event_edit_perms' );
		delete_option( 'mc_css_file' );
		delete_option( 'mc_db_version' );
		delete_option( 'mc_stored_styles' );
		delete_option( 'mc_show_rss' );
		delete_option( 'mc_show_ical' );
		delete_option( 'mc_show_weekends' );
		delete_option( 'mc_convert' );
		delete_option( 'mc_uri' );
		delete_post_meta( get_option( 'mc_uri_id' ), '_mc_calendar' );
		delete_option( 'mc_uri_id' );
		delete_option( 'mc_location_control' );
		delete_option( 'mc_use_mini_template' );
		delete_option( 'mc_use_list_template' );
		delete_option( 'mc_calendar_location' );
		delete_option( 'mc_use_grid_template' );
		delete_option( 'mc_week_format' );
		delete_option( 'mc_time_format' );
		delete_option( 'mc_use_details_template' );
		delete_option( 'mc_details' );
		delete_option( 'mc_default_sort' );
		delete_option( 'mc_show_event_vcal' );
		delete_option( 'mc_caching_enabled' );
		delete_option( 'mc_week_caption' );
		delete_option( 'mc_show_print' );
		delete_option( 'mc_multisite_show' );
		delete_option( 'mc_mini_uri' );
		delete_option( 'mc_process_shortcodes' );
		delete_option( 'mc_remote' );
		delete_option( 'mc_convert' );
		delete_option( 'mc_day_uri' );
		delete_option( 'mc_draggable' );
		delete_option( 'mc_multisite' );
		delete_option( 'mc_open_day_uri' );
		delete_option( 'mc_open_uri' );
		delete_option( 'mc_show_list_info' );
		delete_option( 'mc_show_list_events' );
		delete_option( 'mc_event_link' );
		delete_option( 'mc_default_category' );
		delete_option( 'mc_inverse_color' );
		delete_option( 'mc_bottomnav' );
		delete_option( 'mc_topnav' );
		delete_option( 'mc_ical_utc' );
		delete_option( 'mc_event_title_template' );
		delete_option( 'mc_location_controls' );
		delete_option( 'mc_location_access' );
		delete_option( 'mc_event_access' );
		delete_option( 'mc_modified_feeds' );
		delete_option( 'mc_use_permalinks' );
		delete_option( 'mc_event_groups' );
		delete_option( 'mc_api_enabled' );
		delete_option( 'mc_use_custom_js' );
		delete_option( 'mc_update_notice' );
		delete_option( 'mc_default_direction' );
		delete_option( 'mc_default_admin_view' );
		delete_option( 'mc_count_cache' );
		delete_option( 'mc_default_location' );
		delete_option( 'mc_gmap_api_key' );
		delete_option( 'mc_locations_transitioned' );
		delete_option( 'mc_style_vars' );
		delete_option( 'mc_display_single' );
		delete_option( 'mc_display_mini' );
		delete_option( 'mc_display_main' );
		delete_option( 'mc_multiple_categories' );
		delete_option( 'mc_no_link' );
		delete_option( 'mc_buy_tickets' );
		delete_option( 'mc_view_full' );
		delete_option( 'mc_month_format' );
		delete_option( 'mc_multidate_format' );
		delete_option( 'mc_cpt_base' );
		delete_option( 'mc_location_cpt_base' );
		// Deletes custom template options.
		mc_delete_templates();
	}
	if ( get_option( 'mc_drop_tables' ) === 'true' ) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->posts . ' WHERE post_type = %s', 'mc-events' ) );
		$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->posts . ' WHERE post_type = %s', 'mc-locations' ) );
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'my_calendar' );
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'my_calendar_events' );
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'my_calendar_categories' );
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'my_calendar_category_relationships' );
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'my_calendar_locations' );
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'my_calendar_location_relationships' );
	}
	if ( get_option( 'mc_drop_settings' ) === 'true' ) {
		delete_option( 'mc_drop_tables' );
		delete_option( 'mc_drop_settings' );
	}

	add_option( 'mc_uninstalled', 'true' );
}
