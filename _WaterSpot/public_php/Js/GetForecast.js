
var weekday = new Array(7);
weekday[0] =  "Sun";
weekday[1] = "Mon";
weekday[2] = "Tues";
weekday[3] = "Wed";
weekday[4] = "Thurs";
weekday[5] = "Fri";
weekday[6] = "Sat";



function getForecast(element){
  $("#nothing2").hide();
  $("#forecast").hide();
  if ($(element).parent().parent().hasClass("search")){
    var dataIn = $("#infowindow-content").children("#GMapVals").serializeArray();
    console.log("used default");
  } else {
    $("#infowindow-content").children("#GMapVals").html($(element).parent().children("#GMapVals").html());
    var dataIn = $(element).parent().children(".GMapVals").serializeArray();
    console.log("used location from "+$(element).parent().children("#place-name").text());
  }

  $.ajax({
    url:"search.php",
    method: "POST",
    data:  dataIn,
    success: function(data){
      var data=JSON.parse(data);
      console.log(data);
      var i=0;
      $("#spotName").text(data['SiteRep']['DV']['Location']['name']);
      var weather=data['SiteRep']['DV']['Location']['Period']
      var forecastTime = Number(data['SiteRep']['DV']['dataDate'].split('T')[1].split(':')[0]);
      console.log(forecastTime);
      while (weather[i]) {
        var day = weather[i];
        var thisDate=new Date(day['value'].slice(0,-1));
        var thisDayText= weekday[thisDate.getDay()];
        $("#DayTab"+(i+1)).text(thisDayText);
        var c = 0;
        var thisDay = $("#Day"+(i+1));
        thisDay.html('<div class="varKey"> <div class="weatherVar">Time</div> <div class="weatherVar">Wind Speed (mph)</div> <div class="weatherVar">Wind Gust (mph)</div> <div class="weatherVar">Wind Direction</div> </div> <div class="hours"></div>');
        thisDay=thisDay.children(".hours");
        while (day['Rep'][c]) {
          if (i==0) {
            time=forecastTime+(c-1)*3;
          } else {
            time=c*3;
          }
          var hour = day['Rep'][c];
          forecastHTML='<div class="hour"> <div class="weatherVar time">'+time+':00 </div> <div class="weatherVar">'+hour['S']+'</div> <div class="weatherVar">'+hour['G']+'</div> <div class="weatherVar">'+hour['D']+'</div> </div> ';
          thisDay.html(thisDay.html()+forecastHTML);
          c++;
        }


        i++;
      }
      $("#forecast").show($("#forecast").scrollTop());
      $("#title").hide();
      $("#searchForm").removeClass("justify-content-md-center").addClass( "justify-content-md-between" );



    }
  });

}

$(".search").submit(function(event){
  event.preventDefault();
  getForecast(this);
});

function addFavourites() {
  var dataIn = $("#infowindow-content").children("#GMapVals").serializeArray();
  $.ajax({
    url:"addFavourites.php",
    method: "POST",
    data:  dataIn,
    success: function(data){
      console.log(data);
      $("#errorMessages").modal('show');
      $('#modalMessage').text(data);
      getFavourites();
    }
  });
}

function getFavourites() {
  var place = new Object();
  place.geometry = new Object();
  $.ajax({
    url:"getFavourites.php",
    method: "POST",
    data:  "getFavourites",
    success: function(data){
      try {
        var favourites = JSON.parse(data);
        if (favourites) {
          $('#favourites').html('');
        }

        for (var spotName in favourites) {
          spot=favourites[spotName];
          place.geometry.location = new google.maps.LatLng(spot['lat'], spot['lng']);
          place.name = spotName;
          place.icon = "favouritesIcon.png";
          var hiddenForm = setMarker('Favourite Spot',place);
          var getForecastButton = $('.getForecastButton:first');
          var thisButton = getForecastButton.clone(true).appendTo('#favourites');
          thisButton.children('.getForecast').text(spotName);

          hiddenForm.clone(true).appendTo(thisButton);
        }
      } catch (e) {
        console.log("noFavourites");
      }


    }
  });
}
