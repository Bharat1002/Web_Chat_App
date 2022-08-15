
      setInterval(() => {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "php/set_readstate.php", true);
        xhr.onload = ()=> {
            if(xhr.status === 200){
                let data = xhr.response;
              }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("incoming_id="+incoming_id);
    }, 500);