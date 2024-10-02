$(document).ready(function () {
  $(document).on("click", ".contact-us-submit", function () {
    var first_name = $.trim($("#first_name").val());
    var last_name = $.trim($("#last_name").val());
    var email = $.trim($("#email").val());
    var phone = $.trim($("#phone").val());
    var msg = $.trim($("#message").val());
    var contactform = "contactform";

    var valid = true;
    if (
      first_name == "" ||
      email == "" ||
      IsEmail(email) == false ||
      phone == "" ||
      last_name == ""
    ) {
      if (first_name == "") {
        valid = false;
        $("#first_name").addClass("validate-form-input-field");
      } else {
        $("#first_name").removeClass("validate-form-input-field");
      }

      if (last_name == "") {
        valid = false;
        $("#last_name").addClass("validate-form-input-field");
      } else {
        $("#last_name").removeClass("validate-form-input-field");
      }

      if (IsEmail(email) == false) {
        valid = false;
        $("#email").addClass("validate-form-input-field");
      } else {
        $("#email").removeClass("validate-form-input-field");
      }

      if (phone == "") {
        valid = false;
        $("#phone").addClass("validate-form-input-field");
      } else {
        $("#phone").removeClass("validate-form-input-field");
      }
    } else {
      $("#phone").removeClass("validate-form-input-field");
      $("#message").removeClass("validate-form-input-field");
      $("#email").removeClass("validate-form-input-field");
      $("#first_name").removeClass("validate-form-input-field");
      $("#last_name").removeClass("validate-form-input-field");
      $("#ajax-loder").show();
      $(".response-message").empty();
      $(".response-message").css("display", "block");
      $.ajax({
        url: "mail.php",
        type: "POST",
        data: {
            first_name: first_name,
            last_name: last_name,
          email: email,
          phone: phone,
          msg: msg,
          action: contactform,
        },
        dataType: "text",
        success: function (data) {
          alert(data);
          if (data == 1) {
            $("#ajax-loder").hide();
            $("#contactUsForm").trigger("reset");
            $(".response-message").prepend(
              "<p class='text-danger'>Thanks for your Enquiry. Will be in touch with you in 24-48 Hours.</p>"
            );
            setTimeout(function () {
              $(".response-message").hide();
            }, 5000);
          } else {
            $(".response-message").prepend(
              "<p class='text-danger'>Mail has been not sent.  Please Try again.</p>"
            );
            $("#ajax-loder").hide();
            $("#contactUsForm").trigger("reset");
            setTimeout(function () {
              $(".response-message").hide();
            }, 5000);
          }
        },
      });
    }
    return valid;
  });
});

function IsEmail(email) {
  var regex =
    /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if (!regex.test(email)) {
    return false;
  } else {
    return true;
  }
}
