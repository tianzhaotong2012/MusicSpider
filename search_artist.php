<?php
require_once('login.php');
require_once("simple_html_dom.php");
require_once("mysql.php");
$id = $_GET['id'];
$submit_pinyin = $_GET['pinyin'];
if(empty($submit_pinyin)){
	echo "no pinyin";
	exit();
}
var_dump($id);

/*$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.xiami.com/artist/".$id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
$output = curl_exec($ch);
curl_close($ch);
print_r($output);*/

$html = file_get_html("http://www.xiami.com/artist/".$id);

$artist_element = $html->find('#title h1');
$artist_name  = $artist_element[0]->plaintext;
$artist_e_name_element = $artist_element = $html->find('#title h1 span');
$artist_e_name = $artist_e_name_element[0]->plaintext;
print_r("<br>artist_name:" . $artist_name . "<br>");
$artist_name = strip_tags(trim(str_replace($artist_e_name, '',$artist_name)));

$get_artist_name = $_GET['artist_name'];

if(!empty($get_artist_name)){
	$artist_name = $get_artist_name;
}

print_r("<br><div style='color:red'>artist_name:" . $artist_name . "</div><br>");

print_r("<br><div style='color:red'>pinyin:" . $submit_pinyin . "</div><br>");

if(empty($artist_name)){
        print_r("no_artist_name");
	exit();
}

$cover_elemtnt = $html->find('#cover_lightbox img');
$cover_url = $cover_elemtnt[0]->getAttribute("src");
print_r("<br><div style='color:red'>url:" .$cover_url . "</div><br>");

$record_element = $html->find('.record');
$record = $record_element[0]->plaintext;
print_r("<br><div style='color:red'>record:" .$record. "</div><br>");

$select_sql = sprintf('select * from  artist where artist_name = "%s"',$artist_name);

var_dump($select_sql);

$find = my_sql($select_sql);

if(!empty($find)){
	echo 'have download this artist';
	exit();
}

if(empty($_GET['insert'])){
	echo "param insert need";
	exit();
}

$insert_sql = sprintf("insert into artist (artist_name,artist_photo,artist_des) values ('%s','%s','%s')",$artist_name,$cover_url,addslashes($record));

var_dump($insert_sql);

my_insert($insert_sql);

function download($url,$name){
	$dir = dirname(__FILE__) . '/music/';
	if (!file_exists($dir)){ mkdir ($dir);}

	$cmd = 'wget -U "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.6) Gecko/20070802 SeaMonkey/1.1.4"  -O ' . $dir . $name . ' "' . $url . '"';
	print_r($cmd);
	$retval = array();
	exec($cmd, $retval, $status);
}

download($cover_url,$submit_pinyin.'.jpg');

function move_to($file_name){
	$year = date("Y",time());
	$month = date("m",time());
	$dir = '/var/www/html/musicleft/wp-content/uploads/edd/'.$year.'/'.$month.'/';
	var_dump($dir);
	if (!file_exists($dir)){ mkdir ($dir);}

	$cmd = 'cp ' . dirname(__FILE__) . '/music/' . $file_name . ' ' . $dir . $file_name;
	print_r($cmd);
	$retval = array();
	exec($cmd, $retval, $status);
}

move_to($submit_pinyin.'.jpg');

require_once("to_wordpress_artist.php");
