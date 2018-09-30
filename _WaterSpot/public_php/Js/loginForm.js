
var regex=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
var messages = ["#passwordResetFail","#incorrect", "#alreadySignedUp", "#invalidPassword", "#invalidEmail", "#signedUp", "#noCaptcha"]
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
  $.each(messages,function(key,value) {
    $(value).hide();
  })
  if (!$("#username, #password").val()){
    showFade("#nothing");
  }else if (!regex.test($("#username").val())){

    showFade("#invalidEmail");

  } else if ($("#password").val().length<8) {
    showFade("#invalidPassword");

  } else if(response.length == 0) {
      showFade("#noCaptcha");

  } else {
    if ($("#login input[type=hidden]").length>0) {
      $("#login input[type=hidden]").val($(this).val());
    } else {
      $('<input />').attr('type', 'hidden')
          .attr('name', $(this).attr('name'))
          .attr('value', $(this).attr('value'))
          .appendTo(form);
    }
    $.each(messages,function(key,value) {
      $(value).hide();
    })

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
            resetForm();
          } else if (results.success==3) {
            showFade("#signedUp",resetForm);
          } else if (results.success==5) {
            showFade("#passwordResetFail",resetForm);
          } else if (results.success==4) {
            showFade("#passwordReset",resetForm);
          } else {
            $("#incorrect").show();
            resetForm();
          }
      }
    });
  }
});

function showFade (element,callback="") {
  $(element).show(function(){
    setTimeout(function(){
      $(element).fadeOut("slow");
    },5000);
    if (callback!==""){
      callback();
    }
  });
}
function resetForm () {
  document.getElementById("login").reset();
  grecaptcha.reset(captcha1);
}
