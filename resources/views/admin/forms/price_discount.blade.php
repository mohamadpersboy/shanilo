<script>
    $(document).ready(function(){
        $("input.price,input.discount").on("change keyup",function(){
            var $price = $("input.price");
            var $discount = $("input.discount");
            var $price_discount = $("input.price_discount");

            var price = number_unformat($price.val());
            var discount = ($discount.val().trim() != '')?$discount.val().trim():0;
            discount = parseFloat(discount).toFixed(1);
            var discount_val = (price * discount)/100;
            var price_discount = number_format(Math.trunc(price-discount_val));
            $("input.price_discount").val(price_discount);
        });
    });
</script>