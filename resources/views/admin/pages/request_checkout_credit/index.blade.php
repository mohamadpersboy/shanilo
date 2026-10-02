@extends('admin.master')
@section('content')
    <div class="paper_style1">
        <div class="table_style1">
            {!! $grid !!}
        </div>
    </div>
@endsection

@section('js')
    <script>
      $('.list1').hide();
    </script>
@endsection
