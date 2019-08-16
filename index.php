<?php
$interpretation_id=0;
$interpretation[$interpretation_id]='Feof_Bolgar';
$htm_files[0]='1Co.htm';
$htm_files[1]='1Jn.htm';
$htm_files[2]='1Pe.htm';
$htm_files[3]='1The.htm';
$htm_files[4]='1Ti.htm';
$htm_files[5]='2Co.htm';
$htm_files[6]='2Jn.htm';
$htm_files[7]='2Pe.htm';
$htm_files[8]='2The.htm';
$htm_files[9]='2Ti.htm';
$htm_files[10]='3Jn.htm';
$htm_files[11]='Ac.htm';
$htm_files[12]='Col.htm';
$htm_files[13]='Eph.htm';
$htm_files[14]='Ga.htm';
$htm_files[15]='Ja.htm';
$htm_files[16]='Jn.htm';
$htm_files[17]='Jud.htm';
$htm_files[18]='Lk.htm';
$htm_files[19]='Mk.htm';
$htm_files[20]='Mt.htm';
$htm_files[21]='Phl.htm';
$htm_files[22]='Ro.htm';
$htm_files[23]='Tit.htm';
$arr=Array();
$continue=false;

foreach ($htm_files as $book=>$htm_file){
	$filename="Feof_Bolgar/$htm_file";
	$lines = file($filename);
	$chapter=0;
	foreach($lines as $idx => $line) {
	$line = iconv('Windows-1251', 'UTF-8', $line);
	if (preg_match('/<H2>([А-Яа-я\s]*)/', $line, $matches)) {
	//trim($matches[1]);
	//echo "<br>$book=$chapter=".$matches[1];
	$chapter++;
	$continue=true;
	$verse=0;
	continue;
	}
	if ($continue&&$chapter>0){
	 if (preg_match('/<P>(\d+)-(\d+) (.*)/', $line, $matches)){
	$verse1=$matches[1];
	$verse2=$matches[2];
	$text=$matches[3];
	foreach (range($verse1, $verse2) as $number) {
	$arr[$interpretation_id][$book][$chapter-1][$number]=$text;
	}
	//echo 'verse12='.$verse1.'-'.$verse2.'('.$text.')';
	}else if (preg_match('/<P>(\d+) (.*)/', $line, $matches)) {
	$verse=$matches[1];
	$text=$matches[2];
	$arr[$interpretation_id][$book][$chapter-1][$verse]=$text;
	//echo 'verse='.$verse.'('.$text.')';
	}
	}}}
	//echo '<pre>';print_r($arr);echo '</pre>';

	$host = 'localhost'; // адрес сервера 
	$database = "bibliainterpretations"; // имя базы данных
	$user = 'root'; // имя пользователя
	$password = ''; // пароль

	$link = mysqli_connect($host, $user, $password, $database) 
	    or die("Ошибка " . mysqli_error($link));
	 
	// выполняем операции с базой данных
	echo "Connected successfully";
	foreach ($arr as $interpretation=>$v1){
	foreach ($v1 as $book=>$v2){
	foreach ($v2 as $chapter_id=>$v3){
	foreach ($v3 as $verse_id=>$text){  
	$interpretation_id=$interpretation+1;
	$book_id=$book+1;
	//echo '<br>$interpretation_id='.$interpretation_id.'$book_id='.$book_id.'$chapter_id='.$chapter_id.'$verse_id'.$verse_id.'$text=('.$text.')';
	$sql = "INSERT INTO interpretations (avtor_id,book_id,chapter_id,verse_id,text) VALUES ('$interpretation_id', '$book_id', '$chapter_id','$verse_id','$text')";
	if (mysqli_query($link, $sql)) {
	      echo "New record created successfully";
	} else {
	      echo "Error: " . $sql . "<br>" . mysqli_error($link);
	}
	 }}}}    
	// закрываем подключение
	mysqli_close($link);

?>