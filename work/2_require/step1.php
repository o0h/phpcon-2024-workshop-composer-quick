<?php
const BASE_PACKAGE_ENDPOINT_TEMPLATE = 'https://repo.packagist.org/p2/%s.json';

$requirePackageNameList = ['aura/cli', 'psr/log'];

foreach ($requirePackageNameList as $requirePackageName) {
    processRequirePackage($requirePackageName); // この内部で `procedure2_1` が呼ばれます
}

function procedure2_1 (string $requirePackageName): string
{
    /* === STEP-1 ココから === */




    return ''; // 型宣言を満たすための仮置きのreturn。 @TODO 実装が完了したら削除してください
    /* === STEP-2 ココまで === */
}
