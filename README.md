# BehatPantherExtension

[![Latest Stable Version](https://poser.pugx.org/robertfausk/behat-panther-extension/v/stable.svg)](https://packagist.org/packages/robertfausk/behat-panther-extension)
[![Latest Unstable Version](https://poser.pugx.org/robertfausk/behat-panther-extension/v/unstable.svg)](https://packagist.org/packages/robertfausk/behat-panther-extension)
[![Total Downloads](https://poser.pugx.org/robertfausk/behat-panther-extension/downloads.svg)](https://packagist.org/packages/robertfausk/behat-panther-extension)
[![Monhtly Downloads](https://img.shields.io/packagist/dm/robertfausk/behat-panther-extension?style=flat&color=blue)](https://img.shields.io/packagist/dm/robertfausk/behat-panther-extension)
[![Daily Downloads](https://img.shields.io/packagist/dd/robertfausk/behat-panther-extension?style=flat&color=blue)](https://img.shields.io/packagist/dm/robertfausk/behat-panther-extension)
[![Tests](https://github.com/robertfausk/behat-panther-extension/actions/workflows/ci.yml/badge.svg)](https://github.com/robertfausk/behat-panther-extension/actions/workflows/ci.yml)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/robertfausk/behat-panther-extension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/robertfausk/behat-panther-extension/)
[![Code Coverage](https://scrutinizer-ci.com/g/robertfausk/behat-panther-extension/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/robertfausk/behat-panther-extension/)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)
[![PHP Version Require](http://poser.pugx.org/robertfausk/behat-panther-extension/require/php)](https://packagist.org/packages/robertfausk/behat-panther-extension)
[![Open Issues](https://img.shields.io/github/issues-raw/robertfausk/behat-panther-extension?style=flat)](https://github.com/robertfausk/behat-panther-extension/issues)
[![Closed Issues](https://img.shields.io/github/issues-closed-raw/robertfausk/behat-panther-extension?style=flat)](https://github.com/robertfausk/behat-panther-extension/issues?q=is%3Aissue+is%3Aclosed)
[![Contributors](https://img.shields.io/github/contributors/robertfausk/behat-panther-extension?style=flat)](https://github.com/robertfausk/behat-panther-extension/graphs/contributors)
![Contributors](https://img.shields.io/maintenance/yes/2024?style=flat)
[![Dependents](http://poser.pugx.org/robertfausk/behat-panther-extension/dependents)](https://packagist.org/packages/robertfausk/behat-panther-extension/dependents)

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
                   javascript_with_all_options:
                       panther:
                           options:
                               env:
                                   APP_ENV: 'dev'
                               hostname: '127.0.0.1'    
                           kernel_options: ~ # unused by behat-panther-extension cause it does not extend KernelTestCase
                           manager_options:
                               connection_timeout_in_ms: 5000
                               request_timeout_in_ms: 120000
    ```

#### Example on how to pass arguments to ChromeDriver binary

See also https://chromedriver.chromium.org/logging

```YAML
# in behat.yml enable logging
    extensions:
        Robertfausk\Behat\PantherExtension: ~
        Behat\MinkExtension:
           javascript_session: javascript
           sessions:
               javascript:
                   panther:
                       manager_options:
                           chromedriver_arguments:
                               - --log-path=/var/www/html/chromedriver.log
                               - --verbose
```

#### Example on how to test for a downloaded file

```YAML
# in behat.yml ensure that chrome saves files to the destination you want
    extensions:
        Robertfausk\Behat\PantherExtension: ~
        Behat\MinkExtension:
           javascript_session: javascript
           files_path: '%paths.base%/tests/files'
           sessions:
               javascript:
                   panther:
                       manager_options:
                           capabilities:
                                goog:chromeOptions:
                                    prefs:
                                        download.default_directory: '/var/www/html/tests/files/Downloads'
```

```GHERKIN
# acme_download.feature
Feature: Acme files can be downloaded

  Background:
    Given there is no file in download directory
    # additionally setup your database entries etc. if needed

  @javascript
  Scenario: As an user with role Admin i can download an existing acme file
    Given I am authenticated as "admin@acme.de"
    And I am on "/acme-file-list"
    Then I wait for "acme.pdf" to appear
    When I click on test element "button-acme-download"
    Then I can find file "acme.pdf" in download directory
```

```PHP
<?php
#AcmeContext.php

use Assert\Assertion;
use Behat\Mink\Element\NodeElement;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;


/**
 * @When /^I click on test element "([^"]*)"$/
 *
 * @param string $locator
 */
public function iClickOnTestElement(string $locator): void
{
    $btn = $this->getTestElement($locator);
    $btn->click();
}

/**
 * @Given /^there is no file in download directory$/
 */
public function thereIsNoFileinDownloadDirectory(): void
{
    $finder = new Finder();
    $fs = new Filesystem();
    $fs->remove($finder->in($this->getDownloadDirectory())->files());
}

/**
 * @Then /^I can find file "([^"]*)" in download directory$/
 */
public function iCanFindFileInDownloadDirectory($filename)
{
    $fs = new Filesystem();
    $path = \sprintf('%s%s%s', $this->getDownloadDirectory(), DIRECTORY_SEPARATOR, $filename);
    $this->spin(
        static function () use ($fs, $path): void {
            $isFileExisting = $fs->exists($path);
            Assertion::true($isFileExisting);
        },
    );
    Assertion::true($fs->exists($path));
}

private function getDownloadDirectory(): string
{
    return \sprintf('%s%sDownloads', $this->getMinkParameter('files_path'), DIRECTORY_SEPARATOR);
}

private function getTestElement(string $dataTestLocator, int $tries = 25): NodeElement
{
    return $this->getNodeElement("[data-test='$dataTestLocator']", $tries);
}

private function spin(\Closure $closure, ?int $tries = 25): ?NodeElement
{
    for ($i = 0; $i <= $tries; $i++) {
        try {
            return $closure();
        } catch (\Throwable $e) {
            if ($i === $tries) {
                throw $e;
            }
        }

        \usleep(100000); // 100 milliseconds
    }
}
```
                               
### How to upgrade?

 Have a look at [CHANGELOG](CHANGELOG.md) for detailed information.

## How to contribute?

Start docker-compose with php version of your choice. At the moment the following php versions can be used with docker-compose: `php7.2`, `php7.3`, `php7.4`, `php8.0`, `php8.1`, `php8.2` and `php8.3`.

E.g. you can start a container like this:

    docker-compose up php8.2

Upgrade scenario lock files:

    docker-compose run php8.2 composer update

Run phpunit tests:

    docker-compose run php8.2 vendor/bin/phpunit

If you want to start up all containers at once and keep them running in background then run the following:
```
docker-compose up -d php7.2
docker-compose up -d php7.3
docker-compose up -d php7.4
docker-compose up -d php8.0
docker-compose up -d php8.1
docker-compose up -d php8.2
docker-compose up -d php8.3
```

If you want to execute tests for scenario `symfony6` and `php8.2` then run the following:
```
docker-compose run php8.2 composer scenario symfony6
docker-compose run php8.2 vendor/bin/bdi detect drivers
docker-compose run php8.2 vendor/bin/behat --config=tests/Behat/behat.yml
docker-compose run php8.2 vendor/bin/phpunit
```

Or if you want to execute tests for scenario `symfony7` and `php8.3` then run the following:
```
docker-compose run php8.3 composer scenario symfony7
docker-compose run php8.3 vendor/bin/bdi detect drivers
docker-compose run php8.3 vendor/bin/behat --config=tests/Behat/behat.yml
docker-compose run php8.3 vendor/bin/phpunit
```

See also https://github.com/g1a/composer-test-scenarios for more information about scenarios.

## Credits

Created by Robert Freigang [robertfausk](https://github.com/robertfausk).

BehatPantherExtension is built on top of [symfony/panther](https://github.com/symfony/panther) and [robertfausk/mink-panther-driver](https://github.com/robertfausk/mink-panther-driver).
It is for usage with [Behat and Mink](http://behat.org/en/latest/cookbooks/integrating_symfony2_with_behat.html#initialising-behat). 
