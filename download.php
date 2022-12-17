<?php
require_once('login.php');
require_once('mysql.php');
$submit_song_name = $_POST['song_name'];
$submit_artist = $_POST['artist'];
$submit_song_img = $_POST['song_img'];
$submit_song_url = $_POST['song_url'];
$submit_song_pinyin = $_POST['song_pinyin'];

if(empty($_POST['song_name'])||empty($_POST['artist'])||empty($_POST['song_img'])||empty($_POST['song_url'])||empty($_POST['song_pinyin'])){
	echo "parma need";
	exit();
}

function download($url,$name){
	$dir = dirname(__FILE__) . '/music/';
	if (!file_exists($dir)){ mkdir ($dir);}

	$cmd = 'wget -U "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.6) Gecko/20070802 SeaMonkey/1.1.4"  -O ' . $dir . $name . ' "' . $url . '"';
	print_r($cmd);
	$retval = array();
	exec($cmd, $retval, $status);
}

var_dump($submit_song_name);

$select_sql = sprintf('select * from song where song_name = "%s"',$submit_song_name);

var_dump($select_sql);

$find = my_sql($select_sql);

if(!empty($find)){
	echo 'have download it';
	exit();
}

download($submit_song_img,$submit_song_pinyin.'.jpg');
download($submit_song_url,$submit_song_pinyin.'.mp3');

$insert_sql = sprintf('insert into song (song_name,artist,song_img,song_url,song_pinyin) values ("%s","%s","%s","%s","%s")',$submit_song_name,$submit_artist,$submit_song_img,$submit_song_url,$submit_song_pinyin);

var_dump($insert_sql);

my_insert($insert_sql);

require_once("to_wordpress.php");
