<?php declare(strict_types=1);

return function (array $vars) {
    $packages = glob(WORK_DIR . '/1_install/vendor/*/*');
    if (!$packages) {
        return 'パッケージの展開がうまくいっていなそうです(1_install/vendorの配下にパッケージのディレクトリが見つかりません';
    }
    if (count($packages) !== 37) {
        return '展開されたパッケージの数が想定数と異なります)';
    }
};
