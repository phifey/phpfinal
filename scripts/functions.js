function registerAjaxCall(id, name) {
  $("#loading").show();
  $("#" + id + "-form").submit(function(e) {
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url,
      data: form.serialize(),
      success: function(data) {
        $("#loading").hide();
        if(data.success) {
          if(data.registered) {
            $(".response").html(`Thank you ${name}, you've been registered successfully! <span class="main-font font-sm">To login go to <a href="javascript:void(0);" onClick="formModalSwitch('${splitId}','type-it-login','${url}')">here</a>`);
            $(".response").removeClass("error");
            $(".response").addClass("success");
            $("#" + id + "-button").hide();
            if(data.mailed) {
              $(".response").append(`, An (one-time) verification email has been sent to ${data.mailed}, please confirm it. If you do not confirm it, you will not be able to recover your account in the future`);
            }
          }
        } else {
          $(".response").html(`There has been a mistake ${name}, please fix it to register: <br />
               ${data.error}
               `);
          $(".response").removeClass("success");
          $(".response").addClass("error");
        }
      },
     error: function(XMLHttpRequest, textStatus, errorThrown) {
          alert("Status: " + textStatus);
            alert("Error: " + errorThrown);
      },
    });
    e.preventDefault();
    e.unbind();
  });
  $("#" + id + "-form").submit();
}

function update_url(url) {
    history.pushState(null, null, url);
}

function ego() {
  var loc = location;
  location.href = loc + "portfolio";
}

function sendMail(id) {
  $("#loading").show();
  $("#" + id + "-form").submit(function(e) {
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url,
      data: form.serialize(),
      success: function(data) {
        $("#loading").hide();
        if(data.success) {
          if(data.mailed) {
            $(".response").html(`Thank you, your email has been received. I'll get back to you asap`);
            $(".response").removeClass("error");
            $(".response").addClass("success");
            $("#" + id + "-button").hide();
          }
        } else {
          $(".response").html(`Email wasn't sent, please fix your error: <br />
            ${data.error}
            `);
          $(".response").removeClass("success");
          $(".response").addClass("error");
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert("Status: " + textStatus);
        alert("Error: " + errorThrown);
      },
    });
    e.preventDefault();
    e.unbind();
  });
  $("#" + id + "-form").submit();
}

function requestPasswordAjaxCall(id) {
  $("#loading").show();
  $("#" + id + "-form").submit(function(e) {
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url,
      data: form.serialize(),
      success: function(data) {
        $("#loading").hide();
        if (data.success) {
          if (data.mailed) {
            $(".response").removeClass("error");
            $(".response").addClass("success");
            $(".response").html(`An email has been sent to ${data.mailed}, to reset your password check the email`);
            $("#" + id + "-button").hide();
          }
        } else {
          $(".response").html(`There has been a mistake, please fix it to request your password: <br />
                ${data.error}
                `);
          $(".response").removeClass("success");
          $(".response").addClass("error");
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert("Status: " + textStatus);
        alert("Error: " + errorThrown);
      },
    });
    e.preventDefault();
    e.unbind();
  });
  $("#" + id + "-form").submit();
}

function logoutAjaxCall(url) {
  var directory = directoryLocation(url);
  $.ajax({
    url: `${directory}fetch.php?logout=true`,
    success: function(data) {
      alert("You've been logged out!");
      setTimeout(function() {
        location.href = `${directory}`
      }, 500);
    }
  });
}

function openShop(url,val)
{
  var directory = directoryLocation(url);
  if(url != "https://nate.gg/lookbook/all")
    location.href = `${directory}lookbook/all`;
}

function loginAjaxCall(id, name) {
  $("#loading").show();
  $("#" + id + "-form").submit(function(e) {
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: url,
      data: form.serialize(),
      success: function(data) {
        $("#loading").hide();
        if(data.success) {
          if(data.enter2FA)
          {
			$("#2fa").show();
            $("#2fa").prop('type','text');
            $("#2fa").focus();
            $(".response").html(`There has been a mistake ${name}, please fix it to register: <br />
                  ${data.success}
            `);
            $(".response").removeClass("success");
            $(".response").addClass("error");
          } else if(data.loggedIn) {
			$("#2fa").hide();
            $(".response").html(`Thank you ${name}, you've been logged in successfully! You will now be redirected`);
            $(".response").removeClass("error");
            $(".response").addClass("success");
            $("#" + id + "-back").hide();
            $("#" + id + "-button").hide();
            setTimeout(function() {
              location.reload();
            }, 3000)
          }
        } else {
		  $("#2fa").hide();
          $(".response").html(`There has been a mistake ${name}, please fix it to register: <br />
                ${data.error}
                `);
          $(".response").removeClass("success");
          $(".response").addClass("error");
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert("Status: " + textStatus);
        alert("Error: " + errorThrown);
      },
    });
    e.preventDefault();
    e.unbind();
  });
  $("#" + id + "-form").submit();
}

function sql() {
  $("#sql-form").submit(function(e) {
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
      type: 'POST',
      dataType: 'text',
      url: url,
      data: form.serialize(),
      success: function(data) {
        $(".response").html(data);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert("Status: " + textStatus);
        alert("Error: " + errorThrown);
      },
    });
    e.preventDefault();
    e.unbind();
  });
  $("#sql-form").submit();
}

function validateLogin(id) {
  var username = $("#username").val();
  var password = $("#password").val();
  var error = [];

  if (username == "") {
    error[0] = "Username field cannot be empty";
    $(".username-error").html(error[0]);
  } else {
    $(".username-error").html("");
  }

  if (password == "") {
    error[1] = "Password field cannot be empty";
    $(".password-error").html(error[1]);
  } else {
    $(".password-error").html("");
  }

  if (error == "") {
    loginAjaxCall(id, name);
  }
}

function validateRegister(id) {
  var name = $("#fullname").val();
  var phone = $("#phone").val();
  var email = $("#email").val();
  var password = $("#password").val();
  var username = $("#username").val();
  var error = [];

  if (name == "") {
    error[0] = "Name field cannot be empty";
    $(".name-error").html(error[0]);
  } else
    $(".name-error").html("");

  if (email == "") {
    error[1] = "Email field cannot be empty";
    $(".email-error").html(error[1]);
  } else {
    $(".email-error").html("");
  }

  if (password == "") {
    error[2] = "Password field cannot be empty";
    $(".password-error").html(error[2]);
  } else if (password.length < 6) {
    error[2] = "Password must be at least 6 characters";
    $(".password-error").html(error[2]);
  } else {
    $(".password-error").html("");
  }

  if (username == "") {
    error[3] = "Username field cannot be empty";
    $(".username-error").html(error[3]);
  } else if (username.length < 3) {
    error[3] = "Username must be at least 3 characters";
    $(".username-error").html(error[3]);
  } else {
    $(".username-error").html("");
  }

  if (error == "") {
    registerAjaxCall(id, name);
  }
}

function modalClose(id) {
  $("#" + id).modal("hide");
  $("body").css({
    'overflow': 'visible'
  })
}

function formModalSwitch(id, desiredId, loc) {
  $("#" + id).modal("hide");
  $("body").css({
    'overflow': 'visible'
  })

  makeModal(desiredId, typeIt, loc);
  splitId = desiredId.slice(8);
  $("#" + splitId).modal({
    backdrop: 'static',
    keyboard: false,
    show: true
  });
}

function directoryLocation(url)
{
  stringUrl = `"${url}"`;
  dirAboveCount = stringUrl.split("/").length - 2;
  if(dirAboveCount > 2)
  {
    newDir = dirAboveCount - 2;
    directory = '';
    for(i=0; i<newDir; i++)
    {
      directory += "../";
    }
  }
  else
  {
    directory = '';
  }
  return directory;
}


function makeModal(id, ids, url) {
  directory = '';
  if(url != "https://nate.gg/"){
    directory = directoryLocation(url);
  }
  splitId = id.slice(8);
  const index = ids.indexOf(id);
  if (index != -1) {
    let modalTemplate = `
<div class="${splitId} modal fade" id="${splitId}" tabindex="-1" role="dialog" aria-labelledby="${splitId}" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered ${id == "type-it-login" ? "modal-sm" : id == "type-it-request" ? "modal-sm" : "modal-lg"}" role="document">
  <div style="border:none" class="modal-content">
    <div style="border:none" class="flex-container">
      <img style="max-height: 85px;" src="${directory}images/natewords.png" alt="nate.gg"/>
    </div>
    <form id="${splitId}-form" action="${directory}fetch.php" method="post">
    <div class="py-0 px-2 modal-body">
      ${id == "type-it-register" ? `
      <div class="px-4 wrap">
        <div class="row">
          <div class="col-12">
            <h5 class="main-font">Create an account <span class="main-font font-sm">Already have an account? <a href="javascript:void(0);" onClick="formModalSwitch('${splitId}','type-it-login','${url}')">Login here</a></span></h5>
            <p class="main-font font-sm">Credentials</p>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <input type="hidden" name="register" value="yes"/>
            <input class="my-2 py-1" id="fullname" type="text" name="fullname" placeholder="Full Name"/>
            <p class="font-sm error name-error" val=""></p>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <input class="my-2 py-1" id="email" type="email" name="email" placeholder="Email"/>
            <p class="font-sm error email-error" val=""></p>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <input class="my-2 py-1" id="phone" type="phone" name="phone" placeholder="Phone"/>
            <p class="font-sm error phone-error" val=""></p>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <input class="my-2 py-1" id="password" type="password" name="password" placeholder="Password (6-50)"/>
            <p class="font-sm error password-error" val=""></p>
          </div>
        </div>
        <div class="mt-5 row">
          <div class="col-12">
            <p class="main-font font-sm">How you will be recognized</p>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <input class="my-2 py-1" id="username" type="text" name="username" placeholder="Username"/>
            <p class="font-sm error username-error" val=""></p>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <p class="font-sm response" val=""></p>
          </div>
        </div>
        <div class="row">
          <div class="col-12 flex-container">
            <img id="loading" src="${directory}images/ajax-loader.gif"/>
          </div>
        </div>
        <div style="border:none" class="flex-container p-2">
          <button type="button" onClick="validateRegister('${splitId}')" id="${splitId}-button" class="${splitId}-submit btn btn-dark btn-sm">Submit</button>
        </div>
        <div class="mb-1">
          <a id="${splitId}-back" href="javascript:void(0);" onClick="modalClose('${splitId}')"><span style="cursor:pointer;color:black">&larr;Back</span></i></a>
        </div>
      </div>
      `
         : id == "type-it-login" ? `
      <div class="px-4 wrap">
        <div class="row">
          <div class="col-12">
            <h5 class="main-font">Login below</h5>
            <p class="main-font font-sm">Don't have an account? <a href="javascript:void(0);" onClick="formModalSwitch('${splitId}','type-it-register','${url}')">Register here</a></p>
            </div>
        </div>
        <div class="row">
          <div class="col-12">
            <input type="hidden" name="login" value="yes"/>
            <input class="my-2 py-1" id="username" type="text" name="username" placeholder="Username"/>
            <p class="font-sm error username-error" val=""></p>
          </div>
        </div>
		<div class="row">
          <div class="col-12">
            <input class="my-2 py-1" id="password" type="text" name="password" placeholder="Password"/>
			<p class="font-sm error password-error" val=""></p>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <input class="my-2 py-1" id="2fa" type="hidden" name="2fa" placeholder="2FA (6-digit code)"/>
          </div>
        </div>
        <div class="row">
          <div class="col-12 flex-container">
            <img id="loading" src="${directory}images/ajax-loader.gif"/>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <p class="font-sm response" val=""></p>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <p class="main-font font-sm">Forgot password? <a href="javascript:void(0);" onClick="formModalSwitch('${splitId}', 'type-it-request', '${url}')">Request password here</a></p>
            </div>
        </div>
        <div style="border:none" class="flex-container p-2">
          <button type="button" onClick="validateLogin('${splitId}')" id="${splitId}-button" class="${splitId}-submit btn btn-dark btn-sm">Submit</button>
        </div>
        <div class="mb-1">
          <a id="${splitId}-back" href="javascript:void(0);" onClick="modalClose('${splitId}')"><span style="cursor:pointer;color:black">&larr;Back</span></a>
        </div>
      </div>
         `
         : id == "type-it-request" ? `
         <div class="px-4 wrap">
           <div class="row">
             <div class="col-12">
               <h5 class="main-font">Request password below</h5>
               <p class="main-font font-sm">I will only provide password assistance to accounts that are email verified</p>
               </div>
           </div>
           <div class="row">
             <div class="col-12">
               <input type="hidden" name="requestpassword" value="yes"/>
               <input class="my-2 py-1" id="email" type="email" name="email" placeholder="Email"/>
               <p class="font-sm error email-error" val=""></p>
             </div>
           </div>
           <div class="row">
             <div class="col-12">
               <p class="font-sm response" val=""></p>
             </div>
           </div>
           <div class="row">
              <div class="col-12">
                <p class="main-font font-sm">Don't have an account? <a href="javascript:void(0);" onClick="formModalSwitch('${splitId}','type-it-register', '${url}')">Register here</a></p>
              </div>
           </div>
           <div class="row">
             <div class="col-12 flex-container">
               <img id="loading" src="${directory}images/ajax-loader.gif"/>
             </div>
           </div>
           <div style="border:none" class="flex-container p-2">
             <button type="button" onClick="requestPasswordAjaxCall('${splitId}')" id="${splitId}-button" class="${splitId}-submit btn btn-dark btn-sm">Submit</button>
           </div>
           <div class="mb-1">
             <a id="${splitId}-back" href="javascript:void(0);" onClick="modalClose('${splitId}')"><span style="cursor:pointer;color:black">&larr;Back</span></a>
           </div>
         </div>
         `
         :  `
         <div class="px-4 wrap">
           <div class="row">
             <div class="col-12">
               <h5 class="main-font">Contact us</h5>
               </div>
           </div>
           <div class="row">
             <div class="col-12">
               <input type="hidden" name="contact" value="yes"/>
               <input class="my-2 py-1" id="email" type="email" name="email" placeholder="Email"/>
               <p class="font-sm error username-error" val=""></p>
             </div>
           </div>
           <div class="row">
             <div class="col-12">
               <textarea rows="4" placeholder="Reason for contacting..." name="comment" form="${splitId}-form"></textarea>
               <p class="font-sm error comment-error" val=""></p>
               </div>
           </div>
           <div class="row">
             <div class="col-12">
               <p class="font-sm response" val=""></p>
             </div>
           </div>
           <div class="row">
             <div class="col-12 flex-container">
               <img id="loading" src="${directory}images/ajax-loader.gif"/>
             </div>
           </div>
           <div style="border:none" class="flex-container p-2">
             <button type="button" onClick="sendMail('${splitId}')" id="${splitId}-button" class="${splitId}-submit btn btn-dark btn-sm">Submit</button>
           </div>
           <div class="mb-1">
             <a id="${splitId}-back" href="javascript:void(0);" onClick="modalClose('${splitId}')"><span style="cursor:pointer;color:black">&larr;Back</span></a>
           </div>
         </div>
         `
       }
    </form>
  </div>
</div>
</div>
    `;
    document.getElementById("modals").innerHTML = modalTemplate;
  }
}
