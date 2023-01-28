<?php
require_once'../dbconnect.php';
require('../response/create_response.php');
session_start();

$db=getDb();

$raw=file_get_contents('php://input');//Postリクエストの生データを取得
$data=(array)json_decode($raw);


if($data["password"]!== $data["password_confirm"]){
  $message=[
    "error"=>[
      "message"=>"パスワードが一致しません"
    ]
  ];
  create_respose(422,$message);
  exit;
}

$sql="SELECT * FROM users WHERE email=:email";
$stmt=$db->prepare($sql);
$stmt->bindValue(':email',$data["email"]);
$stmt->execute();
$user=$stmt->fetch();

$sql="SELECT * FROM user_invitations WHERE token=:token";
$stmt=$db->prepare($sql);
$stmt->bindValue(':token',$data["token"]);
$stmt->execute();
$user_invitation=$stmt->fetch();

$diff=(new DateTime())->diff(new DateTime($user_invitation["invited_at"]));
$is_expired=$diff->days>=1;
print_r($is_expired);
if($is_expired){
  $message=[
    "error"=>[
      "message"=>'招待期限が切れています。管理者に連絡してください。'
    ]
    ];
  create_response(401,$message);
  exit;
}
$is_activated=!is_null($user_invitation["activated_at"]);
if($is_activated){
  $message=[
    "error"=>[
      "message"=>'認証済みです'
    ]
    ];
    create_response(401,$message);
    exit;
}

try{
  $db->beginTransaction();

  $sql="UPDATE users SET name=:name,password=:password WHERE id=:id";
  $stmt=$db->prepare($sql);
  $stmt->bindValue(':name',$data["name"]);
  $stmt->bindValue(':password',password_hash($data["password"],PASSWORD_DEFAULT));//同じパスワードでも違うハッシュ値を作る
  $stmt->bindValue(':id',$user["id"]);
  $stmt->execute();

  $sql="UPDATE user_invitations SET activated_at=:activated_at WHERE user_id=:user_id";
  $stmt=$db->prepare($sql);
  $stmt->bindValue(':user_id',$user["id"]);
  $stmt->bindValue(':activated_at',(new DateTime())->format('Y-m-d H:i:s'));
  $stmt->execute();

  $db->commit();
  $_SEESION['id']=$user["id"];//user識別
  $message = [
    "message" => "ユーザー登録に成功しました"
  ];
  create_response(200, $message);

}
catch(PDOException $e){
  $db->rollback();
  $message = [
    "error" => [
      "message" => $e->getMessage()
    ]
  ];
  create_response(500, $message);


}
?>