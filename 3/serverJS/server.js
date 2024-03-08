const mysql = require('mysql');

const connect = mysql.createConnection({
  host:'localhost',
  user:'u67303',
  database:'u67303',
  password:'8187062',
});

connect.connect(err=>{
  if(err){
    console.log("ERROR FROM CONNECTING TO BD -", err);
  }
  else{
    console.log("CONNECT TO BD");
  }
});

while(true){
  console.log("End");
};