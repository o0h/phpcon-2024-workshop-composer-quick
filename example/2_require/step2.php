<?php
$requirePackageNameList = ['aura/cli', 'psr/log'];

foreach ($requirePackageNameList as $requirePackageName) {
    processRequirePackage($requirePackageName); // この内部で `procedure2_2` が呼ばれます
}

function procedure2_2(string $packageVersionedMetaList): array
{
    /* === STEP-2 ココから === */
    $packageVersionedMetaList = json_decode($packageVersionedMetaList, true);
    $packageVersionedMetaPackages = current($packageVersionedMetaList['packages']);

    $packageData = [];
    foreach ($packageVersionedMetaPackages as $packageVersionedMetaPackage) {
        $packageData = array_merge($packageData, $packageVersionedMetaPackage);
        $versionNormalized = $packageVersionedMetaPackage['version'];
        if (str_contains($versionNormalized, '-')) {
            $suffix = explode('-', $versionNormalized)[1];
            if (preg_match('#('.implode('|', ['dev', 'alpha', 'beta', 'rc']).')#i', $suffix)) {
                continue;
            }
        }
        break;
    }

    return $packageData;
    /* === STEP-2 ココまで === */
}

