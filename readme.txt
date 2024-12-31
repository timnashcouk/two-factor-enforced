=== Two-Factor Enforced === 
Contributors: tnash 
Tags: 2fa, mfa, totp, authentication, security
Requires at least: 6.7 
Tested up to: 6.7 
Stable tag:   1.2.1
License:      GPL-3.0-or-later
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
Automatically enables two-factor authentication for new users, with customizable settings for roles and providers.

== Description == 
The **Two-Factor Enforced** plugin extends the functionality of the Two-Factor plugin by automatically enabling two-factor authentication for newly registered users. The plugin: - Enables email as the default two-factor provider. - Allows developers to customize the providers and primary provider using filters. - Includes the ability to restrict two-factor authentication to specific user roles.

== Features == 
- Automatically sets up two-factor authentication for new users. 
- Default provider is **Two-Factor Email**. 
- Use filters to customize two-factor providers and primary provider. 
- Restrict two-factor authentication to specific user roles using a filter. 

== Installation == 
1. Download the plugin and upload it to your `/wp-content/plugins/` directory. 
2. Activate the plugin through the **Plugins** menu in WordPress. 
3. Ensure the **Two-Factor plugin** is installed and active for this plugin to work.

== Filters == The plugin provides three filters to customize its behavior:

### 1. `two_factor_enabled_roles` 
**Description**: Restrict two-factor authentication to specific roles. 
**Default Behavior**: All roles are eligible for two-factor authentication if the filter is not applied or returns invalid data. 
**Example: Restrict to 'administrator' and 'editor' roles** 
```php add_filter('two_factor_enforced_roles', function (): array { return ['administrator', 'editor']; }); ```

### 2. `tfa_default_providers` 
**Description**: Customize the list of two-factor providers enabled for new users. 
**Default Behavior**: Only `Two_Factor_Email` is enabled by default. 
**Example: Add `Two_Factor_Totp` as an additional provider** 
```php add_filter('two_factor_enforced_default_providers', function (array $default_providers, int $user_id): array { return ['Two_Factor_Email', 'Two_Factor_Totp']; }, 10, 2); ```

### 3. `tfa_primary_provider`
**Description**: Customize the primary two-factor provider for new users. 
**Default Behavior**: The primary provider is set to `Two_Factor_Email` by default. 
**Example: Change the primary provider to `Two_Factor_Totp`** 
```php add_filter('two_factor_enforced_primary_provider', function (string $default_primary_provider, int $user_id): string { return 'Two_Factor_Totp'; }, 10, 2); ```

== Frequently Asked Questions == 
**1. Does this plugin work without the Two-Factor plugin?** 
No, the Two-Factor plugin must be installed and active for this plugin to function. 
**2. Can I enable two-factor for specific roles only?** 
Yes, use the `two_factor_enforced_roles` filter to restrict which roles are eligible for automatic two-factor setup. 
**3. How can I add more two-factor providers?** 
Use the `two_factor_enabled_default_providers` filter to add additional providers. 
**4. Can I change the primary two-factor provider?** 
Yes, use the `two_factor_enforced_primary_provider` filter to set a different primary provider.

== Changelog == 
= 1.2.1 = - Very Minor fixes to Readme and headers to meet the WP.org requirements.
= 1.2.0 = - Added `two_factor_enabled_roles` filter to restrict two-factor authentication to specific roles. - Improved error handling and logging. 
= 1.1.0 = - Added filters for customizing two-factor providers and primary provider. 
= 1.0.0 = - Initial release with default functionality for enabling two-factor authentication.

== Upgrade Notice == 
Ensure the **Two-Factor plugin** is installed and active before upgrading to ensure compatibility.