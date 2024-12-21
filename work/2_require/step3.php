<?php

$requirePackageNameList = ['aura/cli', 'psr/log'];

foreach ($requirePackageNameList as $requirePackageName) {
    processRequirePackage($requirePackageName); // この内部で `procedure2_2` が呼ばれます
}


function procedure2_3(
    array   $packageMeta,
    ?string $jsonFilePath = null,
): void
{
    $jsonFilePath ??= __DIR__ . '/composer.json';

    if (!file_exists($jsonFilePath)) {
        file_put_contents($jsonFilePath, json_encode(['require' => new stdClass()]));
    }

    $rootPackage = loadJsonFile($jsonFilePath);

    /* === STEP-3 ココから === */


    /* === STEP-3 ココまで === */
}
