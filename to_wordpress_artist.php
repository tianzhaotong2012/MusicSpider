<?php
require_once('config.php');
require_once('login.php');
require_once("mysql_wordpress.php");

$artist_name = $artist_name;
$artist_pinyin = $submit_pinyin;
$record = $record;
date_default_timezone_set("Etc/GMT+8");
$date = date("Y-m-d h:m:s",time());
date_default_timezone_set("Etc/GMT");
$year = date("Y",time());
$month = date("m",time());
$date_gmt = date("Y-m-d h:m:s",time());
//$base_url = "http://172.16.113.148/musicleft/wp-content/uploads/edd/";

$wp_terms = array(
	'name' => $artist_name,
	'slug' => $artist_pinyin,
	'term_group' => '0',
);

$trem_id = insert_table('wp_terms',$wp_terms);

var_dump($trem_id);

$wp_post = array(
	'post_author' => '1',
	'post_date' => $date,
	'post_date_gmt' => $date_gmt,
	'post_content' => '',
	'post_title' => $artist_pinyin,
	'post_excerpt' => '',
	'post_status' => 'inherit',
	'comment_status' => 'open',
	'ping_status' => 'closed',
	'post_password' => '',
	'post_name' =>$artist_pinyin,
	'to_ping' => '',
	'pinged' => '',
	'post_modified' => $date,
	'post_modified_gmt' => $date_gmt,
	'post_content_filtered' => '',
	'post_parent' => '0',
	'guid' =>  BASE_URL . $year . '/' . $month . '/' .   $artist_pinyin . '.jpg',
	'menu_order' => '0',
	'post_type' => 'attachment',
	'post_mime_type' => 'image/jpeg',
	'comment_count' => '0',
);

$ID_img = insert_table('wp_posts',$wp_post);


$wp_postmeta = array(
	'post_id' => $ID_img,
	'meta_key' => '_wp_attached_file',
	'meta_value' => 'edd/'. $year . '/' . $month . '/' .   $artist_pinyin . '.jpg',
);

insert_table('wp_postmeta',$wp_postmeta);

$wp_termmeta = array(
	'term_id' => $trem_id,
	'meta_key' => 'photo',
	'meta_value' => $ID_img,
);

insert_table('wp_termmeta',$wp_termmeta);

$wp_termmeta1 = array(
	'term_id' => $trem_id,
	'meta_key' => 'content',
	'meta_value' => addslashes($record),
);

insert_table('wp_termmeta',$wp_termmeta1);

$wp_term_taxonomy = array(
	'term_id' => $trem_id,
	'taxonomy' => 'download_artist',
	'description' => '',
	'parent' => 0,
	'count' => 0,
);

insert_table('wp_term_taxonomy',$wp_term_taxonomy);
