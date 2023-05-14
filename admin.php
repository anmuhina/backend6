<head>
        <link rel="stylesheet" href="style.css">
</head> 
<body>

<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' ||
    md5($_SERVER['PHP_AUTH_PW']) != md5('123')) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

print('Вы успешно авторизовались и видите защищенные паролем данные.');
?>

// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>
      
<form action="" class="forma" method="POST">
  <?php  
    foreach($values as $value) {
    <?php  
        echo
    '<label>
        ID:<br>
        <input id="data" name="app_id" value="'; print($value['app_id']);  echo '" >
    </label><br>
    
    <label>
        Имя:<br>
        <input id="data" name="name" value="'; print ($value['name']); echo '" >
    </label><br>
    <label>
        Email:<br>
        <input id="data" name="email" type="email" value="'; print($values['email']); echo '" >
    </label><br>
    <label>
        Дата рождения:<br>
         <select id="data" name="birth_date" >';
           
                 $birthdate=$value['birth_date'];
                 /*if ($value['birth_date']=='') {
                         for ($i = 1922; $i <= 2022; $i++) {
                            printf('<option value="%d">%d год</option>', $i, $i);
                         }
                 }
                 else {*/
                         printf('<option value="%d">%d год</option>', $birthdate, $birthdate);
                         for ($i = 1922; $i <= 2022; $i++) {
                            printf('<option value="%d">%d год</option>', $i, $i);
                         }
                 //}
        ; echo 
        '</select>
    </label><br>
          
    Пол:<br>
        <div>';
             
                /*if ($value['sex']=='') {
                           print ('<label><input id="data" type="radio" name="sex" value="ж">Ж</label> 
                           <label><input id="data" type="radio" name="sex" value="м">М</label><br>');
                }
                else {*/
                  echo '<label><input id="data" type="radio" name="sex" value="ж"'; if ($value['sex']=='ж') print('checked="checked"'); echo '>Ж</label> 
                  <label><input id="data" type="radio" name="sex" value="м"'; if ($values['sex']=='м') print('checked="checked"'); echo '>М</label><br>';       
                //}
       echo '</div>
        
    Количество конечностей:<br />
        <div>';
                /*if ($values['amount_of_limbs']=='') {
                        print ('<label><input id="data" type="radio" name="amount_of_limbs" value="2"> 2 </label>
                        <label><input id="data" type="radio" name="amount_of_limbs" value="3"> 3 </label>
                        <label><input id="data" type="radio" name="amount_of_limbs" value="4"> 4 </label><br>');
                }
                else {*/
                echo
                       ' <label><input id="data" type="radio" name="amount_of_limbs" value="2"'; if ($value['amount_of_limbs']==2) print('checked="checked"'); echo '> 2 </label>
                        <label><input id="data" type="radio" name="amount_of_limbs" value="3"'; if ($value['amount_of_limbs']==3) print('checked="checked"'); echo '> 3 </label>
                        <label><input id="data" type="radio" name="amount_of_limbs" value="4"'; if ($value['amount_of_limbs']==4) print('checked="checked"'); echo '> 4 </label><br>';
                //} 
        echo '</div>
        
    <label>
        Сверхспособности:<br>
        <select id="data" name="abilities[]" multiple="multiple" >';
                /*if (empty($values['abilities']) || !is_array($values['abilities'])) {
                        print ('<option value="Бессмертие">Бессмертие</option>
                        <option value="Прохождение сквозь стены">Прохождение сквозь стены</option>
                        <option value="Левитация">Левитация</option>');
                }
                else {*/
                echo
                    '<option value="Бессмертие"'; if (in_array('Бессмертие', $value['abilities'])) {print('selected="selected"');} echo '>Бессмертие</option>
                     <option value="Прохождение сквозь стены"'; if (in_array('Прохождение сквозь стены', $value['abilities'])) {print('selected="selected"');} echo '>Прохождение сквозь стены</option>
                     <option value="Левитация"'; if (in_array('Левитация', $value['abilities'])) {print('selected="selected"');} echo '>Левитация</option>';
                //}
        echo '</select>
    </label><br>
        
    <label>
        Биография:<br/>
        <textarea id="data" name="biography">'; print $value['biography']; echo '</textarea>  
        </label><br>
        
    <div> <input id="sub" name="save" type="submit" value="Сохранить"> </div>
    <div> <input id="sub" name="delete" type="submit" value="Удалить"> </div>';
    ?>
</form>
</body>

