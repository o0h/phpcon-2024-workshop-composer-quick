<?php
declare(strict_types=1);

function printLn(string $message): void
{
    fwrite(STDOUT, $message . PHP_EOL);
}

function err(string $message, array $advices = []): void
{
    fwrite(STDERR, "❌\t{$message}" . PHP_EOL);
    foreach ($advices as $advice) {
        fwrite(STDERR, "\t💡\t{$advice}" . PHP_EOL);
    }
    exit(1);
}

function test(string $caseName, Closure $test): void
{
    static $caseNum = 1;
    printLn("🤾  {$caseNum}. {$caseName}を開始します...");
    $test();
    printLn("\t=> ✅  OK!");
    $caseNum++;
}


echo <<<AA

.-. . .-..----..-.    .---.  .----. .-.   .-..----.    .---.  .----.      
| |/ \| || {_  | |   /  ___}/  {}  \|  `.'  || {_     {_   _}/  {}  \     
|  .'.  || {__ | `--.\     }\      /| |\ /| || {__      | |  \      /     
`-'   `-'`----'`----' `---'  `----' `-' ` `-'`----'     `-'   `----'      
          .---. .-..-. .-..-.  .-..----.  .----.  .----..----..----.      
         {_   _}| ||  `| | \ \/ / | {}  }/  {}  \{ {__  | {_  | {}  }     
           | |  | || |\  |  }  {  | .--' \      /.-._} }| {__ | .-. \     
           `-'  `-'`-' `-'  `--'  `-'     `----' `----' `----'`-' `-'     
                              .-. . .-. .----. .----. .-.   .----.        
                              | |/ \| |/  {}  \| {}  }| |   | {}  \       
                              |  .'.  |\      /| .-. \| `--.|     /       
                              `-'   `-' `----' `-' `-'`----'`----'        



AA;

test(
    'ファイルの作成・削除の実行可否(/tmp)',
    function () {
        $dir = uniqid('/tmp/requirement-check---');;
        if (!mkdir($dir, 0777, true)) {
            err(
                '/tmpディレクトリの書き込み権限がありません',
            );
        }
        if (file_put_contents("{$dir}/test", 'test') === false) {
            err(
                '/tmpディレクトリの書き込み権限がありません',
            );
        }
        if (unlink("{$dir}/test") === false) {
            err(
                '/tmpディレクトリのファイルを削除できません',
            );
        }
    }
);

test(
    'ファイルの作成・削除の実行可否(/opt/work)',
    function () {
        $dir = '/opt/work/1_install/';
        if (file_put_contents("{$dir}/.test", 'test') === false) {
            err(
                '/opt/workディレクトリの書き込み権限がありません',
            );
        }
        if (unlink("{$dir}/.test") === false) {
            err(
                '/opt/workディレクトリのファイルを削除できません',
            );
        }
    }
);

test(
    'PHP拡張のインストールの確認',
    function () {
        if (!extension_loaded('zip')) {
            err(
                'zip拡張がインストールされていません',
            );
        }
    }
);

test(
    '環境変数の設定',
    function () {
        if (file_exists(__DIR__ . '/runtime.env')) {
            return;
        }
        err(
            'runtime.envファイルが存在しません',
            [
                '.runtime.env.exampleをコピーして、.env.exampleファイルを作成してください',
            ],
        );
    }
);

test(
    'GITHUB_OAUTH_TOKENの設定',
    function () {
        $ghOauthToken = getenv('GITHUB_OAUTH_TOKEN');
        if (!is_string($ghOauthToken) || strlen($ghOauthToken) < 1) {
            err(
                'GITHUB_OAUTH_TOKENが設定されていません',
                [
                    '.runtime.envファイルの内容を確認してください',
                    'トークンは https://github.com/settings/tokens/new?scopes=public_repo&description=Phpcon-2024-Tinyposer で作成できます'
                ],
            );
        }
    }
);

test(
    'GITHUB_OAUTH_TOKENの有効確認',
    function () {
        $ghOauthToken = getenv('GITHUB_OAUTH_TOKEN');
        $cmd = "curl -H 'Authorization: Bearer {$ghOauthToken}' -s https://api.github.com/repos/o0h/phpcon-2024-workshop-composer-quick/contents/README.md";
        exec($cmd, $output, $returnVar);
        $response = json_decode(implode(PHP_EOL, $output));
        if (json_last_error() !== JSON_ERROR_NONE) {
            err(
                'GITHUBとの通信に失敗しました',
            );
        }
        if (($response->name ?? false) === 'README.md') {
            return;
        }
        $status = $response->status ?? 'Unknown';
        $message = $response->message ?? 'Unknown';
        err(
            sprintf('GITHUB_OAUTH_TOKENが正しく設定されていない可能性があります(%s %s)', $status, $message),
            [
                'トークンを再生成して、.runtime.envファイルを更新してください',
                'トークンは https://github.com/settings/tokens/new?scopes=public_repo&description=Phpcon-2024-Tinyposer で作成できます'
            ],
        );
    }
);

test(
    'Packagistへのアクセス確認',
    function () {
       $targetUrl = 'https://packagist.org/packages.json';
       if (@file_get_contents($targetUrl) === false) {
           err(
               'Packagistへのアクセスに失敗しました',
               [
                   "{$targetUrl}をブラウザで開き、JSONデータが表示されるか確認してください。",
                   "一時的な不通状態のに普通になっている可能性もあります。https://status.packagist.org/ でサービスステータスを確認してください"
               ]
           );
       }
    }
);

printLn('');
printLn('💯 おめでとうございます！全ての要件を満たしています！');
