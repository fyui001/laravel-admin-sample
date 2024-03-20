<!DOCTYPE html>
<html lang="ja">
<head>
    <title>Laravelサンプル</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="hold-transition sidebar-mini">
    @auth()
        @include('layouts.templates.auth')
    @endauth
    @guest()
        @include('layouts.templates.guest')
    @endguest
    <script type="module">
        // UTCの日付をローカルの日付に変換する処理
        // 変換したい日付のタグにクラス`datetime-utc-to-local`を入れる
        (() => {
            // datetime-utc-to-localクラスの全てのタグを取得し、中のテキストを変換する
            const elements = document.getElementsByClassName('datetime-utc-to-local')
            $(elements).each((idx, el) => {
                const dateText = $(el).text()
                if (dateText) {
                    $(el).text(
                        dayjs(dateText.trim()).isValid() ?
                            dayjs(dateText.trim()).format('YYYY/MM/DD HH:mm:ss') :
                            dateText
                    )
                }
            })
        })
    </script>
    @stack('js')
</body>
</html>
