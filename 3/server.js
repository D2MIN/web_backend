const http = require('http');
const querystring = require('querystring');
const mysql = require('mysql');
const {validateData,InsertLengs,HTMLAnswer,HTMLTables} = require('./script.js');

const server = http.createServer((req, res) => {
  if (req.method === 'POST' && req.url == "/answer") {
    // Собрать тело запроса из кусков
    const body = [];
    req.on('data', chunk => {
      body.push(chunk);
    });

    req.on('end', () => {
      // Объединить куски в строку и распарсить в объект
      const bodyString = Buffer.concat(body).toString();
      const bodyObject = querystring.parse(bodyString);

      // Получить данные из объекта
      const name = bodyObject.name;
      const number = bodyObject.number;
      const email = bodyObject.email;
      const date = bodyObject.date;
      const gen = bodyObject.gen;
      const lengs = bodyObject['leng[]'];
      const about = bodyObject.about;
      
      res.setHeader('Content-Type', 'text/html; charset=utf-8');
      res.writeHead(200);
      if(validateData(name,number,date)[1] == 0){
        res.end(HTMLAnswer(validateData(name,number,date)[0]));
      }else{
        res.end(HTMLAnswer(validateData(name,number,date)[0]));

      //Заполнение данных в базу данных
      const db = mysql.createConnection({
        host:"localhost",
        user:"d2min",
        password:"Qwerty40982",
        database:"FDB",
      });

      db.connect((err)=>{
        if(err) throw err;
        console.log("Connected to MySQL database");
      });

      let sql = `INSERT INTO users(name,number,email,date,gen,about) VALUES('${name}','${number}','${email}','${date}',${gen},'${about}');`;
      db.query(sql,(err,res)=>{
        if(err) throw err;
        console.log("data users save");
        // res.send("data save");
      })

      let lengObj = InsertLengs(lengs);
      sql = `INSERT INTO lengs(user_id,pascal,c,cpp,js,py,java,haskel,clijure,prolog,scara) 
             VALUE(LAST_INSERT_ID(),
             '${lengObj['Pascal']}','${lengObj['C']}','${lengObj['C++']}','${lengObj['JavaScript']}','${lengObj['Python']}',
             '${lengObj['Java']}','${lengObj['Haskel']}','${lengObj['Clijure']}','${lengObj['Prolog']}','${lengObj['Scara']}');`;
      db.query(sql,(err,res)=>{
        if(err) throw err;
        console.log("data lengs save");
      })
      };
    });
  }

  else  if (req.method === 'GET' && req.url === '/tables') {
    const db = mysql.createConnection({
      host: 'localhost',
      user: 'd2min',
      password: 'Qwerty40982',
      database: 'FDB'
    });

    db.connect((err) => {
      if (err) throw err;
      console.log('Connected to MySQL database');

      // Выполнение SQL-запроса для выборки данных из таблицы
      const query = 'SELECT * FROM users join lengs on users.user_id = lengs.user_id';
      db.query(query, (err, results) => {
        if (err) throw err;

        // Генерация HTML-кода для отображения данных на странице
        let html = HTMLTables(results);

        // Отправка HTML-кода в ответ на запрос
        res.writeHead(200, {'Content-Type': 'text/html'});
        res.end(html);
      });
    });
  }
  else{
    // Отправить ответ 404 Not Found для всех других запросов
    res.writeHead(404);
    res.end('Sorry bro Not Found - ' + req.url!='/tables');
  }
});

// Запустить сервер на порту 600
server.listen(600, function() {
  console.log('Сервер запущен на порту 600');
});
