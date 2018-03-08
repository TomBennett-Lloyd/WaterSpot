$("#website").css("display","none");

var regex=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
$("#email input").on("keyup change blur paste cut click", function(){
   if (!regex.test($(this).val())){
      $(this).css("border-color","red");
    }else{
      $(this).css("border-color","green");
      $("#errorMessages p").text("");
    }
  });

$("#message textarea").on("keyup change blur paste cut click", function() {
  if ($(this).val().length<20) {
    $(this).css("border-color","red");
  }else{
    $(this).css("border-color","green");
    $("#errorMessages p").text("");
  }
});

$('#contactForm').submit(function(event){
        /* stop form from submitting normally */
  event.preventDefault();
  if (!regex.test($("#email input").val())){

    $("#errorMessages").modal('show');
    $("#errorMessages p").text("Sorry, the email adress you entered was not valid. Please try again!");

  } else if ($("#message textarea").val().length<20) {
    $("#errorMessages").modal('show');
    $("#errorMessages p").text("Please enter a message (at least 20 characters long)");

  }else{

    var result=$.ajax({
      url:"processform.php",
      method: "POST",
      data:  $("#contactForm").serializeArray(),
      success: function(data){
          var results = JSON.parse(data);

          $("#errorMessages p").html(results.output);
          $("#errorMessages").modal('show');
          grecaptcha.reset(captcha2);
          if (results.success==1) {
            $("#contactForm").html('');
            setTimeout(function(){location.assign('index.php')},10000);
          }
      }
    });
  }

});
