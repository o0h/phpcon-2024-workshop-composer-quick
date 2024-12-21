<?php declare(strict_types=1);

require_once __DIR__ . '/../work/helper.php';

// alternate to 'common.php'

define('PJ_ROOT', dirname(__DIR__, 1));
define('WORK_DIR', __DIR__);
define('STAFFROOM_DIR', __DIR__ . '/../work/staffroom');
define('LOCK_FILE', implode(DIRECTORY_SEPARATOR, [WORK_DIR, 'composer.lock']));

require STAFFROOM_DIR . '/lib/Spy.php';
require STAFFROOM_DIR . '/lib/FileSystem.php';
require STAFFROOM_DIR . '/lib/WorkManager.php';
