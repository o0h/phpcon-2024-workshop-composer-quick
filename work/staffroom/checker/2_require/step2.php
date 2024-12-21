<?php declare(strict_types=1);

return function (array $vars) {
    $packageMetaList = \Staffroom\Spy::retrieve('receivedPackageMeta');
    if (!$packageMetaList) {
        return 'パッケージ情報の組み立てがうまくいっていなそうです(returnされたデータがありません)';
    }
    if (!array_all(
        $packageMetaList,
        fn($packageMeta) => (
            array_key_exists('name', $packageMeta) &&
            array_key_exists('dist', $packageMeta) &&
            array_key_exists('license', $packageMeta)
        )
    )) {
        return 'パッケージ情報の組み立てがうまくいっていなそうです(欠落しているフィールドがあります)';
    }

    $packageNameList = array_column($packageMetaList, 'name');
    if (!in_array('psr/log', $packageNameList, true)) {
        return 'psr/log のメタデータがうまく読み取れていなそうです';
    }
    if (!in_array('aura/cli', $packageNameList, true)) {
        return 'psr/log のメタデータがうまく読み取れていなそうです';
    }
    if (count($packageNameList) !== 2) {
        return '読み取られたパッケージの数が想定数と異なります';
    }
};
