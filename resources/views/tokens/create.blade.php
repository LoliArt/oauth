@extends('layouts.app')

@section('title', '新个人访问密钥')

@section('content')
    <h3>新个人访问密钥</h3>

    <div class="mb-3">
        <a href="{{ route('tokens.index') }}">个人访问密钥列表</a>
    </div>


    <form method="post" action="{{ route('tokens.store') }}">
        @csrf
        <div class="input-group mb-3">
            <span class="input-group-text">名称</span>
            <input aria-label="名称" type="text" class="form-control" name="name" placeholder="名称">
        </div>

        {{--   选择 scopes   --}}
        <div class="input-group mb-3">
            <span class="input-group-text">权限</span>
            <select class="form-select" name="scopes[]" multiple>
                @foreach($scopes as $scope)
                    <option value="{{ $scope->id }}">{{ $scope->description }}</option>
                @endforeach
            </select>
        </div>


        <button type="submit" class="btn btn-primary">新建</button>
    </form>

@endsection
