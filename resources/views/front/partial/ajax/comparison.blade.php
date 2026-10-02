@foreach(Comparison::details() as $index=>$detail)
    <li class="item">
        <div class="dlt_btn btn-delete-comparison" data-url="{{route('front.comparison.destroy',$detail->product_id)}}"><i class="i-cancel"></i>
        </div>
        <a href="{{$detail->product->path()}}">
            <div class="pic" style="background-image: url('{{$detail->product->takeImage('main','270/150')}}');"></div>
            <div class="name">{{$detail->product->title}}</div>
        </a>
    </li>
@endforeach

