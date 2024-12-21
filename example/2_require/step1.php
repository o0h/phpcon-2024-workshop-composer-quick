<?php
const BASE_PACKAGE_ENDPOINT_TEMPLATE = 'https://repo.packagist.org/p2/%s.json';

$requirePackageNameList = ['aura/cli', 'psr/log'];

foreach ($requirePackageNameList as $requirePackageName) {
    processRequirePackage($requirePackageName); // この内部で `procedure2_1` が呼ばれます
}

function procedure2_1 (string $requirePackageName): string
{
    /* === STEP-1 ココから === */
    $packageEndpoint = sprintf(BASE_PACKAGE_ENDPOINT_TEMPLATE, $requirePackageName);
    $packageVersionedMetaListJson = file_get_contents($packageEndpoint);
    return $packageVersionedMetaListJson;
    /* === STEP-2 ココまで === */
}

