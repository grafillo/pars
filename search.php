
<html>
<form  action="search.php" method="post">
    <p><input name="search" placeholder="найти комментарий" type="text" size="30" minlength="3">
    <p><input type="submit" name="submit" value="Найти"></p>
</form>

</html>
<?php


if($_POST['search']){

    $_host = 'localhost';
    $_login = 'root';
    $_password = '';
    $_base_name = 'parse';

    $mysqlconnect =  mysqli_connect($_host, $_login, $_password, $_base_name );
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться к бд: %s\n", mysqli_connect_errno());
        exit();
    }


    $word = $_POST['search'];
    $search = mysqli_query($mysqlconnect ,"SELECT * FROM comments WHERE body LIKE '%$word%'");
    $comments = mysqli_fetch_all($search,MYSQLI_ASSOC);

    foreach ($comments as $comm){

        $post_id = $comm['postId'];
        $title = mysqli_query($mysqlconnect ,"SELECT * FROM posts WHERE id='$post_id' ");
        $title = mysqli_fetch_all($title,MYSQLI_ASSOC);
        echo "<br><br>Заголовок: ".$title[0]['title'];
        echo "<br>Комментарий: ".$comm['body'];

    }




}


?>