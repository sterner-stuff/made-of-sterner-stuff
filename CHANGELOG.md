## [11.4.0] - 2023-01-13
- Disable Gravity Forms update messages and background updates
- Flush Kinsta cache rather than WP-Rocket when present

## [11.3.1] - 2022-12-15
- Define Kinsta mu-plugin URL

## [11.3.0] - 2022-11-09
- Add sync-db command to pull from WP-CLI aliased environment

## [11.2.0] - 2022-10-18
- Add support for returning update information as JSON

## [11.1.0] - 2022-09-13
- Register `update` command
- Add WP-CLI stubs

## [11.0.1] - 2022-08-30
- Fix bug in update command when updating core

## [11.0.0] - 2022-03-15
- Add Postmark support
- Remove Kinsta CDN customization
- Remove wpFail2ban logic
- Refactor classes to use filter/action interfaces

## [10.4.0] - 2022-01-10
- Declare support for composer/installers 2.0

## [10.3.0] - 2022-01-10
- Add default support for Bedrock to Kinsta's CDN configuration

## [10.2.1] - 2021-12-09
- Fix fatal error w/ WP Migrate DB Pro preserved options

## [10.2.0] - 2021-12-07
- Disable admin email check
- Add MAINTENANCE_MODE_ENABLED and related features

## [10.1.1] - 2021-11-23
- Fix WP_CLI class error

## [10.1.0] - 2021-11-23
- Add deploy command
- Better mailer management

## [10.0.0] - 2021-11-10
- Add support for ACF_PRO_LICENSE
- Disable xmlrpc.php by default

## [9.2.0] - 2021-08-19
- Add Cloudflare support.

## [9.1.0] - 2021-02-02
- Add Jetpack staging/offline support
- Add Mailhog support, default to Mailhog

## [9.0.1] - 2020-11-25
- Update remaining env calls

## [9.0.0] - 2020-11-25
- Require oscarotero/env and version constraint

## [8.1.1] - 2020-08-17
### New
- Add MAILGUN_FROM_ADDRESS env configuration

## [8.1.0] - 2020-08-11
### Changed
- Prevent WP-Rocket from setting `WP_CACHE` constant

## [8.0.4] - 2020-07-29
### Fixed
- Fixed defaults for some constants

## [8.0.3] - 2020-07-23
### Fixed
- Fixed disable tracking logic

## [7.0.0] - 2019-05-10
### Changed
- Now installs as mu-plugin for license compatibility

## [6.3.0] - 2019-05-02
### Added
- Sensible Captcha defaults for Gravity Forms

## [6.2.0] - 2019-05-02
### Added
- Constant for Gravity Forms license from .env
- Constants for Delicious Brains licenses from .env
- Constants for Offload Media keys from .env
- Constant for TinyPNG API key from .env
- Dependency on roots/wp-config