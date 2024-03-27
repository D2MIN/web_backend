<?php
  $host = 'localhost';
  $user = 'u67303';
  $password = '8187062';
  $database = 'u67303';

  $conn = mysqli_connect($host, $user, $password, $database);

  if (!$conn) {
    die('Ошибка подключения к базе данных: ' . mysqli_connect_error());
  }

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $surname = mysqli_real_escape_string($conn, $_POST['surname']);
  $number = mysqli_real_escape_string($conn, $_POST['number']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $date = mysqli_real_escape_string($conn, $_POST['date']);
  $gen = mysqli_real_escape_string($conn, $_POST['gen']);
  $about = mysqli_real_escape_string($conn, $_POST['about']);

  $query = "INSERT INTO users (person_name,person_surname,number,email,year,gen,about) VALUES ('$name', '$surname','$number','$email','$date', '$gen','$about')";

  $lengs = $_POST['leng'];
  $arr_len = ["Pascal","C","C++","JavaScript","PHP","Python","Java","Haskel","Clijure","Prolog","Scara"];
  $arr_num_len = [0,0,0,0,0,0,0,0,0,0,0];

  foreach($lengs as $leng){
    $index = array_search($leng, $arr_len);
    if ($index !== false) {
      $arr_num_len[$index] = 1;
    }
  }

  $e1 = mysqli_real_escape_string($conn, $arr_num_len[0]);
  $e2 = mysqli_real_escape_string($conn, $arr_num_len[1]);
  $e3 = mysqli_real_escape_string($conn, $arr_num_len[2]);
  $e4 = mysqli_real_escape_string($conn, $arr_num_len[3]);
  $e5 = mysqli_real_escape_string($conn, $arr_num_len[4]);
  $e6 = mysqli_real_escape_string($conn, $arr_num_len[5]);
  $e7 = mysqli_real_escape_string($conn, $arr_num_len[6]);
  $e8 = mysqli_real_escape_string($conn, $arr_num_len[7]);
  $e9 = mysqli_real_escape_string($conn, $arr_num_len[8]);
  $e10 = mysqli_real_escape_string($conn, $arr_num_len[9]);
  $e11 = mysqli_real_escape_string($conn, $arr_num_len[10]);

  mysqli_query($conn, $query);

  $user_id = mysqli_insert_id($conn);

  $query = "INSERT INTO leng (id,pascal,c,cpp,js,php,python,java,haskel,clijure,prolog,scara) VALUES ('$user_id','$e1', '$e2','$e3','$e4','$e5', '$e6','$e7','$e8','$e9','$e10','$e11')";

  if (mysqli_query($conn, $query)) {
    echo 'Данные успешно сохранены' . "<br>";
  } else {
    echo 'Ошибка сохранения данных: ' . mysqli_error($conn);
  }

  $query = "SELECT users.person_name, users.person_surname, users.number, users.email, users.year, users.gen, users.about, leng.pascal, leng.c, leng.cpp, leng.js, leng.php, leng.python, leng.java, leng.haskel, leng.clijure, leng.prolog, leng.scara
          FROM users
          INNER JOIN leng ON users.id = leng.id";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Имя: " . $row["person_name"] . "<br>";
        echo "Фамилия: " . $row["person_surname"] . "<br>";
        echo "Номер телефона: " . $row["number"] . "<br>";
        echo "Электронная почта: " . $row["email"] . "<br>";
        echo "Год рождения: " . $row["year"] . "<br>";
        echo "Пол: " . $row["gen"] . "<br>";
        echo "О себе: " . $row["about"] . "<br>";
        echo "Pascal: " . $row["pascal"] . "<br>";
        echo "C: " . $row["c"] . "<br>";
        echo "C++: " . $row["cpp"] . "<br>";
        echo "JavaScript: " . $row["js"] . "<br>";
        echo "PHP: " . $row["php"] . "<br>";
        echo "Python: " . $row["python"] . "<br>";
        echo "Java: " . $row["java"] . "<br>";
        echo "Haskel: " . $row["haskel"] . "<br>";
        echo "Clijure: " . $row["clijure"] . "<br>";
        echo "Prolog: " . $row["prolog"] . "<br>";
        echo "Scara: " . $row["scara"] . "<br>";
        echo "<hr>";
    }
} else {
    echo "Нет результатов";
}

  mysqli_close($conn);
?>