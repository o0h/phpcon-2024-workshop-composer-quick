# phpcon-2024-workshop-composer-quick

PHP Conference Japan 2024 のハンズオン用レポジトリです。  
see: https://fortee.jp/phpcon-2024/proposal/fd511b78-3741-4206-b90c-567d0d043698

## 利用方法

より詳細な情報は https://zenn.dev/o0h/books/phpcon-2024-composer-ws を参照してください。

### 前提条件・セットアップ
**(1)**  
Dockerコンテナを用いた開発作業を想定しています。  
Dockerを利用可能な環境を用意してください。  

**(2)**      
GitHub OAuth トークン(クラシック)を利用します。  
public repoのリード権限が必要です。  
以下のページから、トークンを作成してください。

https://github.com/settings/tokens/new?scopes=public_repo&description=Phpcon-2024-Tinyposer

**(3)**  
このレポジトリをcloneしてください。

**(4)**  
ルートディレクトリにある `runtime.env.example` をコピーして、 `runtime.env` という名前で保存してください。  
`runtime.env` に、先ほど取得したGitHub OAuth トークンを書き込みます。  
```
GITHUB_OAUTH_TOKEN=[取得したトークン]
```
という形式で、セットしてください。

### 動作確認

環境構築を行います。
ルートディレクトリ上で、次のコマンドを実行してください。  
(Dockerコンテナ内ではなく、ホスト上での操作になります)

```sh
make init
```

makeコマンドが利用できない場合は、Docker Composeを利用して操作してください

```sh
docker compose build
```

正常に完了したら、作業に必要な要件を満たしているかをチェックします。  
ルートディレクトリ上で、次のコマンドを実行してください。

```sh
make test
```

もしくは

```sh
docker compose run --rm app php requirement-check.php
```

`💯 おめでとうございます！全ての要件を満たしています！` と表示されたら、環境構築は完了です。

## サポート

うまく動かなかった場合は、当レポジトリのIssueでお知らせください。
