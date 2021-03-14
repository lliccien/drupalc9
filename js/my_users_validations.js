(function ($) {
  'use strict';
  $(document).ready(function () {
    console.log('register-user-form');

    $('#edit-my-name').focus();

    $("#register-users-form").validate({
      rules: {
        my_name : {
          required: true,
          pattern: /^[A-Z]*$/
        }
      },
      messages : {
        my_name: {
          required: "The name is required",
        }
      }
    });
    $.validator.addMethod(
      "pattern",
      function (value, element, regexp) {
        const re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
      },
      "The name must be in uppercaset."
    );
    $("#edit-my-name").on("change paste keyup", function () {
      if ($("#register-users-form").valid()) {
        $('#edit-submit').attr('disabled', false);
        $('#edit-submit').removeClass('is-disabled');
      } else {
        $('#edit-submit').attr('disabled', true);
        $('#edit-submit').addClass('is-disabled');
      }
    });

    // $.fn.resetForm = function (sleep) {
    //   console.log('timeOut');
    //   setTimeout(function () {
    //     document.querySelector('#register-users-form').reset();
    //   },sleep);
    // };

  });

})(jQuery);
