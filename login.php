<?php

header('Content-Type: text/html; charset=UTF-8');

session_start();

if (!empty($_SESSION['login'])) {
  // Делаем перенаправление на форму.
  header('Location: ./');
}
  
  

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

<style>
  #data {
    color: black;
    font-family: 'Times New Roman', Times, serif;
    font-weight: bold;
    font-style: normal;
    font-size: 25px;
  }
  .forma {
    margin: 0 auto;
  }
  .sub {
    padding: 5px;
    color: white;
    margin-top: 10px;
    background-color: rgb(255, 105, 180);
  }
</style>

<form class="forma" action="" method="post">
  <input id="data" name="login" />
  <input id="data" name="password" />
  <input id="data" class="sub" type="submit" value="Войти" />
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
  include('connection.php');
  
  $login=$_POST['login'];
  $password=md5($_POST['password']);
  
  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибкаx
  $sth = $db->prepare("select login, id, password from application1 where login=? and password=?");
  $sth->execute([$login, $password]);
  $res1 = $sth->fetchAll();
  if (!$res1 || empty($res1[0]['id'])) {
    print('<p class="error">Нет такого пользователя! Проверьте корректность введенных логина и пароля.</p>');
  }
  else {
    // Если все ок, то авторизуем пользователя.
    
    echo '<p> Поздравляем, вы прошли авторизацию!</p>';
    
    $_SESSION['login'] = $login;

    // Записываем ID пользователя.
    //$stmt=$db->prepare("select id from application1 where login=?");
    //$stmt->execute([$_SESSION['login']]);
    $_SESSION['uid'] = $res1[0]['id']; //$stmt->fetchAll();

    header('Location: ./');    
  }
}
