<?php declare(strict_types=1);

return function (array $vars) {
    $vendorDir = WORK_DIR . '/3_dump-autoload/vendor';
    $packages = [
        'symfony/polyfill-mbstring' => [WORK_DIR . '/3_dump-autoload/vendor/symfony/polyfill-mbstring/bootstrap.php'],
        'symfony/polyfill-php84' => [WORK_DIR . '/3_dump-autoload/vendor/symfony/polyfill-php84/bootstrap.php'],
    ];
    $eagerLoadPath = WORK_DIR . '/3_dump-autoload/vendor/autoload_files.php';
    if (!file_exists($eagerLoadPath)) {
        return 'イーガーロードの設定ファイルがうまく書き出されていなそうです';
    }
    $actual = require $eagerLoadPath;

    foreach ($packages as $packageName => $eagerLoadFiles) {
        foreach ($eagerLoadFiles as $eagerLoadFile) {
            if (!in_array($eagerLoadFile, $actual, true)) {
                return sprintf(
                    "パッケージ「%s」のイーガーロードファイルがうまく設定されていなそうです\n(期待する設定: %s, 実際の設定: %s)",
                    $packageName,
                    var_export($eagerLoadFiles, true),
                    var_export($actual, true),
                );
            }
        }
    }
};
