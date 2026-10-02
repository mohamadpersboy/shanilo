<script>
    $(function () {
        $(document.body).on('click','.add-dynamic-field',function () {
            var parent=$(this).closest('li'),field=parent.clone().hide();
            field.clearInputs();
            parent.after(field);
            field.fadeIn(200);
            if(field.find('.remove-dynamic-field').length<=0){
                field.find('.add-dynamic-field').before("<i class='i-minus-square marginl15 minus_style1 remove-dynamic-field {{__('content.float')}}'></i>");
            }
        });
        $(document.body).on('click','.remove-dynamic-field',function () {
            var parent=$(this).closest('li').fadeOut(200);
            console.log(parent.length);
            setTimeout(function () {
                parent.remove();
            },400);
        });
        $.fn.clearInputs=function () {
            this.find('input,textarea,select').val('');
        };
    });
</script>