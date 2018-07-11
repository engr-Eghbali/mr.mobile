<?php

	jannah_theme_option(
		array(
			'title' => esc_html__( 'Web Notifications', 'jannah' ),
			'type'  => 'tab-title',
		));

	?>


	<div class="foxpush-intro">
		<a href="<?php echo esc_url( 'https://tielabs.com/go/foxpush-jannah' ); ?>" target="_blank" class="navbar-brand smooth-scroll">
			<img style="width: 250px;height: auto;" src="<?php echo JANNAH_TEMPLATE_URL ?>/framework/admin/assets/images/foxpush.svg" alt="logo">
		</a>

		<h3><?php esc_html_e( "Web Push notifications allow your users to opt-in to timely updates from your website. and allow you to effectively re-engage them with customized, engaging content whenever they are online, wherever they may be - even on their phones! It's easy to set up, and no technical skills are required.", 'jannah' ); ?></h3>

		<a class="tie-primary-button button button-primary button-large" href="<?php echo esc_url( 'https://tielabs.com/go/foxpush-jannah' ); ?>" target="_blank"><?php esc_html_e( 'Sign up for FREE', 'jannah' ) ?></a>

	</div>

	<?php

	$foxpush_class = get_option( 'jannah_foxpush_code' ) ? 'foxpush-is-active' : 'foxpush-is-not-active';

	jannah_theme_option(
		array(
			'title' =>	esc_html__( 'FoxPush Setup', 'jannah' ),
			'type'  => 'header',
		));

	jannah_theme_option(
		array(
			'name'   => esc_html__( 'Enable', 'jannah' ),
			'id'     => 'web_notifications',
			'toggle' => '#foxpush-all-options',
			'type'   => 'checkbox',
		));

	echo '<div id="foxpush-all-options" class="'. $foxpush_class .'"">';




	echo '<div id="foxpush-not-connected">';

		# SSl Setup ----------
		if( jannah_is_ssl() && ! jannah_foxpush_is_installed() ){
			$foxpush_code   = explode( '_',  get_option( 'jannah_foxpush_code' ) );
			jannah_theme_option(
				array(
					'id'   => 'foxpush-ssl-file',
					'text' => '<strong>'. esc_html__( 'One more step!', 'jannah' ) .'</strong><br>' . sprintf( wp_kses_post( '<a href="%s">Download the setup files</a>. Unzip the archive and upload the files into the top-level directory ( public_html , or "/") of your website.', 'jannah' ), "https://www.foxpush.com/downloads/native-$foxpush_code[0].zip" ),
					'type' => 'message',
				));
		}

		# Instructions ----------
		echo '
			<div id="foxpush-instructions" class="option-item">
				<h5>'. esc_html__( 'How to get your API Key?', 'jannah' ) .'</h5>
				<ul style="list-style-type: disc; list-style-position: inside; padding: 0 20px;">
				 <li>'. esc_html__( 'Make sure you are logged into FoxPush.', 'jannah' ) .'</li>
				 <li>'. esc_html__( 'From the navigation panel on the admin dashboard, click on Settings and then on API Keys.', 'jannah' ) .'</li>
				 <li>'. esc_html__( 'Click on Generate New Key.', 'jannah' ) .'</li>
				 <li>'. esc_html__( 'Choose your Domain Name. then click the Generate button.', 'jannah' ) .'</li>
				 <li>'. esc_html__( 'Copy the Domain and the key and add them in the fields below.', 'jannah' ) .'</li>
				 <li>'. esc_html__( 'Click on the Connect button below.', 'jannah' ) .'</li>
				</ul>
			</div>
		';

		jannah_theme_option(
			array(
				'name' => esc_html__( 'FoxPush Domain', 'jannah' ),
				'id'   => 'foxpush_domain',
				'type' => 'text',
			));

		jannah_theme_option(
			array(
				'name' => esc_html__( 'API Key', 'jannah' ),
				'id'   => 'foxpush_api',
				'type' => 'text',
			));


		jannah_theme_option(
			array(
				'id'   => 'foxpush-connect-error',
				'text' => '',
				'type' => 'error',
			));

		?>
			<div id="foxpush-connect-wrapper" class="foxpush-buttons option-item">

				<a id="foxpush-connect" data-connecting="<?php esc_html_e( 'Connecting', 'jannah' ) ?>" data-try="<?php esc_html_e( 'Try again', 'jannah' ) ?>" class="tie-primary-button button button-primary button-large black-button" href="#" target="_blank">
					<div id="foxpush-connect-loader" class="tie-loading-container">
						<div class="tie-loading-wheel"></div>
					</div>
					<span><?php esc_html_e( 'Connect', 'jannah' ) ?></span>
				</a>

			</div>
		<?php

	echo '</div>';

	?>



	<div class="foxpush-buttons option-item" id="foxpush-is-connected">
		<div id="foxpush-connected">
			<h4><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Your account is connected', 'jannah' ) ?></h4>
		</div>

		<a id="foxpush-revoke" href="#" target="_blank"><?php esc_html_e( 'Disconnect', 'jannah' ) ?></a>
	</div>


	<div id="foxpush-stats">
	<?php

		$chart = jannah_foxpush_statistics();
		$stats = jannah_foxpush_statistics( 'stats' );

		if( ! empty( $chart ) || ! empty( $stats ) ){
			jannah_theme_option(
				array(
					'title' =>	esc_html__( 'Statistics (Updated Hourly)', 'jannah' ),
					'type'  => 'header',
				));
		}



		# Statistics ----------
		if( ! empty( $stats ) && is_array( $stats ) ){

			$stats_data[] = array( $stats['total_subscribers'], esc_html__( 'Subscribers',   'jannah' ) );
			$stats_data[] = array( $stats['total_campaigns'],   esc_html__( 'Campaigns',    'jannah' ) );
			$stats_data[] = array( $stats['total_views'],       esc_html__( 'Total Views',  'jannah' ) );
			$stats_data[] = array( $stats['total_clicks'],      esc_html__( 'Total Clicks', 'jannah' ) );

			echo '<div class="web-notifications-stats-box option-item">';
			foreach ( $stats_data as $stats ){
				echo '
				  <div class="web-notifications-stats">
						<span class="box-desc">'. $stats[1] .'</span>
						<p class="box-num">'. number_format_i18n( $stats[0] ) .'</p>
				  </div>
				';
			}
			echo '</div>';
		}


		# Charts ----------
		if( ! empty( $chart ) && is_array( $chart ) ){
			?>

			<script type="text/javascript" src="//www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">

				jQuery(window).resize(function(){
					drawChart();
				});

			  google.charts.load('current', {'packages':['corechart']});
			  google.charts.setOnLoadCallback(drawChart);

			  function drawChart(){
				var data = google.visualization.arrayToDataTable([
				  ['Date', '<?php esc_html_e( 'Subscribers', 'jannah' )  ?>',],
				  <?php

						foreach ( $chart as $value ){
							$date = $value['date'];
							$subs = $value['subscribers'];

							echo "['$date',  $subs ],";
						}

				   ?>
				]);


				var options = {
				  curveType: 'function',
				  width: document.getElementById('tie_form').offsetWidth,
				  height: 450,
				  chartArea: {'width': '90%'},
				  legend: { position: 'bottom' },
				  hAxis: {
					  textStyle: {
							color: '#afafaf',
							fontSize: 11,
							fontName: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif',
					  },
					},
					vAxis: {
					  textStyle: {
							color: '#888',
							fontSize: 16,
							fontName: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif',
					  },
					  gridlines: {color: '#eee'},
					  baselineColor: '#999',
					},
					reverseCategories: true,
					colors: ['#65b70e'],
				};

				var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

				chart.draw(data, options);
			  }
			</script>
			<div id="curve_chart"></div>
		<?php
	}

	echo '</div> <!-- FoxPush Stats -->';
	echo '</div><!-- foxpush-all-options -->';

?>
