<?php
session_start();
$_SESSION=array();//セッション変数を全て削除
session_destroy();//セッションの登録データを削除
//echo'ログアウト成功';

header("Access-Control-Allow-Origin: *");//どのサイトでもレスポンス共有
header("Content-Type: application/json; charset=utf-8");
http_response_code(204);
?>