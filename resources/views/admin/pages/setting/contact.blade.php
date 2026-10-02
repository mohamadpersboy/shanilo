@extends('admin.master')
@section('content')

    <div class="paper_style1">
        <div class="title_style1">
            <p class="title1">تنظیمات</p>
            <p class="title2">تنظیمات تماس با ما</p>
        </div><!--title_style1-->

        <hr class="hr_style1 marginb20 margint20">

        <form method="post" class="form-horizontal form-contact-us-validation" action="{{route('admin.contactus.update')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form_style2">
                <ul class="list clearfix">

                    @foreach($data['objects'] as $object)
                        @if($object->name != 'latlong' && $object->type == 'string')
                            @include('admin.forms.input_text',['inputName'=>$object->name,'inputLabel'=>$object->title,'inputValue'=>$object->value])
                        @endif
                        @if($object->name != 'latlong' && $object->type == 'text')
                            @include('admin.forms.input_textarea',['inputName'=>$object->name,'inputLabel'=>$object->title,'inputValue'=>$object->value,'inputRow'=>3])
                        @endif
                        @if($object->name == 'latlong')
                            <input id="latInput" type="hidden" name="lat" value="">
                            <input id="longInput" type="hidden" name="long" value="">
                        @endif
                    @endforeach

                    <li class="item {{__('content.float')}} width100">
                        <p class="field_label">نقشه:<i class="required_style1">*</i></p>
                        <div class="item_inner">
                            <div id="map" style="width: 100%; height: 400px;"></div>
                        </div>
                    </li>

                </ul>

                <hr class="hr_style1 marginb20 margint20">

                <div class="btn_group_style1">
                    <ul class="list clearfix">
                        <li class="item {{__('content.float')}}">
                            <input type="submit" name="submit" value="{{__('content.save_changes')}}" class="btn_style2 green">
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

@endsection



{{--Active Menu--}}
@section('admin.contactus.index','active')
{{--End Active Menu--}}

@section('js')
    <script type="text/javascript"
            src='https://maps.google.com/maps/api/js?libraries=places&key=AIzaSyDZaZOS9IPKn3EhAlGWW0O7Hf43FKaH4Yw'></script>  <!-- ConfPaper Key -->
    <script type="text/javascript"
            src="{{asset('assets/admin/_plugins/locationpicker/src/locationpicker.jquery.js')}}"></script>


    <?php
    $latlong = explode(',', mainSetting('latlong'));
    $lat = $latlong[0];
    $long = $latlong[1];
    ?>

    <script>
        var LatNumber = '{{$lat}}';
        var LongNumber = '{{$long}}';
        $('#map').locationpicker({
            location: {
                latitude: LatNumber,
                longitude: LongNumber
            },
//            radius: 200,
            inputBinding: {
                latitudeInput: $('#latInput'),
                longitudeInput: $('#longInput')
//                radiusInput: $('#us3-radius'),
//                locationNameInput: $('#us3-address')
            },
            enableAutocomplete: true,
            markerIcon: '{{asset('assets/admin/_plugins/locationpicker')}}/pin.png'
        });

    </script>
@endsection

