1.0.1 / 2020-03-29
==================

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

1.0.0 / 2019-08-16
==================

Initial Release :tada: 
