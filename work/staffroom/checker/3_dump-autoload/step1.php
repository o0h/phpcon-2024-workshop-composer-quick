<?php declare(strict_types=1);

return function (array $vars) {
    $vendorDir = WORK_DIR . '/3_dump-autoload/vendor';
    $packages = [
        'psr/log' => ['Psr\\Log\\' => ["{$vendorDir}/psr/log/src"]],
        'symfony/polyfill-mbstring' => ['Symfony\\Polyfill\\Mbstring\\' => ["{$vendorDir}/symfony/polyfill-mbstring"]],
        'symfony/polyfill-php84' => ['Symfony\\Polyfill\\Php84\\' => ["{$vendorDir}/symfony/polyfill-php84"]],
    ];
    $classmapPath = WORK_DIR . '/3_dump-autoload/vendor/autoload_classmap_psr4.php';
    if (!file_exists($classmapPath)) {
        return 'PSR-4 classmapファイルがうまく書き出されていなそうです';
    }
    $actual = require $classmapPath;

    foreach ($packages as $packageName => $classmap) {
        foreach ($classmap as $namespace => $paths) {
            if ($paths !== $actual[$namespace]) {
                return sprintf(
                    "パッケージ「%s」の名前空間「%s」 に対応するパスがうまく設定されていなそうです\n(期待する設定: %s, 実際の設定: %s)",
                    $packageName,
                    $namespace,
                    var_export($paths, true),
                    var_export($actual[$namespace], true),
                );
            }
        }
    }
};
