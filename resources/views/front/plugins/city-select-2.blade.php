<link rel="stylesheet" href="_plugins/select2/select2.min.css">
<script src="_plugins/select2/select2.min.js"></script>
<script>
    $(function () {
        $.each($('select.select2[data-ajax]'), function () {
            $(this).select2({
                dir: 'rtl',
                minimumInputLength: 2,
                language: {
                    errorLoading: function () {
                        return "خطا هنگام خواندن اطلاعات";
                    },
                    inputTooLong: function (args) {
                        return "ورودی بسیار طولانی است";
                    },
                    inputTooShort: function (args) {
                        return "حدا 2 کاراکتر وارد نمایید.";
                    },
                    loadingMore: function () {
                        return "بیشتر...";
                    },
                    maximumSelected: function (args) {
                        return "ماکسیمم انتخاب شده";
                    },
                    noResults: function () {
                        return "هیچ نتیجه ای یافت نشد.";
                    },
                    searching: function () {
                        return "جستجو...";
                    }
                },
                ajax: {
                    url: $(this).data('url'),
                    dataType: 'json'
                }
            }).bind(this);
        });
        $.each($('select.select2[multiple],select.select2'), function () {
            if(!$(this).attr("data-ajax")){
                console.log($(this));
                $(this).select2({
                    dir: 'rtl',
                });
            }
        });
    });
</script>