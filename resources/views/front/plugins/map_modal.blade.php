<div class="modal_style1 map_modal w800">
    <div class="modal_scroll flex">
        <div class="close_bg"></div>
        <div class="wrapper">
            <div class="wrapper_box">
                <div class="close_btn"><i class="i-cancel"></i></div>
                <div class="title_style7"><span class="title">موقعیت فروشگاه</span></div>
                <div class="big_map">
                    <div id="map2" class="google-map" data-lat="35.763490110196116" data-long="51.32009738715817"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        /////////////////////////////
        //modal style2
        $('.map_modal_btn').click(function () {
            $('.modal_style1.map_modal').fadeIn(300);
            $('body').css('overflow', 'hidden');

            maps=[],markers=[];
            var maps=$('.google-map');
            $.each(maps,function () {
                var $this=this,latLng={
                    lat:parseFloat($($this).data('lat')),
                    lng:parseFloat($($this).data('long'))
                };
                var map = new google.maps.Map($this, {
                    zoom: 14,
                    center: latLng,
                    styles:mapStyles
                });
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    icon: image,
                });
                maps.push(map);
                markers.push(marker);
            });

        });

    });//document ready
</script>