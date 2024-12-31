
# Two-Factor Enforced

A WordPress plugin that extends, the WordPress plugin Two-Factor to automatically enable Two-Factor provider for newly registered users.




## Requirements
- PHP 8.1+
- WordPress 6.7+
- Two-Factor 0.10.0+
## Installation

### Manual Installation

Download the plugin ZIP file from this repository.
1. Upload the ZIP file via the Plugins > Add New > Upload Plugin section of your WordPress dashboard.
2. ctivate the plugin from the Plugins menu.

### WP-CLI Installation
Run the following via WP-CLI
```
wp cli plugin install https://github.com/timnashcouk/two-factor-enforced/releases/latest/two-factor-enforced.zip --activate 
```

    
## Usage/Examples
Once activated, the plugin will set all newly registered users to use the default Two-Factor Email Provider which uses the email they registered with.

### Enabling for specific roles
If you wish to only have specifical roles such as administrator enforced then this can be set:

- Through a define
- Through a filter

#### Defining roles
Within wp-config.php or similar config adding the following:
```
define( 'TWO_FACTOR_ENFORCED_ROLES', [ 'administrator' ] );
```
This will limit the enforcement to just admin users

#### Using a filter
The following can be used to filter the roles 

``` add_filter('two_factor_enabled_roles', function (): array {
    return ['administrator'];
});
```
### Changing Default Provider
By default the plugin will enable email as the default provider for a user. This can be changed via filters. 

> [!NOTE] 
> You need to change **BOTH** filters adding the new provider as the Primary and adding it into the list enabled for users.

```
add_filter('two_factor_enforced_default_providers', function (array $default_providers, int $user_id): array { return ['Two_Factor_Email', 'Two_Factor_Debug']; }, 10, 2); 
```
and 
```
php add_filter('two_factor_enforced_primary_provider', function (string $default_primary_provider, int $user_id): string { return 'Two_Factor_Debug'; }, 10, 2); 
```



## Support

Issues with code please do open a Github Issue. 
The plugin is supplied as is with no formal support.

## Changelog
See [CHANGELOG.md](https://github.com/timnashcouk/two-factor-enforced/blob/main/CHANGELOG.md) for notable changes per version.