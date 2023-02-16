const pswrdField = document.querySelector(".form .field input[type='password']");
const toggleBtn = document.querySelector(".form .field i");

const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-txt");

toggleBtn.onclick = ()=>{
    if(pswrdField.type == 'password'){
        pswrdField.type = 'text';
        toggleBtn.classList.add('active');
    }else{
        pswrdField.type = 'password';
        toggleBtn.classList.remove('active');
    }
}

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest;
    xhr.open("POST", "loginValidation.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == "success"){
                    location.href = "chat.php";
                }else{
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}