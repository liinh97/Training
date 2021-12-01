<?php
    $search = [
        'title' => [
            'name' => 'Title',
            'select' => false,
        ],
        'type' => [
            'name' => 'Type',
            'select' => true,
            'option' => [
                'radio' => [
                    'name' => 'Type Radio',
                    'value' => 1,
                ],
                'checkbox' => [
                    'name' => 'Type Checkbox',
                    'value' => 2,
                ],
                'input' => [
                    'name' => 'Type Input',
                    'value' => 3,
                ]
            ]
        ]
    ];
    $data = json_encode($search)
?>
@extends('home')
@section('title', 'Questions')
@section('content')
    <div id="question-page">
        <div class="header-user">
            <div class="header-user_title">Questions</div>
            <div class="header-user_desc">List Question</div>
        </div>
        <x-search className="search-question" :oldValue="$oldValue" url="questions.index" :data="$data"/>
        <button id="btn-create-question" onclick="window.location='{{ url("admin/questions/create") }}'">Create</button>
        <table class="table">
            <thead class="table-head">
                <th class="table-edit-id">ID</th>
                <th class="table-edit-checkbox">Type CheckBox</th>
                <th class="table-edit-title">Title</th>
            </thead>
            <tbody class="table-body">
                @foreach ($questions as $value)
                    <tr>
                        <td class="table-edit-id">{{ $value['id'] }}</td>
                        <td class="table-edit-checkbox">{{ $value['type_checkbox'] }}</td>
                        <td class="table-edit-title">{{ $value['title'] }}</td>
                        <td>
                            <form method="POST" action="{{ url("admin/questions/".$value->id."/copy") }}">
                                @csrf
                                <button id="btn-question-copy">Copy</button>
                            </form>
                        </td>
                        <td><button id="btn-question-update" onclick="window.location='{{ url("admin/questions/".$value->id."/edit") }}'">Update</button></td>
                        <td>
                            <form method="POST" action="{{ route('questions.destroy', [$value->id]) }}">
                                @method('DELETE')
                                @csrf
                                <button class="handleDelete" id="btn-question-delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-paginate prePage="{{ $questions->previousPageUrl() }}" nextPage="{{ $questions->nextPageUrl() }}" inPage="{{ $questions->count() }}" totalPage="{{ $questions->total() }}"/>
    </div>
@endsection