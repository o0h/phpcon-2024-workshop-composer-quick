<?php
    class Psr4ClassLoader
    {

        private array $psr4ClassMap;

        public function __construct(
            string $psr4ClassMapPath,
        )
        {
            $this->psr4ClassMap = require $psr4ClassMapPath;
        }

        public function loadClass(string $class): void
        {
            /* === STEP-3 ココから === */
            $elements = explode('\\', $class);
            while ($elements) {
                $search = implode('\\', $elements).'\\';
                $packageRootPaths = $this->psr4ClassMap[$search] ?? null;;
                if (!$packageRootPaths) {
                    array_pop($elements);
                    continue;
                }
                $sub = str_replace($search, '', $class);
                $subPath = str_replace('\\', '/', $sub);
                foreach ($packageRootPaths as $packageRootPath) {
                    $filePath = "{$packageRootPath}/{$subPath}.php";
                    if (file_exists($filePath)) {
                        include $filePath;
                        return;
                    }
                    array_pop($elements);
                }
            }
            /* === STEP-3 ココまで === */
        }
    }

