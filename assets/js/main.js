$(document).ready(function () {
  $(".ui.dropdown").dropdown();
  $("#message-when-reservd").hide();

  /** Register form handler */

  const $REGISTER_FORM = $("#registerForm");

  $REGISTER_FORM.form({
    fields: {
      name: {
        identifier: "name",
        rules: [
          {
            type: "empty",
            prompt: "Veuillez renseigner votre nom",
          },
        ],
      },
      role: {
        identifier: "role",
        rules: [
          {
            type: "minCount[1]",
            prompt:
              "Veuillez nous dire quel type de compte vous souhaitez créer",
          },
        ],
      },
      username: {
        identifier: "username",
        rules: [
          {
            type: "empty",
            prompt: "Veuillez saisir un nom d'utilisateur",
          },
        ],
      },
      email: {
        identifier: "email",
        rules: [
          {
            type: "email",
            prompt: "Veuillez saisir un email valide",
          },
        ],
      },
      password: {
        identifier: "password",
        rules: [
          {
            type: "empty",
            prompt: "Please enter a password",
          },
          {
            type: "minLength[6]",
            prompt: "Votre mot de passe doit faire {ruleValue} characteres",
          },
        ],
      },
    },
  });

  $("#submitRegister").click(function (e) {
    // e.preventDefault();
    // Here we are checking is the form is not valid
    if (!$REGISTER_FORM.form("is valid")) {
      return;
    }

    /**
     * Here the form is valid so we don't submit because we will call the
     * register api with an ajax call
     */

    e.preventDefault();

    allFields = $REGISTER_FORM.form("get values");
    $.ajax({
      type: "POST",
      url: "/api/register",
      data: allFields,
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.success) {
          const { data } = response;
          $(location).attr("href", `/members/${data.username}`);
        } else {
          $REGISTER_FORM.form("add errors", [response.message]);
        }
      },
    });
  });

  /** LOGIN FORM HANDLER */

  const $LOGIN_FORM = $("#loginForm");

  $LOGIN_FORM.form({
    fields: {
      username: {
        identifier: "username",
        rules: [
          {
            type: "empty",
            prompt: "Veuillez saisir un nom d'utilisateur",
          },
        ],
      },
      password: {
        identifier: "password",
        rules: [
          {
            type: "empty",
            prompt: "Veuillez renseigner un mot de passe",
          },
          {
            type: "minLength[6]",
            prompt: "Votre mot de passe doit faire 6 caractères ou plus ",
          },
        ],
      },
    },
  });

  $("#submitLogin").click(function (e) {
    // e.preventDefault();
    // Here we are checking is the form is not valid
    if (!$LOGIN_FORM.form("is valid")) {
      return;
    }

    /**
     * Here the form is valid so we don't submit because we will call the
     * login api with an ajax call
     */

    e.preventDefault();
    const allFields = $LOGIN_FORM.form("get values");

    $.ajax({
      type: "POST",
      url: "/api/login",
      data: allFields,
      dataType: "json",
      success: function (response) {
        console.log(response);

        if (response.success) {
          const { data } = response;
          $(location).attr("href", `/members/${data.username}`);
        } else {
          $LOGIN_FORM.form("add errors", [response.message]);
        }
      },
    });
  });

  /** RESERVATION FORM HANDLER */
  const $RESERVATION_FORM = $("#reservationForm");

  const today = new Date();

  $("#example1").calendar({
    ampm: false,
    minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
    maxDate: new Date(
      today.getFullYear() + 1,
      today.getMonth(),
      today.getDate(),
    ),
    formatter: {
      date: function (date, settings) {
        if (!date) return "";
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        return year + "-" + month + "-" + day;
      },
    },
  });

  $("#bookMe").click(function (e) {
    e.preventDefault();
    const allFields = $RESERVATION_FORM.form("get values");

    // let date = new Date(allFields["date"]);
    // date = date.toISOString().slice(0, 19).replace("T", " ");

    // allFields["date"] = date;

    $.ajax({
      type: "POST",
      url: "/api/booking",
      data: allFields,
      dataType: "json",
      success: function (response) {
        console.log(response);

        if (response.success) {
          $("#reservationForm").hide();
          $("#message-when-reservd").show();
        } else {
        }
      },
    });
  });
});
