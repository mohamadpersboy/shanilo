$(document).ready(function () {
  if ($(window).width() > 550) {
    $(".user_home_page .title_style4").addClass("active");
  }

  $(".user-order-wizard li").each(function (i, event) {
    let element = event;
    // console.log(event);
    if (
      event.children[0].getAttribute("href") != "#" &&
      event.children[0].getAttribute("href") != "javascript:void(0)"
    ) {
      event.classList.add("user-order-tooltip");
      // console.log(element);
      if (event.children[0].innerHTML === "ثبت شده") {
        $(".user-order-tooltip").append(
          "<span>لطفا برای تکمیل سفارش وضعیت را به حالت تایید شده تغییر دهید</span>"
        );
      } else if (event.children[0].innerHTML === "تایید شده") {
        $(".user-order-tooltip").append(
          "<span>لطفا برای تکمیل سفارش وضعیت را به حالت تماس فروشگاه و مشتری تغییر دهید</span>"
        );
      } else if (event.children[0].innerHTML === "تماس فروشگاه و مشتری") {
        $(".user-order-tooltip").append(
          "<span>لطفا برای تکمیل سفارش وضعیت را به حالت ارسال سفارش تغییر دهید</span>"
        );
      } else if (event.children[0].innerHTML === "ارسال سفارش") {
        $(".user-order-tooltip").append(
          "<span>لطفا برای تکمیل سفارش وضعیت را به حالت دریافت سفارش تغییر دهید</span>"
        );
      }
    }
  });

  $(".product-gallery-mobile__img").click(function () {
    $(".gallery_modal").fadeIn(300);
    // $("body").css("overflow", "hidden");
  });

  $("body").click(function (e) {
    if (
      !$(e.target).is(
        ".gallery_modal .wrapper, .product-gallery-mobile__img, .slick-arrow, .swiper-button-white"
      ) &&
      !$(e.target).is(
        ".wrapper .wrapper *, .product-gallery-mobile__img .slick-arrow, .swiper-button-white"
      )
    ) {
      $(".modal_style3").fadeOut(300);
      $("body").css("overflow", "auto");
    }
  });

  $(".first").append("<p>Test</p>");
});
