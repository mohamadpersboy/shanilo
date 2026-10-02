<script>
    $(function () {
        $(document.body).on('click','.add-dynamic-field',function () {
            var parent=$(this).closest('li'),field=parent.clone().hide();
            var count=$(document.body).find('li[data-index]').length-1,oldCount=count;
            field.clearInputs();
            if($(this).hasClass('change-count')){
                count++;
                setCount(field,count,oldCount);
            }
            parent.after(field);
            field.fadeIn(200);
            if(field.find('.remove-dynamic-field').length<=0){
                field.find('.add-dynamic-field').before("<i class='i-minus-square marginl15 minus_style1 remove-dynamic-field'></i>");
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

        function setCount(field,count,oldCount) {
            console.log(oldCount);
            var inputs=field.find('input'),replacement='['+oldCount+'][]';
            $.each(inputs,function (index,input) {
                var pureName=$(input).attr('name').replace(replacement,'');
                var newName=pureName+'['+count+'][]';
                $(input).attr('name',newName);
            });
        }
    });
</script>