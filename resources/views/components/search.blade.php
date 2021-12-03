<div id="search-bar" class="{{$className}}">
    <form action="{{ route($url) }}" method="GET">
        @php
            $form = json_decode($value)
        @endphp
        @foreach($form as $value)
            @php
                $name = $value->name
            @endphp
            <div class="container-search">
                <label for="{{ $name }}">{{ $name }}</label>
                @if($value->select)
                    <select name="{{$name}}">
                        <option value=""
                            @if(!array_key_exists($name, $oldValue)) selected @endif >
                        </option>
                        @foreach ($value->option as $item)
                            <option
                                @if(array_key_exists($name, $oldValue))
                                    @if($item->value == $oldValue->$name)
                                        selected
                                    @endif
                                @endif
                                value="{{ $item->value }}">{{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <input @if(array_key_exists($name, $oldValue)) value="{{ $oldValue->$name }}" @endif
                        type="text" id="{{ $name }}" name="{{ $name }}">
                @endif
            </div>
        @endforeach
        <button id="search">Search</button>
    </form>
</div>