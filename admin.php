<!DOCTYPE html>
<html lang="ru">
    <head>
        <!--<link rel="stylesheet" href="style.css" type="text/css"/>-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {
               margin:0;
               color: black;
               font-family: 'Times New Roman', Times, serif;
               font-weight: bold;
               font-style: normal;
               font-size: 25px;
            }
           .forma {
               width: 100%;
               background-color: rgb(255, 105, 180);
               padding: 20px;
           }
           table {
               width: 100%;
               margin: 10px;
               border-collapse: collapse;
               border: 4px solid #FF1493;
           }
           td, tr, th {
               border: 1px solid #FF1493;
           }
           tr {
               text-align: center;
           }
     </style>
</head> 
<body>

<?php
    
        include('connection.php');

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

 <!--*********
 Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
 Реализовать просмотр и удаление всех данных.
 *********-->
    
    <?php
            $imm_id=10;
            $wall_id=20;
            $fly_id=30;
            
            $stmt=$db->prepare("select count(app_id) from application_ability group by ab_id having ab_id=?");
            $stmt->execute([$imm_id]);
            $imm_count=$stmt->fetchColumn();
            
            $stmt->execute([$wall_id]);
            $wall_count=$stmt->fetchColumn();
            
            $stmt->execute([$fly_id]);
            $fly_count=$stmt->fetchColumn();
            
            print '<br>Количество пользователей со сверхспособностью "Бессмертие": '; print(empty($imm_count) ? '0' : $imm_count); print '<br>
            Количество пользователей со сверхспособностью "Прохождение сквозь стены": '; print(empty($wall_count) ? '0' : $wall_count); print '<br>
            Количество пользователей со сверхспособностью "Левитация": '; print(empty($fly_count) ? '0' : $fly_count); print '<br>';
        ?>
      
<form action="" class="forma" method="POST">
  <table>
          <tr>
                  <th>ID</th>
                  <th>NAME</th>
                  <th>EMAIL</th>
                  <th>BIRTH YEAR</th>
                  <th>SEX</th>
                  <th>AMOUNT OF LIMBS</th>
                  <th>SUPERPOWERS</th>
                  <th>BIOGRAPHY</th>
                  <th>ACTION</th>
          </tr>
          
          <?php
          foreach ($values as $val) {
                  $stmt = $db->prepare("select ab_id from application_ability where app_id = ?");
                  $stmt->execute([$val['id']]);
                  $abil = $stmt->fetchAll(PDO::FETCH_COLUMN);
                  
                  $birthdate=$val['birth_date'];
                  print 
                  '<tr>
                      <td> <input name="app_id'.$val['id'].'" value="'; print $val['id']; print '"> </td>
                      <td> <input name="name'.$val['id'].'" value="'; print $val['name']; print '"> </td>
                      <td> <input name="email'.$val['id'].'" value="'; print $val['email']; print '"> </td>
                      <td> <select name="birth_date'.$val['app_id'].'">';
                              for ($i = 1922; $i <= 2022; $i++) {
                                if ($i==$val['birth_date']){
                                 printf('<option value="%d">%d год</option>', $i, $i);
                                }
                              }
                           print '</select> </td>
                      <td> <label><input type="radio" name="sex'.$val['id'].'" value="ж"'; if ($val['sex']=='ж') {print 'checked="checked"';} print '>Ж</label>
                           <label><input type="radio" name="sex'.$val['id'].'" value="м"'; if ($val['sex']=='м') {print 'checked="checked"';} print '>М</label> 
                      </td>     
                      <td> <label><input type="radio" name="amount_of_limbs'.$val['id'].'" value="2"'; if ($val['amount_of_limbs']==2) {print 'checked="checked"';} print '> 2</label>
                           <label><input type="radio" name="amount_of_limbs'.$val['id'].'" value="3"'; if ($val['amount_of_limbs']==3) {print 'checked="checked"';} print '> 3</label>
                           <label><input type="radio" name="amount_of_limbs'.$val['id'].'" value="4"'; if ($val['amount_of_limbs']==4) {print 'checked="checked"';} print '> 4</label>
                      </td>
                      <td> <select name="abilities'.$val['id'].'[]" multiple="multiple"> 
                           <option value="Бессмертие"'; if (in_array(10, $abil)) {print 'selected="selected"';} print '>Бессмертие</option>
                           <option value="Прохождение сквозь стены"'; if (in_array(20, $abil)) {print 'selected="selected"';} print '>Прохождение сквозь стены</option>
                           <option value="Левитация"'; if (in_array(30, $abil)) {print 'selected="selected"';} print '>Левитация</option>
                      </td>
                      <td> <textarea name="biography'.$val['id'].'">'; print $val['biography']; print '</textarea> </td>
                      <td> <div> <input name="update'.$val['id'].'" type="submit" value="update'.$val['id'].'"> </div>
                           <div> <input name="delete'.$val['id'].'" type="submit" value="delete'.$val['id'].'"> </div>
                      </td>
                  </tr>';
          }
          ?>
  </table>
</form>
        
        <!--<?php-->
            /*$imm_id=10;
            $wall_id=20;
            $fly_id=30;
            
            $stmt=$db->prepare("select count(app_id) from application_ability group by ab_id having ab_id=?");
            $stmt->execute([$imm_id]);
            $imm_count=$stmt->fetchColumn();
            
            $stmt->execute([$wall_id]);
            $wall_count=$stmt->fetchColumn();
            
            $stmt->execute([$fly_id]);
            $fly_count=$stmt->fetchColumn();
            
            print '<br>Количество пользователей со сверхспособностью "Бессмертие": '; print(empty($imm_count) ? '0' : $imm_count); print '<br>
            Количество пользователей со сверхспособностью "Прохождение сквозь стены": '; print(empty($wall_count) ? '0' : $wall_count); print '<br>
            Количество пользователей со сверхспособностью "Левитация": '; print(empty($fly_count) ? '0' : $fly_count); print '<br>';
        ?>*/
</body>
</html>

