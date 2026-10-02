<script>
    $(function () {
        $('select[name="parent_id"]').on('change', function () {
            hideOrShowTechnicalTransaction();
        });

        function hideOrShowTechnicalTransaction() {
            var technicalSpecification=$('select[name^=technical_specification]'),select = $('select[name^="parent_id"]'), option = select.find(':selected');
            if (option.length && option.data('level') == 2) {
                technicalSpecification.attr('disabled',false);
            }else{
                technicalSpecification.attr('disabled',true);
            }
        }
    });
</script>