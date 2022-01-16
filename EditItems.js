


let phone = document.getElementById("phone");
let phone_set = document.getElementById("phone_set");
let phone_input = document.getElementById("phone_input");
let sub_phone = document.getElementById("sub_phone");

let family = document.getElementById("family");
let family_set = document.getElementById("family_set");
let family_input = document.getElementById("family_input");
let sub_family = document.getElementById("sub_family");

let name = document.getElementById("name");
let name_set = document.getElementById("name_set");
let name_input = document.getElementById("name_input");
let sub_name = document.getElementById("sub_name");

function noneText (name,set,input,sub){
    name.addEventListener("click" , function (){
        set.style.display = "none";
        input.style.display="block";
        input.focus();
        sub.style.display = "block";
    })
}
noneText(phone , phone_set , phone_input , sub_phone);
noneText(family , family_set , family_input , sub_family);
noneText(name , name_set , name_input , sub_name);


