const form = document.querySelector(".form form"),
backBtn = document.querySelector(".form .back"),
createBtn = form.querySelector(".button .create");

createBtn.onclick = (e)=>{
  e.preventDefault();
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/create_group.php", true);
  xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if(data == "success"){
                location.href="users.php";
              } else {
                  console.log(data);
              }
          }
      }
  }
  let formData = new FormData(form);
  xhr.send(formData);
}

backBtn.onclick = (e)=>{
  e.preventDefault();
  location.href = "users.php";
}