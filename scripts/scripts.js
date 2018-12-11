let typeIt = [];
typeIt.push("type-it-request");

//------Preloader Handler------//
$(window).on('load', function() {
  $('.preloader').delay(800).animate({
    opacity: 'hide',
    left: '3000px',
  }, 1000, function() {
    $('body').css({
      'overflow': 'visible',
      'position': 'static'
    })
  });
});
//------End Preloader Handler------//

$(document).ready(function() {
  //------TypeIt Elements------//
  new TypeIt('.header-text', {
    strings: ["Web Development Student", "Please contact me for more information"],
    speed: 100,
    loop: true,
    breakLines: false,
    autoStart: false
  });

  $('.search-input').keyup(function(){
    var loc = location;
    openShop(loc);
  });

  $('.search-input-main').keyup(function(){
    $("#cardArea").html("");
    var loc = location;
    var backtrack = directoryLocation(loc);
    var input = $(".search-input-main").val();
    var expression = new RegExp(input, "i");
    if(input != "")
    {
      $.ajax({
        url: `${backtrack}search.php?query=${input}`,
        type: 'post',
        data: input,
        dataType: "text",
        success: function(data)
        {
          $("#cardArea").html(data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert("Status: " + textStatus);
          alert("Error: " + errorThrown);
        }
      })
    }
  });

  $("#shop-show-all").click(function(){
    $("#cardArea").html("");
    var loc = location;
    var backtrack = directoryLocation(loc);
    $.ajax({
      url: `${backtrack}search.php?show=all`,
      type: 'post',
      dataType: "text",
      success: function(data)
      {
        $("#cardArea").html(data);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert("Status: " + textStatus);
        alert("Error: " + errorThrown);
      }
    })
  });

  $("#shop-sort-by-price").click(function(){
    $("#cardArea").html("");
    var loc = location;
    var backtrack = directoryLocation(loc);
    $.ajax({
      url: `${backtrack}search.php?price=desc`,
      type: 'post',
      dataType: "text",
      success: function(data)
      {
        $("#cardArea").html(data);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert("Status: " + textStatus);
        alert("Error: " + errorThrown);
      }
    })
  });

  $('.logout').click(function(){
    var loc = location;
    logoutAjaxCall(loc);
  })

  $('.list-item').each(function() {
    $id = $(this).attr('id');
    typeIt.push($id);
  })

  typeIt.forEach(function(ele) {
    typeItElements = new TypeIt('.' + ele);
    splitEle = ele.slice(8);
    typeItElements.type(splitEle);
  });

  $('.list-item').click(function() {
    var loc = location;
    id = $(this).attr('id');
    splitId = id.slice(8);
    $('.' + id).html("");
    newEle = new TypeIt('.' + id);
    newEle.type("Loading... ").pause(750).delete().pause(750).type(splitId);
    if (newEle.hasStarted) {
      if (id == "type-it-home")
        setTimeout(function() {
          directory = '';
          if(loc != "https://nate.gg/"){
            directory = directoryLocation(loc);
            window.location.href = `${directory}`;
          }
          else {
            location.reload();
          }
        }, 3000);
      else {
        makeModal(id, typeIt, loc);
        setTimeout(
          function() {
            $(".navbar-hidden").hide();
            $("." + splitId).modal({
              backdrop: 'static',
              keyboard: false,
              show: true,
              focus: true
            });
            $("body").css({
              'overflow': 'visible'
            })
          }, 3000);
      }
    }
  });
  //------End TypeIt Elements------//


  //------Navbar Handling------//
  $('.menu-click').click(function() {
    $('.navbar-hidden').css({
      'display': 'flex'
    });
    $('.navbar-hidden').show(500, function() {
      $('.navbar-hidden ul li').show(500);
    });
  });

  $('.search-click').click(function() {
    $('.search-hidden').css({
      'display': 'flex'
    });
    $('.search-hidden div').show(500, function() {
      $('.search-hidden input').show(500);
    });
  });

  $('.search-close').click(function() {
    $('.search-hidden').css({
      'display': 'none'
    })
    $('.search-hidden div').hide(500, function() {
      $('.search-hidden input').hide(500);
    });
  });

  $('.navbar-close').click(function() {
    $('.navbar-hidden').css({
      'display': 'none'
    })
    $('.navbar-hidden').hide(500, function() {
      $('.navbar-hidden ul li').hide(500);
    });
  });

  $(window).scroll(function() {
    if ($(window).scrollTop() > 0) {
      $("nav").addClass("b-outline");
      $("nav").addClass("bg-white");
      $("nav").removeClass("navbar-height");
      $("nav").animate({
        'height':'60px',
        'min-height':'60px'
      },500, function(){
        $("#nav").css('overflow','visible');
      });
    } else {
      $("nav").addClass("navbar-height")
      $("nav").removeClass("b-outline");
      $("nav").removeClass("bg-white");
    }
  });
  //------End Navbar Handling------//

  //------Table Handling------//
  $("#products_table").hide();
  $("#display-table").click(function(){
    $("#products_table").toggle();
  });
  //------End Table Handling------//
  ScrollReveal().reveal('.reveal', {delay: 50});
});
