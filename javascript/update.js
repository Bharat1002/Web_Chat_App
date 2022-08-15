const form = document.querySelector(".form form"),
backBtn = document.querySelector(".wrapper .form .back"),
updateBtn = form.querySelector(".button .update");


form.onsubmit = (e)=>{
    e.preventDefault();
}

backBtn.onclick = ()=>{
    location.href="users.php";
}

updateBtn.onclick = (e)=>{
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/update.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == "success"){
                  location.href="users.php";
                } else {
                    console.log(data);
                    location.href="users.php";
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}






