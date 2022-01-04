@extends('layouts.base', ['activePage' => 'News'])

@section('content-header')
<div>
    <h3>
        <span class="oi oi-share-boxed"></span>
        ニュース編集
    </h3>
    <div class="text-right">
        <a href="{{ route('news.index') }}" class="btn btn-round btn-info">
            <span class="oi oi-chevron-left"></span>
            ニュース一覧に戻る
        </a>
    </div>
</div>
@endsection

@section('content')
{{ Form::open(['url' => route('news.update', $news->id()), 'method' => 'put', 'class' => 'form-horizontal']) }}
    <div class="form-group">
        <label for="InputTitle">Title</label>
        {{ Form::text('title', old('title', $news->getTitle()), ['class' => 'form-control', 'placeholder' => 'Enter title', 'required' => true]) }}
    </div>
    <div class="form-group">
        <label for="TexteareaContent">Content</label>
        {{ Form::textarea('content', old('content', $news->getContent()), ['class' => 'form-control', 'rows' => 5, 'placeholder' => 'Content', 'required' => true]) }}
    </div>
    <div class="form-group">
        <label for="InputState">State</label>

        {{ Form::select('status', \Domain\News\Status::getDisplayNameList(), old('status', $news->getStatus()->rawValue()), ['class' => 'form-control selectpicker', 'data-style' => 'btn btn-link', 'required' => true]) }}
    </div>
    <button type="submit" class="btn btn-round btn-info">Submit</button>
{{ Form::close() }}
@endsection
