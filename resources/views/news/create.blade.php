@extends('vendor.adminlte.page')

@section('title', 'News編集')

@section('content_header')
    <div class="row">
        <span class="oi oi-share-boxed"></span>
        ニュース作成
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
<form action="{{ route('admin.news.store') }}"  class="form-horizontal" method="POST">
    @csrf
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
                <option class="btn btn-link" key="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-round btn-info">Submit</button>
</form>
@endsection
