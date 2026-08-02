<?php

declare(strict_types=1);

use Behat\Config\Config;
use Behat\Config\Extension;
use Behat\Config\Profile;
use Behat\Config\Suite;
use Robertfausk\Behat\PantherExtension;

return (new Config())
    ->withProfile((new Profile('default'))
        ->withSuite((new Suite('web'))
            ->withPaths('%paths.base%/tests/Behat/features')
            ->withContexts(
                Behat\MinkExtension\Context\MinkContext::class
            )
        )
        ->withExtension(new Extension(PantherExtension::class))
        ->withExtension(new Extension('Behat\MinkExtension', [
            'browser_name' => 'chrome',
            'javascript_session' => 'javascript_chrome',
            'base_url' => '',
            'sessions' => [
                'default' => ['panther' => ['options' => ['webServerDir' => '%paths.base%/public']]],
                'javascript' => ['panther' => ['options' => []]],
                'javascript_chrome' => ['panther' => ['options' => ['browser' => 'chrome', 'webServerDir' => '%paths.base%/public']]],
                'javascript_firefox' => ['panther' => ['options' => ['browser' => 'firefox']]],
            ],
        ]))
    );