@extends('layouts.app')

@section('title', $client->name)

@section('content')

    <a href="{{ route('clients.index') }}" class="mb-3">
        返回
    </a>


    <h2>{{ $client->name }}</h2>
    <div class="input-group mb-3">
        <span class="input-group-text">客户端 ID</span>
        <input aria-label="客户端 ID" type="text" class="form-control" value="{{ $client->id }}" readonly>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-text">
            {{ __('客户端密钥') }} &nbsp;<input aria-label="客户端密钥" type="checkbox"
                                                id="secret-check-box"
                                                data-secret="{{ $client->secret }}">
        </div>
        <input aria-label="勾选来查看" id="secret-input" type="text" class="form-control" readonly
               placeholder="勾选来查看">
    </div>

    <form class="d-contents" method="post" action="{{ route('clients.update', $client->id) }}">
        @method('PATCH')
        @csrf
        <h2>{{ __('设置') }}</h2>

        <div class="input-group mb-3">
            <span class="input-group-text">名称</span>
            <input aria-label="名称" type="text" class="form-control" name="name" placeholder="客户端名称"
                   value="{{ $client->name }}">
        </div>


{{--        <div class="input-group mb-3">--}}
{{--            <span class="input-group-text">提供方</span>--}}
{{--            <input aria-label="provider" type="text" name="provider" class="form-control"--}}
{{--                   value="{{ $client->provider }}">--}}
{{--        </div>--}}


        <div class="input-group mb-3">
            <span class="input-group-text">重定向地址</span>
            <input aria-label="重定向地址" type="text" class="form-control" name="redirect" placeholder="重定向地址"
                   value="{{ $client->redirect }}">
        </div>

        {{--    密码访问客户端    --}}
        <div class="input-group mb-3">
            <div class="input-group-text">
                <input class="form-check-input" type="checkbox" value="1"
                       @if($client->personal_access_client) checked @endif name="personal_access_client"
                       id="personal_access_client" aria-label="是否是个人访问客户端">
            </div>
            <span class="form-control">是否是个人访问客户端</span>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-text">
                <input class="form-check-input" type="checkbox" value="1"
                       @if($client->password_client) checked @endif name="password_client"
                       id="password_client" aria-label="是否是密码访问客户端">
            </div>
            <span class="form-control">是否是密码访问客户端</span>
        </div>


        <button type="submit" class="btn btn-primary mt-3">
            更新
        </button>
    </form>


    <hr/>

    <form class="d-inline" method="post" action="{{ route('clients.destroy', $client->id) }}"
          onsubmit="return confirm('确定删除吗?')">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-danger mt-3">
            删除
        </button>

    </form>

    <div class="mt-3">
        <h3>授权路由</h3>
        {{ route('passport.authorizations.authorize') }}
    </div>

    <div class="mt-3">
        <h3>请求令牌</h3>
        {{ route('passport.token') }}
    </div>


    <script>
        let client_id = '{{ $client->id }}';
        let secretInput = document.getElementById("secret-input");
        let secretCheckBox = document.getElementById("secret-check-box");

        secretCheckBox.addEventListener('change', function () {
            if (this.checked) {
                secretInput.value = this.dataset.secret;
            } else {
                secretInput.value = '';
            }
        });


    </script>
@endsection
