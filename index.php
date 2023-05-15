<?php
header('Content-Type: text/html; charset=UTF-8');

include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  
  try {
        $stmt = $db->prepare("select id, name, email, birth_date, sex, amount_of_limbs, biography from application1");
        $stmt->execute();
        $values = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //$values = $stmt->fetchAll();
    
  }
  catch (PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
  }
   
  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['birth_date'] = !empty($_COOKIE['birthDate_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['amount_of_limbs'] = !empty($_COOKIE['amountOfLimbs_error']);
  $errors['abilities'] = !empty($_COOKIE['abilities_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['app_id'] = !empty($_COOKIE['id_error']);
  
  // Выдаем сообщения об ошибках.
  if ($errors['name']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Введите имя корректно.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100000);
    $messages[] = '<div class="error">Введите почту.</div>';
  }
  if ($errors['birth_date']) {
    setcookie('birthDate_error', '', 100000);
    $messages[] = '<div class="error">Введите год рождения.</div>';
  }
  if ($errors['sex']) {
    setcookie('sex_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
  }
  if ($errors['amount_of_limbs']) {
    setcookie('amountOfLimbs_error', '', 100000);
    $messages[] = '<div class="error">Выберите количество конечностей.</div>';
  }
  if ($errors['abilities']) {
    setcookie('abilities_error', '', 100000);
    $messages[] = '<div class="error">Выберите сверхспособности.</div>';
  }
  if ($errors['biography']) {
    setcookie('biography_error', '', 100000);
    $messages[] = '<div class="error">Заполните биографию.</div>';
  }
  
  include('admin.php');
  exit();
}

// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  $errors = FALSE;
  
  foreach ($_POST as $key => $value) {
        if (preg_match('/^delete(\d+)$/', $key, $matches)) {
            $app_id = $matches[1];
            $stmt = $db->prepare("delete from application1 where id = ?");
            $stmt->execute([$app_id]);
            $stmt = $db->prepare("delete from application_ability where app_id = ?");
            $stmt->execute([$app_id]);
        }
        if (preg_match('/^update(\d+)$/', $key, $matches)) {
            $app_id = $matches[1];
            $info = array();
            $info['name'] = $_POST['name' . $app_id];
            $info['email'] = $_POST['email' . $app_id];
            $info['birth_date'] = $_POST['birth_date' . $app_id];
            $info['sex'] = $_POST['sex' . $app_id];
            $info['amount_of_limbs'] = $_POST['amount_of_limbs' . $app_id];
            $info['biography'] = $_POST['biography' . $app_id];
          
            $abilities1 = $_POST['abilities' . $app_id];
        
            $name = $info['name'];
            $email = $info['email'];
            $birth_date = $info['birth_date'];
            $sex = $info['sex'];
            $amount_of_limbs = $info['amount_of_limbs'];
            $biography = $info['biography'];
        
  if (empty($name) || !preg_match('/^([a-zA-Z\'\-]+\s*|[а-яА-ЯёЁ\'\-]+\s*)$/u', $name)) {
    // Выдаем куку на день с флажком об ошибке в поле fio.
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($email) || !preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $email)) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($birth_date) || !is_numeric($birth_date) || !preg_match('/^\d+$/', $birth_date)) {
    setcookie('birthDate_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($sex) || !($sex=='ж' || $sex=='м')) {
    setcookie('sex_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  if (empty($amount_of_limbs) || !is_numeric($amount_of_limbs) || ($amount_of_limbs<2) || ($amount_of_limbs>4)) {
    setcookie('amountOfLimbs_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  $abilities = [10 => 'Бессмертие', 20 => 'Прохождение сквозь стены', 30 => 'Левитация'];
  if (empty($abilities1) || !is_array($abilities1)) {
    setcookie('abilities_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    foreach ($abilities1 as $ability) {
      if (!in_array($ability, $abilities)) {
        setcookie('abilities_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
        break;
      }
    }
  }
  if (empty($biography)) {
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  
  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    setcookie('id_error', '1', time() + 24 * 60 * 60);
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('birthDate_error', '', 100000);
    setcookie('sex_error', '', 100000);
    setcookie('amountOfLimbs_error', '', 100000);
    setcookie('abilities_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('informed_error', '', 100000);
    setcookie('id_error', '', 100000);
  } 
          
            $stmt = $db->prepare("select name, email, birth_date, sex, amount_of_limbs, biography from application1 where id = ?");
            $stmt->execute([$app_id]);
            $info1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //$info1 = $stmt->fetchAll();

            $stmt = $db->prepare("select ab_id from application_ability where app_id = ?");
            $stmt->execute([$app_id]);
            $info2 = $stmt->fetchAll(PDO::FETCH_COLUMN);
          
            if (array_diff($info, $info1[0])) {
                $stmt = $db->prepare("update application1 set name = ?, email = ?, birth_date = ?, sex = ?, amount_of_limbs = ?, biography = ? where id = ?");
                $stmt->execute([$name, $email, $birth_date, $sex, $amount_of_limbs, $biography, $app_id]);
            }
            if (array_diff($abilities1, $info2)) {
                $stmt = $db->prepare("delete from application_ability where app_id = ?");
                $stmt->execute([$app_id]);
                $stmt = $db->prepare("insert into application_ability set app_id = ?, ab_id = ?");
                foreach ($abilities1 as $ability) {
                   if ($ability=='Бессмертие')
                   {$stmt -> execute([$app_id, 10]);}
                   else if ($ability=='Прохождение сквозь стены')
                   {$stmt -> execute([$app_id, 20]);}
                   else if ($ability=='Левитация')
                   {$stmt -> execute([$app_id, 30]);}
               }
            }
        }
    }
    header('Location: index.php');
}
