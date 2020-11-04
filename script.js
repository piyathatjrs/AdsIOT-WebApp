
var mysql = require("mysql");
const { exit } = require("process");

var con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "myproject",
});

con.connect(function (err) {
  if (err) throw err;
  //Select only "name" and "address" from "customers":
  con.query("SELECT * FROM sensor", function (err, result, fields) {
    if (err) throw err;
    for (let index = 0; index < result.length; index++) {
      console.log(result[index].value_Realtime);
    }  
    // console.log(result);
    exit();
    //console.log(result.length);

    //console.log(result[0].Code);
  });
});


