@extends('templates.app')

@section('content')
<div class="ui container first">
    <div class="ui segment">
        <h2>{{ __('static.privacy.title') }}</h2>

        {!! $md !!}

        <div class="ui list">
            <div class="item">
                <i class="file icon"></i>
                <div class="content">
                    <div class="header">{{ __('static.privacy.list.files._') }}</div>
                    <div class="description">{{ __('static.privacy.list.files.desc') }}</div>
                </div>
            </div>
            <div class="item">
                <i class="folder icon"></i>
                <div class="content">
                    <div class="header">{{ __('static.privacy.list.groups._') }}</div>
                    <div class="description">{{ __('static.privacy.list.groups.desc') }}</div>
                </div>
            </div>
            <div class="item">
                <i class="user icon"></i>
                <div class="content">
                    <div class="header">{{ __('static.privacy.list.ip._') }}</div>
                    <div class="description">{{ __('static.privacy.list.ip.desc') }}</div>
                </div>
            </div>
            @if(env('MIX_SENTRY_DSN'))
            <div class="item">
                <i class="warning icon"></i>
                <div class="content">
                    <div class="header">{{ __('static.privacy.list.sentry._') }}</div>
                    <div class="description">{{ __('static.privacy.list.sentry.desc') }}</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
