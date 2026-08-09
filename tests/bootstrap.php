<?php

/*
 * PHPUnit's <php><env .../></php> configuration only populates putenv() and
 * $_ENV — never $_SERVER. Laravel's env() helper prefers $_SERVER, so when an
 * environment variable (e.g. APP_ENV) is already exported in the parent shell
 * and therefore present in $_SERVER, the test process would resolve the wrong
 * value (e.g. "local" instead of "testing"). That flips app()->runningUnitTests()
 * to false, disables the CSRF test bypass, and makes every POST return 419.
 *
 * Mirror the values PHPUnit already applied into $_SERVER before the Laravel
 * application is booted so tests always run in the expected environment.
 */

$testEnvKeys = [
    'APP_ENV',
    'APP_MAINTENANCE_DRIVER',
    'BCRYPT_ROUNDS',
    'BROADCAST_CONNECTION',
    'CACHE_STORE',
    'DB_CONNECTION',
    'DB_DATABASE',
    'DB_URL',
    'MAIL_MAILER',
    'QUEUE_CONNECTION',
    'SESSION_DRIVER',
    'PULSE_ENABLED',
    'TELESCOPE_ENABLED',
    'NIGHTWATCH_ENABLED',
];

foreach ($testEnvKeys as $key) {
    if (array_key_exists($key, $_ENV)) {
        $_SERVER[$key] = $_ENV[$key];
    }
}

require __DIR__.'/../vendor/autoload.php';