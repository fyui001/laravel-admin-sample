@extends('vendor.adminlte.page')

@section('content_header')
    <div class="row">
        <h3 class="col">
            <span class="oi oi-flag"></span>
            リリースフラグ編集
        </h3>
    </div>
@endsection

@section('content')
    <div class="card-body table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>フラグ名</th>
                <th>状態</th>
                <th>変更</th>
            </tr>
            </thead>
            <tbody>
            <?php /** @var \Domain\ReleaseFlag\ReleaseFlagList $releaseFlagList */ ?>
            @foreach($releaseFlagList->toArray() as $releaseFlag)
                    <?php /** @var \Domain\ReleaseFlag\ReleaseFlag $releaseFlag */ ?>
                <tr>
                    <td>{{ $releaseFlag->displayName()->getRawValue() }}</td>
                    <td>{{ $releaseFlag->displayIsEnabled() }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.release_flags.edit', ['name' => $releaseFlag->getKeyName()->getValue()->getRawValue()]) }}" class="btn btn-success btn-round" rel="tooltip" data-placement="bottom" title="Edit">
                            <span class="oi oi-pencil"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
