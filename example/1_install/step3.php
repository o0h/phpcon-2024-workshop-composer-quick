<?php
// STEP2で実装した「パッケージごとの逐次処理」を実行させるため、step2.phpを読み込みます
require __DIR__ . '/step2.php';

function procedure1_3(array $package): string
{
    /* === STEP-3 ココから === */
    echo "\tDL: {$package['dist']['url']}\n";
    /* === STEP-3 ココまで === */

    $downloadTo = "/tmp/work1/{$package['name']}.zip";
    if (!is_dir(dirname($downloadTo))) {
        mkdir(dirname($downloadTo), 0777, true);
    }
    file_put_contents($downloadTo, downloadWithGitHubAuth($package['dist']['url']));

    return $downloadTo;
}

