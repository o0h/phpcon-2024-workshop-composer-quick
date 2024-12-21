<?php
declare(strict_types=1);

function downloadWithGitHubAuth(string $url): string
{
    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        throw new \UnexpectedValueException("URL以外の文字列が渡されました: {$url}");
    }
    if (parse_url($url)['host'] !== 'api.github.com') {
        throw new \UnexpectedValueException("GitHubAPI以外のURLは利用できません: {$url}");
    }

    $options = [
        'http' => [
            'header' => [
                'Authorization: Bearer ' . getenv('GITHUB_OAUTH_TOKEN'),
                'User-Agent: Tinyposer/0.1',
            ],
            'follow_location' => 1,
        ],
    ];
    $context = stream_context_create($options);
    $dist = @file_get_contents($url, context: $context);
    if ($dist === false) {
        handleHttpError($url);
    }

    return $dist;
}

function loadJsonFile(string $jsonPath): array
{
    $json = @file_get_contents($jsonPath);
    $data = json_decode($json, true);
    if (!$data) {
        throw new RuntimeException("JSONファイルを正しく読み取れませんでした(path: {$jsonPath})");
    }

    return $data;
}


function handleHttpError(string $requestUrl)
{
    $lastHeaders = http_get_last_response_headers();
    if (in_array('HTTP/1.1 401 Unauthorized', $lastHeaders)) {
        $token = getenv('GITHUB_OAUTH_TOKEN');
        if (!$token) {
            throw new \RuntimeException(
                '401レスポンスを受信しました。正しくトークンがセットされていないようです。'
            );
        } else {
            throw new \RuntimeException(
                sprintf(
                    "401レスポンスを受信しました。認証に失敗しているようです。\t💡tips: トークンを見直してみてください(現在利用中のトークン: %s)",
                    var_export($token, true),
                )
            );
        }
    }

    if (in_array('HTTP/1.1 404 Not Found', $lastHeaders)) {
        throw new \RuntimeException(
            sprintf(
                "404レスポンスを受信しました。指定されたURLが正しくない可能性があります(URL: %s)",
                var_export($requestUrl, true),
            )
        );
    }

    throw new \RuntimeException(
        sprintf(
            "リクエストに失敗しました(ERROR:%s)",
            error_get_last()['message'],
        ),
    );
}

function mv(string $from, string $to): void
{
    $result = \Staffroom\FileSystem::move($from, $to);
    if ($result !== 0) {
        throw new \RuntimeException("mvコマンドが失敗しました(from: {$from}, to: {$to})");
    }
}
