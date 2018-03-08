
var correct1 = 0;
var correct2 = 0;

if ($("#honeypot").val()=='email') {
  var regex=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  $("#newPassword, #newPassword2").on("keyup change blur paste cut click", function(){
   if (!regex.test($(this).val())){
      $(this).css("border-color","red");
      correct1 = 0;
    }else{
      $(this).css("border-color","green");
      correct1 = 1;
    }
  });

} else {
  $("#newPassword").on("keyup change blur paste cut click", function(){
   if ($("#newPassword").val().length<8){
      $(this).css("border-color","red");
      correct1 = 0;
    }else{
      $(this).css("border-color","green");
      correct1 = 1;
    }
  });

}

$("#newPassword2").on("keyup change blur paste cut click", function(){
 if ($("#newPassword2").val()!=$("#newPassword").val()){
    $(this).css("border-color","red");
    correct2 = 0;
  }else{
    $(this).css("border-color","green");
    correct2 = 1;
  }
});



//$("#passwordReset").submit();

function submitNewPassword ( form, event){

  /* stop form from submitting normally */
  event.preventDefault();

  $("#invalidNewPassword, #PasswordMissmatch").hide();
  
  if (!correct1) {
    $("#invalidPassword2").show();
  } else if (!correct2){
    $("#PasswordMissmatch").show();
  } else {

    var data=form.serializeArray();
    $.ajax({
      url:"updatePassword.php",
      method: "POST",
      data:  data,
      success: function(data) {
        console.log(data);
        var results = JSON.parse(data);
        console.log(results);
        if (results.success==1) {
          $("#passwordResetSuccess").show();
          document.getElementById("passwordReset").reset();
          grecaptcha.reset(captcha2);
          form.hide();

        } else {
          $("#PasswordAlreadyReset").show();
          document.getElementById("passwordReset").reset();
          grecaptcha.reset(captcha2);
          form.hide();
        }
      }
    });
  }
}
