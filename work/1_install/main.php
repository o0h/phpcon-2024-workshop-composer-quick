<?php
/**
 * ** NOTICE **
 * このファイルは編集しないでください！
 */
require_once __DIR__ . '/../bootstrap.php';

if (count(debug_backtrace()) === 0) { // エントリーポイントして起動された場合はworkの内容を実行する
    work1();
}

function work1(): void
{
    $setUp = function() {
        $initialDirs = ['/tmp/work1', __DIR__ . '/vendor'];
        foreach ($initialDirs as $dir) {
            \Staffroom\FileSystem::removeFileRecursive($dir);
            if (!mkdir($dir, 0777, true)) {
                throw new \RuntimeException("`{$dir}`ディレクトリの作成に失敗しました");
            }
        }
    };

    $workManager = new \Staffroom\WorkManager(__DIR__, $setUp);
    $workManager->processAllStep();
}

function processInstallPackage(array $package): void
{
    $procedure = match (true) {
        function_exists('procedure1_3') => procedure1_3(...),
        default => function ($package) {
            \Staffroom\Spy::capture($package['name'], 'receivedPackageNameList');
            echo "\tパッケージが読み込まれました: {$package['name']}\n";
        },
    };
    $procedure($package);
}
