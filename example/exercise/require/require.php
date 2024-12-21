<?php

declare(strict_types=1);

const BASE_PACKAGE_ENDPOINT_TEMPLATE = 'https://repo.packagist.org/p2/%s.json';

$workingDir = getcwd();

$requirePackageNames = array_slice($argv, 1);

$sourceData = $lockData = [];
foreach ($requirePackageNames as $requirePackageName) {
    $packageEndpoint = sprintf(BASE_PACKAGE_ENDPOINT_TEMPLATE, $requirePackageName);
    $packageJson = file_get_contents($packageEndpoint);
    $package = json_decode($packageJson, true);
    $versionsDataList = $package['packages'][$requirePackageName];

    $determined = null;
    $candidate = [];
    foreach ($versionsDataList as $versionData) {
        $versionNormalized = $versionData['version'];
        $candidate = array_merge($candidate, $versionData);
        // versionの有効な形式
        // 0.2.5
        // v2.0.4 (prefix "v")
        // 1.0.0-dev (suffix)
        // 3.0.0-RC2 (suffix with number)
        if (str_contains($versionNormalized, '-')) {
            $suffix = explode('-', $versionNormalized)[1];
            if (preg_match('#('.implode('|', ['dev', 'alpha', 'beta', 'RC']).')#', $suffix)) {
                continue;
            }
        }
        $determined = $candidate;

        break;
    }
    if (!$determined) {
        throw new RuntimeException('stable version not provided');
    }

    $sourceData[$determined['name']] = $determined['version'];
    $lockData[] = [
        'name' => $determined['name'],
        'version' => $determined['version'],
        'source' => $determined['source'],
        'dist' => $determined['dist'],
        'license' => $determined['license'],
    ];
}

$composerJsonData = [
    'require' => $sourceData,
];
ksort($composerJsonData['require']);
file_put_contents("{$workingDir}/composer.json", json_encode($composerJsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

$composerLockData = [
    'packages' => $lockData,
    'packages-dev' => [],
];
$contentHash = hash('md5', trim(json_encode($composerLockData)));
$composerLockData['content-hash'] = $contentHash;
ksort($composerLockData);
file_put_contents("{$workingDir}/composer.lock", json_encode($composerLockData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
