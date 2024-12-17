.PHONY: default help init sh work1 work2 work3

DOCKER_COMPOSE := docker compose
DOCKER_COMPOSE_RUN := docker compose run --rm

default: init sh

help: ## 今表示している内容を表示します
	@cat README.md
	echo "\n## コマンド一覧"
## obtained from https://qiita.com/po3rin/items/7875ef9db5ca994ff762
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

init: ## ローカル開発に必要なサービスのセットアップを行います
	${DOCKER_COMPOSE} build

sh: ## 起動中のappサービスに入ってシェルを実行します
	${DOCKER_COMPOSE_RUN} -it -w /opt app bash

work1: ## work1の実装内容を実行します
	${DOCKER_COMPOSE_RUN} app php /opt/work/1_install/main.php

work2: ## work2の実装内容を実行します
	${DOCKER_COMPOSE_RUN} app php /opt/work/2_require/main.php

work3: ## work3の実装内容を実行します
	${DOCKER_COMPOSE_RUN} app php /opt/work/3_dump-autoload/main.php

example: ## workの参考実装を一通りテストラン実行します
	${DOCKER_COMPOSE_RUN} app php /opt/example/1_install/main.php
	${DOCKER_COMPOSE_RUN} app php /opt/example/2_require/main.php
	${DOCKER_COMPOSE_RUN} app php /opt/example/3_dump-autoload/main.php

test: ## 開発環境が要件を満たしているかをチェックします
	${DOCKER_COMPOSE_RUN} app php requirement-check.php
