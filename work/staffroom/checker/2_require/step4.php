<?php declare(strict_types=1);

return function (array $vars) {
    $dependencies = ['psr/log', 'aura/cli'];

    try {
        $lock = loadJsonFile(WORK_DIR . '/2_require/composer.lock');
    } catch (\RuntimeException $e) {
        return "composer.jsonを適切な形式で保存できていなそうです({$e->getMessage()})";
    }

    $requiredFields = ['content-hash', 'packages', 'packages-dev'];
    foreach ($requiredFields as $field) {
        if (!array_key_exists($field, $lock)) {
            return "composer.lockに{$field}フィールドがありません";
        }
    }

    foreach ($dependencies as $dependency) {
        $packageIndex = array_find_key($lock['packages'], fn ($p) => $p['name'] === $dependency);
        if ($packageIndex === null ) {
            return "{$dependency} の情報がcomposer.jsonに書き込めていなそうです";
        }
        $package = $lock['packages'][$packageIndex];
        if (!($package['dist']['url'] ?? false)) {
            return "{$dependency} のdistがcomposer.jsonに書き込めていなそうです";
        }
    }

    if (count($lock['packages']) !== 2) {
        return 'composer.lockファイルに記述されたpackage数が想定数と異なります';
    }
};
