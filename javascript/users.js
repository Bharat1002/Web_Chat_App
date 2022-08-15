const searchBar = document.querySelector(".search input"),
searchIcon = document.querySelector(".search button"),
usersList = document.querySelector(".users-list"),
grpusersList = document.querySelector(".grpusers-list"),
logoutBtn = document.querySelector(".users header .logout"),
createGroup = document.querySelector(".users header .fa-users"),
userUpdate = document.querySelector(".users header .content .fa-edit");




searchIcon.onclick = ()=>{
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if(searchBar.classList.contains("active")){
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
}

searchBar.onkeyup = ()=>{
  let searchTerm = searchBar.value;
  if(searchTerm != ""){
    searchBar.classList.add("active");
  }else{
    searchBar.classList.remove("active");
  }
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/search.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          usersList.innerHTML = data;
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
}

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/usersgrp.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(!searchBar.classList.contains("active")){
            grpusersList.innerHTML = data;
          }
        }
    }
  }
  xhr.send();
}, 500);

setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(!searchBar.classList.contains("active")){
            usersList.innerHTML = data;
          }
        }
    }
  }
  xhr.send();
}, 500);

// userUpdate.onsubmit  = (e)=>{
//   e.preventDefault();
// }

userUpdate.onclick = ()=>{
  location.href = "update.php";
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

createGroup.onclick = ()=>{
  location.href = "create_group.php";
  let xhr2 = new XMLHttpRequest();
  xhr2.open("POST", "php/typedestroy.php", true);
  xhr2.onload = () => {
      if(xhr2.readyState === XMLHttpRequest.DONE){
          if(xhr2.status === 200){
              console.log("destruction done");
          }
      }
  }
  let formData = new FormData(form);
  xhr2.send(formData);
}

logoutBtn.onclick = ()=>{
  let xhr3 = new XMLHttpRequest();
  xhr3.open("POST", "php/typedestroy.php", true);
  xhr3.onload = () => {
      if(xhr3.readyState === XMLHttpRequest.DONE){
          if(xhr3.status === 200){
              console.log("destruction done");
          }
      }
  }
  let formData = new FormData(form);
  xhr3.send(formData);
}