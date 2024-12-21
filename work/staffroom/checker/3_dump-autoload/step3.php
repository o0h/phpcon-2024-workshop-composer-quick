<?php declare(strict_types=1);

$fqcnExists = function (string $fqcn): bool {
    return class_exists($fqcn) || interface_exists($fqcn) || trait_exists($fqcn) || enum_exists($fqcn);
};

return function (array $vars) use ($fqcnExists) {
    if (!class_exists(\Psr4ClassLoader::class)) {
        return 'ClassLoaderクラスが定義されていなそうです';
    }
    if (!method_exists(\Psr4ClassLoader::class, 'loadClass')) {
        return 'loadClassメソッドが定義されていなそうです';
    }

    $classmapPath = WORK_DIR . '/3_dump-autoload/vendor/autoload_classmap_psr4.php';
    $classLoader = new Psr4ClassLoader($classmapPath);

    $tryClasses = [
        'Symfony\Polyfill\Mbstring\Mbstring',
        'Psr\Log\LoggerInterface',
    ];
    foreach ($tryClasses as $tryClass) {
        assert(!$fqcnExists($tryClass));
        $classLoader->loadClass($tryClass);
        if (!$fqcnExists($tryClass)) {
            return "PSR-4準拠のクラスの読み込みロジックがうまく実行されていなそうです({$tryClass}が読み込めませんでした)";
        }
    }
};
