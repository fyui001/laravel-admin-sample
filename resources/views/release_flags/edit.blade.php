<?php /** @var \Domain\ReleaseFlag\ReleaseFlag $releaseFlag */ ?>
@extends('vendor.adminlte.page')

@section('content_header')
    <div class="row">
        <h3 class="col">
            <span class="oi oi-flag"></span>
            リリースフラグ編集
        </h3>
        <div class="col text-right">
            <a href="{{ route('admin.release_flags.index') }}" class="btn btn-round btn-info">
                <span class="oi oi-chevron-left"></span>
                リリースフラグ一覧に戻る
            </a>
        </div>
    </div>
@endsection

@section('content')
    <form action="{{ route('admin.release_flags.update', ['name' => $releaseFlag->getKeyName()->getValue()->getRawValue()]) }}" name="{{ $releaseFlag->getKeyName()->getValue()->getRawValue() }}" method="POST">
        @csrf
        <h4>{{ $releaseFlag->displayName()->getRawValue() }}</h4>
        <div class="form-group">
            <div>
                <input type="radio" name="is_enabled" value="{{ old('is_enabled', '1') }}" checked="{{ $releaseFlag->isEnabled() }}" id="is_enable_on">
                <label for="is_enable_on">ON</label>
                <input type="radio" name="is_enabled" value="{{ old('is_enabled', '0') }}" checked="{{ !$releaseFlag->isEnabled() }}" id="is_enable_off">
                <label for="is_enable_off">OFF</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"
                onclick="return confirm('関連するユーザーすべてに対して対象の機能が公開または非公開となります。よろしいですか？');">
            変更
        </button>
    </form>
@endsection

@push('js')
    <script type="module">
        $(document).ready(function() {
            $('#is_enabled').on('click', function() {
                const isChecked = document.getElementById('is_enabled').checked
                document.getElementById('is_enabled').value = isChecked ? '1' : '0'
            })
        })
    </script>
@endpush
