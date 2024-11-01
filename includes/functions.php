<?php

/**
 * DX Info Widget for YouTube
 * functions file
 */


// the main function used to load widget content
function yiw_widget_content ( $product_id, $max_vids, $vid_h, $vid_w, $is_channel_id, $cc_period, $tab_1, $tab_2, $tab_3 ) {
	$s_1 = ( get_option('ytiw_s_1') != "" ) ? get_option('ytiw_s_1') : __( "Recent", "wordpress" );
	$s_2 = ( get_option('ytiw_s_2') != "" ) ? get_option('ytiw_s_2') : __( "Popular", "wordpress" );
	$s_3 = ( get_option('ytiw_s_3') != "" ) ? get_option('ytiw_s_3') : __( "Info", "wordpress" );
	$s_4 = ( get_option('ytiw_s_4') != "" ) ? get_option('ytiw_s_4') : '2';
	$s_5 = ( get_option('ytiw_s_5') != "" ) ? get_option('ytiw_s_5') : '2';
	if ( $product_id == '' ) {
		echo "<p> DX Info Widget for YouTube needs to be configured, kindly fill out a YouTube username or channel ID from your dashboard widgets area. </p>";
		return false;
	}
	$last_update = esc_attr( get_transient( 'liteyiw_last_update_'  . $product_id ) );
	$op_1 = esc_attr( get_transient( 'liteyiw_op_1_' . $product_id ) );
	$op_2 = esc_attr( get_transient( 'liteyiw_op_2_' . $product_id ) );
	$op_3 = esc_attr( get_transient( 'liteyiw_op_3_' . $product_id ) );
	$op_4 = esc_attr( get_transient( 'liteyiw_op_4_' . $product_id ) );
	$op_5 = esc_attr( get_transient( 'liteyiw_op_5_' . $product_id ) );
	$op_6 = esc_attr( get_transient( 'liteyiw_op_6_' . $product_id ) );
	$op_7 = esc_attr( get_transient( 'liteyiw_op_7_' . $product_id ) );
	if( empty( $last_update ) ){
		$force_update = "1";
	} else {
		$force_update = esc_attr( get_transient( 'liteyiw_force_update_' . $product_id  ) );
	}
	$date1 = $last_update;
	$date2 = time();
	if( ! empty( $date1 ) && ! empty( $date2 ) ) {
		$subTime = $date1 - $date2;
		$m = ($subTime/60)%60;
		$h = ($subTime/(60*60))%24;
	} else {
		$h = 0;
	}
	$cc_period_val = ( $cc_period !== '' && is_numeric( $cc_period ) ) ? esc_attr( $cc_period ) : $s_4;
	// empties the existing cache, and gets fresh new one
	if ( $h >= $cc_period_val || $last_update == '' || $force_update == "1" ) {
		$max_vids_val = ( $max_vids == '' ) ? $s_5 : esc_attr( $max_vids );
		$vid_h_val = ( $vid_h == '' ) ? "auto" : esc_attr( $vid_h );
		$vid_w_val = ( $vid_w == '' ) ? "auto" : esc_attr( $vid_w );
		$key = "AIzaSyCwo5FQlBqYxOd-LT39WmB_xLlR9Ydugjo";
		$api_1_meta = ( $is_channel_id !== '' ) ? "&id=" . $product_id : "&forUsername=" . $product_id;
		$api_1 = "https://www.googleapis.com/youtube/v3/channels?part=snippet$api_1_meta&key=$key";
		$request = wp_remote_get( $api_1 );
		$json_1 = wp_remote_retrieve_body( $request );
		$json_data_1 = json_decode($json_1, false);
		$channel_id = $json_data_1->items[0]->id;
		$channel_name = esc_attr( $json_data_1->items[0]->snippet->title );
		$channel_thumb = esc_attr( $json_data_1->items[0]->snippet->thumbnails->high->url );
		$api_meta_all = "&id=$channel_id";
		$api_2 = "https://www.googleapis.com/youtube/v3/channels?part=statistics$api_meta_all&key=$key";
		$api_3 = "https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=$channel_id&maxResults=$max_vids_val&key=$key&type=video";
		$api_4 = "https://www.googleapis.com/youtube/v3/search?order=viewCount&part=snippet&channelId=$channel_id&maxResults=$max_vids_val&key=$key&type=video";
		$request_2 = wp_remote_get( $api_2 );
		$json_2 = wp_remote_retrieve_body( $request_2 );
		$json_data_2 = json_decode( $json_2, false );
		$request_3 = wp_remote_get( $api_3 );
		$json_3 = wp_remote_retrieve_body( $request_3 );
		$json_data_3 = json_decode( $json_3, false );
		$request_4 = wp_remote_get( $api_4 );
		$json_4 = wp_remote_retrieve_body( $request_4 );
		$json_data_4 = json_decode( $json_4, false );
		$channel_link = "https://youtube.com/channel/$channel_id/";
		$subscribe_button = "
			<div class=\"g-ytsubscribe\" data-channelid=\"$channel_id\" data-layout=\"default\" data-count=\"default\">
				<a href=\"$channel_link?sub_confirmation=1\">subscribe</a>
			</div>
		";
		$last_uploads = "";
		$id_verify = '';

		if ( ! empty( $json_data_3->items ) ) :
			foreach ( $json_data_3->items as $item ) {

				$id = $item->id->videoId;
				$id_verify .= $id;
				$last_uploads .=
				"<iframe id=\"ytplayer\" type=\"text/html\" width=\"$vid_w_val\" height=\"$vid_h_val\" src=\"//www.youtube.com/embed/$id?rel=0&showinfo=1\" frameborder=\"0\" allowfullscreen></iframe>
				<div style=\"height: .55em;\"></div>";

			}
		endif;

		if ( $id_verify == '' )
			$last_uploads = "<p>Apologize, nothing found for this channel.</p>";
		else
			$last_uploads .= "<a href=\"" . $channel_link . "videos\" title=\"More uploads of $channel_name on YouTube\" class=\"yiw-more\">Browse more &raquo;</a>";
		$popular_uploads = "";
		$id_verify = '';

		if ( ! empty( $json_data_4->items ) ) :
			foreach ( $json_data_4->items as $item ) {

				$id = $item->id->videoId;
				$id_verify .= $id;
				$popular_uploads .=
				"<iframe id=\"ytplayer\" type=\"text/html\" width=\"$vid_w_val\" height=\"$vid_h_val\" src=\"//www.youtube.com/embed/$id?rel=0&showinfo=1\" frameborder=\"0\" allowfullscreen></iframe>
				<div style=\"height: .55em;\"></div>";

			}
		endif;

		if ( $id_verify == '' )
			$popular_uploads = "<p>Apologize, nothing found for this channel.</p>";
		else
			$popular_uploads .= "<a href=\"" . $channel_link . "videos?sort=p&flow=grid&view=0\" title=\"More popular uploads of $channel_name on YouTube\" class=\"yiw-more\">Browse more &raquo;</a>";
		$channel_info = '';
		$info_about = esc_attr( nl2br( $json_data_1->items[0]->snippet->description ) );
		$info_subs = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->subscriberCount ) );
		$info_vids = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->videoCount ) );
		$info_view = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->viewCount ) );
		$info_comment = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->commentCount ) );
		$channel_info .= ( $info_about != '' ) ? "<p><strong>About:</strong><br class=\"clear\"> $info_about </p>" : "";
		$channel_info .= ( $info_subs != '' ) ? "<p><strong>Total subscribers:</strong><br class=\"clear\"> $info_subs </p>" : "";
		$channel_info .= ( $info_vids != '' ) ? "<p><strong>Total uploads:</strong><br class=\"clear\"> $info_vids </p>" : "";
		$channel_info .= ( $info_view != '' ) ? "<p><strong>Total upload views:</strong><br class=\"clear\"> $info_view </p>" : "";
		$channel_info .= ( $info_comment != '' ) ? "<p><strong>Total comments:</strong><br class=\"clear\"> $info_comment </p>" : "";

		if ( $channel_info == '' )
			$channel_info = "<p>Apologize, nothing found for this channel.</p>";
		if ( false === $op_1 ) {
			set_transient( 'liteyiw_op_1_' . $product_id , esc_attr( $channel_name ), $cc_period );
		}
		if ( false === $op_2 ) {
			set_transient( 'liteyiw_op_2_' . $product_id , esc_attr( $channel_link ), $cc_period);
		}
		if ( false === $op_3 ) {
			set_transient('liteyiw_op_3_' . $product_id , esc_attr( $channel_thumb ), $cc_period );
		}
		if ( false === $op_4 ) {
			set_transient( 'liteyiw_op_4_' . $product_id , esc_attr( $subscribe_button ), $cc_period );
		}
		if ( false === $op_5 ) {
			set_transient( 'liteyiw_op_5_' . $product_id , esc_attr( $last_uploads ), $cc_period );
		}
		if ( false === $op_6 ) {
			set_transient( 'liteyiw_op_6_' . $product_id , esc_attr( $popular_uploads ), $cc_period );
		}
		if ( false === $op_7 ) {
			set_transient( 'liteyiw_op_7_' . $product_id , esc_attr( $channel_info ), $cc_period );
		}
		if ( false === $last_update ) {
			set_transient( 'liteyiw_last_update_' . $product_id , esc_attr( time() ), $cc_period );
		}
		if ( false === $force_update ) {
			set_transient( 'liteyiw_force_update_' . $product_id , '0', $cc_period );
		}

		// using the new cached data without the need to get them from database
		$op_1 = $channel_name;
		$op_2 = $channel_link;
		$op_3 = $channel_thumb;
		$op_4 = $subscribe_button;
		$op_5 = $last_uploads;
		$op_6 = $popular_uploads;
		$op_7 = $channel_info;

	}
	// if cache clearing isn't needed, output the existing cache
	?>
		<?php $rndm = rand("1", "999"); ?>
		<div id="ytio-container">
			<div id="ytio-avatar">
				<div id="ytio-left" class="inline">
					<a href="<?php echo html_entity_decode( $op_2 ); ?>" title="<?php echo html_entity_decode( $op_1 ); ?>">
						<img src="<?php echo html_entity_decode( $op_3 ); ?>" height="90" width="90" alt="<?php echo html_entity_decode( $op_1 ); ?>" />
					</a>
				</div>
				<div id="ytio-right" class="inline">
					<a href="<?php echo html_entity_decode( $op_2 ); ?>">
						<span><?php echo html_entity_decode( $op_1 ); ?></span>
					</a><br class="clear" />
					<?php echo html_entity_decode( $op_4 ); ?>
				</div>
			</div>

			<div id="ytio-uploads">
				<div id="ytio-switch">
					<span id="sw-st-<?php echo $rndm; ?>"  onclick="this.setAttribute('class','active'),document.getElementById('sw-nd-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('sw-rd-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-last-uploads-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-popular-uploads-<?php echo $rndm; ?>').setAttribute('class','ytio-hid'),document.getElementById('ytio-stats-<?php echo $rndm; ?>').setAttribute('class','ytio-hid');" class="active">
						<?php echo $s_1; ?>
					</span>
					<span id="sw-nd-<?php echo $rndm; ?>" onclick="this.setAttribute('class','active'),document.getElementById('sw-st-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('sw-rd-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-popular-uploads-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-last-uploads-<?php echo $rndm; ?>').setAttribute('class','ytio-hid'),document.getElementById('ytio-stats-<?php echo $rndm; ?>').setAttribute('class','ytio-hid');">
						<?php echo $s_2; ?>
					</span>
					<span id="sw-rd-<?php echo $rndm; ?>" onclick="this.setAttribute('class','active'),document.getElementById('sw-st-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('sw-nd-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-stats-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-last-uploads-<?php echo $rndm; ?>').setAttribute('class','ytio-hid'),document.getElementById('ytio-popular-uploads-<?php echo $rndm; ?>').setAttribute('class','ytio-hid');">
						<?php echo $s_3; ?>
					</span>
				</div>
				<div style="padding: 1em;">
					<div id="ytio-last-uploads-<?php echo $rndm; ?>">
						<?php echo html_entity_decode( $op_5 ); ?>
					</div>
					<div id="ytio-popular-uploads-<?php echo $rndm; ?>" class="ytio-hid">
						<?php echo html_entity_decode( $op_6 ); ?>
					</div>
					<div id="ytio-stats-<?php echo $rndm; ?>" class="ytio-hid">
						<?php echo html_entity_decode( $op_7 ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php
}

// little function to return short numbers, like 1.4k instead of 1400
function yiw_pretty_num ( $num ) {

	if(empty ($num) ) {
			return false;
	} else {
		if( $num < 1000 )
			return $num;
		$x = round($num);
		$x_number_format = number_format($x);
		$x_array = explode(',', $x_number_format);
		$x_parts = array(' thousand', ' million', ' billion', ' trillion');
		$x_count_parts = count($x_array) - 1;
		$x_display = $x;
		$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
		$x_display .= $x_parts[$x_count_parts - 1];
		return $x_display;
	}

}
// load the widget
function yiw_load_widget() {
	register_widget( 'liteyiw_widget' );
}
add_action( 'widgets_init', 'yiw_load_widget' );

add_action( 'wp_enqueue_scripts', 'yiw_enqueue_scripts' );

function yiw_enqueue_scripts() {
	wp_enqueue_style('ytio-css', plugin_dir_url( __FILE__ ) . 'style.css' );
	wp_enqueue_script( 'platform', 'https://apis.google.com/js/platform.js', array(), '1.0.0', true );
}

add_action( 'admin_enqueue_scripts', 'yiw_enqueue_admin_scripts' );

function yiw_enqueue_admin_scripts() {
	global $pagenow;

	if( $pagenow === 'widgets.php' ) {
		wp_enqueue_script( 'toggle-js', plugin_dir_url( __DIR__ ) . 'assets/js/toggle-help.js', array(), '1.0.0', true );
	}
}

add_action('wp_head', 'yiw_lite_custom_css');
// enqueue custom css
function yiw_lite_custom_css() {
	?>
		<style type="text/css"><?php echo get_option('ytiw_s_6') != "" ? get_option('ytiw_s_6') : ''; ?></style>
	<?php
}

// adds Settings and Donate links in the plugin's snippet in admin plugins list (plugins.php) 
function yiw_settings_link( $links ) {
    $link = '<a href="options-general.php?page=yt-info&pg=settings">' . __( 'Settings' ) . '</a>';
    array_push( $links, $link );
  	return $links;
}

$plugin = "youtube-information-widget/youtube-information-widget.php";
//$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'yiw_settings_link' );
// widget shortcode
function yiw_widget_shortcode( $atts ) {

	$a = shortcode_atts( array(
        'channel' => 'channel',
        'id' => 'id',
        'max' => '',
        'height' => '',
        'width' => '',
        'cache' => 'cache'
    ), $atts );
	$s_1 = ( get_option('ytiw_s_1') != "" ) ? get_option('ytiw_s_1') : __( "Recent", "wordpress" );
	$s_2 = ( get_option('ytiw_s_2') != "" ) ? get_option('ytiw_s_2') : __( "Popular", "wordpress" );
	$s_3 = ( get_option('ytiw_s_3') != "" ) ? get_option('ytiw_s_3') : __( "Info", "wordpress" );
	$s_4 = ( get_option('ytiw_s_4') != "" ) ? get_option('ytiw_s_4') : '2';
	$s_5 = ( get_option('ytiw_s_5') != "" ) ? get_option('ytiw_s_5') : '2';
	$product_id = esc_attr( "{$a['channel']}" );
	$max_vids = ( "{$a['max']}" !== '' && is_numeric( "{$a['max']}" ) ) ? esc_attr( "{$a['max']}" ) : $s_5;
	$vid_h = ( "{$a['height']}" !== '' && is_numeric( "{$a['height']}" ) ) ? esc_attr( "{$a['height']}" ) : 'auto';
	$vid_w = ( "{$a['width']}" !== '' && is_numeric( "{$a['width']}" ) ) ? esc_attr( "{$a['width']}" ) : 'auto';
	$cc_period = ( "{$a['cache']}" !== '' && is_numeric( "{$a['cache']}" ) ) ? esc_attr( "{$a['cache']}" ) : $s_4;
	$is_channel_id = esc_attr( "{$a['id']}" );
	$key = "AIzaSyCwo5FQlBqYxOd-LT39WmB_xLlR9Ydugjo";
	$api_1_meta = ( $is_channel_id !== 'id' ) ? "&id=" . $product_id : "&forUsername=" . $product_id;
	$api_1 = "https://www.googleapis.com/youtube/v3/channels?part=snippet$api_1_meta&key=$key";
	$request_1 = wp_remote_get( $api_1 );
	$json_1 = wp_remote_retrieve_body( $request_1 );
	$json_data_1 = json_decode($json_1, false);
	$channel_id = esc_attr( $json_data_1->items[0]->id );
	$rand = "shortcode_" . $channel_id . "_meta_" . $max_vids . "_" . $cc_period;
	if ( $product_id == 'channel' || $rand == '' ) {
		echo "<p> DX Info Widget for YouTube needs to be configured, kindly fill out a YouTube username or channel ID from your dashboard widgets area. </p>";
		return false;
	}
	$last_update = esc_attr( get_transient( "liteyiw_last_update_$product_id" ) );
	$op_1 = esc_attr( get_transient( "liteyiw_op_1_$product_id" ) );
	$op_2 = esc_attr( get_transient( "liteyiw_op_2_$product_id" ) );
	$op_3 = esc_attr( get_transient( "liteyiw_op_3_$product_id" ) );
	$op_4 = esc_attr( get_transient( "liteyiw_op_4_$product_id" ) );
	$op_5 = esc_attr( get_transient( "liteyiw_op_5_$product_id" ) );
	$op_6 = esc_attr( get_transient( "liteyiw_op_6_$product_id" ) );
	$op_7 = esc_attr( get_transient( "liteyiw_op_7_$product_id" ) );
	$force_update = esc_attr( get_transient( "liteyiw_force_update_$product_id" ) );
	$date1 = ($last_update);
	$date2 = time();
	if( ! empty( $date1 ) && ! empty( $date2 ) ) {
		$subTime = $date1 - $date2;
		$m = str_replace("-", "", ($subTime/60)%60 );
		$h = str_replace("-", "", ($subTime/(60*60))%24 );
	} else {
		$h = 0;
	}
	$cc_period_val = ( $cc_period !== '' && is_numeric( $cc_period ) ) ? esc_attr( $cc_period ) : $s_4;
	// empties the existing cache, and gets fresh new one
	if ( $h >= $cc_period_val || $last_update == '' || $force_update == "1" ) {
		
		$max_vids_val = ( $max_vids == '' && !is_numeric( $max_vids ) ) ? $s_5 : esc_attr( $max_vids );
		$vid_h_val = ( $vid_h == '' ) ? "auto" : esc_attr( $vid_h );
		$vid_w_val = ( $vid_w == '' ) ? "auto" : esc_attr( $vid_w );
		$channel_name = esc_attr( $json_data_1->items[0]->snippet->title );
		$channel_thumb = esc_attr( $json_data_1->items[0]->snippet->thumbnails->high->url );
		$api_meta_all = "&id=$channel_id";
		$api_2 = "https://www.googleapis.com/youtube/v3/channels?part=statistics$api_meta_all&key=$key";
		$api_3 = "https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=$channel_id&maxResults=$max_vids_val&key=$key&type=video";
		$api_4 = "https://www.googleapis.com/youtube/v3/search?order=viewCount&part=snippet&channelId=$channel_id&maxResults=$max_vids_val&key=$key&type=video";
		$request_2 = wp_remote_get( $api_2 );
		$json_2 = wp_remote_retrieve_body( $request_2 );
		$json_data_2 = json_decode( $json_2, false );
		$request_3 = wp_remote_get( $api_3 );
		$json_3 = wp_remote_retrieve_body( $request_3 );
		$json_data_3 = json_decode( $json_3, false );
		$request_4 = wp_remote_get( $api_4 );
		$json_4 = wp_remote_retrieve_body( $request_4 );
		$json_data_4 = json_decode( $json_4, false );

		$channel_link = "https://youtube.com/channel/$channel_id/";
		$subscribe_button = "
			<div class=\"g-ytsubscribe\" data-channelid=\"$channel_id\" data-layout=\"default\" data-count=\"default\">
				<a href=\"$channel_link?sub_confirmation=1\">subscribe</a>
			</div>
		";
		$last_uploads = "";
		$id_verify = '';
		foreach ( $json_data_3->items as $item ) {

			$id = $item->id->videoId;
			$id_verify .= $id;
			$last_uploads .=
			"<iframe id=\"ytplayer\" type=\"text/html\" width=\"$vid_w_val\" height=\"$vid_h_val\" src=\"//www.youtube.com/embed/$id?rel=0&showinfo=1\" frameborder=\"0\" allowfullscreen></iframe>
			<div style=\"height: .55em;\"></div>";

		}
		if ( $id_verify == '' )
			$last_uploads = "<p>Apologize, nothing found for this channel.</p>";
		else
			$last_uploads .= "<a href=\"" . $channel_link . "videos\" title=\"More uploads of $channel_name on YouTube\" class=\"yiw-more\">Browse more &raquo;</a>";
		$popular_uploads = "";
		$id_verify = '';
		foreach ( $json_data_4->items as $item ) {

			$id = $item->id->videoId;
			$id_verify .= $id;
			$popular_uploads .=
			"<iframe id=\"ytplayer\" type=\"text/html\" width=\"$vid_w_val\" height=\"$vid_h_val\" src=\"//www.youtube.com/embed/$id?rel=0&showinfo=1\" frameborder=\"0\" allowfullscreen></iframe>
			<div style=\"height: .55em;\"></div>";

		}
		if ( $id_verify == '' )
			$popular_uploads = "<p>Apologize, nothing found for this channel.</p>";
		else
			$popular_uploads .= "<a href=\"" . $channel_link . "videos?sort=p&flow=grid&view=0\" title=\"More popular uploads of $channel_name on YouTube\" class=\"yiw-more\">Browse more &raquo;</a>";
		$channel_info = '';
		$info_about = esc_attr( nl2br( $json_data_1->items[0]->snippet->description ) );
		$info_subs = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->subscriberCount ) );
		$info_vids = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->videoCount ) );
		$info_view = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->viewCount ) );
		$info_comment = esc_attr( yiw_pretty_num( $json_data_2->items[0]->statistics->commentCount ) );
		$channel_info .= ( $info_about != '' ) ? "<p><strong>About:</strong><br class=\"clear\"> $info_about </p>" : "";
		$channel_info .= ( $info_subs != '' ) ? "<p><strong>Total subscribers:</strong><br class=\"clear\"> $info_subs </p>" : "";
		$channel_info .= ( $info_vids != '' ) ? "<p><strong>Total uploads:</strong><br class=\"clear\"> $info_vids </p>" : "";
		$channel_info .= ( $info_view != '' ) ? "<p><strong>Total upload views:</strong><br class=\"clear\"> $info_view </p>" : "";
		$channel_info .= ( $info_comment != '' ) ? "<p><strong>Total comments:</strong><br class=\"clear\"> $info_comment </p>" : "";

		if ( $channel_info == '' )
			$channel_info = "<p>Apologize, nothing found for this channel.</p>";
		if ( false === $op_1 )
			set_transient( "liteyiw_op_1_$product_id", esc_attr( $channel_name ), $cc_period );
		if ( false ===  $op_2 )
			set_transient( "liteyiw_op_2_$product_id", esc_attr( $channel_link ), $cc_period );
		if ( false === $op_3 )
			set_transient("liteyiw_op_3_$product_id", esc_attr( $channel_thumb ), $cc_period );
		if ( false === $op_4 )
			set_transient( "liteyiw_op_4_$product_id", esc_attr( $subscribe_button ), $cc_period );
		if ( false === $op_5 )
			set_transient( "liteyiw_op_5_$product_id", esc_attr( $last_uploads ), $cc_period );
		if ( false === $op_6 )
			set_transient( "liteyiw_op_6_$product_id", esc_attr( $popular_uploads), $cc_period );
		if ( false === $op_7 )
			set_transient( "liteyiw_op_7_$product_id", esc_attr( $channel_info), $cc_period );
		if ( false === $last_update )
			set_transient( "liteyiw_last_update_$product_id", esc_attr( time() ), $cc_period );
		if ( false === $force_update )
			set_transient( "liteyiw_force_update_$product_id", '0', $cc_period );

		// using the new cached data without the need to get them from database
		$op_1 = $channel_name;
		$op_2 = $channel_link;
		$op_3 = $channel_thumb;
		$op_4 = $subscribe_button;
		$op_5 = $last_uploads;
		$op_6 = $popular_uploads;
		$op_7 = $channel_info;

	}
	// if cache clearing isn't needed, output the existing cache
	ob_start();
	?>
		<?php $rndm = rand("1", "999"); ?>
		<div id="ytio-container">
			<div id="ytio-avatar">
				<div id="ytio-left" class="inline">
					<a href="<?php echo html_entity_decode( $op_2 ); ?>" title="<?php echo html_entity_decode( $op_1 ); ?>">
						<img src="<?php echo html_entity_decode( $op_3 ); ?>" height="90" width="90" alt="<?php echo html_entity_decode( $op_1 ); ?>" />
					</a>
				</div>
				<div id="ytio-right" class="inline">
					<a href="<?php echo html_entity_decode( $op_2 ); ?>">
						<span><?php echo html_entity_decode( $op_1 ); ?></span>
					</a><br class="clear" />
					<?php echo html_entity_decode( $op_4 ); ?>
				</div>
			</div>

			<div id="ytio-uploads">
				<div id="ytio-switch">
					<span id="sw-st-<?php echo $rndm; ?>"  onclick="this.setAttribute('class','active'),document.getElementById('sw-nd-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('sw-rd-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-last-uploads-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-popular-uploads-<?php echo $rndm; ?>').setAttribute('class','ytio-hid'),document.getElementById('ytio-stats-<?php echo $rndm; ?>').setAttribute('class','ytio-hid');" class="active">
						<?php echo $s_1; ?>
					</span>
					<span id="sw-nd-<?php echo $rndm; ?>" onclick="this.setAttribute('class','active'),document.getElementById('sw-st-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('sw-rd-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-popular-uploads-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-last-uploads-<?php echo $rndm; ?>').setAttribute('class','ytio-hid'),document.getElementById('ytio-stats-<?php echo $rndm; ?>').setAttribute('class','ytio-hid');">
						<?php echo $s_2; ?>
					</span>
					<span id="sw-rd-<?php echo $rndm; ?>" onclick="this.setAttribute('class','active'),document.getElementById('sw-st-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('sw-nd-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-stats-<?php echo $rndm; ?>').setAttribute('class',''),document.getElementById('ytio-last-uploads-<?php echo $rndm; ?>').setAttribute('class','ytio-hid'),document.getElementById('ytio-popular-uploads-<?php echo $rndm; ?>').setAttribute('class','ytio-hid');">
						<?php echo $s_3; ?>
					</span>
				</div>
				<div style="padding: 1em;">
					<div id="ytio-last-uploads-<?php echo $rndm; ?>">
						<?php echo html_entity_decode( $op_5 ); ?>
					</div>
					<div id="ytio-popular-uploads-<?php echo $rndm; ?>" class="ytio-hid">
						<?php echo html_entity_decode( $op_6 ); ?>
					</div>
					<div id="ytio-stats-<?php echo $rndm; ?>" class="ytio-hid">
						<?php echo html_entity_decode( $op_7 ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php
	return ob_get_clean();

}
add_shortcode('yt-info', 'yiw_widget_shortcode');