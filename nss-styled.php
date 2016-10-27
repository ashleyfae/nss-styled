<?php
/**
 * Plugin Name: NSS - Styled Buttons
 * Plugin URI: https://www.nosegraze.com
 * Description: Styled Naked Social Share buttons.
 * Version: 1.0
 * Author: Nose Graze
 * Author URI: https://www.nosegraze.com
 * License: GPL2
 *
 * @package   nss-styled
 * @copyright Copyright (c) 2016, Nose Graze Ltd.
 * @license   GPL2+
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Add Stylesheet
 *
 * @since 1.0
 * @return void
 */
function nss_styled_stylesheet() {
	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_dequeue_style( 'nss-frontend' );

	wp_enqueue_style( 'nss-styled', plugin_dir_url( __FILE__ ) . 'css/nss-styled' . $suffix . '.css', array(), '1.0' );
}

add_action( 'wp_enqueue_scripts', 'nss_styled_stylesheet' );

/**
 * All Shares
 *
 * @param Naked_Social_Share_Buttons $nss_buttons
 *
 * @since 1.0
 * @return void
 */
function nss_styled_total_shares( $nss_buttons ) {
	$total = 0;

	foreach ( $nss_buttons->share_numbers as $site => $number ) {
		$total += $number;
	}

	if ( ! $total > 0 && apply_filters( 'nss-styled/hide-all-if-no-shares', false ) ) {
		return;
	}
	?>
	<li class="nss-all">
		<span>
			<i class="fa fa-share-alt" aria-hidden="true"></i>
				<span class="nss-total-count">
					<?php if ( $total > 0 ) : ?>
						<?php printf( _n( '<span>%s</span> Share', '<span>%s</span> Shares', absint( $total ), 'nss-styled' ), nss_styled_format_number( absint( $total ) ) ); ?>
					<?php else :
						echo apply_filters( 'nss-styled/no-shares-message', __( 'No shares yet!', 'nss-styled' ) );
					endif; ?>
				</span>
		</span>
	</li>
	<?php
}

add_action( 'naked-social-share/display/after-sites', 'nss_styled_total_shares' );

/**
 * Twitter Site Name
 *
 * @param string $name
 *
 * @since 1.0
 * @return string
 */
function nss_styled_twitter_name( $name ) {
	return __( 'Tweet', 'nss-styled' );
}

add_filter( 'naked-social-share/display/site-name/twitter', 'nss_styled_twitter_name' );

/**
 * Facebook Site Name
 *
 * @param string $name
 *
 * @since 1.0
 * @return string
 */
function nss_styled_general_share_name( $name ) {
	return __( 'Share', 'nss-styled' );
}

add_filter( 'naked-social-share/display/site-name/facebook', 'nss_styled_general_share_name' );
add_filter( 'naked-social-share/display/site-name/google', 'nss_styled_general_share_name' );
add_filter( 'naked-social-share/display/site-name/linkedin', 'nss_styled_general_share_name' );

/**
 * Pinterest Site Name
 *
 * @param string $name
 *
 * @since 1.0
 * @return string
 */
function nss_styled_pinterest_name( $name ) {
	return __( 'Pin', 'nss-styled' );
}

add_filter( 'naked-social-share/display/site-name/pinterest', 'nss_styled_pinterest_name' );

/**
 * StumbleUpon Site Name
 *
 * @param string $name
 *
 * @since 1.0
 * @return string
 */
function nss_styled_stumbleupon_name( $name ) {
	return __( 'Stumble', 'nss-styled' );
}

add_filter( 'naked-social-share/display/site-name/stumbleupon', 'nss_styled_stumbleupon_name' );

/**
 * Format Number
 *
 * @param int $number    Number to format.
 * @param int $precision Number of decimal places.
 *
 * @since 1.0
 * @return string
 */
function nss_styled_format_number( $number, $precision = 1 ) {
	if ( $number < 1000 ) {
		$n_format = $number;
	} elseif ( $number < 1000000 ) {
		// Anything less than a million
		$n_format = number_format( $number / 1000, $precision ) . 'K';
	} else if ( $number < 1000000000 ) {
		// Anything less than a billion
		$n_format = number_format( $number / 1000000, $precision ) . 'M';
	} else {
		// At least a billion
		$n_format = number_format( $number / 1000000000, $precision ) . 'B';
	}

	$n_format = str_replace( '.0', '', $n_format );

	return apply_filters( 'nss-styled/format-number', $n_format, $number, $precision );
}