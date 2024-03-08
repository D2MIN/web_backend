let pr_name = document.getElementById("name");
let pr_surname = document.getElementById("surname");
let number = document.getElementById("number");
let email = document.getElementById("email");
let date = document.getElementById("date");

let form = document.getElementById('form');

form.addEventListener('submit',function(event){
  event.preventDefault();
  console.log(pr_name.value);
})