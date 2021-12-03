<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Page Anwser</title>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front.page.css') }}" rel="stylesheet">
    
</head>
<body>
    @php
        $count = 0;
        $radio = 1;
        $checkbox = 2;
        $input = 3;
    @endphp
    <div class="front-page">
        <div class="header-title">
            <div class="title-left"><全国私立保育園連盟></div>
            <div class="title-right">災害報告フォーム</div>
        </div>
        <form method="POST" action="{{ route('anwser.post') }}" class="body-anwser">
            @csrf
            @foreach($form as $key => $item)
                @php
                    $count++;
                    switch($item['type']){
                        case $radio:
                            $typeInput = 'radio';
                            break;
                        case $checkbox:
                            $typeInput = 'checkbox';
                            break;
                        case $input:
                            $typeInput = 'text';
                            break;
                    }
                @endphp
                <div class="q{{ $count }} Q-item">
                    <div class="count-anwser">
                        @if($item['require'])
                            *Q{{ $count }}
                        @else
                            Q{{ $count }}
                        @endif
                        </div>
                    <div class="Q-container">
                        <div class="title Q-title">
                            {{ $item['title'] }}
                        </div>
                        <div @if($item['type'] == $input) class="content content_eidt" @else class="content" @endif >         
                            @if($item['db'])
                                @if($item['require'])
                                    <input checked type="checkbox" hidden name="require-validate[]" value="{{ $item['id'] }}">
                                @endif
                                @if($item['key'] == 'questions')
                                    <div class="container-question_anwser">
                                        @foreach($item['anwser'] as $value)
                                            <div
                                                @if($typeInput == 'text')
                                                    class="container-input container-input_edit container-input_edit_input"
                                                @else
                                                    class="container-input container-input_edit"
                                                @endif>
                                                <input @if($typeInput != 'text') value="{{ $value['title'] }}" @endif type="{{ $typeInput }}" id="{{ $value['title'] }}" name="q{{ $item['id'] }}[]">
                                                <label @if($item['type'] == $input)
                                                    hidden
                                                @endif for="{{ $value['title'] }}">{{ $value['title'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($item['more'])
                                        <div class="container-more">
                                            <input type="checkbox" id="q{{ $count }}" class="more-checkbox-{{ $count }} more-checkbox">
                                            <label for="q{{ $count }}">More</label>
                                            <input disabled class="more-{{ $count }} more-input" name="q{{ $item['id'] }}[] type="text">
                                        </div>
                                    @endif
                                @else
                                    @php
                                        $keyword = $item['key'];
                                    @endphp
                                    @foreach($$keyword as $value)
                                        <div class="container-input">
                                            <input type="radio" hidden name="category_id" value="{{ $value['id'] }}">
                                            <input class="input-checked" type="{{ $typeInput }}" value="{{ $value['title'] }}" id="{{ $value['title'] }}" name="q{{ $count }}">
                                            <label @if($item['type'] == $input)
                                                hidden
                                            @endif for="{{ $value['title'] }}">{{ $value['title'] }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            @else
                                @if($item['require'])
                                    <input checked type="checkbox" hidden name="require-validate[]" value="q{{ $count }}">
                                @endif
                                @foreach($item['content'] as $content)
                                    @if($item['type'] == $input)
                                        @if($item['form'])
                                            <div class="container-input">
                                                @if($content['desc'])
                                                    <div class="desc">{{ $content['desc-title'] }}</div>
                                                @endif
                                                <label for="{{ $content['title'] }}">{{ $content['title'] }}</label>
                                                @if($content['select'])
                                                    <input type="text" name="user_id" hidden class="id-user" value="">
                                                    <select class="select-more-info" name="{{ $content['key'] }}" id="{{ $content['title'] }}">
                                                        <option value=""></option>
                                                        @if($content['db'])
                                                            @php
                                                                $keyword = $content['key'];
                                                            @endphp
                                                            @foreach($$keyword as $element)
                                                                <option value="{{ $element }}">{{ $element }}</option>
                                                            @endforeach
                                                        @else
                                                        
                                                        @endif
                                                    </select>
                                                @else
                                                    <input class="input-more-info" type="{{ $typeInput }}" id="{{ $content['title'] }}" name="qq{{ $count }}">
                                                @endif
                                            </div>
                                            @if($content['err'])
                                                <div id="{{ $content['className'] }}" class="form-input-err"></div>
                                            @endif
                                        @else
                                        
                                        @endif
                                    @else
                                        <div class="container-input">
                                            <input type="{{ $typeInput }}" value="{{ $content['title'] }}" id="{{ $content['title'] }}" name="q{{ $count }}">
                                            <label for="{{ $content['title'] }}">{{ $content['title'] }}</label>
                                        </div>
                                    @endif
                                    @if($content['btn'])
                                        <button type="button" class="{{ $content['custom']['className'] }} btn-more-info">
                                            {{ $content['custom']['title'] }}
                                        </button>
                                    @endif
                                @endforeach
                            @endif
                            @if(count($errors) > 0)
                                @if($item['db'])
                                    @if($item['require'])
                                        <div class="form-input-err"> {{ $errors->getBag('default')->first('q'.$item['id']) }} </div>
                                    @endif
                                @else
                                    @if($item['require'])
                                        <div class="form-input-err"> {{ $errors->getBag('default')->first('q'.$count) }} </div>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <button id="btn-submit-anwser">Submit</button>
        </form>
    </div>

    <script src="{{ asset('js/jquery.slim.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(() =>{

            setAjaxHeader();

            const style = {
                'display': 'block',
            }
            $('.container-more').parent().css(style);

            // Handle enable input question - Q4 =>
            $('.more-checkbox').each(function(i){
                $('.more-checkbox').eq(i).change(function(){
                    if(this.checked){
                        $('.more-input').eq(i).prop('disabled', false);
                    }else{
                        $('.more-input').eq(i).prop('disabled', true);
                    }
                });
            });
            
            // Reload web with param category for get list question
            $('input[name=q1]').each(function(i){
                $('input[name=q1]').eq(i).change(function(){
                    if(this.checked){
                        $('input[name=category_id]').eq(i).prop('checked', true);
                        const category_id = $('input[name=category_id]').eq(i).val();
                        window.location.href = "http://127.0.0.1:8000/anwser?category_id=" + category_id;
                    }
                });
            });

            // Handle checked for radio category - Q1
            $('input[name=category_id]').each(i => {
                const queryString = location.search
                const params = new URLSearchParams(queryString);
                const id = parseInt(params.get("category_id"));
                if($('input[name=category_id]').eq(i).val() == id){
                    $('.input-checked').eq(i).prop('checked', true);
                    $('input[name=category_id]').eq(i).prop('checked', true);
                }
            })

            // Handle get info user - Q3
            $('.btn-more-info').click(() => {
                const post_code = $('.input-more-info').val();
                const city = $('select[name=cities]').val();
                const ward = $('select[name=wards]').val();
                const name = $('select[name=name]').val();

                $.ajax({
                    type: 'POST',
                    url: '/get-user',
                    data: {post_code, city, ward, name},
                    success: function(response){
                        if(response.status){
                            $('.form-input-err').each( i => {
                                $('#' + $('.form-input-err').eq(i).attr('id')).text('');
                            });
                            if(response.data.length > 0){
                                $('select[name=wards]').html(setHtml(response.data, 'ward'));
                                $('select[name=name]').html(setHtml(response.data, 'name'));
                                $('.id-user').val(response.data[0].id);
                                $('#name').text('');
                            }
                            else{
                                $('#name').text('User not found');
                            }
                        }
                        else{
                            $('.form-input-err').each( i => {
                                if(response.mess[$('.form-input-err').eq(i).attr('id')] != undefined){
                                    $('#' + $('.form-input-err').eq(i).attr('id')).text(response.mess[$('.form-input-err').eq(i).attr('id')][0]);
                                }
                            });
                        }
                    }
                });
            });
        });

        // Function render list option - support Q3
        function setHtml(arr, value){
            let option = '<option value=""></option>';
            arr.forEach(i => {
                option = option.concat(`<option class="option-more-info" value="${i[value]}">${i[value]}</option>`);
            });
            return option;
        }
    </script>
    
</body>
</html>