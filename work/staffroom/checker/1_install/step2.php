<?php declare(strict_types=1);

return function (array $vars) {
    $spy = \Staffroom\Spy::retrieve('receivedPackageNameList');
    if (!is_array($spy) ) {
        return sprintf(
            'うまくパッケージ情報を取り出せていなそうです: `$lockData` がarrayではなく%sになっています。',
            get_debug_type($spy),
        );
    }
    if (!in_array('guzzlehttp/guzzle', $spy)) {
        return '`packages`の情報をうまく読み取れていなそうです(guzzlehttp/guzzleが含まれていません)';
    }
    if (!in_array('phpunit/phpunit', $spy)) {
        return '`packages-dev`の情報をうまく読み取れていなそうです(phpunit/phpunitが含まれていません)';
    }
    if (count($spy) !== 37) {
        return '`$lockData` から全てのうまくパッケージ情報を取り出せていなそうです(読み取ったパッケージの数が想定数と異なります)';
    }
};
