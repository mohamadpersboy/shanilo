{{--Mehrdad Gharibdoost--}}

<script>
    $(document).ready(function() {

        $("[data-remove-file]").click(function() {
            var $this = $(this);
            var scope = $this.attr('data-scope');
            var rmv_elm = $this.attr('data-rmv-elm');
            var rmv_closest = $this.attr('data-rmv-closest');
            var pic_default = $this.attr('data-pic-default');
            var pic_old = $this.attr('data-pic-old');
            var pic_place = $this.attr('data-pic-place');

            var model = $this.attr('data-model');
            var id = $this.attr('data-id');
            var attachment_slug= $this.attr('data-attachment-slug');

            if($this.is('.static_remove')){

                if(pic_old != ""){
                    if($(scope).find(pic_place).is("img")){
                        $(scope).find(pic_place).attr("src",pic_old);
                        $(scope).find(pic_place).attr("style","");
                    }else{
                        $(scope).find(pic_place).css("background-image","url("+pic_old+")");
                        $(scope).find(pic_place+" img").remove();
                    }
                }
                else if(pic_default != ""){
                    if($(scope).find(pic_place).is("img")){
                        $(scope).find(pic_place).attr("src",pic_default);
                        $(scope).find(pic_place).attr("style","");
                    }else{
                        $(scope).find(pic_place).css("background-image","url("+pic_default+")");
                        $(scope).find(pic_place+" img").remove();
                    }
                    $this.css('display','none');
                }
                else{
                    $(scope).find(pic_place).remove();
                    $this.css('display','none');
                }

                /*if(rmv_elm != ""){
                    $(scope).find(rmv_elm).remove();
                }

                if(rmv_closest != ""){
                    $this.closest(rmv_closest).remove();
                }*/

                $this.removeClass('static_remove');

                return;
            }// static remove

            $this.addClass("loading_remove");
            $.ajax({
                data:{
                    model: model,
                    id: id,
                    attachment_slug: attachment_slug,
                    _token: $token,
                    _method: 'DELETE'
                },
                url: "{{ route('admin.ajax.delete.file') }}",
                type:"POST"
            }).always(function(){
                $this.removeClass("loading_remove");
            }).done(function(response){
                //var data = $.parseJSON(response);
                $this.css('display','none');

                $this.attr('data-pic-old','');

                if(pic_default != ""){
                    if($(scope).find(pic_place).is("img")){
                        $(scope).find(pic_place).attr("src",pic_default);
                        $(scope).find(pic_place).attr("style","");
                    }else{
                        $(scope).find(pic_place).css("background-image","url("+pic_default+")");
                        $(scope).find(pic_place+" img").remove();
                    }
                }
                else{
                    $(scope).find(pic_place).remove();
                }

                /*if(rmv_elm != ""){
                    $(scope).find(rmv_elm).remove();
                }

                if(rmv_closest != ""){
                    $this.closest(rmv_closest).remove();
                }*/

            }).fail(function(){
                show_notif('','مشکلی در ارتباط اینترنتی رخ داده است، مجددا تلاش نمائید','e','tc',15000);
            });// dynamic remove

        });//click

    });//document ready
</script>
