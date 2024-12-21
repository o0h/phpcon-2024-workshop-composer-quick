<?php declare(strict_types=1);

return function (array $vars) {
    $packageVersionedMetaListJsonList = \Staffroom\Spy::retrieve('receivedPackageVersionedMetaJsonList');
    if (!$packageVersionedMetaListJsonList) {
        return 'メタデータの取得がうまくいっていなそうです';
    }
    $packageVersionedMetaList = array_map('json_decode', $packageVersionedMetaListJsonList);
    $receivedPackageNameList = [];
    foreach ($packageVersionedMetaList as $packageVersionedMeta) {
        if ($packageVersionedMeta === null) {
            return 'メタデータが正しくJSONとして出力されていなそうです';
        }
        if (!property_exists($packageVersionedMeta, 'packages')) {
            return 'メタデータがうまく読み取れていなそうです(読み取ったデータにpackagesがありません)';
        }
        array_push(
            $receivedPackageNameList,
            ...array_keys(get_object_vars($packageVersionedMeta->packages)),
        );
    }
    if (!in_array('psr/log', $receivedPackageNameList, true)) {
        return 'psr/log のメタデータがうまく読み取れていなそうです';
    }
    if (!in_array('aura/cli', $receivedPackageNameList, true)) {
        return 'psr/log のメタデータがうまく読み取れていなそうです';
    }
    if (count($receivedPackageNameList) !== 2) {
        return '読み取られたパッケージの数が想定数と異なります';
    }
};
