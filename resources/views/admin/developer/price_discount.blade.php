{{-- Atlasweb Price Discount v1.1.0 --}}
{{-- Mehrdad gharibdoust --}}

<!-- Price Discount -->
<script type="text/javascript">
    $(document).ready(function () {
        $("[data-price-value]").on("change keyup",function(){
            var $price = $(this);
            var $discount = $(this).closest('[data-price-wrapper]').find("[data-discount-value]");

            var price = number_unformat($price.val());
            var discount = ($discount.val().trim() != '')?$discount.val().trim():0;
            discount = parseFloat(discount).toFixed(1);
            var discount_val = (price * discount)/100;
            var price_discount = number_format(round_num(price-discount_val));
            $(this).closest('[data-price-wrapper]').find("[data-price-discount-value]").val(price_discount);
        });

        $("[data-discount-value]").on("change keyup",function(){
            var $price = $(this).closest('[data-price-wrapper]').find("[data-price-value]");
            var $discount = $(this);

            var price = number_unformat($price.val());
            var discount = ($discount.val().trim() != '')?$discount.val().trim():0;
            discount = parseFloat(discount).toFixed(1);
            var discount_val = (price * discount)/100;
            var price_discount = number_format(round_num(price-discount_val));
            $(this).closest('[data-price-wrapper]').find("[data-price-discount-value]").val(price_discount);
        });
    });
</script>
<!-- End Price Discount -->
