<?php

declare(strict_types=1);

namespace Staffroom;

class WorkManager
{

    private string $workTitle {
        get {
            [$no, $subtitle] = explode('_', $this->workTitle);

            return sprintf("WORK%s:\t %s", $no, $subtitle);
        }
    }

    public function __construct(
        private readonly string $workDir,
        private readonly \Closure $setUp,
    )
    {
        $this->workTitle = basename($this->workDir);
    }

    public function processAllStep(): void
    {
        $this->println('🐘WORK START🐘');
        $this->println($this->workTitle, 2);

        $this->println('---Begin Set Up---', 2);
        $this->setUp->call($this);
        $this->println('---Finished Set Up---', 2, 1);

        foreach (glob("{$this->workDir}/step*.php") as $path) {
            $this->process($path);
        }
        $this->println('💯 WORK COMPLETE 💯', 1, 1);
    }

    private function process(string $path)
    {
        $this->println(sprintf("🤾\t%sを開始します...", $this->pathToStepName($path)));
        static $vars = [];
        try {
            (function ($path) use (&$vars) {
                extract($vars);
                require $path;
                $vars = get_defined_vars();
                unset($vars['vars'], $vars['path']);
            })($path);
        } catch (\Throwable $e) {
            $errorFilePath = $this->getPathFromRepositoryRoot($e->getFile());
            $error = "{$e->getMessage()} @ \t{$errorFilePath}:{$e->getLine()}行目";
            $this->stop($path, $error);
        }

        $checkerPath = implode('/', [STAFFROOM_DIR, 'checker', basename($this->workDir), basename($path)]);
        $checker = require $checkerPath;
        if ($error = $checker($vars)) {
            $this->stop($path, $error);
        }

        $this->println(sprintf("✅\t%sが完了しました！", $this->pathToStepName($path)));
        Spy::forget();;
    }

    private function println(string $message, int $breakLineNum = 1, int $beforeBreakLine = 0): void
    {
        fwrite(STDOUT, str_repeat(PHP_EOL, $beforeBreakLine) . $message . str_repeat(PHP_EOL, $breakLineNum));
    }

    private function stop($path, $error): never
    {
        $template = <<<ERR
                ====
                【%s】の内容を正しく実装できていなそうです。コードを見直してみてください！
                💡 正しく動作しない原因が、もっと手前のステップにある場合もあります。
                ----
                失敗理由: \t%s
                ファイルパス: \t%s
                ====

                ERR;

        $message = sprintf($template, $this->pathToStepName($path), $error, $this->getPathFromRepositoryRoot($path));

        fwrite(STDERR, $message);

        exit(1);
    }

    function getPathFromRepositoryRoot(string $path): string
    {
        return str_replace(PJ_ROOT . '/', '', $path);
    }

    private function pathToStepName(string $path): string
    {
        return ucfirst(basename($path, '.php'));
    }


}
