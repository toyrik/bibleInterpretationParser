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
    $patch_to_dir = 'lopuhin';//Путь к сканируемой папке
    $books = scandir($patch_to_dir);
    $continue=false;
    $arr = Array();
          
    foreach($books as $book){
      if(is_file("$patch_to_file")){
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

          if (preg_match('/<[hH]2>([0-9A-ZА-Яа-я\s]*)/', $line, $matches)) {// Считаем главы

            // echo "<br>$book=$chapter=".$matches[1];
            $chapter++;
            $continue = true;
            $verse = 0;
            continue;
          }
          if ($continue&&$chapter>0){

            if (preg_match('/<[pP]>(\d+)-(\d+) (.*)/', $line, $matches)){

              $verse1=$matches[1];
              $verse2=$matches[2];
              $text=$matches[3];

              foreach (range($verse1, $verse2) as $number) {
              $arr[$interpretation_id][$book][$chapter-1][$number]=$text;
              }
              // echo 'verse12='.$verse1.'-'.$verse2.'('.$text.')';
            }else if (preg_match('/<P>(\d+) (.*)/', $line, $matches)) {

              $verse=$matches[1];
              $text=$matches[2];
              $arr[$interpretation_id][$book][$chapter-1][$verse]=$text;
              //echo 'verse='.$verse.'('.$text.')';
            }
          }
        }         
      }
    }

    // echo '<pre>';
    // print_r($arr);
    // echo '</pre>';
  ?>
  
</body>
</html>