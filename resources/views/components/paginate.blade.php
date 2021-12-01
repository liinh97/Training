<div id="comp_paginate">
    @if($prePage)
        <button id="pre-page" onclick="window.location='{{ url( $prePage ) }}'" id="btn_pre_page">Pre</button>
    @endif
    <div>{{ $inPage }} in {{ $totalPage }}</div>
    @if($nextPage)
        <button id="next-page" onclick="window.location='{{ url( $nextPage ) }}'" id="btn_next_page">Next</button>
    @endif
</div>