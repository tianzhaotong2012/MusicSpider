<?php
require_once('config.php');
require_once('login.php');
require_once("mysql_wordpress.php");

/*$wp_post = array(
	'post_author' => '',
	'post_date' => '',
	'post_date_gmt' => '',
	'post_content' => '',
	'post_title' => '',
	'post_excerpt' => '',
	'post_status' => '',
	'comment_status' => '',
	'ping_status' => '',
	'post_password' => '',
	'post_name' => '',
	'to_ping' => '',
	'pinged' => '',
	'post_modified' => '',
	'post_modified_gmt' => '',
	'post_content_filtered' => '',
	'post_parent' => '',
	'guid' => '',
	'menu_order' => '',
	'post_type' => '',
	'post_mime_type' => '',
	'comment_count' => '',
);*/

$song_name = $submit_song_name;
$artist = $submit_artist;
$song_img = $submit_song_img;
$song_url = $submit_song_url;
$song_pinyin = $submit_song_pinyin;
date_default_timezone_set("Etc/GMT+8");
$date = date("Y-m-d h:m:s",time());
date_default_timezone_set("Etc/GMT");
$date_gmt = date("Y-m-d h:m:s",time());
$year = date("Y",time());
$month = date("m",time());
//$base_url = "http://172.16.113.148/musicleft/wp-content/uploads/edd/";

var_dump($song_name);
var_dump($artist);
var_dump($song_img);
var_dump($song_url);
var_dump($song_pinyin);
var_dump($date);
var_dump($date_gmt);
var_dump($year);
var_dump($month);

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

move_to($song_pinyin . '.jpg');
move_to($song_pinyin . '.mp3');

$wp_post = array(
	'post_author' => '1',
	'post_date' => $date,
	'post_date_gmt' => $date_gmt,
	'post_content' => '',
	'post_title' => $song_name,
	'post_excerpt' => '',
	'post_status' => 'publish',
	'comment_status' => 'open',
	'ping_status' => 'closed',
	'post_password' => '',
	'post_name' => $song_pinyin,
	'to_ping' => '',
	'pinged' => '',
	'post_modified' =>  $date,
	'post_modified_gmt' => $date_gmt,
	'post_content_filtered' => '',
	'post_parent' => '0',
	'guid' => '',
	'menu_order' => '0',
	'post_type' => 'download',
	'post_mime_type' => '',
	'comment_count' => '',
);


$ID = insert_table('wp_posts',$wp_post);

var_dump($ID);

$wp_post1 = array(
	'post_author' => '1',
	'post_date' => $date,
	'post_date_gmt' => $date_gmt,
	'post_content' => $song_pinyin,
	'post_title' => $song_pinyin,
	'post_excerpt' => '',
	'post_status' => 'inherit',
	'comment_status' => 'open',
	'ping_status' => 'closed',
	'post_password' => '',
	'post_name' => $song_pinyin,
	'to_ping' => '',
	'pinged' => '',
	'post_modified' => $date,
	'post_modified_gmt' => $date_gmt,
	'post_content_filtered' => '',
	'post_parent' => $ID,
	'guid' => BASE_URL . $year . '/' . $month . '/' .  $song_pinyin . '.mp3',
	'menu_order' => '0',
	'post_type' => 'attachment',
	'post_mime_type' => 'audio/mpeg',
	'comment_count' => '',
);

$ID_mp3 = insert_table('wp_posts',$wp_post1);

$wp_post2 = array(
	'post_author' => '1',
	'post_date' =>$date,
	'post_date_gmt' => $date_gmt,
	'post_content' => '',
	'post_title' => $song_pinyin,
	'post_excerpt' => '',
	'post_status' => 'inherit',
	'comment_status' => 'open',
	'ping_status' => 'closed',
	'post_password' => '',
	'post_name' => $song_pinyin,
	'to_ping' => '',
	'pinged' => '',
	'post_modified' => $date,
	'post_modified_gmt' => $date_gmt,
	'post_content_filtered' => '',
	'post_parent' => $ID,
	'guid' => BASE_URL . $year . '/' . $month . '/' .  $song_pinyin . '.jpg',
	'menu_order' => '0',
	'post_type' => 'attachment',
	'post_mime_type' => 'image/jpeg',
	'comment_count' => '',
);

$ID_img = insert_table('wp_posts',$wp_post2);

$wp_postmeta = array(
	'post_id' => $ID,
	'meta_key' => '_edd_download_earnings',
	'meta_value' => '0.00',
);

insert_table('wp_postmeta',$wp_postmeta);

$wp_postmeta1 = array(
	'post_id' => $ID,
	'meta_key' => '_edd_download_sales',
	'meta_value' => '1',
);

insert_table('wp_postmeta',$wp_postmeta1);

$wp_postmeta2 = array(
	'post_id' => $ID,
	'meta_key' => 'music_type',
	'meta_value' => 'single',
);

insert_table('wp_postmeta',$wp_postmeta2);

$wp_postmeta3 = array(
	'post_id' => $ID,
	'meta_key' => 'preview_type',
	'meta_value' => 'remote',
);

insert_table('wp_postmeta',$wp_postmeta3);

$meta_value4 = serialize(array(array(
		'preview_media_type' => 'mp3',
            'preview_media_url' => BASE_URL . $year . '/' . $month . '/' .  $song_pinyin . '.mp3'
	)));

$wp_postmeta4 = array(
	'post_id' => $ID,
	'meta_key' => 'preview_url',
	'meta_value' => $meta_value4,
);

$tmp = insert_table('wp_postmeta',$wp_postmeta4,true);
var_dump($tmp);

$meta_value5 = serialize(array(array(
		 'link_text' => '',
           	 'link_url' => ''
	)));

$wp_postmeta5 = array(
	'post_id' => $ID,
	'meta_key' => 'links',
	'meta_value' => $meta_value5,
);

insert_table('wp_postmeta',$wp_postmeta5);

$wp_postmeta6 = array(
	'post_id' => $ID,
	'meta_key' => 'edd_price',
	'meta_value' => '0.00'
);

insert_table('wp_postmeta',$wp_postmeta6);

$meta_value7 = serialize(array());

$wp_postmeta7 = array(
	'post_id' => $ID,
	'meta_key' => 'edd_variable_prices',
	'meta_value' => $meta_value7,
);

insert_table('wp_postmeta',$wp_postmeta7);

$meta_value8 = serialize(array(array(
            'index' => 0,
            'attachment_id' => $ID_mp3,
            'thumbnail_size' => false,
            'name' => $song_name,
            'file' => BASE_URL . $year . '/' . $month . '/' .  $song_pinyin . '.mp3',
            'condition' => 'all'
	)));

$wp_postmeta8 = array(
	'post_id' => $ID,
	'meta_key' => 'edd_download_files',
	'meta_value' => $meta_value8,
);

insert_table('wp_postmeta',$wp_postmeta8);

$wp_postmeta9 = array(
	'post_id' => $ID,
	'meta_key' => '_edd_bundled_products',
	'meta_value' => serialize(array(0)),
);

insert_table('wp_postmeta',$wp_postmeta9);

$wp_postmeta10 = array(
	'post_id' => $ID,
	'meta_key' => '_edd_bundled_products_conditions',
	'meta_value' => serialize(array('all')),
);

insert_table('wp_postmeta',$wp_postmeta10);

$wp_postmeta11 = array(
	'post_id' => $ID,
	'meta_key' => '_thumbnail_id',
	'meta_value' => $ID_img,
);

insert_table('wp_postmeta',$wp_postmeta11);

//_wp_attached_file  _wp_attachment_metadata

$wp_postmeta12 = array(
	'post_id' => $ID_img,
	'meta_key' => '_wp_attached_file',
	'meta_value' => 'edd/' . $year . '/' . $month . '/' .  $song_pinyin . '.jpg',
);

insert_table('wp_postmeta',$wp_postmeta12);

$wp_postmeta13 = array(
	'post_id' => $ID_mp3,
	'meta_key' => '_wp_attached_file',
	'meta_value' => 'edd/' . $year . '/' . $month . '/' .  $song_pinyin . '.mp3',
);

insert_table('wp_postmeta',$wp_postmeta13);






