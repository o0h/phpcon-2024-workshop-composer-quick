<?php

define('PJ_ROOT', dirname(__DIR__, 2));
define('WORK_DIR', dirname(__DIR__, 1));
define('STAFFROOM_DIR', __DIR__);
define('LOCK_FILE', implode(DIRECTORY_SEPARATOR, [WORK_DIR, 'composer.lock']));

require __DIR__ . '/lib/Spy.php';
require __DIR__ . '/lib/FileSystem.php';
require __DIR__ . '/lib/WorkManager.php';

