vx.x.x / 2024-xx-xx
===================

v1.1.3 / 2024-05-07
===================

Fixes:
* Ensure support for ```php-webdriver/webdriver >= 1.15.0``` #16

  Thanks for report and investigation to @validaide-mark-bijl

v1.1.2 / 2024-04-18
===================

Features:
* Add support for ```Symfony 7``` #14

  Thanks to @ConstantBqt
* Add support for ```PHP 8.3``` #15

v1.1.1 / 2022-09-17
===================

Features:
* Add support for ```PHP 8.2``` #12

Fixes:
* Allow to pass variables/arrays to ```options``` in config #11
 
Misc:

* Rename branch ```master``` to ```main``` cause black lives matter. #9 #10

v1.1.0 / 2022-02-16
===================

Features:
* Add support for ```Symfony 6```
* Add support for ```PHP 8.1```
* Drop support for ```PHP 7.1``` cause of too much maintenance afford. Stick with ```v1.0.6``` if you want to use ```PHP 7.1```.

Misc:
* Use GitHub Actions instead of Travis CI for continuous integration.

v1.0.6 / 2021-03-30
===================

Features:
* Allow to pass a variable/array to manager options and not just scalar values
* Provide example in Readme on how to test if a file was downloaded 

v1.0.5 / 2021-03-14
===================

Features:
* Allow to pass kernel options and manager options to panther driver (#5 and #6; Thx to @phcorp)

v1.0.4 / 2021-02-23
===================

Features:
* Add support for ```PHP 8.0```

Misc:
* Support and use composer 2 in Dockerfile
* Add support for local development with ```PHP 7.1```, ```PHP 7.2```, ```PHP 7.3```, ```PHP 7.4``` and ```PHP 8.0``` via ```docker-compose.yml```

v1.0.3 / 2020-09-21
===================

Features:
* switch to ```friends-of-behat/mink-extension``` from ```behat/mink-extension```
  cause it is recommended to switch at the moment and there is no real support for ```behat/mink-extension``` with symfony 5.x
  If you want to stay with ```behat/mink-extension``` then you have to pin ```v1.0.2```.

v1.0.2 / 2020-09-21
===================

Features:
* Add support for symfony 5 using ```behat/mink-extension```
  But as a drawback you need to add following in your ```composer.json```:
```JSON
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/chadyred/MinkExtension"
        }
    ],
```

v1.0.1 / 2020-03-29
===================

Features: 
* Enabled configuration per driver instance; usage examples with all sessions using mink-panther-driver:
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
                           webServerDir: '%paths.base%/public'
               javascript_firefox:
                   panther:
                       options:
                           browser: 'firefox'
```

Testsuite:

* Enabled travis at all with phpunit and behat for PHP 7.1-7.4 
* Added PHP 7.4 in the CI
* Added Unit Tests
* Added one simple scenario test with behat

v1.0.0 / 2019-08-16
===================

Initial Release :tada: 
