<?php /** @var \Domain\News\News $news */ ?>

@extends('vendor.adminlte.page')

@section('title', 'News編集')

@section('content_header')
    <div class="row">
        <h3 class="col">
            <span class="oi oi-share-boxed"></span>
            News編集
        </h3>
    <div class="text-right">
        <a href="{{ route('admin.news.index') }}" class="btn btn-round btn-info">
            <span class="oi oi-chevron-left"></span>
            ニュース一覧に戻る
        </a>
    </div>
</div>
@endsection

@section('content')
    <form action="{{ route('admin.news.update', $news->id()) }}"  class="form-horizontal" method="POST">
        @csrf
        @method('put')
        <?php /** @vae News $news */ ?>
        <div class="form-group">
            <label for="InputTitle">Title</label>
            <input name="title" value="{{ old('title', $news->getTitle()) }}" class="form-control" placeholder="Enter title" required>
        </div>
        <div class="form-group">
            <label for="TexteareaContent">Content</label>
            <textarea name="content" class="form-control" placeholder="Content" required>{{ $news->getContent()->getRawValue() }}:</textarea>
        </div>
        <div class="form-group">
            <label for="InputState">State</label>
            <select class="form-control selectpicker", name="status" required>
                @foreach( \Domain\News\Status::displayNameList() as $key => $value)
                    <option class="btn btn-link" value="{{ $key }}" @if(old('status') == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-round btn-info">Submit</button>
    </form>
@endsection
