<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ES_Campaign_Report extends ES_List_Table {

	public static $instance;

	public function __construct() {

		parent::__construct(
			array(
				'singular' => __( 'Report', 'email-subscribers' ), // singular name of the listed records
				'plural'   => __( 'Reports', 'email-subscribers' ), // plural name of the listed records
				'ajax'     => true, // does this table support ajax?,
				'screen'   => 'es_reports',
			)
		);

		add_action( 'ig_es_view_activity_table_html', array( $this, 'view_activity_report_table' ), 10, 3 );
		add_action( 'admin_footer', array( $this, 'es_view_activity_report_sort_and_filter' ) );
	}

	public function es_campaign_report_callback() {
		?>
		
		<?php
		$this->ajax_response();
		$paged          = ig_es_get_request_data( 'paged', 1 );
		$campaign_class = '';

		if ( ES()->is_pro() ) {
			$campaign_class = 'es_campaign_premium';
		}
		?>
		<div id="poststuff" class="es-items-lists es-campaign-reports-table">
			<div id="post-body" class="metabox-holder column-1">
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						<form method="get" class="es_campaign_report <?php echo esc_html( $campaign_class ); ?>" id="es_campaign_report">
							<input type="hidden" name="order" />
							<input type="hidden" name="orderby" />
							<input type="hidden" name="paged" value='<?php echo esc_attr( $paged ); ?>'/>
							<p class="inline text-lg font-medium leading-7 tracking-wide text-gray-600"><?php esc_html_e( 'Activity Info', 'email-subscribers' ); ?></p>
							<?php $this->display(); ?>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public function ajax_response() {

		$this->prepare_items();
		$no_placeholder = ig_es_get_request_data( 'no_placeholder', '' );
		extract( $this->_args );
		extract( $this->_pagination_args, EXTR_SKIP );

		ob_start();
		if ( ! empty( $no_placeholder ) ) {
			$this->display_rows();
		} else {
			$this->display_rows_or_placeholder();
		}
		$rows = ob_get_clean();

		ob_start();
		$this->print_column_headers();
		$headers = ob_get_clean();

		ob_start();
		$this->pagination( 'top' );
		$pagination_top = ob_get_clean();

		ob_start();
		$this->pagination( 'bottom' );
		$pagination_bottom = ob_get_clean();

		$response = array( 'rows' => $rows );

		$response['column_headers']       = $headers;
		$response['pagination']['top']    = $pagination_top;
		$response['pagination']['bottom'] = $pagination_bottom;

		if ( isset( $total_items ) ) {
			/* translators: %s: Total items in the table */
			$response['total_items_i18n'] = sprintf( _n( '%s item', '%s items', $total_items, 'email-subscribers' ), number_format_i18n( $total_items ) );
		}

		if ( isset( $total_pages ) ) {
			$response['total_pages']      = $total_pages;
			$response['total_pages_i18n'] = number_format_i18n( $total_pages );
		}
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			die( json_encode( $response ) );

		} else {
			return $response;
		}
	}

	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {

		$sortable_columns = array(
			'email'        => array( 'email', false ),
			'country_flag' => array( 'country_flag', false ),
			'os'           => array( 'os', false ),
			'email_client' => array( 'email_client', false ),
			'sent_at'      => array( 'sent_at', false ),
			'opened_at'    => array( 'opened_at', false ),
			'status'       => array( 'status', false ),
		);

		return $sortable_columns;
	}


	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

		$per_page = 100;
		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array( $columns, $hidden, $sortable );

		$data        = $this->get_activity_table_data();
		$total_items = $this->get_activity_table_data( true );

		$this->items = $data;

		/**
		 * Call to _set_pagination_args method for informations about
		 * total items, items for page, total pages and ordering
		 */
		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
			)
		);
	}

	/**
	 * Method to handle display of WP_List table
	 *
	 * @Override of display method
	 */
	public function display() {
		$search = ig_es_get_request_data( 's' );
		$this->search_box( $search, 'campaign-reports-search-input' );
		parent::display();
	}

	/**
	 * Prepare search box
	 *
	 * @param string $text
	 * @param string $input_id
	 *
	 * @since 4.6.12
	 */
	public function search_box( $text = '', $input_id = '' ) {
		do_action( 'ig_es_campaign_reports_filter_options', $text, $input_id );
	}


	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	public function get_columns() {
		$columns = array(
			'sr_no'     => '#',
			'email'     => __( 'Email', 'email-subscribers' ),
			'status'    => __( 'Status', 'email-subscribers' ),
			'sent_at'   => __( 'Sent Date', 'email-subscribers' ),
			'opened_at' => __( 'Viewed Date', 'email-subscribers' ),

		);

		$columns = apply_filters( 'additional_es_campaign_report_columns', $columns );

		return $columns;
	}

	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array  $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		$column_data = ! empty( $item[ $column_name ] ) ? $item[ $column_name ] : '-';
		return $column_data;
	}

	public function column_status( $item ) {
		$status = ! empty( $item['status'] ) ? $item['status'] : ( ! empty( $item['es_deliver_sentstatus'] ) ? $item['es_deliver_sentstatus'] : '' );

		switch ( $status ) {
			case 'Sent':
				?>
				<svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
					<title><?php echo esc_html__( 'Sent', 'email-subscribers' ); ?></title>
					<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
				</svg>
				<?php
				break;
			case 'In Queue':
				?>
				<svg class=" h-6 w-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
				<title><?php echo esc_html__( 'In Queue', 'email-subscribers' ); ?></title>
				<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
			</svg>
				<?php
				break;
			case 'Sending':
				?>
				<svg class=" h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
				<title><?php echo esc_html__( 'Sending', 'email-subscribers' ); ?></title>
				<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"/>
			</svg>
				<?php
				break;
			case 'Opened':
				?>
				<svg xmlns="http://www.w3.org/2000/svg" class="" width="28" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="color:green">
					<title><?php echo esc_html__( 'Opened', 'email-subscribers' ); ?></title>
					  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
					  <path d="M7 12l5 5l10 -10" />
					  <path d="M2 12l5 5m5 -5l5 -5" />
				</svg>
				<?php
				break;
			case '':
				?>
				<i class="dashicons dashicons-es dashicons-minus"/>
				<?php
				break;
			default:
				echo esc_html( $status );
				break;

		}
	}

	/**
	 * Get view activity table data
	 */
	public function get_activity_table_data( $return_count = false ) {

		global $wpbd;

		$hash              = ig_es_get_request_data( 'list', '' );
		$campaign_id       = ig_es_get_request_data( 'campaign_id', '' );
		$filter_by_status  = ig_es_get_request_data( 'status', '' );
		$filter_by_country = ig_es_get_request_data( 'country_code', '' );
		$search            = ig_es_get_request_data( 's' );
		$orderby           = ig_es_get_request_data( 'orderby' );
		$order             = ig_es_get_request_data( 'order', 'DESC' );
		$page_number       = ig_es_get_request_data( 'paged', 1 );

		$message_id            = 0;
		$view_activity_data    = array();
		$delivery_table_exists = false;
		$selects               = array();

		if ( ! empty( $hash ) ) {
			$notification_data_from_hash = ES_DB_Mailing_Queue::get_notification_by_hash( $hash );
			$campaign_id                 = $notification_data_from_hash['campaign_id'];
			$message_id                  = $notification_data_from_hash['id'];
			$delivery_table_exists       = ES()->campaigns_db->table_exists( $wpbd->prefix . 'es_deliverreport' );

			// We are assigning NULL values to sent_at and opened_at columns as actions tables have NULL values for these columns when no data is present in the column.
			// Assigning NULL ensures sorting works as expected when both the tables are combined.
			$queue_query = "SELECT queue.contact_id AS `contact_id`, queue.email AS `email`, 0 AS `type`, NULL AS `sent_at`, NULL AS `opened_at`, queue.status, '' AS `country`, '' AS `device`, '' AS `email_client`, '' AS `os`
			FROM {$wpbd->prefix}ig_sending_queue AS queue
			WHERE `mailing_queue_id` = %d AND `contact_id` NOT IN ( SELECT `contact_id` FROM {$wpbd->prefix}ig_actions WHERE campaign_id = %d AND message_id = %d )";

			$delivery_query = $wpbd->prepare(
				"SELECT
				es_deliver_emailid AS `contact_id`,
				es_deliver_emailmail AS `email`,
				0 AS `type`,
				UNIX_TIMESTAMP(es_deliver_sentdate) AS `sent_at`,
				UNIX_TIMESTAMP(es_deliver_viewdate) AS `opened_at`,
				es_deliver_sentstatus AS `status`,
				'' AS `country`,
				'' AS `device`,
				'' AS `email_client`,
				'' AS `os`
				FROM {$wpbd->prefix}es_deliverreport WHERE es_deliver_sentguid = %s",
				array( $hash )
			);

			$selects[] = $wpbd->prepare( $queue_query, $message_id, $campaign_id, $message_id );
		}

		$action_query = "SELECT 
		MAX(contacts.id) AS `contact_id`,
		contacts.email AS `email`,
		MAX(actions.type) AS `type`,
		MAX(CASE WHEN actions.type = %d THEN actions.created_at END) AS `sent_at`,
		MAX(CASE WHEN actions.type = %d THEN actions.created_at END) AS `opened_at`,
		CASE WHEN MAX(actions.type) = %d THEN 'Sent' WHEN MAX(actions.type) = %d THEN 'Opened' END AS `status`,
		MAX(actions.country) AS `country`,
		MAX(actions.device) AS `device`,
		MAX(actions.email_client) AS `email_client`,
		MAX(actions.os) AS `os`
		FROM {$wpbd->prefix}ig_actions AS actions
		LEFT JOIN {$wpbd->prefix}ig_contacts AS contacts ON actions.contact_id = contacts.id
		WHERE actions.campaign_id = %d AND actions.message_id = %d AND actions.type IN (%d, %d)
		GROUP BY email";

		$query_args = array(
			IG_MESSAGE_SENT,
			IG_MESSAGE_OPEN,
			IG_MESSAGE_SENT,
			IG_MESSAGE_OPEN,
			$campaign_id,
			$message_id,
			IG_MESSAGE_SENT,
			IG_MESSAGE_OPEN,
		);

		$selects[] = $wpbd->prepare( $action_query, $query_args );

		if ( $return_count ) {
			$notification_query = 'SELECT count(*) FROM ( ';
		} else {
			$notification_query = 'SELECT * FROM ( ';
		}
		$notification_query .= implode( ' UNION ALL ', $selects );
		$notification_query .= ') AS `activity`';

		$notification       = ES()->campaigns_db->get( $campaign_id );
		$total_email_sent   = ES()->actions_db->get_count_based_on_id_type( $notification['id'], $message_id, IG_MESSAGE_SENT );
		$email_viewed_count = ES()->actions_db->get_count_based_on_id_type( $notification['id'], $message_id, IG_MESSAGE_OPEN );

		$notification_query .= ' WHERE 1';

		$search_query = '';
		if ( ! empty( $search ) ) {
			$search_query = $wpbd->prepare( ' AND email LIKE %s', '%' . $wpbd->esc_like( $search ) . '%' );
		}

		$status_query = '';
		if ( ! empty( $filter_by_status ) ) {
			$status       = 'not_opened' === $filter_by_status ? 'Sent' : 'Opened';
			$status_query = $wpbd->prepare( ' AND `status` = %s', $status );
		}

		$country_query = '';
		if ( ! empty( $filter_by_country ) ) {
			$country_query = $wpbd->prepare( ' AND `country` = %s', $filter_by_country );
		}

		$order_by_query = '';
		if ( ! $return_count ) {

			if ( empty( $orderby ) ) {
				// By default sort by opened_at and sent_at columns.
				$orderby = "`opened_at` {$order}, `sent_at` {$order}";
			} else {
				$orderby = "{$orderby} {$order}";
			}
			$orderby = esc_sql( $orderby );

			$per_page = 100;
			$offset   = $page_number > 1 ? ( $page_number - 1 ) * $per_page : 0;

			$order_by_query = " ORDER BY {$orderby} LIMIT {$offset}, {$per_page}";
		}

		$notification_query .= $search_query . $status_query . $country_query . $order_by_query;
		if ( $return_count ) {
			$count = $wpbd->get_var( $notification_query );
			if ( empty( $count ) && $delivery_table_exists ) {
				$count_query  = 'SELECT count(*) FROM ( ' . $delivery_query . ' ) AS delivery_report WHERE 1';
				$count_query .= $search_query . $status_query . $country_query . $order_by_query;

				// If no results exists then check data into es_deliverreport table as earlier version were using this table.
				$count = $wpbd->get_var(
					$count_query
				);
			}
			return $count;
		} else {
			$results = $wpbd->get_results( $notification_query, ARRAY_A );

			// If no results exists then check data into es_deliverreport table as earlier version were using this table.
			if ( empty( $results ) && $delivery_table_exists ) {

				$delivery_query  = 'SELECT * FROM ( ' . $delivery_query . ' ) AS delivery_report WHERE 1';
				$delivery_query .= $search_query . $status_query . $country_query . $order_by_query;

				$results = $wpbd->get_results(
					$delivery_query,
					ARRAY_A
				);
			}

			$sr_no = $offset + 1;
			if ( ! empty( $results ) ) {
				$date_format = get_option( 'date_format' );
				$time_format = get_option( 'time_format' );
				$gmt_offset  = ig_es_get_gmt_offset( true );
				$format      = $date_format . ' ' . $time_format;
				foreach ( $results as $notification_action ) {

					$contact_id = $notification_action['contact_id'];
					$sent_at 	= '';
					if ( ! empty( $notification_action['sent_at'] ) ) {
						$sent_timestamp  = (int) $notification_action['sent_at'];
						$sent_timestamp += $gmt_offset;
						$sent_at         = ES_Common::convert_timestamp_to_date( $sent_timestamp, $format );
					}

					$opened_at = '';
					if ( ! empty( $notification_action['opened_at'] ) ) {
						$opened_timestamp  = (int) $notification_action['opened_at'];
						$opened_timestamp += $gmt_offset;
						$opened_at         = ES_Common::convert_timestamp_to_date( $opened_timestamp, $format );
					}

					$view_activity_data[ $contact_id ] = array(
						'sr_no'        => $sr_no++,
						'email'        => $notification_action['email'],
						'opened_at'    => $opened_at,
						'sent_at'      => $sent_at,
						'status'       => $notification_action['status'],
						'country_flag' => '',
						'device'       => '',
						'email_client' => '',
						'os'           => '',
					);

					$view_activity_data = apply_filters( 'additional_es_report_activity_data', $view_activity_data, $contact_id, $notification_action );
				}
			}
		}

		if ( ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			$insight  = ig_es_get_request_data( 'insight', '' );
			$_wpnonce = ig_es_get_request_data( '_wpnonce', '' );

			if ( ( ES()->is_pro() || $insight ) && 0 !== $message_id ) {
				do_action( 'ig_es_view_report_data', $hash );
			}
			?>

			<div class="wrap">
				<?php if ( ! ES()->is_pro() && ! $insight ) { ?>
					<a href="?page=es_reports&action=view&list=<?php echo esc_attr( $hash ); ?>&_wpnonce=<?php echo esc_attr( $_wpnonce ); ?>&insight=true" class="float-right top-10 relative ig-es-title-button px-2 py-2 mx-2 -mt-2 ig-es-imp-button cursor-pointer"><?php esc_html_e( 'Campaign Analytics', 'email-subscribers' ); ?></a>
				<?php } ?>
			</div>
			<div class="mt-2 mb-2 inline-block relative es-activity-viewed-count">
				<span class="pt-3 pb-4 leading-5 tracking-wide text-gray-600"><?php echo esc_html( '(Viewed ' . number_format( $email_viewed_count ) . '/' . number_format( $total_email_sent ) . ')' ); ?>
				</span>
			</div>
			<?php
		}

		return $view_activity_data;
	}

	/**
	 * Handling filtering and sorting for view activity table
	 */
	public function es_view_activity_report_sort_and_filter() {
		$hash        = ig_es_get_request_data( 'list', '' );
		$campaign_id = ig_es_get_request_data( 'campaign_id', '' );

		?>

		<script type="text/javascript">

		(function ($) {

			$(document).ready(

				function () {
							
					$('#es_campaign_report').on('click', '.tablenav-pages a, .manage-column.sortable a, .manage-column.sorted a', function (e) {
						e.preventDefault();
						var query = this.search.substring(1);
						var paged = list.__query( query, 'paged' ) || '1';
						var order = list.__query( query, 'order' ) || 'desc';
						var orderby = list.__query( query, 'orderby' ) || '';
						$("input[name='order']").val(order);
						$("input[name='orderby']").val(orderby);
						$("input[name='paged']").val(paged);
						check_filter_value();
						
					});

					$('#campaign-report-search-submit').on('click', function (e) {
						e.preventDefault();
						$("input[name='paged']").val(1);
						check_filter_value();
					});
				});

		
				list = {

					/** AJAX call
					 *
					 * Send the call and replace table parts with updated version!
					 *
					 * @param    object    data The data to pass through AJAX
					 */
					update: function (data) {

						$.ajax({

							url: ajaxurl,
							data: $.extend(
								{
									action: 'ajax_fetch_report_list',
								},
								data
							),
							beforeSend: function(){
								$('#es_campaign_report table.wp-list-table.widefat.fixed.striped.table-view-list.reports tbody').addClass('pulse-animation').css({'filter': 'blur(1px)', '-webkit-filter' : 'blur(1px)'});
							},
							success: function (response) {
								var response = $.parseJSON(response);
								if (response.rows.length)
									$('#the-list').html(response.rows);
								if (response.column_headers.length)
									$('#es_campaign_report thead tr, #es_campaign_report tfoot tr').html(response.column_headers);
								if (response.pagination.bottom.length)
									$('.tablenav.bottom .tablenav-pages').html($(response.pagination.bottom).html());
								if (response.pagination.top.length)
									$('.tablenav.top .tablenav-pages').html($(response.pagination.top).html());
								},
								error: function (err) {
	
							}
						}).always(function(){
							$('#es_campaign_report table.wp-list-table.widefat.fixed.striped.table-view-list.reports tbody').removeClass('pulse-animation').css({'filter': 'blur(0px)', '-webkit-filter' : 'blur(0px)'});
						});
					},

					/**
					 * Filter the URL Query to extract variables
					 *
					 * @see http://css-tricks.com/snippets/javascript/get-url-variables/
					 *
					 * @param    string    query The URL query part containing the variables
					 * @param    string    variable Name of the variable we want to get
					 *
					 * @return   string|boolean The variable value if available, false else.
					 */
					__query: function (query, variable) {

						var vars = query.split("&");
						for (var i = 0; i < vars.length; i++) {
							var pair = vars[i].split("=");
							if (pair[0] == variable)
								return pair[1];
						}
						return false;
					},
				}


				function check_filter_value( filter_value = '' ){
						var search 	= $('#campaign-reports-search-input').val();
						var country_code 			= $('#ig_es_filter_activity_report_by_country').val();
						var report_activity_status 	= $('#ig_es_filter_activity_report_by_status').val();
						var order 	= $("input[name='order']").val();
						var orderby = $("input[name='orderby']").val();
						var paged 	= $("input[name='paged']").val();
						
						data = 
						{
							list : "<?php echo esc_html( $hash ); ?>",
							campaign_id 	: <?php echo ( ! empty( $campaign_id ) ? esc_html( $campaign_id ) : 0 ); ?>,
							order 			: order,
							orderby 		: orderby,
							paged 			: paged,
							s     			: search,
							country_code	: country_code,
							status 			: report_activity_status

						};
						
						list.update(data);
				}
			})(jQuery);

		</script>
		<?php
	}


}
