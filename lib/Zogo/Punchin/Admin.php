<?php

class Zogo_Punchin_Admin {

    public function __construct() {

        add_action( 'admin_menu', array( $this, 'menu' ) );
     	add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

		add_action( 'init', array( $this, 'update_existing_records' ) );

    }

	public function assets() {

		wp_register_script( 'zogo-punchin-admin', ZOGO_PUNCHIN_URL . '/assets/admin/zogo.punchin.admin.js', array( 'jquery' ) );
		wp_enqueue_script( 'zogo-punchin-admin' );

        wp_register_style( 'zogo-punchin-admin', ZOGO_PUNCHIN_URL . '/assets/admin/zogo_punchin_admin.css' );
        wp_enqueue_style( 'zogo-punchin-admin' );
	}

    public function menu() {

        add_menu_page(
            __( 'Timecards', 'zogo-punchin-domain' ),
             __( 'Timecards', 'zogo-punchin-domain' ),
             'manage_options',
             'zogo-punchin-timecards',
             array( $this, 'view_timecards_page' ),
			 ZOGO_PUNCHIN_URL . '/images/timecards.png'
        );
    }

    public function view_timecards_page() {

        // Get all users with timecard details
        $user_query = new WP_User_Query( array(
            'meta_query' => array(
                array(
                    'key' => 'zogo_punchin_timecard',
                    'compare' => 'EXISTS'
                )
            )
        ) );

		//print_r('<pre>');

		// Week
		//$weeks = array();



		// Loop through users
		foreach ( $user_query->results as $user ) {

			// Holds all the weeks data
			$weeks = array();
			$completed_array_hours = array();

			// Get timecard for user
			$timecards = zogo_punchin_timecard( $user->ID );

			// Loop through timecards
			foreach ( $timecards as $date => $in_outs ) {

				// Generate the weeks for this timecard date, and merge them
				$weeks = array_merge($weeks, $this->week_from_monday( $date ) );

				// Check the in is set
				if ( isset( $in_outs['in'] ) ) {

					// Loop through all in times
					foreach( $in_outs['in'] as $key => $time ) {

						// Determine if an out time is set with the same key
						if ( isset( $in_outs['out'][$key] ) ) {

							// Make the in time
							$in_date_time = DateTime::createFromFormat('U', $time );

							// Make the out time
							$out_date_time = DateTime::createFromFormat( 'U',  $in_outs['out'][$key] );

							// Make a DateTimeDifference
							$completed_array_hours[$date][] = $in_date_time->diff( $out_date_time );

						}

					}
				}
			}

			//print_r('<pre>');
			//echo 'Completed Array Hours <br/>';
			//echo '=====================================<br/>';
			//var_dump($completed_array_hours);
			//echo '=======================================<br/>';

			$counted_hours = array();
			// Loop through all the dates of differences
			foreach ( $completed_array_hours as $date => $dates ) {

				// Make a new variable, and a blank datetime
				if ( ! array_key_exists( $date, $counted_hours ) )
					$counted_hours[$date] = new DateTime( '00:00:00', new DateTimeZone( 'America/New_York' ) );

				// Loop through all the differences
				foreach ( $dates as $differences ) {

					// Add the difference time
					$counted_hours[$date]->add($differences);

				}
			}

			//echo 'Counted Hours <br/>';
			//echo '=====================================<br/>';
			//var_dump($counted_hours);
			//echo '======================================<br/>';

			// Loop through all weeks and get the unique key name
			foreach ( $weeks as $start_end_date_key => $start_end_dates ) {

				$week_date = new DateTime( '00:00:00', new DateTimeZone( 'America/New_York' ) );

				// Loop through all the individual days of that week
				foreach ( $start_end_dates as $date => $array ) {

					// Determine if that day has some set differences
					if ( array_key_exists( $date, $counted_hours ) ) {

						// Add those differences to the weeks array
						$weeks[$start_end_date_key][$date] = $counted_hours[$date];

					}
				}

				//var_dump($week_date);
				//exit;
			}

			//echo 'Weeks <br/>';
			//echo '=====================================<br/>';
			//var_dump($weeks);
			//echo '=====================================<br/>';
		}




        $view = new Pronamic_Base_View( ZOGO_PUNCHIN_ROOT . '/views/Zogo_Punchin_Admin' );
        $view
            ->set_view( 'view_timecards_page' )
            ->set( 'users', $user_query->results )
            ->render();
    }

	public function week_from_monday( $date ) {
		// Assuming $date is in format DD-MM-YYYY
		list($year, $month, $day) = explode("-", $date );

		// Get the weekday of the given date
		$wkday = date('l',mktime('0','0','0', $month, $day, $year));

		switch($wkday) {
			case 'Monday': $numDaysToMon = 0; break;
			case 'Tuesday': $numDaysToMon = 1; break;
			case 'Wednesday': $numDaysToMon = 2; break;
			case 'Thursday': $numDaysToMon = 3; break;
			case 'Friday': $numDaysToMon = 4; break;
			case 'Saturday': $numDaysToMon = 5; break;
			case 'Sunday': $numDaysToMon = 6; break;
		}

		// Timestamp of the monday for that week
		$monday = mktime('0','0','0', $month, $day-$numDaysToMon, $year);

		$seconds_in_a_day = 86400;

		// Get date for 7 days from Monday (inclusive)
		for($i=0; $i<7; $i++)
		{
			$dates[date('Y-m-d',$monday+($seconds_in_a_day*0)) . '::' . date('Y-m-d',$monday+($seconds_in_a_day*6))][date('Y-m-d',$monday+($seconds_in_a_day*$i))] = array();
		}


		return $dates;
	}

	public function update_existing_records() {

		if ( isset( $_GET['update_punchins'] ) ) {

			set_time_limit(0);

			$all_users_ids = get_users( array(
				'fields' => 'ids'
			) );

			foreach ( $all_users_ids as $id ) {

				$users_timesheet_information = get_the_author_meta( 'zogo_punchin_timecard', $id );

				print_r('<pre>');
				var_dump($users_timesheet_information);

				$new_information = array();
				foreach ( $users_timesheet_information as $key => $times ) {



					if ( 'in' == $key || 'out' == $key ) {

						foreach ( $times as $time ) {

							$date_time = DateTime::createFromFormat( 'U', $time );
							$date_time->setTimeZone(new DateTimeZone( 'America/New_York' ) );
							$adjusted_timestamp = $date_time->format( 'U' ) + $date_time->getOffset();

							$adjusted_date_time = DateTime::createFromFormat( 'U', $adjusted_timestamp );

							$date_key = $adjusted_date_time->format( 'Y-m-d' );

							$new_information[$date_key][$key][] = $adjusted_date_time->getTimestamp();

						}

					}


				}


				if ( ! empty( $new_information ) )
					update_user_meta( $id, 'zogo_punchin_timecard', $new_information );

			}

		}
	}
}