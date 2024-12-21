<?php
/**
 * ** NOTICE **
 * このファイルは編集しないでください！
 */
require_once __DIR__ . '/../bootstrap.php';

if (count(debug_backtrace()) === 0) { // エントリーポイントして起動された場合は
    work3();
}

function work3(): void
{
    $setUp = function () {
        chdir(__DIR__);
        // 予め指定されているパッケージを、カレントディレクトリ配下にインストールします
        exec('composer install');
        // これから自分で作る部分なので、自動で生成されるautoload関連のファイルを削除します
        \Staffroom\FileSystem::removeFileRecursive(__DIR__ . '/vendor/composer');
        \Staffroom\FileSystem::removeFileRecursive(__DIR__ . '/vendor/autoload.php');
    };

    $workManager = new \Staffroom\WorkManager(__DIR__, $setUp);
    $workManager->processAllStep();
}

function processDumpAutoload(?string $vendorDirPath = null): void
{
    $vendorDirPath ??= __DIR__ . '/vendor';

    $psr4ClassMapPath = procedure3_1($vendorDirPath);
    if (function_exists('procedure3_2')) {
        $eagerLoadFilesPath = procedure3_2($vendorDirPath);
    }
    if (function_exists('procedure3_3')) {
        $psr4ClassLoaderPath = procedure3_3($vendorDirPath);
    }
    if (function_exists('procedure3_4')) {
        procedure3_4(
            $vendorDirPath,
            $psr4ClassMapPath,
            $eagerLoadFilesPath,
            $psr4ClassLoaderPath,
        );
    }
}

