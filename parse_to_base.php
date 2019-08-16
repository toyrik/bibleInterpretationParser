<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Парсер</title>
</head>
<body>
  <?php
    $patch_to_dir = 'test';//Путь к сканируемой папке
    $books = scandir($patch_to_dir);
    $continue=false;
          
    foreach($books as $book){
        if(is_file("$patch_to_dir/$book")){
          $ext = new SplFileInfo($book);
          $ext = $ext->getExtension(); //получаем расширение файла

          if ($ext!='htm') { // если не *,htm - берём следующий
            continue;
          }  

          $patch_to_file = "$patch_to_dir/$book";
          $lines = file($patch_to_file);
          $chapter = 0; 
          
          foreach($lines as $idx => $line) {
            $line = iconv('Windows-1251', 'UTF-8', $line); //Конвертируем элементы в удобочитаемую кодировку

            if (preg_match('/<H2>([А-Яа-я\s]*)/', $line, $matches)) {//
              $chapter++;
              $continue = true;
              $verse = 0;
              continue;
            }
            echo $chapter;
          }         
        }
    }
  ?>
  
</body>
</html>