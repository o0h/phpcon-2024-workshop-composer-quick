<?php declare(strict_types=1);

return function (array $vars) {
    if (!array_key_exists('lockData', $vars)) {
        return '`$lockData` が定義されていません';
    }

    $lockData = $vars['lockData'];
    if (!is_array($lockData)) {
        return sprintf('`$lockData`が配列ではなく、%sになっています。', gettype($lockData));
    }

    foreach (['packages', 'packages-dev'] as $field) {
        if (!array_key_exists($field, $lockData)) {
            return '`$lockData` が正しく読み込まれていません';
        }
        if (!array_all(
            $lockData[$field],
            fn(array $package) => ($package['name'] ?? false) && ($package['dist']['url'] ?? false))
        ) {
            return 'composer.lockが壊れている可能性があります。作成者に問い合わせてください';
        }
    }
};
