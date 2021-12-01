<?php
    $form = [
        'name' => [
            'class' => 'user-name',
            'title' => '*Username',
            'id' => 'name',
        ],
        'email' => [
            'class' => 'user-email',
            'title' => '*Email',
            'id' => 'email',
        ],
        'password' => [
            'class' => 'user-password',
            'title' => '*Password',
            'id' => 'password',
        ],
        'phone' => [
            'class' => 'user-phone',
            'title' => '*Phone',
            'id' => 'phone',
        ],
        'post_code' => [
            'class' => 'user-post_code',
            'title' => '*Post Code',
            'id' => 'post_code',
        ],
        'city' => [
            'class' => 'user-city',
            'title' => '* City',
            'id' => 'city',
        ],
        'ward' => [
            'class' => 'user-ward',
            'title' => '*Ward',
            'id' => 'ward',
        ],
        'address' => [
            'class' => 'user-address',
            'title' => '*Address',
            'id' => 'address',
        ],
        'note' => [
            'class' => 'user-note',
            'title' => 'Note',
            'id' => 'note',
        ],
    ];

    if(isset($user)){
        $action = route('users.update', [$user['id']]);
        $method = 'PUT';
    }else{
        $action = route('users.store');
        $method = 'POST';
    }
?>
@extends('home')
@section('title', 'Users Create')
@section('content')
    <div id="user-create">
        <h1 class="user-create_title">
            @if(isset($user))
                Update {{ $user['name'] }}
            @else
                User Create
            @endif
        </h1>
        <form class="h-adr" action="{{ $action }}" method="POST" id="user-post">
            @method($method)
            @csrf
            <span class="p-country-name" style="display:none;">Japan</span>
            @foreach($form as $value)
                <div class="{{ $value['class'] }} item">
                    <label for="{{ $value['id'] }}">{{ $value['title'] }}</label>
                    <div class="input">
                        @if(isset($user))
                            <input value="{{ $user[$value['id']] }}"
                                @if($value['id'] == 'post_code') class="p-postal-code" size="8" maxlength="8" @endif
                                @if($value['id'] == 'city') class="p-region" @endif
                                @if($value['id'] == 'ward') class="p-locality p-street-address p-extended-address"  @endif
                                type="text" name="{{ $value['id'] }}" id="{{ $value['id'] }}">
                        @else
                            <input type="text"
                                @if($value['id'] == 'post_code') class="p-postal-code" size="8" maxlength="8" @endif
                                @if($value['id'] == 'city') class="p-region" @endif
                                @if($value['id'] == 'ward') class="p-locality p-street-address p-extended-address"  @endif
                                name="{{ $value['id'] }}" id="{{ $value['id'] }}">
                        @endif
                        @if(isset($errs))
                            @if($errs->has($value['id']))
                                <div class="err">{{ $errs->first($value['id']) }}</div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="btn-group">
                <button id="btn-back-create-user" type="button" onclick="window.location='{{ url("admin/users") }}'" class="back">Back</button>
                <button id="btn-confirm-create-user" class="confirm">Confirm</button>
            </div>
        </form>
    </div>
@endsection