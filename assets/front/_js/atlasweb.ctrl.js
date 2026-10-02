$(function () {
  var atlasweb = new Atlasweb(),
    slider;
  var productContainerLimit = 12;
  var xhrRequest;
  var timer;
  setProductCountDown();
  try {
    xzoom();
  } catch (error) {}

  /*##################################################*/
  //SPECIFIC FOR THIS PROJECT
  //Don't forget to remove this part in other new project.
  /*##################################################*/

  /**:::::::::::::::**| Pjax |**:::::::::::::::**/
  $.pjax.defaults.timeout = 3000;
  $.pjax.defaults.scrollTo = false;
  var profileSearchTypingTimer,
    profileSearchTypingTimeInterval = 500;
  $(document).on("pjax:beforeSend", function (event, xhr, settings) {
    atlasweb.block($("#pjax-container").addClass("loading"));
  });
  $(document).on("pjax:complete", function (event, xhr, settings) {
    atlasweb.unblock($("#pjax-container").removeClass("loading"));
    if (timer) {
      clearInterval(timer);
    }
    setProductCountDown();
    try {
      xzoom();
    } catch (error) {}
  });
  $(document).on(
    "pjax:error",
    function (event, xhr, textStatus, errorThrown, options) {}
  );

  $(document.body).on("focus", ".single-validation", function () {
    $(this).addClass("loading");
  });
  $(document.body).on("blur", ".single-validation", function () {
    var value = $(this).val().trim();
    if (!value) {
      $(this).removeClass("checked loading error error_style1");
      return false;
    }
    atlasweb.singleFieldValidation($(this));
  });
  $(document.body).on("change", "select.profile-filter", function () {
    pjax();
  });
  $(document.body).on(
    "keyup",
    'input[type="text"].profile-filter',
    function () {
      clearTimeout(profileSearchTypingTimer);
      profileSearchTypingTimer = setTimeout(
        pjax,
        profileSearchTypingTimeInterval
      );
    }
  );
  $(document.body).on(
    "keydown",
    'input[type="text"].profile-filter',
    function () {
      clearTimeout(profileSearchTypingTimer);
    }
  );
  $(document.body).on("click", ".pagination a", function (e) {
    e.preventDefault();
    if (!$(this).attr("href")) {
      return false;
    }
    pjax($(this).attr("href"));
  });
  $(document.body).on("click", ".pjax-link", function (e) {
    e.preventDefault();
    if ($(this).data("no-query")) {
      pjax($(this).attr("href"), null, true);
    } else {
      getProductsViaPjax();
    }
  });

  /**:::::::::::::::**| Filter products |**:::::::::::::::**/
  $(document.body).on("click", ".btn-load-more-pjax", function (e) {
    e.preventDefault();
    var limit = parseInt($("#limit").val()) + productContainerLimit;
    $("#limit").val(limit);
    getProductsViaPjax();
  });
  $(document.body).on("change", "select.filter", function () {
    getProductsViaPjax();
  });
  $(document.body).on("click", ".btn-remove-search", function () {
    $(document.body).find("#search").val("");
    getProductsViaPjax();
  });
  $(document.body).on("click", "#search+button", function () {
    getProductsViaPjax();
  });

  function getProductsViaPjax() {
    var url = $("#pjax-container").data("url") + "?limit=" + $("#limit").val();
    if ($("#view").length) {
      url += "&view=" + $("#view").val();
    }
    if ($("#search").length) {
      url += "&search=" + $("#search").val();
    }
    if ($("#category").length) {
      url += "&category=" + $("#category").val();
    }
    if ($("#plan").length) {
      url += "&plan=" + $("#plan").val();
    }
    pjax(url);
  }

  function pjax(url, container, clearQuery) {
    $.pjax({
      url: clearQuery ? url : generatePjaxUrl(url),
      container: container ? container : "#pjax-container",
    });
  }

  function generatePjaxUrl(url) {
    url = url ? url + "&" : $("#pjax-container").data("url") + "&";
    $.each($(".profile-filter"), function () {
      url += $(this).data("group") + "=" + $(this).val() + "&";
    });
    $.each($(".filter"), function () {
      var value = $(this).val() ? $(this).val() : "";
      if (value) {
        url += $(this).data("group") + "=" + value + "&";
      }
    });
    url = url.split("&");
    url.pop();
    return url.join("&");
  }

  /**:::::::::::::::**| Pjax End |**:::::::::::::::**/

  $("#third-level-categories").on("change", function () {
    var value = $(this).val(),
      url = $(this).data("url") + "/" + value,
      container = $("#technical-specification-container");
    if (value) {
      $.getJSON(url, function (response) {
        container.html(response.view);
        container.parent().fadeIn(200);
      }).fail(function (error) {
        atlasweb.showAlertErrorMessages(error);
      });
    } else {
      container.parent().fadeOut(200);
    }
  });
  $(document.body).on("click", ".btn-product-property-detail", function (e) {
    e.preventDefault();
    var btn = $(this),
      propertyContainer = btn
        .closest(".add_select_part")
        .find(".product-property-container"),
      url = btn.siblings("input[data-url]").data("url"),
      value = btn.siblings("input[data-url]").val(),
      propertyId = btn.siblings('input[name="product_property"]').val(),
      data = {
        value: value,
        product_property: propertyId,
        _token: $('meta[name="csrf-token"]').attr("content"),
      };
    $.ajax({
      type: "POST",
      url: url,
      data: data,
      dataType: "json",
      beforeSend: function () {
        atlasweb.blockButton(btn);
      },
      success: function (response) {
        var newProductPropertyDetail = $(response.view).hide();
        propertyContainer.append(newProductPropertyDetail);
        newProductPropertyDetail.slideDown(200);
        btn.siblings("input[data-url]").val("");
      },
      error: function (error) {
        atlasweb.showAlertErrorMessages(error);
      },
      complete: function () {
        atlasweb.unblockButton(btn);
      },
    });
  });
  $(document.body).on("click", ".btn-delete-product-property", function (e) {
    e.preventDefault();
    var btn = $(this),
      parent = btn.parent("div"),
      url = btn.data("url"),
      data = {
        _token: $('meta[name="csrf-token"]').attr("content"),
        _method: "DELETE",
      };

    $.ajax({
      type: "POST",
      url: url,
      data: data,
      dataType: "json",
      beforeSend: function () {
        parent.slideUp(200);
      },
      success: function (response) {
        parent.remove();
      },
      error: function (error) {
        parent.slideDown(200);
        atlasweb.showAlertErrorMessages(error);
      },
    });
  });
  $(document.body).on("click", ".triggerer", function (e) {
    e.preventDefault();
    $($(this).data("element")).trigger($(this).data("event"));
  });
  $(document.body).on("change", '[id^="detail-radio"]', function () {
    var input = $(this),
      url = input.data("url");
    $.ajax({
      type: "POST",
      url: url,
      dataType: "json",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        _method: "PATCH",
      },
      beforeSend: function () {
        atlasweb.block(input.closest("td"));
      },
      success: function (response) {
        toastr.options = atlasweb.setToastrOptions();
        toastr[response.type](response.message, response.header);
      },
      error: function (error) {
        atlasweb.showAlertErrorMessages(error);
      },
      complete: function () {
        atlasweb.unblock(input.closest("td"));
      },
    });
  });
  $(document.body).on("click", ".btn-covered-states", function (e) {
    var button = $(this),
      url = button.data("url"),
      modal = $(".modal_style1.states_modal");
    modal.fadeIn(300);
    $("body").css("overflow", "hidden");
    sendGet(
      url,
      null,
      function (response) {
        modal.find(".modal-body").html(response.view);
      },
      function () {
        atlasweb.block(modal.find(".modal-body"));
      },
      function () {
        atlasweb.unblock(modal.find(".modal-body"));
      }
    );
  });
  $(document.body).on("click", ".btn-covered-cities", function (e) {
    var button = $(this),
      url = button.data("url"),
      modal = $(".modal_style1.cities_modal");
    modal.fadeIn(300);
    $("body").css("overflow", "hidden");
    sendGet(
      url,
      null,
      function (response) {
        modal.find(".modal-body").html(response.view);
      },
      function () {
        atlasweb.block(modal.find(".modal-body"));
      },
      function () {
        atlasweb.unblock(modal.find(".modal-body"));
      }
    );
  });
  $(document.body).on("change", "#select-shop-cities", function () {
    if (!$(this).val()) return false;
    var select = $(this),
      url = select.data("url") + "/" + $(this).val();
    sendGet(
      url,
      null,
      function (response) {
        select.closest("ul").after(response.view);
      },
      function () {
        select.closest(".modal-body").find("ul:nth-child(2)").remove();
        atlasweb.block(select.closest(".modal-body"));
      },
      function () {
        atlasweb.unblock(select.closest(".modal-body"));
        atlasweb.priceFormat($("input.currency"));
      }
    );
  });

  $(document.body).on("change", 'input[type="checkbox"].all', function () {
    $('input[type="checkbox"].all-child').prop(
      "checked",
      $(this).is(":checked")
    );
  });
  $(document.body).on("keyup", 'input[type="text"].all', function () {
    $('input[type="text"].all-child').val($(this).val());
  });

  /**:::::::::::::::**| Load more (Pagination) |**:::::::::::::::**/
  $(document.body).on("click", ".btn-load-more", function (e) {
    e.preventDefault();
    var button = $(this),
      url = button.data("url"),
      data = {
        page: parseInt(button.attr("data-page")) + 1,
      };
    button.addClass("loading");
    $.getJSON(url, data, function (response) {
      button.attr("data-page", data.page);
      $(button.data("parent")).find(button.data("item")).before(response.view);
      if (!response.hasMorePage) {
        button.fadeOut(200, function () {
          $(this).remove();
        });
      }
    })
      .fail(function (error) {
        atlasweb.showAlertErrorMessages(error);
      })
      .always(function () {
        button.removeClass("loading");
      });
  });

  /**:::::::::::::::**| Block |**:::::::::::::::**/
  $(document.body).on("click", ".btn-follow,.btn-block", function (e) {
    e.preventDefault();
    var button = $(this),
      url = button.data("url");
    $.ajax({
      type: "POST",
      url: url,
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
      },
      dataType: "json",
      beforeSend: function () {
        atlasweb.blockButton(button);
      },
      success: function (response) {
        if (button.hasClass("in-modal")) {
          button.parent().html(response.view);
        } else {
          var followerCount = parseInt(
            $(".follower_btn.modal_btn").find(".count").html()
          );
          if (response.text == "unfollow") {
            followerCount++;
          } else if (response.text == "follow") {
            followerCount--;
          }
          $(".follower_btn.modal_btn").find(".count").html(followerCount);
          button
            .removeClass(response.removeClass)
            .addClass(response.addClass)
            .find("span")
            .text(response.text);
        }
        $(response.counter).html(response.count);
      },
      error: function (error) {
        atlasweb.showAlertErrorMessages(error);
      },
      complete: function () {
        atlasweb.unblockButton(button);
      },
    });
  });

  /**:::::::::::::::**| Followers modal |**:::::::::::::::**/
  $(document.body).on("click", ".following_btn", function () {
    var button = $(this),
      url = button.data("url"),
      modal = $(".modal_style1.following_modal");
    modal.find("ul").html("");
    atlasweb.block(modal.find("ul"));
    modal.fadeIn(300);
    $("body").css("overflow", "hidden");
    getFollowers(url, modal);
  });
  $(document.body).on("click", ".follower_btn", function () {
    var button = $(this),
      url = button.data("url"),
      modal = $(".modal_style1.follower_modal");
    modal.find("ul").html("");
    atlasweb.block(modal.find("ul"));
    modal.fadeIn(300);
    $("body").css("overflow", "hidden");
    getFollowers(url, modal);
  });

  /**:::::::::::::::**| Customers modal |**:::::::::::::::**/
  $(document.body).on("click", ".btn-clients", function (e) {
    e.preventDefault();
    var button = $(this),
      url = button.data("url"),
      modal = $(".modal_style1.user_modal");
    modal.find("ul").html("");
    atlasweb.block(modal.find("ul"));
    modal.fadeIn(300);
    $("body").css("overflow", "hidden");
    getFollowers(url, modal);
  });

  /**:::::::::::::::**| Comments |**:::::::::::::::**/
  $(document.body).on("click", ".btn-comments", function (e) {
    e.preventDefault();
    var url = $(this).data("url"),
      modal = $(".modal_style1.comment_modal"),
      container = modal.find(".modal-body");
    container.html("");
    atlasweb.block(container);
    modal.fadeIn(300);
    $("body").css("overflow", "hidden");
    $.getJSON(url, function (response) {
      container.html(response.view);
    })
      .fail(function (error) {
        modal.find(".close_btn").trigger("click");
        atlasweb.showAlertErrorMessages(error);
      })
      .always(function () {
        atlasweb.unblock(container);
      });
  });
  $(document.body).on(
    "click",
    ".comment_style1 .reply_btn.cm_btn",
    function () {
      var this_btn = $(this);
      var reply_html = $("#reply_comment_form").clone().html();
      $(".reply_html")
        .stop()
        .slideUp(200, function () {
          $(this).empty();
        });
      var url = this_btn.data("url");
      $(this_btn)
        .closest(".item1")
        .find(".reply_html")
        .html(reply_html)
        .stop()
        .slideDown(200, function () {
          $(this).find("form").attr("action", url);
        });
    }
  ); // reply comment
  //close reply comment
  $(document.body).on("click", ".comment_style1 .close_btn", function () {
    $(".comment_style1 .reply_html").slideUp(200, function () {
      $(this).empty();
    });
  }); //close reply comment
  $(document.body).on("change", 'form input[name^="rating"]', function () {
    var value = $(this).val();
    $(this).closest("form").find('input[name="rate"]').val(value);
  });

  /**:::::::::::::::**| Reports |**:::::::::::::::**/
  $(document.body).on("click", ".btn-report", function () {
    var btn = $(this),
      url = btn.data("url");
    sendPost(
      url,
      null,
      function (response) {
        btn.addClass("reported").find("span").text(response.text);
      },
      function () {
        atlasweb.blockButton(btn);
      },
      function () {
        atlasweb.unblockButton(btn);
      }
    );
  });
  $(document.body).on("click", ".btn-create-report", function (e) {
    e.preventDefault();
    var url = $(this).data("url"),
      modal = $(".modal_style1.report_modal"),
      container = modal.find(".modal-body");
    atlasweb.block(container);
    modal.fadeIn(300);
    $("body").css("overflow", "hidden");
    $.getJSON(url, function (response) {
      container.html(response.view);
    })
      .fail(function (error) {
        modal.find(".close_btn").trigger("click");
        atlasweb.showAlertErrorMessages(error);
      })
      .always(function () {
        atlasweb.unblock(container);
      });
  });

  /**:::::::::::::::**| Share |**:::::::::::::::**/
  $(document.body).on("click", ".share_btn", function () {
    var model = $(this).data("model"),
      id = $(this).data("id"),
      modal = $(".modal_style1.share_modal");
    modal.fadeIn(300, function () {
      $(this).find('input[name="model"]').val(model);
      $(this).find('input[name="id"]').val(id);
    });
    $("body").css("overflow", "hidden");
  });

  /**:::::::::::::::**| Favorite |**:::::::::::::::**/
  $(document.body).on("click", ".btn-favorite", function (e) {
    e.preventDefault();
    var button = $(this),
      url = button.data("url");
    sendPost(
      url,
      null,
      function (response) {
        var favoriteCountMethod = response.count ? "removeClass" : "addClass";
        $("#favorite-count").html(response.count)[favoriteCountMethod]("hide");
        $("#favorite-container")
          .html(response.view)
          .find(".have_scroll_y")
          .refreshmCustomScrollbar();
        $(document.body)
          .find('.btn-favorite.in-product[data-url="' + url + '"]')
          [response.method](response.class)
          .find("span.text")
          .text(response.text);
        $(document.body)
          .find('.btn-favorite.in-details[data-url="' + url + '"]')
          [response.method](response.class)
          .find("span.tooltip")
          .text(response.text);
      },
      function () {
        atlasweb.blockButton(button);
      },
      function () {
        atlasweb.unblockButton(button);
      }
    );
  });

  /**:::::::::::::::**| NotfiyList |**:::::::::::::::**/
  $(document.body).on("click", ".btn-notify-list", function (e) {
    e.preventDefault();
    var button = $(this),
      url = button.data("url");
    sendPost(
      url,
      null,
      function (response) {
        $('.btn-notify-list.in-product[data-url="' + url + '"]')
          [response.method](response.class)
          .find("span.text")
          .html(response.text);
        $('.btn-notify-list.in-details[data-url="' + url + '"]')
          [response.method](response.class)
          .find("span.tooltip")
          .text(response.text);
      },
      function () {
        atlasweb.blockButton(button);
      },
      function () {
        atlasweb.unblockButton(button);
      }
    );
  });

  /**:::::::::::::::**| Announcement |**:::::::::::::::**/
  $(document.body).on("click", ".btn-seen-announcement", function (e) {
    e.preventDefault();
    var li = $(this)
        .closest("li")
        .fadeOut(200, function () {
          sendPost(url, { _method: "PATCH" }, function (response) {
            li.remove();
            var count = parseInt($("#announcements-count").html());
            $("#announcements-count").html(--count);
            if (ul.find("li").length <= 0) {
              location.reload();
            }
          });
        }),
      ul = li.closest("ul"),
      url = $(this).data("url");
  });

  /**:::::::::::::::**| Send Message |**:::::::::::::::**/
  $(document.body).on("click", ".btn-send-message", function (e) {
    e.preventDefault();
    var button = $(this),
      url = button.data("url"),
      modal = $(".modal_style1.message_modal"),
      container = modal.find(".modal-body");
    container.html("");
    atlasweb.block(container);
    modal.fadeIn(300);
    atlasweb.blockButton(button);
    $.getJSON(url, function (response) {
      container.html(response.view);
    })
      .fail(function (error) {
        modal.find(".close_btn").trigger("click");
        atlasweb.showAlertErrorMessages(error);
      })
      .always(function () {
        atlasweb.unblockButton(button);
        atlasweb.unblock(container);
      });
  });

  /**:::::::::::::::**| Share product with friends |**:::::::::::::::**/
  $(document.body).on("typeend", "#frm-send-to-friends input", function () {
    var value = $(this).val().trim(),
      url = $(this).data("url"),
      loading = $(this).parent().find(".loading");
    $("#frm-send-to-friends input[name='users']").val("");
    if (value && value != "" && value != "@") {
      sendGet(
        url,
        {
          key: value,
        },
        function (response) {
          $("#share-friend-list")
            .html(response.view)
            .closest(".have_scroll_y")
            .refreshmCustomScrollbar();
        },
        function () {
          loading.removeClass("hide");
        },
        function () {
          loading.addClass("hide");
        }
      );
    } else {
      loading.addClass("hide");
      $("#share-friend-list")
        .html("")
        .closest(".have_scroll_y")
        .refreshmCustomScrollbar();
    }
  });

  $(document.body).on("click", ".share-friend", function () {
    $(this).toggleClass("checked");
    setShareUsers();
  });

  $(document.body).on(
    "click",
    ".search_result_style1 .btn_style2",
    function () {
      $("#frm-send-to-friends").submit();
    }
  );

  function setShareUsers() {
    var str = "";
    $.each($(".share-friend.checked"), function () {
      str += $(this).data("id") + ",";
    });
    str = str.split(",");
    str.splice(-1, 1).join(",");
    $("#frm-send-to-friends").find('input[name="users"]').val(str);
  }

  function getFollowers(url, modal) {
    $.getJSON(url, function (response) {
      modal.find("ul").html(response.view);
    })
      .fail(function (error) {
        atlasweb.showAlertErrorMessages(error);
        modal.find(".close_btn").trigger("click");
      })
      .always(function () {
        atlasweb.unblock(modal.find("ul"));
      });
  }

  /**:::::::::::::::**| Product color changer |**:::::::::::::::**/
  $(document.body).on("change", ".rdo-product-color", function () {
    pjax($(this).data("url"));
  });

  /**:::::::::::::::**| Product count down timer |**:::::::::::::::**/
  function setProductCountDown() {
    if ($(document.body).find("#special-suggestion").length) {
      //timer
      var expiresAt = $("#special-suggestion").attr("data-date");
      var compareDate = new Date(expiresAt);
      compareDate.setDate(compareDate.getDate()); //just for this demo today + 7 days
      timer = setInterval(function () {
        timeBetweenDates(compareDate);
      }, 1000);
    }
  }

  function timeBetweenDates(toDate) {
    var dateEntered = toDate;
    var now = new Date();
    var difference = dateEntered.getTime() - now.getTime();

    if (difference <= 0) {
      // Timer done
      clearInterval(timer);
    } else {
      var seconds = Math.floor(difference / 1000);
      var minutes = Math.floor(seconds / 60);
      var hours = Math.floor(minutes / 60);
      var days = Math.floor(hours / 24);
      var monthts = Math.floor(days / 30);
      days %= 30;
      hours %= 24;
      minutes %= 60;
      seconds %= 60;

      $("#months").text(monthts);
      $("#days").text(days);
      $("#hours").text(hours);
      $("#minutes").text(minutes);
      $("#seconds").text(seconds);
      if ($("#months").text() == 0) {
        $("#months").parent().hide();
      }
      if ($("#days").text() == 0 && $("#months").text() == 0) {
        $("#days").parent().hide();
      }
      if (
        $("#hours").text() == 0 &&
        $("#days").text() == 0 &&
        $("#months").text() == 0
      ) {
        $("#hours").parent().hide();
      }
      if (
        ($("#minutes").text() == 0) & ($("#hours").text() == 0) &&
        $("#days").text() == 0 &&
        $("#months").text() == 0
      ) {
        $("#minutes").parent().hide();
      }
      if (
        ($("#seconds").text() == 0) &
          ($("#minutes").text() == 0) &
          ($("#hours").text() == 0) &&
        $("#days").text() == 0 &&
        $("#months").text() == 0
      ) {
        $("#special-suggestion").slideUp();
      }
      $("#special-suggestion").slideDown(200);
    }
  }

  /**:::::::::::::::**| Product details xzoom |**:::::::::::::::**/
  $(document.body).on("click", ".compare_btn a", function (e) {
    var button = $(this),
      url = $(this).data("url");
    sendPost(
      url,
      null,
      function (response) {
        updateComparison(response);
      },
      function () {
        atlasweb.blockButton(button);
      },
      function () {
        atlasweb.unblockButton(button);
      }
    );
  });
  $(document.body).on("click", ".btn-delete-comparison", function () {
    var button = $(this),
      url = button.data("url"),
      item = button.closest("li.item");
    sendPost(
      url,
      { _method: "delete" },
      function (response) {
        updateComparison(response);
      },
      function () {
        atlasweb.blockButton(item);
      },
      function () {
        atlasweb.unblockButton(item);
      }
    );
  });

  function updateComparison(response) {
    if (response.redirect) {
      location.reload();
    }
    if (response.count) {
      $(".compare_style1").slideDown(200, function () {
        $(this).find(".bottom_part").slideDown(200);
        $(this).find(".down_btn").removeClass("active");
      });
    } else {
      $(".compare_style1").hide().find(".bottom_part").hide();
      $(".compare_style1 .down_btn").addClass("active");
    }
    $(".compare_style1 ul").html(response.view);
    $("#comparison-count").html(response.count);
    $('[data-url="' + response.toggleUrl + '"]')
      [response.method]("active")
      .find("span.text")
      .text(response.text);
    if (response.deletedItems.length) {
      $.each(response.deletedItems, function () {
        $(document.body)
          .find('[data-url="' + this.toggleUrl + '"]')
          [this.method]("active")
          .find("span.text")
          .text(this.text);
      });
    }
  }

  /**:::::::::::::::**| Product details xzoom |**:::::::::::::::**/
  function xzoom() {
    if ($(".xzoom4").length) {
      $(".xzoom4, .xzoom-gallery4").xzoom({
        tint: "#fff",
        Xoffset: 15,
        position: "left",
      });

      //Integration with hammer.js
      var isTouchSupported = "ontouchstart" in window;

      if (isTouchSupported) {
        //If touch device
        $(".xzoom4").each(function () {
          var xzoom = $(this).data("xzoom");
          xzoom.eventunbind();
        });

        $(".xzoom4").each(function () {
          var xzoom = $(this).data("xzoom");
          $(this)
            .hammer()
            .on("tap", function (event) {
              event.pageX = event.gesture.center.pageX;
              event.pageY = event.gesture.center.pageY;
              var s = 1,
                ls;

              xzoom.eventmove = function (element) {
                element.hammer().on("drag", function (event) {
                  event.pageX = event.gesture.center.pageX;
                  event.pageY = event.gesture.center.pageY;
                  xzoom.movezoom(event);
                  event.gesture.preventDefault();
                });
              };

              var counter = 0;
              xzoom.eventclick = function (element) {
                element.hammer().on("tap", function () {
                  counter++;
                  if (counter == 1) setTimeout(openfancy, 300);
                  event.gesture.preventDefault();
                });
              };

              function openfancy() {
                if (counter == 2) {
                  xzoom.closezoom();
                  $.fancybox.open(xzoom.gallery().cgallery);
                } else {
                  xzoom.closezoom();
                }
                counter = 0;
              }

              xzoom.openzoom(event);
            });
        });
      } else {
        //Integration with fancybox plugin
        $("#xzoom-fancy").bind("click", function (event) {
          var xzoom = $(this).data("xzoom");
          xzoom.closezoom();
            $.fancybox.open(xzoom.gallery().cgallery, {
              padding: 0,
              helpers	: {
                overlay: { locked: false },
                  thumbs	: {
                      width	: 100,
                      height	: 100
                  }
              }
            });
          event.preventDefault();
        });
      }
    }
  }

  /**:::::::::::::::**| Cart |**:::::::::::::::**/
  $(document.body).on("click", ".btn-toggle-cart", function () {
    var button = $(this),
      url = button.data("url"),
      data = {
        properties: $('select[name="properties[]"]')
          .map(function () {
            return $(this).val();
          })
          .get(),
      };
    sendPost(
      url,
      data,
      function (response) {
        updateCartList(response);
        var method = response.count ? "removeClass" : "addClass";
        $("#cart-count")[method]("hide").html(response.count);
        ellipsis();
        $('.btn_style2.btn-toggle-cart[data-url="' + url + '"]')
          [response.method]("in_cart")
          .find("span.text")
          .html(response.text);
      },
      function () {
        atlasweb.blockButton(button);
      },
      function () {
        atlasweb.unblockButton(button);
      }
    );
  });
  $(document.body).on("change", ".cart-product-count", function () {
    var input = $(this),
      url = input.data("url");
    sendPost(
      url,
      {
        count: input.val(),
      },
      function (response) {
        updateCartList(response);
        input
          .closest(".table_style3")
          .find(".total-cart-price")
          .text(response.total_cart_price);
        input
          .closest("table")
          .find(".total-product-price")
          .text(response.total_product_price);
      },
      function () {},
      function () {}
    );
  });
  $(document.body).on("change", '[name="dont_show_as_customer"]', function () {
    var input = $(this),
      url = $(this).attr("data-url"),
      showAsCustomer = input.is(":checked") ? 0 : 1;
    sendPost(
      url,
      {
        show_as_customer: showAsCustomer,
        _method: "PATCH",
      },
      function (response) {},
      function () {
        atlasweb.blockButton(input);
      },
      function () {
        atlasweb.unblockButton(input);
      }
    );
  });
  $(document.body).on("change", ".cart-updater", function () {
    var input = $(this),
      url = input.data("url"),
      blockable = $(input.data("block")),
      data = {
        _method: "PATCH",
        field: input.data("field"),
        value: input.data("value"),
      };
    sendPost(
      url,
      data,
      function (response) {
        //
      },
      function () {
        atlasweb.block(blockable);
      },
      function () {
        atlasweb.unblock(blockable);
      },
      function (error) {
        input.prop("checked", false);
      }
    );
  });

  function updateCartList(response) {
    $("#cart-container")
      .html(response.view)
      .find(".have_scroll_y")
      .refreshmCustomScrollbar();
  }

  /**:::::::::::::::**| Wallet |**:::::::::::::::**/
  $(document.body).on("click", ".btn-wallet", function () {
    var button = $(this),
      url = button.data("url"),
      modal = $(".modal_style1.waller_transactions_modal"),
      container = modal.find(".wrapper_box");
    sendGet(
      url,
      null,
      function (response) {
        container.html(response.view);
      },
      function () {
        modal.fadeIn(200);
        $("body").css("overflow", "hidden");
        atlasweb.block(container);
      },
      function () {
        atlasweb.unblock(container);
      }
    );
  });

  /**:::::::::::::::**| Bank cart |**:::::::::::::::**/
  $(document.body).on("click", ".btn-bank-cart", function () {
    var button = $(this),
      url = button.data("url"),
      modal = $(".modal_style1.add_cart_modal"),
      container = modal.find(".wrapper_box");
    sendGet(
      url,
      null,
      function (response) {
        container.html(response.view);
      },
      function () {
        modal.fadeIn(200);
        $("body").css("overflow", "hidden");
        atlasweb.block(container);
      },
      function () {
        atlasweb.unblock(container);
      }
    );
  });

  /**:::::::::::::::**| Address |**:::::::::::::::**/
  $(".add_address_btn").click(function () {
    var top_sp = $(this).offset().top;
    $("html,body").animate({ scrollTop: top_sp - 50 }, 800);
    if ($(this).attr("data-ajax") == "true") {
      var url = $(this).data("url");
      changeAddressForm(url);
      $(".add_address_btn").attr("data-ajax", false);
    } else {
      $(".add_address_part").slideDown(300);
    }
  });
  $(document.body).on("click", ".btn-edit-address", function (e) {
    e.preventDefault();
    $(".add_address_btn").attr("data-ajax", true);
    changeAddressForm($(this).data("url"));
  });

  /**:::::::::::::::**| Order |**:::::::::::::::**/
  $(document.body).on("click", ".btn-update-order-status", function (e) {
    e.preventDefault();
    var button = $(this),
      url = button.attr("href"),
      status = button.data("status");
    if (
      (!button.parent("li").hasClass("active") || url == "#") &&
      !button.hasClass("cancel_btn")
    )
      return false;
    swal({
      title: "آیا از تغییر وضعیت این سفارش مطمئن هستید؟",
      text: "پس از تغییر وضعیت برگشتن به وضعیت قبلی امکانپذیر نخواهد بود.",
      icon: "warning",
      buttons: {
        cancel: "انصراف",
        confirm: "بله",
      },
      dangerMode: true,
    }).then(function (value) {
      if (value === true) {
        sendPost(
          url,
          {
            status: status,
            _method: "PATCH",
          },
          function (response) {
            window.location.href = response.url;
          },
          function () {
            atlasweb.blockButton(button);
          },
          function () {
            atlasweb.unblockButton(button);
          }
        );
      }
    });
  });

  function changeAddressForm(url) {
    sendGet(
      url,
      null,
      function (response) {
        $(".add_address_part").html(response.view);
      },
      function () {
        $(".add_address_part").slideDown(300);
        atlasweb.block($(".add_address_part"));
      },
      function () {
        atlasweb.unblock($(".add_address_part"));
      }
    );
  }

  /**:::::::::::::::**| Search |**:::::::::::::::**/
  $(document.body).on("typeend", "#search-input", function () {
    $("#search-form").submit();
  });
  $(document.body).on("submit", "#search-form", function (e) {
    e.preventDefault();
    var form = $(this),
      url = form.attr("action"),
      value = $("#search-input").val().trim(),
      loading = form.find(".loading"),
      container = $("#search-result ul");
    if (!value) {
      container.slideUp(200, function () {
        $(this).html("").parent("div").refreshmCustomScrollbar();
      });
      return false;
    }
    sendGet(
      url,
      { key: value },
      function (response) {
        container.html(response.view).parent("div").refreshmCustomScrollbar();
        container.slideDown(200);
      },
      function () {
        loading.find(".loading_img").fadeIn();
      },
      function () {
        loading.find(".loading_img").fadeOut();
      }
    );
  });

  /**:::::::::::::::**| Tooltip |**:::::::::::::::**/

  $(document.body)
    .on("mouseenter", ".help_text_style1", function (event) {
      $(this)
        .find(".tooltip_style1")
        .fadeIn(200, function () {
          $(this).removeClass("loading");
        });
    })
    .on("mouseleave", ".help_text_style1", function (event) {
      $(this)
        .find(".tooltip_style1")
        .fadeOut(200, function () {
          $(this).removeClass("loading");
        });
    });
  /*##################################################*/
  //SPECIFIC FOR THIS PROJECT ENDS
  /*##################################################*/

  function sendPost(url, data, success, beforeSend, complete, errorC) {
    data = data ? data : {};
    data._token = $('meta[name="csrf-token"]').attr("content");
    xhrRequest = $.ajax({
      type: "POST",
      url: url,
      data: data,
      dataType: "json",
      beforeSend: function () {
        beforeSend ? beforeSend() : null;
        if (xhrRequest) {
          xhrRequest.abort();
        }
      },
      success: function (response) {
        success(response);
      },
      error: function (error) {
        atlasweb.showAlertErrorMessages(error);
        if (errorC) {
          errorC(error);
        }
      },
      complete: function () {
        complete ? complete() : null;
      },
    });
  }

  function sendGet(url, data, success, beforeSend, complete, errorC) {
    data = data ? data : {};
    xhrRequest = $.ajax({
      type: "GET",
      url: url,
      data: data,
      dataType: "json",
      beforeSend: function () {
        beforeSend ? beforeSend() : null;
        if (xhrRequest) {
          xhrRequest.abort();
        }
      },
      success: function (response) {
        success(response);
      },
      error: function (error) {
        atlasweb.showAlertErrorMessages(error);
        if (errorC) {
          errorC(error);
        }
      },
      complete: function () {
        complete ? complete() : null;
      },
    });
  }

  /**********************************************************/
  // Send ajax form requests
  /**********************************************************/
  $(document.body).on("submit", "form[data-ajax]", function (e) {
    if ($(this).valid()) {
      e.preventDefault();
      atlasweb.sendFormRequest(this);
    }
  });

  /**********************************************************/
  // Do logout
  /**********************************************************/
  $(".btn-logout").on("click", function (e) {
    e.preventDefault();
    $("#frm_logout").submit();
  });

  /**********************************************************/
  /* Delete item
     /***********************************************************/

  $(document.body).on("submit", "form[data-ajax-delete]", function (e) {
    e.preventDefault();
    var form = this;
    //atlasweb.sendFormRequest(form);
    swal({
      title: "آیا مطمئن هستید؟",
      text: "اطلاعات حذف شده به هیچ عنوان قابل بازیابی نخواهد بود.",
      icon: "warning",
      buttons: {
        cancel: "انصراف",
        confirm: "بله",
      },
      dangerMode: true,
    }).then(function (value) {
      if (value === true) {
        atlasweb.sendFormRequest(form);
      }
    });
  });

  $(document.body).on("click", ".btn-delete", function (e) {
    e.preventDefault();
    var deleteForm = $("#frm_delete");
    deleteForm.attr("action", $(this).data("url"));
    deleteForm.data("block", $(this).data("block"));
    deleteForm.submit();
  });

  /**********************************************************/
  /* Select auto fill
     /***********************************************************/
  $(document.body).on("change", ".select-auto-fill", function () {
    var parent = $(this),
      url = parent.data("url") + "/" + parent.val(),
      child = $(parent.data("child")),
      defaultOption = child.data("default"),
      loading = child.data("loading");
    if (parent.val() === "" || parent.val() === undefined) {
      child.html("<option value=''>" + defaultOption + "</option>");
      child.trigger("change");
      // $('select[data-nice-select]').niceSelect('update');
      return false;
    }
    child.html('<option value="">' + loading + "</option>");
    //  $('select[data-nice-select]').niceSelect('update');
    $.getJSON(url, function (response) {
      var options = "<option value=''>" + defaultOption + "</option>";
      $.each(response, function (index, object) {
        if (object.latitude && object.longitude) {
          var zoom = object.zoom ? object.zoom : 11;
          options +=
            "<option value='" +
            object.value +
            "' " +
            "data-latitude='" +
            object.latitude +
            "' " +
            "data-longitude='" +
            object.longitude +
            "'" +
            " data-zoom='" +
            zoom +
            "'>" +
            object.title +
            "</option>";
        } else {
          options +=
            "<option value='" +
            object.value +
            "'>" +
            object.title +
            "</option>";
        }
      });
      child.html(options);
    })
      .fail(function (error) {
        alert("An error occurred with code " + error.status);
      })
      .always(function () {
        child.trigger("change");
        // $('select[data-nice-select]').niceSelect('update');
      });
  });

  /**********************************************************/
  /* Format the currency input value
     /***********************************************************/
  atlasweb.priceFormat($("input.currency"));

  $(document.body).on("input", "input.currency", function (event) {
    atlasweb.priceFormat($(this), event);
  });

  /**:::::::::::::::**| Type end event |**:::::::::::::::**/
  var typeEndTimer,
    typeEndDelay = 500;

  $(document.body).on("keyup", "input", function () {
    var input = $(this);
    clearTimeout(typeEndTimer);
    typeEndTimer = setTimeout(function () {
      input.trigger("typeend");
    }, typeEndDelay);
  });

  $(document.body).on("keydown", "input", function () {
    clearTimeout(typeEndTimer);
  });
});
