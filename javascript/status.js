
status1 = document.querySelector(".chat-details p");

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/status.php", true);
    xhr.onload = ()=> {
        if(xhr.status === 200){
            let data = xhr.response;
            status1.innerHTML = data;
            
          }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id);
}, 500);