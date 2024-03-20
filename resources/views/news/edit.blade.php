@extends('layouts.base', ['activePage' => 'News'])

@section('content-header')
<div>
    <h3>
        <span class="oi oi-share-boxed"></span>
        ニュース編集
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
    <form action="{{ route('admin.news.store', route('admin.news.update', $news->id()) }}"  class="form-horizontal" method="POST">
        @csrf
        @method('put')
        <?php /** @vae News $news */ ?>
        <div class="form-group">
            <label for="InputTitle">Title</label>
            <input name="title" value="{{ old('title') }}" class="form-control" placeholder="Enter title" required>
        </div>
        <div class="form-group">
            <label for="TexteareaContent">Content</label>
            <textarea name="content" value="{{ old('content') }}" class="form-control" placeholder="Content" required />
        </div>
        <div class="form-group">
            <label for="InputState">State</label>
            <select class="form-control selectpicker", name="status" required>
                @foreach( \Domain\News\Status::displayNameList() as $key => $value)
                    <option class="btn btn-link" key="{{ $key }}" @if(old('status') == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-round btn-info">Submit</button>
    </form>
@endsection
