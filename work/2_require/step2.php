<?php

$requirePackageNameList = ['aura/cli', 'psr/log'];

foreach ($requirePackageNameList as $requirePackageName) {
    processRequirePackage($requirePackageName); // この内部で `procedure2_2` が呼ばれます
}

function procedure2_2(string $packageVersionedMetaList): array
{
    /* === STEP-2 ココから === */



    return []; // 型宣言を満たすための仮置きのreturn。 @TODO 実装が完了したら削除してください
    /* === STEP-2 ココまで === */
}

