<?php
/**
 * Plugin Name: Two-Factor Enforced
 * Description: Automatically enables Two-Factor authentication for newly registered users.
 * Plugin URI: https://github.com/timnashcouk/two-factor-enforced
 * Version: 1.2.1
 * Author: Tim Nash
 * Author URI: https://timnash.co.uk
 * Text Domain: two-factor-enforced
 * Requires at least: 6.7 
 * Tested up to: 6.7
 * Requires PHP: 8.1
 * Requires Plugins: two-factor
 * 
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package Two_Factor_Enforced
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hook into user registration to enable two-factor options.
 *
 * @param int $user_id The ID of the newly registered user.
 */
// Hook into user registration to enable two-factor options.
add_action(
	'user_register',
	function ( int $user_id ): void {
		// Check if the Two-Factor plugin is active.
		if ( ! class_exists( 'Two_Factor_Core' ) ) {
			return;
		}

		// Get the user object.
		$user = get_userdata( $user_id );
		if ( ! $user ) {
			return;
		}

		$enabled_roles = array();

		// Get roles for which two-factor is enabled via defined constant.
		if ( defined( 'TWO_FACTOR_ENFORCED_ROLES' ) && ! empty( TWO_FACTOR_ENFORCED_ROLES ) ) {
			$enabled_roles = TWO_FACTOR_ENFORCED_ROLES;
		}

		/**
		 * Filter to modify the roles for which two-factor is enabled by default.
		 *
		 * @param string[] $enabled_roles The list of roles for which two-factor is enabled by default.
		 */
		$enabled_roles = apply_filters( 'two_factor_enforced_roles', $enabled_roles );

		// Validate the roles. If not an array or empty, default to all roles.
		if ( ! is_array( $enabled_roles ) || empty( $enabled_roles ) ) {
			$enabled_roles = null; // Null implies all roles are eligible.
		}

		// Check if the user has an eligible role.
		if ( null !== $enabled_roles && ! array_intersect( $enabled_roles, $user->roles ) ) {
			return;
		}

		/**
		 * Filter to modify the two-factor provider(s).
		 *
		 * @param string[] $default_providers The default list of providers.
		 * @param int      $user_id           The ID of the newly registered user.
		 */
		$providers = apply_filters( 'two_factor_enforced_default_providers', array( 'Two_Factor_Email' ), $user_id );

		/**
		 * Filter to modify the primary two-factor provider.
		 *
		 * @param string $default_primary_provider The default primary provider.
		 * @param int    $user_id                  The ID of the newly registered user.
		 */
		$primary_provider = apply_filters( 'two_factor_enforced_primary_provider', 'Two_Factor_Email', $user_id );

		// Get a list of valid providers from the Two-Factor plugin.
		$valid_providers = array_keys( Two_Factor_Core::get_providers_registered() );

		// Validate that the primary provider is in the list of filtered providers & is a valid provider.
		if ( ! in_array( $primary_provider, $providers, true ) || ! in_array( $primary_provider, $valid_providers, true ) ) {
			return;
		}

		// Update user meta for two-factor methods.
		update_user_meta( $user_id, Two_Factor_Core::ENABLED_PROVIDERS_USER_META_KEY, $providers );

		// Update user meta for the primary two-factor method.
		update_user_meta( $user_id, Two_Factor_Core::PROVIDER_USER_META_KEY, $primary_provider );
	}
);
