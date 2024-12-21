<?php declare(strict_types=1);

use Psr\Log\AbstractLogger;

return function (array $vars) {
    $autoloaderPath = WORK_DIR . '/3_dump-autoload/vendor/autoload.php';
    if (!file_exists($autoloaderPath)) {
        return 'autoload.phpが存在していなそうです';
    }

    assert(
        !count(spl_autoload_functions()),
        '既にオートローダーが登録されていて、うまく検査できません',
    );

    require $autoloaderPath;

    if (count(spl_autoload_functions()) !== 1) {
        return 'オートローダーが登録されていなそうです';
    }

    assert(
        !class_exists(AbstractLogger::class, false),
        'PSR-3のAbstractLoggerの有無で検査したいのですが、既に読み込まれていてうまく検査できません',
    );

    if (!class_exists(AbstractLogger::class)) {
        return 'PSR-4オートローダーがうまく動いていなそうです';
    }

    $includedFiles = get_included_files();
    $polyfillFilePath = WORK_DIR . '/3_dump-autoload/vendor/symfony/polyfill-php84/bootstrap.php';
    if (!in_array($polyfillFilePath, $includedFiles, true)) {
        return sprintf(
            "イーガーロード対象のファイルが読み込みがうまく動いていなそうです\n(%sが読み込まれていることを期待しましたが、読み込まれていません)",
            $polyfillFilePath,
        );
    }
};
