<?php declare(strict_types=1);

return function (array $vars) {
    $dependencies = ['psr/log', 'aura/cli'];

    try {
        $package = loadJsonFile(WORK_DIR . '/2_require/composer.json');
    } catch (\RuntimeException $e) {
        return "composer.jsonを適切な形式で保存できていなそうです({$e->getMessage()})";
    }

    if (!array_key_exists('require', $package)) {
        return 'composer.jsonにrequireフィールドがありません';
    }
    foreach ($dependencies as $dependency) {
        $determinedVersion = $package['require'][$dependency] ?? false;
        if ($determinedVersion === false) {
            return "{$dependency} の情報がcomposer.jsonに書き込めていなそうです";
        }
        $isValidVersion = filter_var(
            $determinedVersion,
            FILTER_VALIDATE_REGEXP,
            [
                'options' => [
                    'regexp' => '/\A(v)?\d+\.\d+\.\d+(-[a-zA-Z]+(\d)?)?\Z/'
                ],
            ]
        );
        if (!$isValidVersion) {
            return "{$dependency} のバージョン情報が正しくありません(version: {$determinedVersion})";
        }

    }

    if (count($package['require']) !== 2) {
        return 'composer.jsonファイルに記述されたrequire数が想定数と異なります';
    }
};
