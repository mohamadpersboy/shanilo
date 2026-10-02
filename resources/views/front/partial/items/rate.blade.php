@php
 $id=rand(10000,999999);
@endphp
<div class="rate_inner pointer_event clearfix">
    @for($i=5;$i>=1;$i--)
        <input type="radio" id="{{$id}}_star5_{{$i}}" value="{{$i}}" {{$rate==$i?'checked':''}}><label class="full star" for="{{$id}}_star5_{{$i}}" title=" امتیاز"></label>
    @endfor
</div>