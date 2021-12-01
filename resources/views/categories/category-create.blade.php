@extends('home')
@section('title', 'Create Category')
@section('content')
    <div id="category-create">
        <h1 class="category-create_title">
            @if(isset($category))
                Update {{ $category['title'] }}
            @else
                Category Create
            @endif
        </h1>
        <form id="category-post">
            <div class="category-info">
                <div class="category-title">
                    <label for="title">Title</label>
                    <div class="input-err">
                        @if (isset( $category ))
                            <input type="text" id="id-category" hidden value="{{ $category['id'] }}">
                            <input value="{{ $category['title'] }}" type="text" id="category-title" name="title">
                        @else
                            <input type="text" id="category-title" name="title">
                        @endif
                        <div id="category_err_title"></div>
                    </div>
                </div>
                <div class="category-type">
                    <div class="type-title">Type</div>
                    <div class="radio-group">
                        <div class="group-public">
                            <input type="radio"
                                @if(isset($category))
                                    @if($category['type'] == 1) checked @endif
                                @else
                                    checked
                                @endif value="1" name="type" id="public">
                            <label for="public">Public</label>
                        </div>
                        <div class="group-private">
                            <input type="radio"
                                @if(isset($category))
                                    @if($category['type'] == 2) checked @endif
                                @endif value="2" name="type" id="private">
                            <label for="private">Private</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-question">
                <div class="list-question-title">
                    Choose Questions
                </div>
                <table class="table">
                    <thead class="table-head">
                        <th class="table-edit-id">ID</th>
                        <th>Check</th>
                        <th class="table-edit-title">Title Question</th>
                    </thead>
                    <tbody class="table-body">
                        @foreach ($questions as $value)
                            <tr>
                                <td class="table-edit-id">{{ $value['id'] }}</td>
                                @if(isset($questionHasCheck))
                                    <td class="table-edit-check">
                                        <input value="{{ $value['id'] }}" @if(in_array($value['id'], $questionHasCheck)) checked @endif class="list_questions" name="questions" type="checkbox">
                                    </td>
                                @else
                                    <td>
                                        <input value="{{ $value['id'] }}" class="list_questions" name="questions" type="checkbox">
                                    </td>
                                @endif
                                <td class="table-edit-title">{{ $value['title'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="category_err_checkbox"></div>
            <div class="btn-group">
                <button id="btn-back-create-category" type="button" onclick="window.location='{{ url("admin/categories") }}'" class="back">
                    Back
                </button>
                <button id="btn-confirm-create-category" class="confirm">Confirm</button>
            </div>
        </form>
    </div>
@endsection