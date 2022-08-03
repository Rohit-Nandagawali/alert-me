function showPassword() {
    // getting elements by id
    var showPasswordbtn = document.getElementById("showPassword");
    var passwordLabelField = document.getElementById("passwordLabel");


    // cheking if type is password then change it to text

    if (passwordLabelField.type === "password") {

        passwordLabelField.type = "text";
        showPasswordbtn.innerHTML="Hide password"
        
    } else {
        passwordLabelField.type = "password";
        showPasswordbtn.innerHTML="Show password";
    }
  }