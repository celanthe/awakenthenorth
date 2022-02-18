<?php
/**
 * Navigation Output. Functions that generate elements of the My Calendar navigation.
 *
 * @category Output
 * @package  My Calendar
 * @author   Joe Dolson
 * @license  GPLv2 or later
 * @link     https://www.joedolson.com/my-calendar/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create navigation elements used in My Calendar main view
 *
 * @param array  $params Calendar parameters (modified).
 * @param int    $cat Original category from calendar args.
 * @param int    $start_of_week First day of week.
 * @param int    $show_months num months to show (modified).
 * @param string $main_class Class/ID.
 * @param int    $site Which site in multisite.
 * @param string $date current date.
 * @param string $from date view started from.
 *
 * @return array of calendar nav for top & bottom
 */
function mc_generate_calendar_nav( $params, $cat, $start_of_week, $show_months, $main_class, $site, $date, $from ) {
	if ( $site ) {
		$site    = ( 'global' === $site ) ? BLOG_ID_CURRENT_SITE : $site;
		$restore = $site;
		restore_current_blog();
	}
	$format   = $params['format'];
	$category = $params['category'];
	$above    = $params['above'];
	$below    = $params['below'];
	$time     = $params['time'];
	$ltype    = $params['ltype'];
	$lvalue   = $params['lvalue'];

	if ( 'none' === $above && 'none' === $below ) {
		return array(
			'bottom' => '',
			'top'    => '',
		);
	}

	// Fallback values.
	$mc_toporder    = array( 'nav', 'toggle', 'jump', 'print', 'timeframe' );
	$mc_bottomorder = array( 'key', 'feeds' );
	$available      = array( 'nav', 'toggle', 'jump', 'print', 'timeframe', 'key', 'feeds', 'exports', 'categories', 'locations', 'access', 'search' );

	if ( 'none' === $above ) {
		$mc_toporder = array();
	} else {
		// Set up above-calendar order of fields.
		if ( '' !== get_option( 'mc_topnav', '' ) ) {
			$mc_toporder = array_map( 'trim', explode( ',', get_option( 'mc_topnav' ) ) );
		}

		if ( '' !== $above ) {
			$mc_toporder = array_map( 'trim', explode( ',', $above ) );
		}
	}

	if ( 'none' === $below ) {
		$mc_bottomorder = array();
	} else {
		if ( '' !== get_option( 'mc_bottomnav', '' ) ) {
			$mc_bottomorder = array_map( 'trim', explode( ',', get_option( 'mc_bottomnav' ) ) );
		}

		if ( '' !== $below ) {
			$mc_bottomorder = array_map( 'trim', explode( ',', $below ) );
		}
	}

	$aboves = $mc_toporder;
	$belows = $mc_bottomorder;
	$used   = array_merge( $aboves, $belows );

	// Define navigation element strings.
	$timeframe    = '';
	$print        = '';
	$toggle       = '';
	$nav          = '';
	$feeds        = '';
	$exports      = '';
	$jump         = '';
	$mc_topnav    = '';
	$mc_bottomnav = '';

	// Setup link data.
	$add = array(
		'time'   => $time,
		'ltype'  => $ltype,
		'lvalue' => $lvalue,
		'mcat'   => $category,
		'yr'     => $date['year'],
		'month'  => $date['month'],
		'dy'     => $date['day'],
		'href'   => ( isset( $params['self'] ) && esc_url( $params['self'] ) ) ? urlencode( $params['self'] ) : urlencode( mc_get_current_url() ),
	);

	if ( 'list' === $format ) {
		$add['format'] = 'list';
	}

	$subtract = array();
	if ( '' === $ltype ) {
		$subtract[] = 'ltype';
		unset( $add['ltype'] );
	}

	if ( '' === $lvalue ) {
		$subtract[] = 'lvalue';
		unset( $add['lvalue'] );
	}

	if ( 'all' === $category ) {
		$subtract[] = 'mcat';
		unset( $add['mcat'] );
	}

	// Set up print link.
	if ( in_array( 'print', $used, true ) ) {
		$print_add    = array_merge( $add, array( 'cid' => 'mc-print-view' ) );
		$mc_print_url = mc_build_url( $print_add, $subtract, home_url() );
		$print        = "<div class='mc-print'><a href='$mc_print_url'>" . __( 'Print<span class="maybe-hide"> View</span>', 'my-calendar' ) . '</a></div>';
	}

	// Set up format toggle.
	$toggle = ( in_array( 'toggle', $used, true ) ) ? mc_format_toggle( $format, 'yes', $time ) : '';

	// Set up time toggle.
	if ( in_array( 'timeframe', $used, true ) ) {
		$timeframe = mc_time_toggle( $format, $time, $date['month'], $date['year'], $date['current_date'], $start_of_week, $from );
	}

	// Set up category key.
	$key = ( in_array( 'key', $used, true ) ) ? mc_category_key( $cat ) : '';

	// Set up category filter.
	$cat_args   = array(
		'categories',
		'id' => $main_class . '-categories',
	);
	$categories = ( in_array( 'categories', $used, true ) ) ? mc_filters( $cat_args, mc_get_current_url() ) : '';

	// Set up location filter.
	$loc_args  = array(
		'locations',
		'id' => $main_class . '-locations',
	);
	$locations = ( in_array( 'locations', $used, true ) ) ? mc_filters( $loc_args, mc_get_current_url(), 'name' ) : '';

	// Set up access filter.
	$acc_args = array(
		'access',
		'id' => $main_class . '-access',
	);
	$access   = ( in_array( 'access', $used, true ) ) ? mc_filters( $acc_args, mc_get_current_url() ) : '';

	// Set up search.
	$search = ( in_array( 'access', $used, true ) ) ? my_calendar_searchform( 'simple', mc_get_current_url() ) : '';

	// Set up navigation links.
	if ( in_array( 'nav', $used, true ) ) {
		$nav = mc_nav( $date, $format, $time, $show_months, $main_class );
	}

	// Set up subscription feeds.
	if ( in_array( 'feeds', $used, true ) ) {
		$feeds = mc_sub_links( $subtract );
	}

	// Set up exports.
	if ( in_array( 'exports', $used, true ) ) {
		$ical_m    = ( isset( $_GET['month'] ) ) ? (int) $_GET['month'] : mc_date( 'n' );
		$ical_y    = ( isset( $_GET['yr'] ) ) ? (int) $_GET['yr'] : mc_date( 'Y' );
		$next_link = my_calendar_next_link( $date, $format, $time, $show_months );
		$exports   = mc_export_links( $ical_y, $ical_m, $next_link, $add, $subtract );
	}

	// Set up date switcher.
	if ( in_array( 'jump', $used, true ) ) {
		$jump = mc_date_switcher( $format, $main_class, $time, $date );
	}

	$mc_toporder = apply_filters( 'mc_header_navigation', $mc_toporder, $used, $params );
	foreach ( $mc_toporder as $value ) {
		if ( 'none' !== $value && in_array( $value, $used, true ) && in_array( $value, $available, true ) ) {
			$value      = trim( $value );
			$mc_topnav .= ${$value};
		}
	}

	$mc_bottomorder = apply_filters( 'mc_footer_navigation', $mc_bottomorder, $used, $params );
	foreach ( $mc_bottomorder as $value ) {
		if ( 'none' !== $value && 'stop' !== $value && in_array( $value, $used, true ) && in_array( $value, $available, true ) ) {
			$value         = trim( $value );
			$mc_bottomnav .= ${$value};
		}
	}

	if ( '' !== $mc_topnav ) {
		$mc_topnav = PHP_EOL . '<nav aria-label="' . __( 'Calendar (top)', 'my-calendar' ) . '">' . PHP_EOL . '<div class="my-calendar-header">' . $mc_topnav . '</div>' . PHP_EOL . '</nav>' . PHP_EOL;
	}

	if ( '' !== $mc_bottomnav ) {
		$mc_bottomnav = PHP_EOL . '<nav aria-label="' . __( 'Calendar (bottom)', 'my-calendar' ) . '">' . PHP_EOL . '<div class="mc_bottomnav my-calendar-footer">' . $mc_bottomnav . '</div>' . PHP_EOL . '</nav>' . PHP_EOL;
	}

	if ( $site ) {
		switch_to_blog( $restore );
	}

	return array(
		'bottom' => $mc_bottomnav,
		'top'    => $mc_topnav,
	);
}

/**
 * Generate calendar navigation
 *
 * @param string $date Current date.
 * @param string $format Current format.
 * @param string $time Current time view.
 * @param int    $show_months Num months to show.
 * @param string $id view ID.
 *
 * @return string prev/next nav.
 */
function mc_nav( $date, $format, $time, $show_months, $id ) {
	$prev      = my_calendar_prev_link( $date, $format, $time, $show_months );
	$next      = my_calendar_next_link( $date, $format, $time, $show_months );
	$prev_link = mc_build_url(
		array(
			'yr'    => $prev['yr'],
			'month' => $prev['month'],
			'dy'    => $prev['day'],
			'cid'   => $id,
		),
		array()
	);
	$prev_link = mc_url_in_loop( $prev_link );
	$next_link = mc_build_url(
		array(
			'yr'    => $next['yr'],
			'month' => $next['month'],
			'dy'    => $next['day'],
			'cid'   => $id,
		),
		array()
	);
	$next_link = mc_url_in_loop( $next_link );

	$prev_link = apply_filters( 'mc_previous_link', '<li class="my-calendar-prev"><a href="' . $prev_link . '" rel="nofollow" class="mcajax">' . $prev['label'] . '</a></li>', $prev );
	$next_link = apply_filters( 'mc_next_link', '<li class="my-calendar-next"><a href="' . $next_link . '" rel="nofollow" class="mcajax">' . $next['label'] . '</a></li>', $next );

	$nav = '
		<div class="my-calendar-nav">
			<ul>
				' . $prev_link . $next_link . '
			</ul>
		</div>';

	return $nav;
}

/**
 * Show the list of categories on the calendar
 *
 * @param int $category the currently selected category.
 *
 * @return string HTML for category key
 */
function mc_category_key( $category ) {
	global $wpdb;
	$url  = plugin_dir_url( __FILE__ );
	$mcdb = $wpdb;
	if ( 'true' === get_option( 'mc_remote' ) && function_exists( 'mc_remote_db' ) ) {
		$mcdb = mc_remote_db();
	}
	$has_icons       = ( 'true' === get_option( 'mc_hide_icons' ) ) ? false : true;
	$class           = ( $has_icons ) ? 'has-icons' : 'no-icons';
	$key             = '';
	$cat_limit       = mc_select_category( $category, 'all', 'category' );
	$select_category = str_replace( 'AND', 'WHERE', ( isset( $cat_limit[1] ) ) ? $cat_limit[1] : '' );

	$sql        = 'SELECT * FROM ' . my_calendar_categories_table() . " $select_category ORDER BY category_name ASC";
	$categories = $mcdb->get_results( $sql );
	$key       .= '<div class="category-key ' . $class . '"><h3 class="maybe-hide">' . __( 'Categories', 'my-calendar' ) . "</h3>\n<ul>\n";
	$path       = ( mc_is_custom_icon() ) ? str_replace( 'my-calendar', 'my-calendar-custom', $url ) : plugins_url( 'images/icons', __FILE__ ) . '/';

	foreach ( $categories as $cat ) {
		$class = '';
		// Don't display private categories to public users.
		if ( mc_private_event( $cat ) ) {
			continue;
		}
		$hex   = ( 0 !== strpos( $cat->category_color, '#' ) ) ? '#' : '';
		$class = mc_category_class( $cat, '' );

		$selected_categories = ( empty( $_GET['mcat'] ) ) ? array() : explode( ',', $_GET['mcat'] );

		if ( in_array( $cat->category_id, $selected_categories, true ) || $category === $cat->category_id ) {
			$selected_categories = array_diff( $selected_categories, array( $cat->category_id ) );
			$class              .= ' current';
			$aria_current        = 'aria-current="true"';
		} else {
			$selected_categories[] = $cat->category_id;
			$aria_current          = '';
		}
		$selectable_categories = implode( ',', $selected_categories );
		if ( '' === $selectable_categories ) {
			$url = remove_query_arg( 'mcat', mc_get_current_url() );
		} else {
			$url = mc_build_url( array( 'mcat' => $selectable_categories ), array( 'mcat' ) );
		}
		$url = mc_url_in_loop( $url );
		if ( 1 === (int) $cat->category_private ) {
			$class .= ' private';
		}
		$cat_name = mc_kses_post( stripcslashes( $cat->category_name ) );
		$cat_name = ( '' === $cat_name ) ? '<span class="screen-reader-text">' . __( 'Untitled Category', 'my-calendar' ) . '</span>' : $cat_name;
		$cat_key  = '';
		if ( '' !== $cat->category_icon && $has_icons ) {
			$image    = mc_category_icon( $cat );
			$type     = ( stripos( $image, 'svg' ) ) ? 'svg' : 'img';
			$back     = ( 'default' !== get_option( 'mc_apply_color' ) ) ? ' style="background:' . $hex . $cat->category_color . ';"' : '';
			$cat_key .= '<span class="category-color-sample ' . $type . '"' . $back . '>' . $image . '</span>' . $cat_name;
		} elseif ( 'default' !== get_option( 'mc_apply_color' ) ) {
			$cat_key .= ( ( '' !== $cat->category_color ) ? '<span class="category-color-sample no-icon" style="background:' . $hex . $cat->category_color . ';"> &nbsp; </span>' : '' ) . $cat_name;
		} else {
			// If category colors are ignored, don't render HTML for them.
			$cat_key .= $cat_name;
		}
		$key .= '<li class="cat_' . $class . '"><a href="' . esc_url( $url ) . '" class="mcajax"' . $aria_current . '>' . $cat_key . '</a></li>';
	}
	if ( isset( $_GET['mcat'] ) ) {
		$key .= "<li class='all-categories'><a href='" . esc_url( mc_url_in_loop( mc_build_url( array(), array( 'mcat' ), mc_get_current_url() ) ) ) . "' class='mcajax'>" . apply_filters( 'mc_text_all_categories', __( 'All Categories', 'my-calendar' ) ) . '</a></li>';
	}
	$key .= '</ul></div>';
	$key  = apply_filters( 'mc_category_key', $key, $categories );

	return $key;
}

/**
 * Set up subscription links for calendar
 *
 * @param array $subtract Array of data to remove.
 *
 * @return string HTML output for subscription links
 */
function mc_sub_links( $subtract ) {

	$google  = get_feed_link( 'my-calendar-google' );
	$outlook = get_feed_link( 'my-calendar-outlook' );

	$sub_google  = "<li class='ics google'><a href='" . esc_url( $google ) . "'>" . __( '<span class="maybe-hide">Subscribe in </span>Google', 'my-calendar' ) . '</a></li>';
	$sub_outlook = "<li class='ics outlook'><a href='" . esc_url( $outlook ) . "'>" . __( '<span class="maybe-hide">Subscribe in </span>Outlook', 'my-calendar' ) . '</a></li>';

	$output = "<div class='mc-export mc-subscribe'>
	<ul>$sub_google$sub_outlook</ul>
</div>";

	return $output;
}

/**
 * Generate links to export current view's dates.
 *
 * @param string $y year.
 * @param string $m month.
 * @param array  $next array of next view's dates.
 * @param array  $add params to add to link.
 * @param array  $subtract params to subtract from links.
 *
 * @return string HTML output for export links.
 */
function mc_export_links( $y, $m, $next, $add, $subtract ) {
	$add['yr']     = $y;
	$add['month']  = $m;
	$add['nyr']    = $next['yr'];
	$add['nmonth'] = $next['month'];
	unset( $add['href'] );

	$add['export'] = 'google';
	$ics           = mc_build_url( $add, $subtract, get_feed_link( 'my-calendar-ics' ) );
	$add['export'] = 'outlook';
	$ics2          = mc_build_url( $add, $subtract, get_feed_link( 'my-calendar-ics' ) );

	$google  = "<li class='ics google'><a href='" . $ics . "'>" . __( '<span class="maybe-hide">Export for </span>Google', 'my-calendar' ) . '</a></li>';
	$outlook = "<li class='ics outlook'><a href='" . $ics2 . "'>" . __( '<span class="maybe-hide">Export for </span>Outlook', 'my-calendar' ) . '</a></li>';

	$output = "<div class='mc-export mc-download'>
	<ul>$google$outlook</ul>
</div>";

	return $output;
}

/**
 * Set up next link based on current view
 *
 * @param array  $date Current date of view.
 * @param string $format of calendar.
 * @param string $time current time view.
 * @param int    $months number of months shown in list views.
 *
 * @return string array of parameters for link
 */
function my_calendar_next_link( $date, $format, $time = 'month', $months = 1 ) {
	$cur_year  = $date['year'];
	$cur_month = $date['month'];
	$cur_day   = $date['day'];

	$next_year   = $cur_year + 1;
	$mc_next     = get_option( 'mc_next_events', '' );
	$next_events = ( '' === $mc_next ) ? '<span class="maybe-hide">' . __( 'Next', 'my-calendar' ) . '</span>' : stripslashes( $mc_next );
	if ( $months <= 1 || 'list' !== $format ) {
		if ( 12 === (int) $cur_month ) {
			$month = 1;
			$yr    = $next_year;
		} else {
			$next_month = $cur_month + 1;
			$month      = $next_month;
			$yr         = $cur_year;
		}
	} else {
		$next_month = ( ( $cur_month + $months ) > 12 ) ? ( ( $cur_month + $months ) - 12 ) : ( $cur_month + $months );
		if ( $cur_month >= ( 13 - $months ) ) {
			$month = $next_month;
			$yr    = $next_year;
		} else {
			$month = $next_month;
			$yr    = $cur_year;
		}
	}
	$day = '';
	if ( (int) $yr !== (int) $cur_year ) {
		$format = apply_filters( 'mc_month_year_format', 'F, Y', $date, $format, $time, $month );
	} else {
		$format = apply_filters( 'mc_month_format', 'F, Y', $date, $format, $time, $month );
	}
	$date = date_i18n( $format, mktime( 0, 0, 0, $month, 1, $yr ) );
	if ( 'week' === $time ) {
		$nextdate = strtotime( "$cur_year-$cur_month-$cur_day" . '+ 7 days' );
		$day      = mc_date( 'd', $nextdate, false );
		$yr       = mc_date( 'Y', $nextdate, false );
		$month    = mc_date( 'm', $nextdate, false );
		if ( (int) $yr !== (int) $cur_year ) {
			$format = 'F j, Y';
		} else {
			$format = 'F j';
		}
		// Translators: Current formatted date.
		$date = sprintf( __( 'Week of %s', 'my-calendar' ), date_i18n( $format, mktime( 0, 0, 0, $month, $day, $yr ) ) );
	}
	if ( 'day' === $time ) {
		$nextdate = strtotime( "$cur_year-$cur_month-$cur_day" . '+ 1 days' );
		$day      = mc_date( 'd', $nextdate, false );
		$yr       = mc_date( 'Y', $nextdate, false );
		$month    = mc_date( 'm', $nextdate, false );
		if ( (int) $yr !== (int) $cur_year ) {
			$format = 'F j, Y';
		} else {
			$format = 'F j';
		}
		$date = date_i18n( $format, mktime( 0, 0, 0, $month, $day, $yr ) );
	}
	$next_events = str_replace( '{date}', $date, $next_events );
	$output      = array(
		'month' => $month,
		'yr'    => $yr,
		'day'   => $day,
		'label' => $next_events,
	);

	return $output;
}

/**
 * Set up prev link based on current view
 *
 * @param array  $date Current date of view.
 * @param string $format of calendar.
 * @param string $time current time view.
 * @param int    $months number of months shown in list views.
 *
 * @return string array of parameters for link
 */
function my_calendar_prev_link( $date, $format, $time = 'month', $months = 1 ) {
	$cur_year  = $date['year'];
	$cur_month = $date['month'];
	$cur_day   = $date['day'];

	$last_year       = $cur_year - 1;
	$mc_previous     = get_option( 'mc_previous_events', '' );
	$previous_events = ( '' === $mc_previous ) ? '<span class="maybe-hide">' . __( 'Previous', 'my-calendar' ) . '</span>' : stripslashes( $mc_previous );
	if ( $months <= 1 || 'list' !== $format ) {
		if ( 1 === (int) $cur_month ) {
			$month = 12;
			$yr    = $last_year;
		} else {
			$next_month = $cur_month - 1;
			$month      = $next_month;
			$yr         = $cur_year;
		}
	} else {
		$next_month = ( $cur_month > $months ) ? ( $cur_month - $months ) : ( ( $cur_month - $months ) + 12 );
		if ( $cur_month <= $months ) {
			$month = $next_month;
			$yr    = $last_year;
		} else {
			$month = $next_month;
			$yr    = $cur_year;
		}
	}
	if ( (int) $yr !== (int) $cur_year ) {
		$format = apply_filters( 'mc_month_year_format', 'F, Y', $date, $format, $time, $month );
	} else {
		$format = apply_filters( 'mc_month_format', 'F, Y', $date, $format, $time, $month );
	}
	$date = date_i18n( $format, mktime( 0, 0, 0, $month, 1, $yr ) );
	$day  = '';
	if ( 'week' === $time ) {
		$prevdate = strtotime( "$cur_year-$cur_month-$cur_day" . '- 7 days' );
		$day      = mc_date( 'd', $prevdate, false );
		$yr       = mc_date( 'Y', $prevdate, false );
		$month    = mc_date( 'm', $prevdate, false );
		if ( (int) $yr !== (int) $cur_year ) {
			$format = 'F j, Y';
		} else {
			$format = 'F j';
		}
		$date = __( 'Week of ', 'my-calendar' ) . date_i18n( $format, mktime( 0, 0, 0, $month, $day, $yr ) );
	}
	if ( 'day' === $time ) {
		$prevdate = strtotime( "$cur_year-$cur_month-$cur_day" . '- 1 days' );
		$day      = mc_date( 'd', $prevdate, false );
		$yr       = mc_date( 'Y', $prevdate, false );
		$month    = mc_date( 'm', $prevdate, false );
		if ( (int) $yr !== (int) $cur_year ) {
			$format = 'F j, Y';
		} else {
			$format = 'F j';
		}
		$date = date_i18n( $format, mktime( 0, 0, 0, $month, $day, $yr ) );
	}
	$previous_events = str_replace( '{date}', $date, $previous_events );
	$output          = array(
		'month' => $month,
		'yr'    => $yr,
		'day'   => $day,
		'label' => $previous_events,
	);

	return $output;
}

/**
 * Generate filters form to limit calendar events.
 *
 * @param array  $args can include 'categories', 'locations' and 'access' to define individual filters.
 * @param string $target_url Where to send queries.
 * @param string $ltype Which type of location data to show in form.
 *
 * @return string HTML output of form
 */
function mc_filters( $args, $target_url, $ltype = 'name' ) {
	$id = ( isset( $args['id'] ) ) ? esc_attr( $args['id'] ) : 'mc_filters';
	if ( isset( $args['id'] ) ) {
		unset( $args['id'] );
	}
	if ( ! is_array( $args ) ) {
		$fields = explode( ',', $args );
	} else {
		$fields = $args;
	}
	if ( empty( $fields ) ) {
		return;
	}
	$has_multiple = ( count( $fields ) > 1 ) ? true : false;
	$return       = false;

	$current_url = mc_get_uri();
	$current_url = ( '' !== $target_url && esc_url( $target_url ) ) ? $target_url : $current_url;
	$class       = ( $has_multiple ) ? 'mc-filters-form' : 'mc-' . esc_attr( $fields[0] ) . '-switcher';
	$form        = "
	<div id='$id' class='mc_filters'>
		<form action='" . esc_url( $current_url ) . "' method='get' class='$class'>\n";
	$qsa         = array();
	if ( isset( $_SERVER['QUERY_STRING'] ) ) {
		parse_str( $_SERVER['QUERY_STRING'], $qsa );
	}
	if ( ! isset( $_GET['cid'] ) ) {
		$form .= '<input type="hidden" name="cid" value="all" />';
	}
	foreach ( $qsa as $name => $argument ) {
		$name = esc_attr( strip_tags( $name ) );
		if ( ! ( 'access' === $name || 'mcat' === $name || 'loc' === $name || 'ltype' === $name || 'mc_id' === $name || 'legacy-widget-preview' === $name ) ) {
			$argument = ( ! is_string( $argument ) ) ? (string) $argument : $argument;
			$argument = esc_attr( strip_tags( $argument ) );
			$form    .= '<input type="hidden" name="' . $name . '" value="' . $argument . '" />' . "\n";
		}
	}
	$key = __( 'Choose Filters', 'my-calendar' );
	foreach ( $fields as $show ) {
		$show = trim( $show );
		switch ( $show ) {
			case 'categories':
				$cats   = my_calendar_categories_list( 'form', 'public', 'group' );
				$form  .= $cats;
				$return = ( $cats || $return ) ? true : false;
				$key    = __( 'Categories', 'my-calendar' );
				break;
			case 'locations':
				$locs   = my_calendar_locations_list( 'form', $ltype, 'group' );
				$form  .= $locs;
				$return = ( $locs || $return ) ? true : false;
				$key    = __( 'Locations', 'my-calendar' );
				break;
			case 'access':
				$access = mc_access_list( 'form', 'group' );
				$form  .= $access;
				$return = ( $access || $return ) ? true : false;
				$key    = __( 'Accessibility Services', 'my-calendar' );
				break;
		}
	}
	$label = ( $has_multiple ) ? __( 'Filter Events', 'my-calendar' ) : $key;
	$form .= '<p><input type="submit" class="button" data-href="' . esc_url( $current_url ) . '" value="' . esc_attr( $label ) . '" /></p>
	</form></div>';
	if ( $return ) {
		return $form;
	}

	return '';
}

/**
 * Generate select form of categories for filters.
 *
 * @param string $show type of view.
 * @param string $context Public or admin.
 * @param string $group single form or part of a field group.
 * @param string $target_url Where to post form to.
 *
 * @return string HTML
 */
function my_calendar_categories_list( $show = 'list', $context = 'public', $group = 'single', $target_url = '' ) {
	global $wpdb;
	$mcdb = $wpdb;

	if ( 'true' === get_option( 'mc_remote' ) && function_exists( 'mc_remote_db' ) ) {
		$mcdb = mc_remote_db();
	}

	$output      = '';
	$current_url = mc_get_uri();
	$current_url = ( '' !== $target_url && esc_url( $target_url ) ) ? $target_url : $current_url;

	$name         = ( 'public' === $context ) ? 'mcat' : 'category';
	$admin_fields = ( 'public' === $context ) ? ' name="' . $name . '"' : ' multiple="multiple" size="5" name="' . $name . '[]"  ';
	$admin_label  = ( 'public' === $context ) ? '' : __( '(select to include)', 'my-calendar' );
	$form         = ( 'single' === $group ) ? '<form action="' . esc_url( $current_url ) . '" method="get">
				<div>' : '';
	if ( 'single' === $group ) {
		$qsa = array();
		if ( isset( $_SERVER['QUERY_STRING'] ) ) {
			parse_str( $_SERVER['QUERY_STRING'], $qsa );
		}
		if ( ! isset( $_GET['cid'] ) ) {
			$form .= '<input type="hidden" name="cid" value="all" />';
		}
		foreach ( $qsa as $name => $argument ) {
			$name     = esc_attr( strip_tags( $name ) );
			$argument = esc_attr( strip_tags( $argument ) );
			if ( 'mcat' !== $name || 'mc_id' !== $name ) {
				$form .= '		<input type="hidden" name="' . $name . '" value="' . $argument . '" />' . "\n";
			}
		}
	}
	$form       .= ( 'list' === $show || 'group' === $group ) ? '' : '
		</div><p>';
	$public_form = ( 'public' === $context ) ? $form : '';
	if ( ! is_user_logged_in() ) {
		$categories = $mcdb->get_results( 'SELECT * FROM ' . my_calendar_categories_table() . ' WHERE category_private = 0 ORDER BY category_name ASC' );
	} else {
		$categories = $mcdb->get_results( 'SELECT * FROM ' . my_calendar_categories_table() . ' ORDER BY category_name ASC' );
	}
	if ( ! empty( $categories ) && count( $categories ) >= 1 ) {
		$output  = ( 'single' === $group ) ? "<div id='mc_categories'>\n" : '';
		$url     = mc_build_url( array( 'mcat' => 'all' ), array() );
		$output .= ( 'list' === $show ) ? "
		<ul>
			<li><a href='$url'>" . __( 'All Categories', 'my-calendar' ) . '</a></li>' : $public_form . '
			<label for="category">' . __( 'Categories', 'my-calendar' ) . ' ' . $admin_label . '</label>
			<select' . $admin_fields . ' id="category">
			<option value="all">' . __( 'All Categories', 'my-calendar' ) . '</option>' . "\n";

		foreach ( $categories as $category ) {
			$category_name = strip_tags( stripcslashes( $category->category_name ), mc_strip_tags() );
			$mcat          = ( empty( $_GET['mcat'] ) ) ? '' : (int) $_GET['mcat'];
			$category_id   = (int) $category->category_id;
			if ( 'list' === $show ) {
				$this_url = mc_build_url( array( 'mcat' => $category->category_id ), array() );
				$selected = ( $category_id === $mcat ) ? ' class="selected"' : '';
				$output  .= " <li$selected><a rel='nofollow' href='$this_url'>$category_name</a></li>";
			} else {
				$selected = ( $category_id === $mcat ) ? ' selected="selected"' : '';
				$output  .= " <option$selected value='$category_id'>$category_name</option>\n";
			}
		}
		$output .= ( 'list' === $show ) ? '</ul>' : '</select>';
		if ( 'admin' !== $context && 'list' !== $show ) {
			if ( 'single' === $group ) {
				$output .= '<input type="submit" class="button" value="' . __( 'Submit', 'my-calendar' ) . '" /></p></form>';
			}
		}
		$output .= ( 'single' === $group ) ? '</div>' : '';
	}
	$output = apply_filters( 'mc_category_selector', $output, $categories );

	return $output;
}

/**
 * Show set of filters to limit by accessibility features.
 *
 * @param string $show type of view.
 * @param string $group single or multiple.
 * @param string $target_url Where to post form to.
 *
 * @return string HTML
 */
function mc_access_list( $show = 'list', $group = 'single', $target_url = '' ) {
	$output      = '';
	$current_url = mc_get_uri();
	$current_url = ( '' !== $target_url && esc_url( $target_url ) ) ? $target_url : $current_url;
	$form        = ( 'single' === $group ) ? "<form action='" . esc_url( $current_url ) . "' method='get'><div>" : '';
	if ( 'single' === $group ) {
		$qsa = array();
		if ( isset( $_SERVER['QUERY_STRING'] ) ) {
			parse_str( $_SERVER['QUERY_STRING'], $qsa );
		}
		if ( ! isset( $_GET['cid'] ) ) {
			$form .= '<input type="hidden" name="cid" value="all" />';
		}
		foreach ( $qsa as $name => $argument ) {
			$name     = esc_attr( strip_tags( $name ) );
			$argument = esc_attr( strip_tags( $argument ) );
			if ( 'access' !== $name || 'mc_id' !== $name ) {
				$form .= '<input type="hidden" name="' . $name . '" value="' . $argument . '" />' . "\n";
			}
		}
	}
	$form .= ( 'list' === $show || 'group' === $group ) ? '' : '</div><p>';

	$access_options = mc_event_access();
	if ( ! empty( $access_options ) && count( $access_options ) >= 1 ) {
		$output       = ( 'single' === $group ) ? "<div id='mc_access'>\n" : '';
		$url          = mc_build_url( array( 'access' => 'all' ), array() );
		$not_selected = ( ! isset( $_GET['access'] ) ) ? 'selected="selected"' : '';
		$output      .= ( 'list' === $show ) ? "
		<ul>
			<li><a href='$url'>" . __( 'Accessibility Services', 'my-calendar' ) . '</a></li>' : $form . '
		<label for="access">' . __( 'Accessibility Services', 'my-calendar' ) . '</label>
			<select name="access" id="access">
			<option value="all"' . $not_selected . '>' . __( 'All Services', 'my-calendar' ) . '</option>' . "\n";

		foreach ( $access_options as $key => $access ) {
			$access_name = $access;
			$this_access = ( empty( $_GET['access'] ) ) ? '' : (int) $_GET['access'];
			if ( 'list' === $show ) {
				$this_url = mc_build_url( array( 'access' => $key ), array() );
				$selected = ( $key === $this_access ) ? ' class="selected"' : '';
				$output  .= " <li$selected><a rel='nofollow' href='$this_url'>$access_name</a></li>";
			} else {
				$selected = ( $this_access === $key ) ? ' selected="selected"' : '';
				$output  .= " <option$selected value='" . esc_attr( $key ) . "'>" . esc_html( $access_name ) . "</option>\n";
			}
		}
		$output .= ( 'list' === $show ) ? '</ul>' : '</select>';
		$output .= ( 'list' !== $show && 'single' === $group ) ? '<p><input type="submit" class="button" value="' . __( 'Limit by Access', 'my-calendar' ) . '" /></p></form>' : '';
		$output .= ( 'single' === $group ) ? "\n</div>" : '';
	}
	$output = apply_filters( 'mc_access_selector', $output, $access_options );

	return $output;
}

/**
 * Build date switcher
 *
 * @param string $type Current view being shown.
 * @param string $cid ID of current view.
 * @param string $time Current time view.
 * @param array  $date current date array (month, year, day).
 *
 * @return string HTML output.
 */
function mc_date_switcher( $type = 'calendar', $cid = 'all', $time = 'month', $date = array() ) {
	if ( 'week' === $time ) {
		return '';
	}
	global $wpdb;
	$mcdb    = $wpdb;
	$c_month = isset( $date['month'] ) ? $date['month'] : current_time( 'n' );
	$c_year  = isset( $date['year'] ) ? $date['year'] : current_time( 'Y' );
	$c_day   = isset( $date['day'] ) ? $date['day'] : current_time( 'j' );
	if ( 'true' === get_option( 'mc_remote' ) && function_exists( 'mc_remote_db' ) ) {
		$mcdb = mc_remote_db();
	}
	$current_url    = mc_get_current_url();
	$date_switcher  = '';
	$date_switcher .= '<div class="my-calendar-date-switcher"><form class="mc-date-switcher" action="' . $current_url . '" method="get"><div>';
	$qsa            = array();
	if ( isset( $_SERVER['QUERY_STRING'] ) ) {
		parse_str( $_SERVER['QUERY_STRING'], $qsa );
	}
	if ( ! isset( $_GET['cid'] ) ) {
		$date_switcher .= '<input type="hidden" name="cid" value="' . esc_attr( $cid ) . '" />';
	}
	$data_href = $current_url;
	foreach ( $qsa as $name => $argument ) {
		$name = esc_attr( strip_tags( $name ) );
		if ( is_array( $argument ) ) {
			$argument = '';
		} else {
			$argument = esc_attr( strip_tags( $argument ) );
		}
		if ( 'month' !== $name && 'yr' !== $name && 'dy' !== $name ) {
			$date_switcher .= '<input type="hidden" name="' . $name . '" value="' . $argument . '" />';
			$data_href      = add_query_arg( $name, $argument, $data_href );
		}
	}
	$day_switcher = '';
	if ( 'day' === $time ) {
		$day_switcher = ' <label class="maybe-hide" for="' . $cid . '-day">' . __( 'Day', 'my-calendar' ) . '</label> <select id="' . $cid . '-day" name="dy">' . "\n";
		for ( $i = 1; $i <= 31; $i++ ) {
			$day_switcher .= "<option value='$i'" . selected( $i, $c_day, false ) . '>' . $i . '</option>' . "\n";
		}
		$day_switcher .= '</select>';
	}
	// We build the months in the switcher.
	$date_switcher .= ' <label class="maybe-hide" for="' . $cid . '-month">' . __( 'Month', 'my-calendar' ) . '</label> <select id="' . $cid . '-month" name="month">' . "\n";
	for ( $i = 1; $i <= 12; $i ++ ) {
		$test           = str_pad( $i, 2, '0', STR_PAD_LEFT );
		$c_month        = str_pad( $c_month, 2, '0', STR_PAD_LEFT );
		$date_switcher .= "<option value='$i'" . selected( $test, $c_month, false ) . '>' . date_i18n( 'F', mktime( 0, 0, 0, $i, 1 ) ) . '</option>' . "\n";
	}
	$date_switcher .= '</select>' . "\n" . $day_switcher . ' <label class="maybe-hide" for="' . $cid . '-year">' . __( 'Year', 'my-calendar' ) . '</label> <select id="' . $cid . '-year" name="yr">' . "\n";
	// Query to identify oldest start date in the database.
	$first  = $mcdb->get_var( 'SELECT event_begin FROM ' . my_calendar_table() . ' WHERE event_approved = 1 AND event_flagged <> 1 ORDER BY event_begin ASC LIMIT 0 , 1' );
	$first  = ( '1970-01-01' === $first ) ? '2000-01-01' : $first;
	$year1  = mc_date( 'Y', strtotime( $first, false ) );
	$diff1  = mc_date( 'Y' ) - $year1;
	$past   = $diff1;
	$future = apply_filters( 'mc_jumpbox_future_years', 5, $cid );
	$fut    = 1;
	$f      = '';
	$p      = '';
	$time   = current_time( 'Y' );

	while ( $past > 0 ) {
		$p   .= '<option value="';
		$p   .= $time - $past;
		$p   .= '"' . selected( $time - $past, $c_year, false ) . '>';
		$p   .= $time - $past . "</option>\n";
		$past = $past - 1;
	}

	while ( $fut < $future ) {
		$f  .= '<option value="';
		$f  .= $time + $fut;
		$f  .= '"' . selected( $time + $fut, $c_year, false ) . '>';
		$f  .= $time + $fut . "</option>\n";
		$fut = $fut + 1;
	}

	$date_switcher .= $p;
	$date_switcher .= '<option value="' . $time . '"' . selected( $time, $c_year, false ) . '>' . $time . "</option>\n";
	$date_switcher .= $f;
	$date_switcher .= '</select> <input type="submit" class="button" data-href="' . esc_attr( $data_href ) . '" value="' . __( 'Go', 'my-calendar' ) . '" /></div></form></div>';
	$date_switcher  = apply_filters( 'mc_jumpbox', $date_switcher );

	return $date_switcher;
}

/**
 * Generate toggle between list and grid views
 *
 * @param string $format currently shown.
 * @param string $toggle whether to show.
 * @param string $time Current time view.
 *
 * @return string HTML output
 */
function mc_format_toggle( $format, $toggle, $time ) {
	if ( 'mini' !== $format && 'yes' === $toggle ) {
		$toggle = "<div class='mc-format'>";
		switch ( $format ) {
			case 'list':
				$url     = mc_build_url( array( 'format' => 'calendar' ), array() );
				$url     = mc_url_in_loop( $url );
				$toggle .= "<a href='$url' class='grid mcajax'>" . __( '<span class="maybe-hide">View as </span>Grid', 'my-calendar' ) . '</a>';
				break;
			default:
				$url     = mc_build_url( array( 'format' => 'list' ), array() );
				$url     = mc_url_in_loop( $url );
				$toggle .= "<a href='$url' class='list mcajax'>" . __( '<span class="maybe-hide">View as </span>List', 'my-calendar' ) . '</a>';
				break;
		}
		$toggle .= '</div>';
	} else {
		$toggle = '';
	}

	if ( 'day' === $time ) {
		$toggle = "<div class='mc-format'><span class='mc-active list'>" . __( '<span class="maybe-hide">View as </span>List', 'my-calendar' ) . '</span></div>';
	}

	if ( ( 'true' === get_option( 'mc_convert' ) || 'mini' === get_option( 'mc_convert' ) ) && mc_is_mobile() ) {
		$toggle = '';
	}

	return apply_filters( 'mc_format_toggle_html', $toggle, $format, $time );
}

/**
 * Generate toggle for time views between day month & week
 *
 * @param string $format of current view.
 * @param string $time timespan of current view.
 * @param string $month current month.
 * @param string $year current year.
 * @param string $current Current date.
 * @param int    $start_of_week Day week starts on.
 * @param string $from Date started from.
 *
 * @return string HTML output
 */
function mc_time_toggle( $format, $time, $month, $year, $current, $start_of_week, $from ) {
	// if dy parameter not set, use today's date instead of first day of month.
	$weeks_day = mc_first_day_of_week( $current );
	$adjusted  = false;
	if ( isset( $_GET['dy'] ) ) {
		if ( '' === $_GET['dy'] ) {
			$current_day = $weeks_day[0];
			if ( -1 === (int) $weeks_day[1] ) {
				$adjusted = true;
				$month    = $month - 1;
			}
		} else {
			$current_day = absint( $_GET['dy'] );
		}
		$current_set = mktime( 0, 0, 0, $month, $current_day, $year );
		if ( mc_date( 'N', $current_set, false ) === $start_of_week ) {
			$weeks_day = mc_first_day_of_week( $current_set );
		}
	} else {
		$weeks_day = mc_first_day_of_week();
	}
	$day = $weeks_day[0];
	if ( isset( $_GET['time'] ) && 'day' === $_GET['time'] ) {
		// don't adjust day if viewing day format.
	} else {
		// if the current date is displayed and the week beginning day is greater than 20 in the month.
		if ( ! isset( $_GET['dy'] ) && $day > 20 ) {
			$day = mc_date( 'j', strtotime( "$from + 1 week" ), false );
		}
	}
	$adjust = ( isset( $weeks_day[1] ) ) ? $weeks_day[1] : 0;
	$toggle = '';

	if ( 'mini' !== $format ) {
		$toggle      = "<div class='mc-time'>";
		$current_url = mc_get_current_url();
		if ( -1 === (int) $adjust && ! $adjusted ) {
			$wmonth = ( 1 !== (int) $month ) ? $month - 1 : 12;
		} else {
			$wmonth = $month;
		}
		switch ( $time ) {
			case 'week':
				$url     = mc_build_url( array( 'time' => 'month' ), array( 'mc_id' ) );
				$url     = mc_url_in_loop( $url );
				$toggle .= "<a href='$url' class='month mcajax'>" . __( 'Month', 'my-calendar' ) . '</a>';
				$toggle .= "<span class='mc-active week'>" . __( 'Week', 'my-calendar' ) . '</span>';
				$url     = mc_build_url(
					array(
						'time' => 'day',
						'dy'   => $day,
					),
					array( 'dy', 'mc_id' )
				);
				$url     = mc_url_in_loop( $url );
				$toggle .= "<a href='$url' class='day mcajax'>" . __( 'Day', 'my-calendar' ) . '</a>';
				break;
			case 'day':
				$url     = mc_build_url( array( 'time' => 'month' ), array() );
				$url     = mc_url_in_loop( $url );
				$toggle .= "<a href='$url' class='month mcajax'>" . __( 'Month', 'my-calendar' ) . '</a>';
				$url     = mc_build_url(
					array(
						'time'  => 'week',
						'dy'    => $day,
						'month' => $wmonth,
						'yr'    => $year,
					),
					array( 'dy', 'month', 'mc_id' )
				);
				$url     = mc_url_in_loop( $url );
				$toggle .= "<a href='$url' class='week mcajax'>" . __( 'Week', 'my-calendar' ) . '</a>';
				$toggle .= "<span class='mc-active day'>" . __( 'Day', 'my-calendar' ) . '</span>';
				break;
			default:
				$toggle .= "<span class='mc-active month'>" . __( 'Month', 'my-calendar' ) . '</span>';
				$url     = mc_build_url(
					array(
						'time'  => 'week',
						'dy'    => $day,
						'month' => $wmonth,
					),
					array( 'dy', 'month', 'mc_id' )
				);
				$url     = mc_url_in_loop( $url );
				$toggle .= "<a href='$url' class='week mcajax'>" . __( 'Week', 'my-calendar' ) . '</a>';
				$url     = mc_build_url( array( 'time' => 'day' ), array() );
				$url     = mc_url_in_loop( $url );
				$toggle .= "<a href='$url' class='day mcajax'>" . __( 'Day', 'my-calendar' ) . '</a>';
				break;
		}
		$toggle .= '</div>';
	} else {
		$toggle = '';
	}

	return apply_filters( 'mc_time_toggle_html', $toggle, $format, $time );
}
