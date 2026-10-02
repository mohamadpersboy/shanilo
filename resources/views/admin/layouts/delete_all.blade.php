

<script>

  dataForDelete = {};
  /**
   * Get id delete all
   *
   * @author Reza Sarlak
   */
  $(document).on('change', '.delete-select', function () {

    var checkElement = $(this);
    var elementSelect = $('.delete-select:checked');
    data = {};
    for (i = 0; elementSelect.length > i; i++) {
      data[i] = elementSelect.eq(i).val();
    }
    dataForDelete['ids'] = data;
  });

  /**
   * Delete all  button
   *
   * @author Reza Sarlak
   */
  $(document).on('click', '.delete_from_list', function (e) {
    e.preventDefault();

    deleteElement($(this).attr('data-url'), dataForDelete);
  });

  /**
   * Delete all data
   *
   * @author Reza Sarlak
   * @param url
   * @param data
   */
  function deleteElement (url, data) {

    if ('ids' in data) {
      data['_token'] = "{{ csrf_token() }}";
      swal({
        title: 'آیا مطمئن هستید؟',
        text: 'اطلاعات حذف شده به هیچ عنوان قابل بازیابی نخواهد بود.',
        icon: 'warning',
        buttons: {
          cancel: 'انصراف',
          confirm: 'بله'
        },
        dangerMode: true
      })
        .then(function (value) {
          if (value === true) {
            $.ajax({
              url: url,
              type: 'DELETE',
              data: data,
              success: function (response) {
                if (parseInt(response.status) == 200) {
                  var timeOut = 2000;
                  show_notif('', 'حذف با موفقیت انجام شد ', 's', timeOut);
                  setTimeout(function () {
                    window.location.reload();
                  }, timeOut);
                }
              }
            });
          }
        });
    } else {
      swal({
        title: 'موردی برای حذف انتخاب نشده ',
        text: 'لطفا ابتدا مورد یا مواردی را که قصد حذف کردن دارید انتخاب نمایید ',
        type: 'info',
        showCancelButton: true,
        closeOnConfirm: false,
        confirmButtonColor: '#2196F3',
        showLoaderOnConfirm: true,
        buttons: {
          confirm: 'باشه'
        },
      });
    }

  }

  /**
   * Check and uncheck checkbox
   *
   * @author Reza Sarlak
   */
  $(document).on('change', '.check-all', function () {
    var checkBoxData = $('.delete-select');
    $(this).prop('checked') ? checkBoxData.prop('checked', true) : checkBoxData.prop('checked', false);
  });
</script>
