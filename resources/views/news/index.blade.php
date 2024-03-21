@extends('vendor.adminlte.page')

@section('title', 'ニュース一覧')

@section('content_header')
<div class="row">
    <h3 class="col">
        <span class="oi oi-share-boxed"></span>
        ニュース一覧 ( 全{{ $news->count() }}件 )
    </h3>
    <div class="text-right">
        <a href="{{ route('admin.news.create') }}" class="btn btn-round btn-info" rel="tooltip">
            <span class="oi oi-plus"></span>
            新規作成
        </a>
    </div>
</div>
@endsection

@section('content')
<table class="table">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th>Title</th>
        <th>Content</th>
        <th>Status</th>
        <th class="text-right">Actions</th>
    </tr>
    </thead>
    @foreach($news as $item)
        <?php /** @var Domain\News\News $item */ ?>
        <tr>
            <td>{{ $item->id() }}</td>
            <td>{{ $item->getTitle() }}</td>
            <td>{{ $item->getContent() }}</td>
            <td>{{ $item->getStatus()->displayName() }}</td>
            <td class="td-actions text-right">
                <a href="{{ route('admin.news.edit', $item->id()) }}" class="btn btn-success btn-round" rel="tooltip" data-placement="bottom" title="Edit">
                    <span class="oi oi-pencil"></span>
                </a>
                <a href="javascript:void(0)" data-url="{{ route('admin.news.destroy', $item->id()) }}"
                   class="btn btn-danger btn-round delete-form-btn" rel="tooltip"
                   data-label="{{ $item->getTitle() }}" title="Delete">
                    <span class="oi oi-x"></span>
                </a>
            </td>
        </tr>
    @endforeach
</table>
<div class="box-footer clearfix">
    {!! $news->withPath('/admin/news')->links('pagination::bootstrap-4') !!}
</div>
<form action="#" id="form-delete" method="POST">
    <input type="hidden" name="_method" value="delete" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
@endsection

@push('js')
    <script>
        $(function(){
            $('.delete-form-btn').on('click', function() {
                let btn = $(this);
                if (confirm('「' + btn.data('label') + '」' + 'を削除してよろしいでしょうか？')) {
                    $('#form-delete').attr('action', btn.data('url'));
                    $('#form-delete').submit();
                }
            })
        });

    </script>
@endpush
