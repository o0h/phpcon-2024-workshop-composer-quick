<?php
if (class_exists('Psr4ClassLoader', false)):
    return;
else:

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



            /* === STEP-3 ココまで === */
        }
    }
endif;
function procedure3_3(string $vendorDirPath): string
{
    $reflector = new ReflectionClass('Psr4ClassLoader');
    $fileName = $reflector->getFileName();
    $startLine = $reflector->getStartLine() - 1;
    $endLine = $reflector->getEndLine();
    $length = $endLine - $startLine;

    $source = file($fileName);
    $classDefinition = implode("", array_slice($source, $startLine, $length));

    $psr4ClassLoaderPath = $vendorDirPath . '/Psr4lassMap.php';
    file_put_contents(
        $psr4ClassLoaderPath,
        "<?php\n{$classDefinition}\n"
    );

    return $psr4ClassLoaderPath;
}

processDumpAutoload(__DIR__ . '/vendor'); // この内部で `procedure3_3` が呼ばれます
