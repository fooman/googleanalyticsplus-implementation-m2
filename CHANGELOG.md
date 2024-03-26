# Change Log

## [Unreleased]

## [105.3.1] - 2024-03-26
### Changed
- With Google's retirement of Google Analytics in favour of GA4 this package is no longer useful at it built on top of Magento's core Google Analytics implementation

## [105.3.0] - 2023-03-08
### Added
- Support for Php 8.2
### Changed
- Minimum Magento version is now 2.3.0 - for earlier versions please use previous releases

## [105.2.0] - 2022-04-12
### Added
- Support for Php 8.0/8.1

## [105.1.0] - 2020-07-30
### Added
- Compatibility with Magento 2.4.0
- Support for Php 7.4
- Ability to switch tracked url to be based on requested uri

## [105.0.1] - 2019-10-08
### Fixed
- Normalised url was not used

## [105.0.0] - 2019-09-26
### Security
- Fixed potential XSS due to wrong escape method used

## [104.0.1] 2018-12-02
### Changed
- Reorganised unit tests

## [104.0.0] 2018-12-02
### Changed
- Package name renamed to fooman/googleanalyticsplus-implementation-m2, installation should be via metapackage fooman/googleanalyticsplus-m2
- Increased version number by 100 to differentiate from metapackage
### Fixed
- Add currency code on order tracking data
### Added
- Support for Magento 2.3

## [3.0.0] 2017-09-27
### Changed
- Rewrite to support Magento 2.2.0, most of the added logic is now in 
src/view/frontend/web/js/google-analytics.js
### Added
- Support for PHP 7.1

## [2.0.5] 2017-06-05
### Changed
- Specify compatible php versions

## [2.0.4] 2016-12-30
### Fixed
- Update functional tests to work with 2.1.x

## [2.0.3] - 2016-03-13
### Added
- Initial release for Magento 2
