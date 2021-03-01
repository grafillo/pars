<?php
$_host = 'localhost';
$_login = 'root';
$_password = '';
$_base_name = 'parse';

$mysqlconnect =  mysqli_connect($_host, $_login, $_password, $_base_name );
if (mysqli_connect_errno()) {
    printf("Не удалось подключиться к бд: %s\n", mysqli_connect_errno());
    exit();
}


function Parse ($content,$begin,$end,$number_cut=0){

    $begin_position = strpos($content,$begin)+1;
    $content_cut  = substr($content,$begin_position); // обрезает
    $end_position = strpos($content_cut,$end)+$number_cut;
    $cuting_element = substr($content_cut,0,$end_position);

    return $cuting_element;

}


$post_url = "https://jsonplaceholder.typicode.com/posts";
$post_content = file_get_contents($post_url);
$number_post=0;


while (strpos($post_content,"{")!=false) {
    $post = Parse($post_content, "{", "}", 1);
    $user_id = Parse($post, ":", ",");
    $post = substr($post, strpos($post, ",") + 1); //обрезаем пост
    $id = Parse($post, ":", ",");
    $post = substr($post, strpos($post, ",") + 1); //обрезаем пост
    $title = Parse($post, ":", ",");
    $post = substr($post, strpos($post, ",") + 1); //обрезаем пост
    $body = Parse($post, ":", '}');
    $post_content = substr($post_content, strpos($post_content, $body));
    $mysql = mysqli_query($mysqlconnect ,"INSERT INTO posts SET id='$id',user_id='$user_id',title='$title',body='$body'  ");
    $number_post++;
}

echo "Загружено ".$number_post. " записей ";

$post_url = "https://jsonplaceholder.typicode.com/comments";
$post_content = file_get_contents($post_url);
$number_comments=0;


while (strpos($post_content,"{")!=false) {
$post = Parse($post_content, "{", "}", 1);
$post_id = Parse($post, ":", ",");
$post = substr($post, strpos($post, ",") + 1); //обрезаем пост
$id = Parse($post, ":", ",");
$post = substr($post, strpos($post, ",") + 1); //обрезаем пост
$name = Parse($post, ":", ",");
$post = substr($post, strpos($post, ",") + 1); //обрезаем пост
$email =  Parse($post, ":", ",");
$post = substr($post, strpos($post, ",") + 1); //обрезаем пост
$body = Parse($post, ":", '}');
$post_content = substr($post_content, strpos($post_content, $body));
$mysql = mysqli_query($mysqlconnect ,"INSERT INTO comments SET id='$id',postid='$post_id',name='$name',email='$email',body='$body'  ");
    $number_comments++;
}

echo "<br>Загружено ".$number_comments." комментариев ";


?>