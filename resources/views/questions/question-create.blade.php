@extends('home')
@section('title', 'Question Create')
@section('content')
    <div id="question-create">
        <h1 class="question-create_title">
            @if(isset($question))
                Update {{$question['title']}}
            @else
                Create Question
            @endif
        </h1>
        <form id="question-post">
            <div class="question-container">
                <div class="question-title">
                    <label for="question-title">Title</label>
                    <div class="question-input-err">
                        @if(isset($question))
                            <input type="text" id="id-question" hidden value="{{ $question['id'] }}">
                            <input type="text" value="{{ $question['title'] }}" id="question-title">
                        @else
                            <input type="text" id="question-title">
                        @endif
                        <div id="question_err_title"></div>
                    </div>
                </div>
                <div class="question-type">
                    <label for="">Type check</label>
                    <select name="selection-type" id="selection-type">
                        <option @if(isset($question)) @if($question['type_checkbox'] == 1) selected @endif @endif value="1">Radio</option>
                        <option @if(isset($question)) @if($question['type_checkbox'] == 2) selected @endif @endif value="2">Checkbox</option>
                        <option @if(isset($question)) @if($question['type_checkbox'] == 3) selected @endif @endif value="3">Input</option>
                    </select>
                </div>
                <div class="question-more-anwser more-option">
                    <div class="more-option-title">More awnser</div>
                    <div class="require-true more-option_item">
                        <input
                            @if(isset($question)) @if($question['more'] == 1) checked @endif @endif
                            type="radio" id="more-true" name="more" value="1">
                        <label for="more-true">Cant more</label>
                    </div>
                    <div class="more-false more-option_item">
                        <input
                            @if(isset($question)) @if($question['more'] == 0) checked @endif @endif
                            type="radio" id="more-false" name="more" value="0">
                        <label for="more-false">Can't more</label>
                    </div>
                </div>
                <div class="question-require more-option">
                    <div class="more-option-title">This require ?</div>
                    <div class="require-true">
                        <input
                            @if(isset($question)) @if($question['require'] == 1) checked @endif @endif
                            type="radio" id="require-true" name="require" value="1">
                        <label for="require-true">Yes</label>
                    </div>
                    <div class="require-false">
                        <input
                            @if(isset($question)) @if($question['require'] == 0) checked @endif @endif
                            type="radio" id="require-false" name="require" value="0">
                        <label for="require-false">No</label>
                    </div>
                </div>
                <div class="anwser-container">
                    <label for="">Anwser</label>
                    <div class="container-right">
                        <button type="button" id="btn-new-input">New Input</button>
                        <span id="question_err_anwser"></span>
                        <div class="anwser-list">
                            @if(isset($anwsers))
                                @foreach($anwsers as $value)
                                    <input value="{{ $value['title'] }}" class="anwser-item" type="text">
                                @endforeach
                            @else
                                <input class="anwser-item" type="text">
                                <input class="anwser-item" type="text">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="btn-group">
                    <button id="btn-back-create-question" type="button" onclick="window.location='{{ url("/admin/questions") }}'" class="back">Back</button>
                    <button id="btn-confirm-create-question" class="confirm">Confirm</button>
                </div>
            </div>
        </form>
    </div>
@endsection