const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");
// backBtn = document.querySelector("header .back-icon")

form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != "" || document.getElementById("file").value != ""){
        sendBtn.classList.add("active");
        if(inputField.value != ""){
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "php/typeset.php", true);
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        console.log("set done");
                    }
                }
            }
            let formData = new FormData(form);
            xhr.send(formData);
        }
    }else{
        sendBtn.classList.remove("active");
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/typedestroy.php", true);
        xhr.onload = () => {
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    console.log("destruction done");
                }
            }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    }
}

// backBtn.onclick = ()=>{
//     let xhr = new XMLHttpRequest();
//     xhr.open("POST", "php/typedestroy.php", true);
//     xhr.onload = () => {
//         if(xhr.readyState === XMLHttpRequest.DONE){
//             if(xhr.status === 200){
//                 console.log("destruction done");
//             }
//         }
//     }
//     let formData = new FormData(form);
//     xhr.send(formData);
// }

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              sendBtn.classList.remove("active");
              scrollToBottom();
              let xhr1 = new XMLHttpRequest();
              xhr1.open("POST", "php/typedestroy.php", true);
              xhr1.onload = () => {
                  if(xhr1.readyState === XMLHttpRequest.DONE){
                      if(xhr1.status === 200){
                          console.log("destruction done");
                      }
                  }
              }
              let formData = new FormData(form);
              xhr1.send(formData);
              
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chatgrp.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id);
}, 500);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  
