//Storing data:
$("#btn-signup").on("click", save_json);

function save_json() {
    signup = {
        username: document.getElementById("username").value,
        email: document.getElementById("email").value,
        first_name: document.getElementById("first_name").value,
        family_name: document.getElementById("family_name").value
    }

    myJSON = JSON.stringify(signup);
    localStorage.setItem("signupJSON", myJSON);
    console.log("data should be saved in json");
};

// fill data from json
fill_data();

function fill_data() {
    var text;
    text = localStorage.getItem("signupJSON");
    signup = JSON.parse(text);
    $("#username").val(signup.username);
    $("#email").val(signup.email);
    $("#first_name").val(signup.first_name);
    $("#family_name").val(signup.family_name);
    console.log("data should be received from json");
};
