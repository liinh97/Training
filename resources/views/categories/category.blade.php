<?php
    $public = 1;
    $search = [
        'title' => [
            'name' => 'Title',
            'select' => false,
        ]
    ];
    $data = json_encode($search)
?>
@extends('home')
@section('title', 'Category')
@section('content')
    <div id="category-page">
        <div class="header-user">
            <div class="header-user_title">Categories</div>
            <div class="header-user_desc">List Category</div>
        </div>
        <x-search className="search-category" :oldValue="$oldValue" url="categories.index" :data="$data"/>
        <table class="table">
            <button id="btn-create-category" onclick="window.location='{{ url("admin/categories/create") }}'">Create</button>
            <thead class="table-head">
                <th>ID</th>
                <th>Title</th>
                <th>Type</th>
            </thead>
            <tbody class="table-body">
                @foreach ($category as $value)
                    <tr>
                        <td style="width: 5%">{{ $value['id'] }}</td>
                        <td style="width: 65%">{{ $value['title'] }}</td>
                        <td>{{ $value['type'] == $public ? 'Public' : 'Private' }}</td>
                        <td>
                            <form method="POST" action="{{ url("admin/categories/".$value->id."/copy") }}">
                                @csrf
                                <button id="btn-category-copy">Copy</button>
                            </form>
                        </td>
                        <td><button id="btn-category-update" onclick="window.location='{{ url("admin/categories/".$value->id."/edit") }}'">Update</button></td>
                        <td>
                            <form method="POST" action="{{ route('categories.destroy', [$value->id]) }}">
                                @method('DELETE')
                                @csrf
                                <button class="handleDelete" id="btn-category-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-paginate prePage="{{ $category->previousPageUrl() }}" nextPage="{{ $category->nextPageUrl() }}" inPage="{{ $category->count() }}" totalPage="{{ $category->total() }}"/>
    </div>
@endsection