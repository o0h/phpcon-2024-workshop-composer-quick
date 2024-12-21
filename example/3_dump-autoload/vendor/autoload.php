<?php
/* === STEP-4 ココから === */
$eagerLoadFiles = require '/opt/example/3_dump-autoload/vendor/autoload_files.php';
foreach ($eagerLoadFiles as $file) {
    require_once $file;
}

if (!class_exists('Psr4ClassLoader')) {
    require_once '/opt/example/3_dump-autoload/vendor/autoload.php';
}

$psr4ClassLoader = new Psr4ClassLoader('/opt/example/3_dump-autoload/vendor/autoload_classmap_psr4.php');
spl_autoload_register([$psr4ClassLoader, 'loadClass']);
/* === STEP-4 ココまで === */