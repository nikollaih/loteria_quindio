var posibilities = [
  {
    id: 1,
    url: "https://images.unsplash.com/photo-1557800636-894a64c1696f?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxleHBsb3JlLWZlZWR8MXx8fGVufDB8fHw%3D&auto=format&fit=crop&w=500&q=60"
  },
  {
    id: 2,
    url:  "https://images.unsplash.com/photo-1528825871115-3581a5387919?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxleHBsb3JlLWZlZWR8M3x8fGVufDB8fHw%3D&auto=format&fit=crop&w=500&q=60"
  },
  {
    id: 3,
    url:  "https://images.unsplash.com/photo-1579613832125-5d34a13ffe2a?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxleHBsb3JlLWZlZWR8NHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=500&q=60"
  },
  {
    id: 4,
    url: "https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxleHBsb3JlLWZlZWR8NXx8fGVufDB8fHw%3D&auto=format&fit=crop&w=500&q=60"
  },
  {
    id: 5,
    url: "https://images.unsplash.com/photo-1528821128474-27f963b062bf?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxleHBsb3JlLWZlZWR8OXx8fGVufDB8fHw%3D&auto=format&fit=crop&w=500&q=60"
  },
  {
    id: 6,
    url: "https://images.unsplash.com/photo-1589820296156-2454bb8a6ad1?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxleHBsb3JlLWZlZWR8MTJ8fHxlbnwwfHx8&auto=format&fit=crop&w=500&q=60"
  },
  {
    id: 7,
    url: "https://images.unsplash.com/photo-1577730618729-76ab611700b3?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxleHBsb3JlLWZlZWR8MTZ8fHxlbnwwfHx8&auto=format&fit=crop&w=500&q=60"
  },
  {
    id: 8,
    url: "https://images.unsplash.com/photo-1572635148818-ef6fd45eb394?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxleHBsb3JlLWZlZWR8MTl8fHxlbnwwfHx8&auto=format&fit=crop&w=500&q=60"
  },
  {
    id: 9,
    url: "https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxleHBsb3JlLWZlZWR8Mjd8fHxlbnwwfHx8&auto=format&fit=crop&w=500&q=60"
  }
];


var slot = $(".slot");

slot.each(function() {
var uniqueArray = randomizeOrder();
for (var i = 0; i < 9; i++) {

  $(this).append('<img src="' + uniqueArray[i].url + '" class="image-' + uniqueArray[i].id +'"></img>');
}
});

function randomizeOrder() {
var mixedPosibilities = [],
  generatedElement,
  x = 0;
while (x < 1) {
  generatedElement = posibilities[Math.floor(Math.random() * posibilities.length)];
  if ($.inArray(generatedElement, mixedPosibilities) < 0) {
    mixedPosibilities.push(generatedElement);
  }
  if (mixedPosibilities.length == 9) {
    x = 1;
  }
}
return mixedPosibilities;
}


$("#btn-play").click(function() {
  wishMeLuck(1);
  $(".play-container").hide();
});

function recognizePos(tokenId) {
switch (tokenId) {
  case 1:
    var posY = "0";
    return posY;
    break;
  case 2:
    var posY = "-400";
    return posY;
    break;
  case 3:
    var posY = "-800";
    return posY;
    break;
  case 4:
    var posY = -"1200";
    return posY;
    break;
  case 5:
    var posY = "-1600";
    return posY;
    break;
  case 6:
    var posY = "-2000";
    return posY;
    break;
  case 7:
    var posY = "-2400";
    return posY;
    break;
  case 8:
    var posY = "-2800";
    return posY;
    break;
  case 9:
    var posY = "-3200";
    return posY;
    break;
}
}

function wishMeLuck(lopp_i) {
  $("body").removeClass();
  var status = [];
  slot.each(function(index) {
    var newNumber = Math.floor((Math.random() * 9) + 1),
      newPosition = recognizePos(newNumber)  + "px";
    $(this).stop().animate({
      "top": newPosition
    }, {
      duration: 700, 
      easing: 'linear',
      complete: function() {
        if(lopp_i <= 6) {
          wishMeLuck(lopp_i + 1);
        }else{
          newNumber--;
          var getCurrentElem = $(this).children("img:eq(" + newNumber + ")").attr('class').substring(6);
          status.push(getCurrentElem);
          if(index == 2) {
            validateResult(status, getCurrentElem);
          }
        }
      }
    })
  });

}

function validateResult(status, product_id) {
  //status = ["1", "1", "1"];
  status = jQuery.unique(status).length;
  //console.log(numSameElem);
  //react(numSameElem);
  if(status == 1) {
    $.ajax({
      url: "validate_slot_machine_result",
      type:"POST",
      data: {slots: status, product_id},
      beforeSend: function( xhr ) {
        console.log('se enviará');
      }
    })
    .done(function( data ) {
      var result = jQuery.parseJSON(data);
      console.log(result);
    });
  }else{
    //console.log('No gano');
    $(".play-container").show();
    $(".lose").show();
  }
}

function react(a) {
if (a == 1) {
  $("body").addClass("winner");
} else if (a == 2) {
  $("body").addClass("meh");
} else {
  $("body").addClass("nothing");
}
}

$("body").on("click", "#restart", function(){
  $(this).parent().remove();
  $(".container").show();
  return false;
});


function payer_wins(product) {
	var number = btn.getAttribute('number');
	var serie = btn.getAttribute('serie');
	var date = btn.getAttribute('date');
	var d = new Date(date);
	date = d.getDate()  + "/" + (d.getMonth()+1) + "/" + d.getFullYear() + " " ;

	var content = "<div class='buying'><div><label>Numero</label><p class='number-confirm'>" + number + "</p></div><div><label>Serie</label><p class='serie-confirm'>" + serie + "</p></div><div><label>Fecha de sorteo</label><p class='fecha-confirm'>" + date +"</p></div></div>";
	swal({
					title: '¿Deseas hacer esta compra?',
					html: true,
					text: content,
					showCancelButton: true,
					confirmButtonText: 'Si, comprar!',
					closeOnConfirm: false,
					showLoaderOnConfirm: true
			},
			function() {
				window.location.href = 'Main/set_session_draw_number/' + number + '/' + serie;
			});
}


$( document ).ready(function() {
  $("body").removeClass();
});