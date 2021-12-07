var loggedInUser = document.querySelector("#user").innerHTML.split("Logged in as: ")[1]
var reciever = document.querySelector("#reciever").placeholder.split("Send message to ")[1]
console.log(loggedInUser, reciever);
// let msg_container = document.querySelector(".msg-container").children;
// let arr = msg_container[msg_container.length-1].innerHTML.split(" | ")
let latest_loaded_message;
let chatbox = document.getElementById("chatbot");
let maxScrollPosition = chatbox.scrollHeight - chatbox.clientHeight;


$(document).ready(function() {
  getMessages()
  // Get the input field
  var input = document.querySelector("#reciever");

  // Execute a function when the user releases a key on the keyboard
  input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
      sendMsg()
    }
  });
  document.getElementById("btnSend").onclick = function() {sendMsg()}
  // check once in five seconds
  checkmsg = setInterval(function() {
    $.post('./includes/latest.inc.php', {
      do: 'new_messages', 
      uid: loggedInUser, 
      reciever: reciever, 
      latest_loaded_message: latest_loaded_message
    }, function(response) {
      move_msg(response)
    });
  }, 1000); 
});

function move_msg(response) {
  messages = response.split(" : ").slice(1)
  for (let i = 0; i < messages.length; i++) {
    const element = messages[i];
    // console.log(element);
    toArray = element.split(" | ");
    msg = toArray[0]
    from = toArray[1]
    to = toArray[2]
    latest_loaded_message = toArray[3]
    if (from == loggedInUser) {
        var u = document.querySelector("#chat")
        var p = document.createElement("li");
        p.className = "me";
        u.appendChild(p)
        var textnode = document.createTextNode(msg);
        p.appendChild(textnode)
    }
    else if (from == reciever) {
        var u = document.querySelector("#chat")
        var p = document.createElement("li");
        p.className = "him";
        u.appendChild(p)
        var textnode = document.createTextNode(msg);
        p.appendChild(textnode)
    }
  }

  // if at bottom scroll to new message
  if (chatbox.scrollTop >= (maxScrollPosition-1)) {
    chatbox = document.getElementById("chatbot");
    chatbox.scrollTop = chatbox.scrollHeight;
  }
  maxScrollPosition = chatbox.scrollHeight - chatbox.clientHeight;
}

function sendMsg() {
  msg = document.getElementById("reciever").value;
  if (msg!="") {
    $.post('./includes/msg.inc.php', {
      msg: msg, 
      from: loggedInUser, 
      to: reciever
    }, function(response) {});
  }
}

function getMessages() {
  $.post('./includes/view_msg.inc.php', {
    do: "show_messages",
    from: loggedInUser, 
    to: reciever
  }, function(response) {
    // console.log(response);
    move_msg(response);
  });
}
// function ifAtBottom() {
  // var chatbox = document.getElementById("chatbot");
  //   if (chatbox.scrollTop = chatbox.scrollHeight) {
  //       chatbox.scrollTop = chatbox.scrollHeight;
  //   }
// }
// setInterval(ifAtBottom, 500);