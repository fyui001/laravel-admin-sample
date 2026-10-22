# セットアップ
Taskfileにコマンドをまとめてます

アプリのコンテナは FrankenPHP(classic mode)で動きます。
ウェブサーバの設定は `docker/frankenphp/Caddyfile`、PHP の設定は `docker/php/zz-custom.ini` にあります。

1. dotenvとdocker composeファイルの初期化

```shell
task init
```

2. 初期セットアップ

```shell
task up
task setup
```


# コンテナ起動

```shell script
taks up
```

# テスト実行

## Feature Test
```shell
task test_feature
```

## Unit Test
```shell
task test_unit
```
