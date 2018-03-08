
var regex=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
$("#username").on("keyup change blur paste cut click", function(){
 if (!regex.test($(this).val())){
    $(this).css("border-color","red");
  }else{
    $(this).css("border-color","green");
  }
});
$("#password").on("keyup change blur paste cut click", function(){
 if ($("#password").val().length<8){
    $(this).css("border-color","red");
  }else{
    $(this).css("border-color","green");
  }
});

$('.loginButton').click(function(event){
        /* stop form from submitting normally */
  var form = $("#login");
  var response = grecaptcha.getResponse();
  $("#incorrect #alreadySignedUp #invalidPassword #invalidEmail").hide();
  if (!$("#username, #password").val()){
    $("#nothing").show();
  }else if (!regex.test($("#username").val())){

    $("#invalidEmail").show();

  } else if ($("#password").val().length<8) {
    $("#invalidPassword").show();

  } else if(response.length == 0) {
      $("#noCaptcha").show();

  } else {
    if ($("#login input[type=hidden]").length>0) {
      $("#login input[type=hidden]").val($(this).val());
    } else {
      $('<input />').attr('type', 'hidden')
          .attr('name', $(this).attr('name'))
          .attr('value', $(this).attr('value'))
          .appendTo(form);
    }
    $('#incorrect, #alreadySignedUp, #invalidPassword, #invalidEmail').hide();


    var data=form.serializeArray();

    $.ajax({

      url:"login.php",
      method: "POST",
      data:  data,
      success: function(data) {

          var results = JSON.parse(data);
          console.log(results);
          if (results.success==1) {
            window.location.reload();

          } else if (results.success==2) {

            $("#alreadySignedUp").show();
            document.getElementById("login").reset();
            grecaptcha.reset(captcha1);
          } else if (results.success==3) {

            $("#signedUp").show(function(){
              setTimeout(function(){
                $("#signedUp").fadeOut("slow");
                document.getElementById("login").reset();
                grecaptcha.reset(captcha1);
              },2000);
            });

          } else if (results.success==5) {

            $("#passwordResetFail").show(function(){
              setTimeout(function(){
                $("#PasswordReset").fadeOut("slow");
                document.getElementById("login").reset();
                grecaptcha.reset(captcha1);
              },2000);
            });
          } else if (results.success==4) {

            $("#passwordReset").show(function(){
              setTimeout(function(){
                $("#PasswordReset").fadeOut("slow");
                document.getElementById("login").reset();
                grecaptcha.reset(captcha1);
              },2000);
            });
          } else {

            $("#incorrect").show();
            document.getElementById("login").reset();
            grecaptcha.reset(captcha1);
          }

      }
    });
  }
});
