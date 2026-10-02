@if(session('msg'))
    <div class="result_style2 sign s">
        <div class="text icon">{{ session('msg') }}</div>
    </div>
    @php Session::forget('msg'); @endphp
@endif

@if(session('err'))
    <div class="result_style2 sign e">
        <div class="text icon">{{ session('err') }}</div>
    </div>
    @php Session::forget('err'); @endphp
@endif

@if (count($errors) > 0)
    <div class="result_style2 sign e">
        @foreach ($errors->all() as $error)
            <div class="text icon">{{ $error }}</div>
        @endforeach
    </div>
    @php $errors->add('visited', '1'); @endphp
@endif