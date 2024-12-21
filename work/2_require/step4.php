<?php

$requirePackageNameList = ['aura/cli', 'psr/log'];

foreach ($requirePackageNameList as $requirePackageName) {
    processRequirePackage($requirePackageName); // この内部で `procedure2_4` が呼ばれます
}


function procedure2_4(
    array   $packageMeta,
    ?string $lockFilePath = null,
): void
{
    $lockFilePath ??= __DIR__ . '/composer.lock';

    if (!file_exists($lockFilePath)) {
        file_put_contents($lockFilePath, json_encode(['packages' => [], 'packages-dev' => []]));
    }

    $rootPackageLock = loadJsonFile($lockFilePath);

    /* === STEP-4 ココから === */



    /* === STEP-4 ココまで === */
}
