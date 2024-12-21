<?php
/**
 * ** NOTICE **
 * このファイルは編集しないでください！
 */
require_once __DIR__ . '/../bootstrap.php';

if (count(debug_backtrace()) === 0) { // エントリーポイントして起動された場合はworkの内容を実行する
    work2();
}

function work2(): void
{
    $setUp = function () {
        $filesToReset = [__DIR__ . '/composer.json', __DIR__ . '/composer.lock'];
        foreach ($filesToReset as $file) {
            \Staffroom\FileSystem::removeFileRecursive($file);
        }
    };

    $workManager = new \Staffroom\WorkManager(__DIR__, $setUp);
    $workManager->processAllStep();
}

function processRequirePackage(string $packageName): void
{
    $packageVersionedMetaJson = procedure2_1($packageName);
    \Staffroom\Spy::capture($packageVersionedMetaJson, 'receivedPackageVersionedMetaJsonList');

    if (function_exists('procedure2_2')) {
        $packageMeta = procedure2_2($packageVersionedMetaJson);
        \Staffroom\Spy::capture($packageMeta, 'receivedPackageMeta');
    }
    if (function_exists('procedure2_3')) {
        procedure2_3($packageMeta);
    }
    if (function_exists('procedure2_4')) {
        procedure2_4($packageMeta);
    }
}

