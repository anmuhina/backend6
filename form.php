<head>
        <link rel="stylesheet" href="style.css">
</head> 
<body> 
        
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
    <label>
        Имя:<br>
        <input id="data" name="name" placeholder="Введите Ваше имя" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>" >
    </label><br>
    <label>
        Email:<br>
        <input id="data" name="email" type="email" placeholder="Введите вашу почту" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" >
    </label><br>
    <label>
        Дата рождения:<br>
         <select id="data" name="birth_date" <?php if ($errors['birth_date']) {print 'class="error"';} ?> >
         <?php  
                 $birthdate=$values['birth_date'];
                 if ($values['birth_date']=='') {
                         for ($i = 1922; $i <= 2022; $i++) {
                            printf('<option value="%d">%d год</option>', $i, $i);
                         }
                 }
                 else {
                         printf('<option value="%d">%d год</option>', $birthdate, $birthdate);
                         for ($i = 1922; $i <= 2022; $i++) {
                            printf('<option value="%d">%d год</option>', $i, $i);
                         }
                 }
         ?>
        </select>
    </label><br>
          
    Пол:<br>
        <div <?php if ($errors['sex']) {print 'class="error"';} ?> >
        <?php
             
                if ($values['sex']=='') {
                           print ('<label><input id="data" type="radio" name="sex" value="ж">Ж</label> 
                           <label><input id="data" type="radio" name="sex" value="м">М</label><br>');
                }
                else {
                ?>
                  <label><input id="data" type="radio" name="sex" value="ж" <?php if ($values['sex']=='ж') print('checked="checked"'); ?> >Ж</label> 
                  <label><input id="data" type="radio" name="sex" value="м" <?php if ($values['sex']=='м') print('checked="checked"'); ?> >М</label><br>
                <?php        
                }
                ?>
        </div>
        
    Количество конечностей:<br />
        <div <?php if ($errors['amount_of_limbs']) {print 'class="error"';} ?> >
                <?php
                if ($values['amount_of_limbs']=='') {
                        print ('<label><input id="data" type="radio" name="amount_of_limbs" value="2"> 2 </label>
                        <label><input id="data" type="radio" name="amount_of_limbs" value="3"> 3 </label>
                        <label><input id="data" type="radio" name="amount_of_limbs" value="4"> 4 </label><br>');
                }
                else {
                        ?>
                        <label><input id="data" type="radio" name="amount_of_limbs" value="2" <?php if ($values['amount_of_limbs']==2) print('checked="checked"'); ?> > 2 </label>
                        <label><input id="data" type="radio" name="amount_of_limbs" value="3" <?php if ($values['amount_of_limbs']==3) print('checked="checked"'); ?> > 3 </label>
                        <label><input id="data" type="radio" name="amount_of_limbs" value="4" <?php if ($values['amount_of_limbs']==4) print('checked="checked"'); ?> > 4 </label><br>
                <?php
                } 
                ?>
        </div>
        
    <label>
        Сверхспособности:<br>
        <select id="data" name="abilities[]" multiple="multiple" <?php if ($errors['abilities']) {print 'class="error"';} ?> >
                <?php
                if (empty($values['abilities']) || !is_array($values['abilities'])) {
                        print ('<option value="Бессмертие">Бессмертие</option>
                        <option value="Прохождение сквозь стены">Прохождение сквозь стены</option>
                        <option value="Левитация">Левитация</option>');
                }
                else {
                ?>
                <option value="Бессмертие" <?php if (in_array('Бессмертие', $values['abilities'])) {print('selected="selected"');} ?>>Бессмертие</option>
                <option value="Прохождение сквозь стены" <?php if (in_array('Прохождение сквозь стены', $values['abilities'])) {print('selected="selected"');} ?>>Прохождение сквозь стены</option>
                <option value="Левитация" <?php if (in_array('Левитация', $values['abilities'])) {print('selected="selected"');} ?>>Левитация</option>;
                <?php
                }
                ?>
        </select>
    </label><br>
        
    <label>
        Биография:<br />
        <textarea id="data" name="biography" placeholder="Введите текст" <?php if ($errors['biography']) {print 'class="error"';} ?> > <?php print $values['biography'] ?> </textarea>  
        </label><br>
        
        <div <?php if ($errors['informed']) {print 'class="error"';} ?> >
                <?php
                if ($values['informed']=='') {
                        print('<label><input id="data" type="checkbox" name="informed">С контрактом ознакомлен(а)</label><br>');
                }
                else {
                        print('<label><input id="data" type="checkbox" name="informed" checked="checked">С контрактом ознакомлен(а)</label><br>');
                }
                ?>
        </div>
        
    <input id="sub" type="submit" value="Отправить">
  </form>
</body>
