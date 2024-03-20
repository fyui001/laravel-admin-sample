# セットアップ
Makefileにコマンドをまとめてます

1. dotenvとdocker composeファイルの初期化

```shell
make init
```

2. 初期セットアップ

```shell
make setup
```


# コンテナ起動

```shell script
docker-compose up -d
```

# テスト実行

## Feature Test
```shell
make test_feature
```

## Unit Test
```shell
make test_unit
```
