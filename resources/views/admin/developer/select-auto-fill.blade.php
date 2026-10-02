<script>
    $(function () {
        $(document.body).on('change', '.select-auto-fill', function () {
            var selects=['shop_id','product_id'];
            var parent = $(this), url = parent.data('url'), child = $(parent.data('child')),
                defaultOption = child.data('default'),
                loading = child.data('loading');
                console.log($(this).attr('name'));
                if(selects.includes($(this).attr('name'))){
                    url+='/'+parent.val();
                }else{
                    var data={
                        categories:parent.val()
                    };
                }

            if(parent.val()==="" || parent.val()===undefined){
                child.html("<option select value=''>"+defaultOption+"</option>");
                return false;
            }
            child.html('<option value="">' + loading + '</option>');
            $.getJSON(url,data, function (response) {
                var options = "";
                if(defaultOption){
                    options = "<option value=''>" + defaultOption + "</option>";
                }

                $.each(response, function (index,object) {
                        options+="<option value='"+object.value+"'>"+object.title+"</option>";
                });
                child.html(options);
                child.trigger('change');
            }).fail(function (error) {
                alert('An error occurred with code ' + error.status);
            }).always(function () {

            });
        });
    });
</script>