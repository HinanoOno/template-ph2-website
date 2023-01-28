<?php
require_once('../dbconnect.php');
require('../response/create_response.php');
$db=getDb();
$raw = file_get_contents('php://input');
$data = (array)json_decode($raw);

$sql="SELECT * FROM users WHERE email=:email";
$stmt=$db->prepare($sql);
$stmt->bindValue(':email',$data["email"]);
$stmt->execute();
$user=$stmt->fetch();

if(!$user||!password_verify($data["password"],$user["password"])){//指定したハッシュがパスワードにマッチするか
  $message=[
    "error"=>[
      "message"=>"入力情報が正しくありません"
    ]
  ];
  create_response(401,$message);
  exit;
}

session_start();
$_SESSION["id"]=$user["id"];
$_SESSION["name"]=$user["name"];
$message=[
  "message" => $_SESSION["id"]
];
create_response(200,$message);

?>