@php use Domain\AdminUser\AdminUserRole;use Domain\AdminUser\AdminUserStatus; @endphp

@extends('vendor.adminlte.page')

@section('title', '管理ユーザー編集')

@section('content_header')
    <div class="row">
        <h3 class="col">
            <span class="oi oi-person"></span>
            管理ユーザー編集
        </h3>
    <div class="text-right">
        <a href="{{ route('admin.admin_users.index') }}" class="btn btn-round btn-info">
            <span class="oi oi-chevron-left"></span>
            管理ユーザー一覧に戻る
        </a>
    </div>
</div>
@endsection

@section('content')
    <form action="{{ route('admin.admin_users.update', $adminUser) }}" class="form-horizontal" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group info">
            <label for="InputUserId">User ID</label>
            <input name="user_id" value="{{ old('user_id', $adminUser->user_id) }}" class="form-control" placeholder="Enter title" required>
        </div>
        <div class="form-group">
            <label for="InputPassword">Password</label>
            <input type="password" name="password" class="form-control input-sm" placeholder="8 characters or more" required>
        </div>
        <div class="form-group">
            <label for="InputPasswordConfirm">Password Confirm</label>
            <input type="password" name="password_confirm" class="form-control input-sm" required>
        </div>
        <div class="form-group">
            <label for="TextareaUserName">User Name</label>
            <input type="text" name="name" value="{{ old('name', $adminUser->name) }}" class="form-control input-sm" required>
        </div>
        <div class="form-group">
            <label for="InputRole">Role</label>
            <select class="form-control selectpicker" name="role" required>
                @foreach(AdminUserRole::displayNameList() as $key => $value)
                    <option class="btn btn-link" value="{{ $key }}" @if(old('role') == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="InputState">State</label>
            <select class="form-control selectpicker" name="status" required>
                @foreach (AdminUserStatus::displayNameList() as $key => $value)
                    <option class="btn btn-link" value="{{ $key }}" @if(old('status') == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-round btn-info">Submit</button>
    </form>>
@endsection
