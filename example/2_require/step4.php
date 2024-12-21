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
    $packageLock = [
        'name' => $packageMeta['name'],
        'version' => $packageMeta['version'],
        'source' => $packageMeta['source'],
        'dist' => $packageMeta['dist'],
        'license' => $packageMeta['license'],
    ];

    $packageName = $packageLock['name'];
    $packageIndex = array_find_key(
        $rootPackageLock['packages'],
        fn($package) => $package['name'] === $packageName,
    );
    if ($packageIndex === null) {
        $packageIndex = count($rootPackageLock['packages']);
    }
    $rootPackageLock['packages'][$packageIndex] =  $packageLock;

    if (array_key_exists('content-hash', $rootPackageLock)) {
        unset($rootPackageLock['content-hash']);
    }
    unset($rootPackageLock['content-hash']);
    $rootPackageLock['content-hash'] = hash('md5', trim(json_encode($rootPackageLock)));

    file_put_contents($lockFilePath, json_encode($rootPackageLock, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    /* === STEP-4 ココまで === */
}
