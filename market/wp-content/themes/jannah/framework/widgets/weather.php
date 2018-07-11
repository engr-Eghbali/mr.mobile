<?php
/*
Weather Widget developed By : Fouad Badawy | TieLabs
Based On :  Awesome Weather Widget http://halgatewood.com/awesome-weather
*/

if( ! class_exists( 'TIE_WEATHER_WIDGET' )){

	add_action( 'widgets_init', 'tie_weather_widget_register' );
	function tie_weather_widget_register(){
		register_widget( 'TIE_WEATHER_WIDGET' );
	}


	class TIE_WEATHER_WIDGET extends WP_Widget{

		public function __construct(){
			$widget_ops  = array( 'classname' => 'tie-weather-widget' );
			parent::__construct( 'tie-weather-widget', JANNAH_THEME_NAME .' - '.esc_html__( 'Weather', 'jannah' ), $widget_ops );
		}

		public function widget( $args, $instance ){
			extract( $args );

			$widget_title  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$location      = isset($instance['location']) ? $instance['location'] : false;
			$custom_name   = isset($instance['custom_name']) ? $instance['custom_name'] : false;
			$api_key       = isset($instance['api_key']) ? $instance['api_key'] : false;
			$units         = isset($instance['units']) ? $instance['units'] : false;
			$forecast_days = isset($instance['forecast_days']) ? $instance['forecast_days'] : false;
			$bg_color      = ! empty($instance['bg_color']) ? 'background-color:'. $instance['bg_color']  .'!important' : '';
			$font_color    = ! empty($instance['font_color']) ? 'color:'. $instance['font_color'] .'!important' : '';

			echo ( $before_widget );

			if ( ! empty( $widget_title ) ){
				echo ( $before_title . $widget_title . $after_title );
			}

			echo jannah_weather_logic( array( 'location' => $location, 'api_key' => $api_key, 'units' => $units, 'forecast_days' => $forecast_days, 'custom_name' => $custom_name ));

			$widget_id = '#'.$args['widget_id'];

			if ( ! empty( $bg_color ) || ! empty( $font_color ) ){
				$out = "<style scoped type=\"text/css\">";
					if ( ! empty( $font_color ) ){
						$out .= "
							$widget_id,
							$widget_id .widget-title{
								 $font_color;
							}
						";
					}
					if ( ! empty( $bg_color ) ){
						$out .= "
							$widget_id,
							$widget_id .basecloud-bg,
							$widget_id .basecloud-bg:before,
							$widget_id .basecloud-bg:after{
								 $bg_color;
							}
						";
					}
				echo ( $out ) ."</style>";
			}

			echo ( $after_widget );
		}

		public function update( $new_instance, $old_instance ){
			$instance                  = $old_instance;
			$instance['location']      = strip_tags($new_instance['location']);
			$instance['custom_name']   = strip_tags($new_instance['custom_name']);
			$instance['api_key']       = strip_tags($new_instance['api_key']);
			$instance['title']         = strip_tags($new_instance['title']);
			$instance['units']         = strip_tags($new_instance['units']);
			$instance['forecast_days'] = strip_tags($new_instance['forecast_days']);
			$instance['font_color']    = strip_tags($new_instance['font_color']);
			$instance['bg_color']      = strip_tags($new_instance['bg_color']);
			$instance['animated']      = 'true'; // will be used later for animation option
			return $instance;
		}

		public function form( $instance ){
			$defaults = array( 'title' =>esc_html__('Weather', 'jannah') );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$location      = isset( $instance['location'] ) ? esc_attr( $instance['location']) : '';
			$custom_name   = isset( $instance['custom_name'] ) ? esc_attr( $instance['custom_name']) : '';
			$api_key       = isset( $instance['api_key'] ) ? esc_attr( $instance['api_key']) : '';
			$title         = isset( $instance['title'] ) ? esc_attr( $instance['title']) : '';
			$units         = ( isset( $instance['units'] ) AND strtoupper( $instance['units']) == 'C' ) ? 'C' : 'F';
			$forecast_days = isset( $instance['forecast_days'] ) ? esc_attr( $instance['forecast_days'] ) : 5;
			$font_color    = isset( $instance['font_color'] ) ? esc_attr( $instance['font_color']) : '';
			$bg_color      = isset( $instance['bg_color'] ) ? esc_attr( $instance['bg_color']) : '';

			$id = explode( '-', $this->get_field_id( 'widget_id' ));
			$colors_class = ( $id[4] == '__i__' ) ? 'ajax-added' : '';

			$theme_color = jannah_get_option( 'global_color', '#000000' );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'jannah'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('location') ); ?>">
				<?php esc_html_e('Location:', 'jannah'); ?> - <a href="<?php echo esc_url( 'http://openweathermap.org/find' ); ?>" target="_blank"><?php esc_html_e('Find Your Location', 'jannah'); ?></a><br />
				<small><?php esc_html_e( '(i.e: London,UK or New York City,NY)', 'jannah' ); ?></small>
			</label>
			<input class="widefat" style="margin-top: 4px;" id="<?php echo esc_attr( $this->get_field_id('location') ); ?>" name="<?php echo esc_attr( $this->get_field_name('location') ); ?>" type="text" value="<?php echo esc_attr( $location ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('api_key') ); ?>">
				<?php esc_html_e('API key', 'jannah'); ?> - <a href="<?php echo esc_url( 'http://openweathermap.org/appid#get' ); ?>" target="_blank"><?php esc_html_e('How to get your API Key?', 'jannah'); ?></a><br />
			</label>
			<input class="widefat" style="margin-top: 4px;" id="<?php echo esc_attr( $this->get_field_id('api_key') ); ?>" name="<?php echo esc_attr( $this->get_field_name('api_key') ); ?>" type="text" value="<?php echo esc_attr( $api_key ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('units') ); ?>"><?php esc_html_e('Units:', 'jannah'); ?></label>  &nbsp;
			<input id="<?php  echo esc_attr( $this->get_field_id('units') ); ?>-f" name="<?php echo esc_attr( $this->get_field_name('units') ); ?>" type="radio" value="F" <?php checked( $units, 'F' ); ?> /> <?php esc_html_e('F', 'jannah'); ?> &nbsp; &nbsp;
			<input id="<?php  echo esc_attr( $this->get_field_id('units') ); ?>-c" name="<?php echo esc_attr( $this->get_field_name('units') ); ?>" type="radio" value="C" <?php checked( $units, 'C' ); ?> /> <?php esc_html_e('C', 'jannah'); ?>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('forecast_days') ); ?>"><?php esc_html_e('Forecast:', 'jannah' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('forecast_days') ); ?>" name="<?php echo esc_attr( $this->get_field_name('forecast_days') ); ?>">
				<?php
					for ( $i=5; $i>0; $i-- ) {
						echo '<option value="'. $i .'"'. selected( $forecast_days, $i, false ) .'>'. sprintf( _n( '%d day', '%d days', $i, 'jannah' ), $i ) .'</option>';
					}
				?>
				<option value="hide"<?php selected( $forecast_days, 'hide' ); ?>><?php esc_html_e('Disable', 'jannah'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('custom_name') ); ?>">
				<?php esc_html_e('Custom City Name:', 'jannah'); ?><br />
			</label>
			<input class="widefat" style="margin-top: 4px;" id="<?php echo esc_attr( $this->get_field_id('custom_name') ); ?>" name="<?php echo esc_attr( $this->get_field_name('custom_name') ); ?>" type="text" value="<?php echo esc_attr( $custom_name ); ?>" />
		</p>
		<div class="weather-color tie-custom-color-picker <?php echo esc_attr( $colors_class ) ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Background Color', 'jannah' ); ?></label>
			<input data-palette="<?php echo esc_attr( $theme_color ); ?>, #9b59b6, #3498db, #2ecc71, #f1c40f, #34495e, #e74c3c" class="widefat tieColorSelector" id="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bg_color' ) ); ?>" type="text" value="<?php echo esc_attr( $bg_color ) ?>" />
		</div>

		<div class="weather-color tie-custom-color-picker <?php echo esc_attr( $colors_class ) ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'font_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Text Color', 'jannah' ); ?></label>
			<input data-palette="<?php echo esc_attr( $theme_color ); ?>, #9b59b6, #3498db, #2ecc71, #f1c40f, #34495e, #e74c3c" class="widefat tieColorSelector" id="<?php echo esc_attr( $this->get_field_id( 'font_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'font_color' ) ); ?>" type="text" value="<?php echo esc_attr( $font_color ) ?>" />
		</div>

		<?php
		}
	}



	# THE LOGIC
	function jannah_weather_logic( $atts ){

		$rtn               = '';
		$weather_data      = array();
		$location          = isset( $atts['location'] ) ? $atts['location'] : false;
		$api_key           = isset( $atts['api_key'] )  ? $atts['api_key']  : false;
		$units             = ( isset( $atts['units'] ) AND strtoupper( $atts['units'] ) == 'C' ) ? 'metric' : 'imperial';
		$units_display     = $units == 'metric' ? '&#x2103;' : '&#x2109;';
		$days_to_show      = isset( $atts['forecast_days'] ) ? $atts['forecast_days'] : 5;
		$locale            = 'en';
		$sytem_locale      = get_locale();
		$available_locales = array( 'en', 'ru', 'it', 'es', 'uk', 'de', 'pt', 'ro', 'pl', 'fi', 'nl', 'fr', 'bg', 'sv', 'zh_tw', 'zh_cn', 'tr', 'hr', 'ca'  );


		if( empty( $api_key ) ){
			echo'<span class="theme-notice">'. esc_html__( 'WEATHER WIDGET: You need to set the API key and Location.', 'jannah' ) .'</span>';
			return;
		}


		# CHECK FOR LOCALE
		if( in_array( $sytem_locale , $available_locales )){
			$locale = $sytem_locale;
		}

		# CHECK FOR LOCALE BY FIRST TWO DIGITS
		if( in_array( substr( $sytem_locale, 0, 2 ), $available_locales )){
			$locale = substr( $sytem_locale, 0, 2 );
		}

		# NO LOCATION, ABORT ABORT!!!1!
		if( ! $location ){
			return jannah_weather_error();
		}

		# FIND AND CACHE CITY ID
		if( is_numeric( $location )){
			$city_name_slug = $location;
			$api_query      = "id=" . $location;
		}
		else{
			$city_name_slug = sanitize_title( $location );
			$api_query      = "q=" . $location;
		}

		# TRANSIENT NAME
		$weather_transient_name = 'tie_' . $city_name_slug . "_" . strtolower($units) . '_' . $locale;

		# GET WEATHER DATA
		if( $weather_data = get_transient( $weather_transient_name )){


		}
		else{
			$weather_data['now']      = array();
			$weather_data['forecast'] = array();

			# NOW ----------
			$now_ping = "http://api.openweathermap.org/data/2.5/weather?" . $api_query . "&lang=" . $locale . "&units=" . $units."&APPID=".$api_key;
			$now_ping = jannah_remove_spaces( $now_ping );

			$now_ping_get = wp_remote_get( $now_ping, array( 'timeout' => 30 ) );

			if( is_wp_error( $now_ping_get )){
				return jannah_weather_error( $now_ping_get->get_error_message() );
			}

			$city_data = json_decode( $now_ping_get['body'] );

			if( isset($city_data->cod) AND $city_data->cod == 404 ){
				return jannah_weather_error( $city_data->message );
			}
			else{
				$weather_data['now'] = $city_data;
			}

			# FORECAST ----------
			$forecast_ping = "http://api.openweathermap.org/data/2.5/forecast/daily?" . $api_query . "&lang=" . $locale . "&units=" . $units ."&cnt=7&APPID=".$api_key;
			$forecast_ping = jannah_remove_spaces( $forecast_ping );

			$forecast_ping_get = wp_remote_get( $forecast_ping, array( 'timeout' => 30 ) );

			if( is_wp_error( $forecast_ping_get ) ){
				return jannah_weather_error( $forecast_ping_get->get_error_message()  );
			}

			$forecast_data = json_decode( $forecast_ping_get['body'] );

			if( isset( $forecast_data->cod ) AND $forecast_data->cod == 404 ){
				return jannah_weather_error( $forecast_data->message );
			}
			else{
				$weather_data['forecast'] = $forecast_data;
			}

			# SET THE TRANSIENT, CACHE FOR TWO HOURS
			if( $weather_data['now'] AND $weather_data['forecast'] ){
				set_transient( $weather_transient_name, $weather_data, 2* HOUR_IN_SECONDS );
			}
		}

		# NO WEATHER
		if( ! $weather_data OR ! isset( $weather_data['now'] )){
			return jannah_weather_error();
		}


		//var_dump( $weather_data );


		# TODAYS TEMPS & ICONS
		$today        = $weather_data['now'];
		$forecast     = $weather_data['forecast'];
		$dt_today     = date( 'Ymd', current_time( 'timestamp', 0 ) );
		$city_name    = ! empty( $atts['custom_name'] ) ? $atts['custom_name'] : $today->name;
		$days_to_show = $days_to_show;


		# DATA
		$today_temp = round( $today->main->temp );


		# ICONS
		$icon_divs = jannah_weather_status_icon( $today->weather[0]->icon );

		# UPCOMMING DAYS // We run this first to get the Max and MIN values for today
		$c = 1;
		$forecast_out = '';

		foreach( (array) $forecast->list as $forecast ){
			$forecast_icon_divs = jannah_weather_status_icon( $forecast->weather[0]->icon );

			if( $dt_today == date( 'Ymd', $forecast->dt )){
				$today_high = round( $forecast->temp->max );
				$today_low  = round( $forecast->temp->min );
				$today->main->humidity = round( $forecast->humidity );
				$today->wind->speed    = round( $forecast->speed );
			}

			if( $dt_today >= date( 'Ymd', $forecast->dt )){
				continue;
			}

			$forecast->temp = (int) $forecast->temp->day;
			$day_of_week    = date_i18n( 'D', $forecast->dt );

			$forecast_out .= "
				<div class=\"weather-forecast-day\">
					{$forecast_icon_divs}
					<div class=\"weather-forecast-day-temp\">{$forecast->temp}<sup>{$units_display}</sup></div>
					<div class=\"weather-forecast-day-abbr\">$day_of_week</div>
				</div>
			";

			if( $c == $days_to_show ){
				break;
			}

			$c++;
		}


		# DISPLAY WIDGET
		$rtn .= "
			<div id=\"tie-weather-{$city_name_slug}\" class=\"weather-wrap\">
		";

		$rtn .= "
			<div class=\"weather-icon-and-city\">
				{$icon_divs}
				<h6 class=\"weather-name\">{$city_name}</h6>
				<div class=\"weather-desc\">{$today->weather[0]->description}</div>
			</div> <!-- /.weather-icon-and-city -->
		";


		$speed_text = ($units == 'metric') ? __ti('km/h') : __ti('mph');

		$rtn .= "
			<div class=\"weather-todays-stats\">
				<div class=\"weather-current-temp\">$today_temp<sup>{$units_display}</sup></div>
				<div class=\"weather-more-todays-stats\">";

				if( ! empty( $today_high ) && ! empty( $today_low ) ){
					$rtn .= "
						<div class=\"weather_highlow\"><span aria-hidden=\"true\" class=\"tie-icon-thermometer-half\"></span> {$today_high}&ordm; - {$today_low}&ordm;</div>";
				}

				$rtn .= "
					<div class=\"weather_humidty\"><span aria-hidden=\"true\" class=\"tie-icon-raindrop\"></span><span class=\"screen-reader-text\">" . esc_html__('humidity:', 'jannah') . "</span> {$today->main->humidity}% </div>
					<div class=\"weather_wind\"><span aria-hidden=\"true\" class=\"tie-icon-wind\"></span><span class=\"screen-reader-text\">" . esc_html__('wind:', 'jannah') . "</span> {$today->wind->speed} " . $speed_text . "</div>
				</div>
			</div> <!-- /.weather-todays-stats -->
		";


		#-----
		if( $days_to_show != 'hide' ){
			$rtn .= "
				<div class=\"weather-forecast weather_days_{$days_to_show}\">
					$forecast_out
				</div><!-- /.weather-forecast -->
			";
		}


		$rtn .= "</div> <!-- /.weather-wrap -->";

		return $rtn;
	}


	# Return Weather Status icon
	function jannah_weather_status_icon( $today_icon ){

		# Default icon | Cloudy ----------
		$weather_icon = '
			<div class="weather-icon">
				<div class="icon-cloud"></div>
				<div class="icon-cloud-behind"></div>
				<div class="basecloud-bg"></div>
			</div>
		';

		# Sunny ----------
		if( $today_icon == '01d' ){
			$weather_icon = '
				<div class="weather-icon">
					<div class="icon-sun"></div>
				</div>
			';
		}

		# Moon ----------
		elseif( $today_icon == '01n' ){
			$weather_icon = '
				<div class="weather-icon">
					<div class="icon-moon"></div>
				</div>
			';
		}

		# Cloudy Sunny ----------
		elseif( $today_icon == '02d' || $today_icon == '03d' || $today_icon == '04d' ){
			$weather_icon = '
				<div class="weather-icon">
					<div class="icon-cloud"></div>
					<div class="icon-cloud-behind"></div>
					<div class="basecloud-bg"></div>
					<div class="icon-sun-animi"></div>
				</div>
			';
		}

		# Cloudy Night ----------
		elseif( $today_icon == '02n' || $today_icon == '03n'  || $today_icon == '04n' ){
			$weather_icon = '
				<div class="weather-icon">
					<div class="icon-cloud"></div>
					<div class="icon-cloud-behind"></div>
					<div class="basecloud-bg"></div>
					<div class="icon-moon-animi"></div>
				</div>
			';
		}

		# Showers ----------
		elseif( $today_icon == '09d' ||  $today_icon == '09n'){
			$weather_icon = '
				<div class="weather-icon drizzle-icons showers-icons">
					<div class="basecloud"></div>
					<div class="icon-rainy-animi"></div>
					<div class="icon-rainy-animi-2"></div>
					<div class="icon-rainy-animi-4"></div>
					<div class="icon-rainy-animi-5"></div>
				</div>
			';
		}

		# Rainy Sunny ----------
		elseif( $today_icon == '10d' ){
			$weather_icon = '
				<div class="weather-icon">
					<div class="basecloud"></div>
					<div class="basecloud-bg"></div>
					<div class="icon-rainy-animi"></div>
					<div class="icon-rainy-animi-2"></div>
					<div class="icon-rainy-animi-4"></div>
					<div class="icon-rainy-animi-5"></div>
					<div class="icon-sun-animi"></div>
				</div>
			';
		}

		# Rainy Night ----------
		elseif( $today_icon == '10n' ){
			$weather_icon = '
				<div class="weather-icon">
					<div class="basecloud"></div>
					<div class="basecloud-bg"></div>
					<div class="icon-rainy-animi"></div>
					<div class="icon-rainy-animi-2"></div>
					<div class="icon-rainy-animi-4"></div>
					<div class="icon-rainy-animi-5"></div>
					<div class="icon-moon-animi"></div>
				</div>
			';
		}

		# Thunder ----------
		elseif( $today_icon == '11d' || $today_icon == '11n'){
			$weather_icon = '
				<div class="weather-icon">
					<div class="basethundercloud"></div>
					<div class="icon-thunder-animi"></div>
				</div>
			';
		}

		# Snowing ----------
		elseif( $today_icon == '13d' || $today_icon == '13n' ){
			$weather_icon = '
				<div class="weather-icon weather-snowing">
					<div class="basecloud"></div>
					<div class="icon-windysnow-animi"></div>
					<div class="icon-windysnow-animi-2"></div>
				</div>
			';
		}

		# Mist ----------
		elseif( $today_icon == '50d'  || $today_icon == '50n' ){
			$weather_icon = '
				<div class="weather-icon">
					<div class="icon-mist"></div>
					<div class="icon-mist-animi"></div>
				</div>
			';
		}


		// Debug Icons ----
		// $weather_icon = '<img src="http://openweathermap.org/img/w/'. $today_icon .'.png">' .$weather_icon;

		return $weather_icon;
	}


	# RETURN ERROR
	function jannah_weather_error( $msg = false ){

		if( empty( $msg )){
			$msg = esc_html__('No weather information available', 'jannah');
		}

		return '<div class="weather-widget-error">'. $msg .'</div>';

		//return apply_filters( 'jannah_weather_error', "<!-- TIE WEATHER ERROR: " . $msg . " -->" );
	}

}
