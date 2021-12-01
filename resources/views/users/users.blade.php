<?php
    $searchCity = [];
    $searchWard = [];
    foreach($cities as $key => $value){
        $searchCity[$key] = [
            'name' => $value,
            'value' => $value,
        ];
    }
    foreach($wards as $key => $value){
        $searchWard[$key] = [
            'name' => $value,
            'value' => $value,
        ];
    }
    $search = [
        'name' => [
            'name' => 'Name',
            'select' => false,
        ],
        'Phone' => [
            'name' => 'Phone',
            'select' => false,
        ],
        'City' => [
            'name' => 'City',
            'select' => true,
            'option' => $searchCity,
        ],
        'Ward' => [
            'name' => 'Ward',
            'select' => true,
            'option' => $searchWard,
        ]
    ];
    $data = json_encode($search)
?>
@extends('home')
@section('title', 'Users')
@section('content')
    <div id="users-page">
        <div class="header-user">
            <div class="header-user_title">User</div>
            <div class="header-user_desc">List User</div>
        </div>
        <x-search className="search-user" :oldValue="$oldValue" url="users.index" :data="$data"/>
        <button id="btn-create-user" onclick="window.location='{{ url("admin/users/create") }}'">Create</button>
        <table class="table">
            <thead class="table-head">
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Post Code</th>
                <th>City</th>
                <th>Ward</th>
                <th>Address</th>
                <th>Note</th>
            </thead>
            <tbody class="table-body">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->post_code }}</td>
                        <td>{{ $user->city }}</td>
                        <td>{{ $user->ward }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->note }}</td>
                        <td>
                            <button id="btn-user-update" type="button" onclick="window.location='{{ url("admin/users/".$user->id."/edit") }}'">Update</button>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('users.destroy', [$user->id]) }}">
                                @method('DELETE')
                                @csrf
                                <button class="handleDelete" id="btn-user-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-paginate prePage="{{ $users->previousPageUrl() }}" nextPage="{{ $users->nextPageUrl() }}" inPage="{{ $users->count() }}" totalPage="{{ $users->total() }}"/>
    </div>
@endsection