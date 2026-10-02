<script>
    $(function () {
        $('.btn-random-str').on('click',function (e) {
            e.preventDefault();
            var count=$(this).data('count');
            count=count?count:5;
            $('.input-random-str').val(makeid(count));
        });
        function makeid(count) {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < count; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }
    });
</script>