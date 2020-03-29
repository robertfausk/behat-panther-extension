# BehatPantherExtension

[![Latest Stable Version](https://poser.pugx.org/robertfausk/behat-panther-extension/v/stable.svg)](https://packagist.org/packages/robertfausk/behat-panther-extension)
[![Latest Unstable Version](https://poser.pugx.org/robertfausk/behat-panther-extension/v/unstable.svg)](https://packagist.org/packages/robertfausk/behat-panther-extension)
[![Total Downloads](https://poser.pugx.org/robertfausk/behat-panther-extension/downloads.svg)](https://packagist.org/packages/robertfausk/behat-panther-extension)
[![Build Status](https://travis-ci.com/robertfausk/behat-panther-extension.svg?branch=master)](https://travis-ci.com/robertfausk/behat-panther-extension)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/robertfausk/behat-panther-extension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/robertfausk/behat-panther-extension/)
[![Code Coverage](https://scrutinizer-ci.com/g/robertfausk/behat-panther-extension/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/robertfausk/behat-panther-extension/)
[![SensioLabsInsight](https://img.shields.io/symfony/i/grade/79cf1602-c15a-4805-b9d6-ad46208a3c67?style=flat-square)](https://insight.sensiolabs.com/projects/79cf1602-c15a-4805-b9d6-ad46208a3c67)
[![SensioLabsInsight](https://img.shields.io/symfony/i/violations/79cf1602-c15a-4805-b9d6-ad46208a3c67?style=flat-square)](https://insight.sensiolabs.com/projects/79cf1602-c15a-4805-b9d6-ad46208a3c67)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
![PHP7 Compatible](https://img.shields.io/travis/php-v/robertfausk/behat-panther-extension/master?style=flat-square)
[![Open Issues](https://img.shields.io/github/issues-raw/robertfausk/behat-panther-extension?style=flat-square)](https://github.com/robertfausk/behat-panther-extension/issues)
[![Closed Issues](https://img.shields.io/github/issues-closed-raw/robertfausk/behat-panther-extension?style=flat-square)](https://github.com/robertfausk/behat-panther-extension/issues?q=is%3Aissue+is%3Aclosed)
[![Contributors](https://img.shields.io/github/contributors/robertfausk/behat-panther-extension?style=flat-square)](https://github.com/robertfausk/behat-panther-extension/graphs/contributors)
![Contributors](https://img.shields.io/maintenance/yes/2020?style=flat-square)

Symfony Panther extension for Behat

## Install

```BASH
composer require --dev robertfausk/behat-panther-extension
```

## Usage example

* Add ```Robertfausk\Behat\PantherExtension: ~``` to your behat.yml.
* Use ```panther``` session in ```Behat\MinkExtension```. 
* The extension will use options of ```symfony/panther``` by default.
Have a look at ```PantherTestCaseTrait::$defaultOptions``` for this.
* Following are some examples with all sessions using mink-panther-driver:
    ```YAML
    # in behat.yml
        extensions:
            Robertfausk\Behat\PantherExtension: ~ # no configuration here
            Behat\MinkExtension:
               javascript_session: javascript_chrome
               sessions:
                   default:
                       panther: ~
                   javascript:
                       panther:
                           options: ~
                   javascript_chrome:
                       panther:
                           options:
                               browser: 'chrome'
                               webServerDir: '%paths.base%/public' # your custom public dir
                   javascript_firefox:
                       panther:
                           options:
                               browser: 'firefox'
    ```

### How to upgrade?

 Have a look at [CHANGELOG](CHANGELOG.md) for detailed information.

## How to contribute?

Start docker-compose with php version of your choice. Currently there are php7.2, php7.3 and php7.4.

    docker-compose up php7.2

Run phpunit tests

    docker-compose run php7.2 vendor/bin/phpunit

## Credits

Created by Robert Freigang [robertfausk](https://github.com/robertfausk).

BehatPantherExtension is built on top of [symfony/panther](https://github.com/symfony/panther) and [robertfausk/mink-panther-driver]([Panther](https://github.com/robertfausk/mink-panther-driver)).
It is for usage with [Behat and Mink](http://behat.org/en/latest/cookbooks/integrating_symfony2_with_behat.html#initialising-behat). 
