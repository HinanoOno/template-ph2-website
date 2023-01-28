<?php
require_once('../dbconnect.php');
require('../mailer/invitation.php');
require('../response/create_response.php');

$db=getDb();
/*$email=$_POST['email'];
print($email);

$sql='SELECT * FROM users WHERE email=:email';
$stmt=$db->prepare($sql);
$stmt->bindValue(':email',$email);
$stmt->execute();
$user=$stmt->fetch();// データの配列の形式を指定　指定なしFETCH_BOTH
print_r($user);

if($user){
  $message=[
    "error"=>[
      "message"=>"招待済みのメールアドレスです"
    ]
  ];
  create_response(422,$message);
  exit;
}
try{
  $db->beginTransaction();
  $stmt=$db->prepare("INSERT INTO users (email) VALUES(:email)");
  $stmt->bindValue(':email',$email);
  $stmt->execute();
  $user_id=$db->lastInsertId();

  $token = hash('sha256',uniqid(rand(),1));//文字列からハッシュ（不可逆）を生成
  $stmt=$db->prepare('INSERT INTO user_invitations(user_id,token) VALUES(:user_id,:token)');
  $stmt->bindValue(':user_id',$user_id);
  $stmt->bindValue(':token',$token);
  $stmt->execute();

  if(send_invitation($email,$token)){
    $message='メールを送信しました';
  }
  else{
    $message='メールの送信に失敗しました';
  }
  $db->commit();
  print_r($message);
  
}catch(PDOException $e){
  $db->rollBack();
  echo'失敗しました';

}*/

$raw = file_get_contents('php://input');
$data = (array)json_decode($raw);


$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $db->prepare($sql);
$stmt->bindValue(":email", $data["email"]);
$stmt->execute();
$user = $stmt->fetch();

if ($user) {
  $message = [
    "error" => [
      "message" => "招待済みのメールアドレスです"
    ]
  ];
  create_response(422, $message);
  exit;
}

try {
  $db->beginTransaction();

  $stmt = $db->prepare("INSERT INTO users(email) VALUES(:email)");
  $stmt->execute([
    "email" => $data["email"]
  ]);
  $user_id = $db->lastInsertId();

  $token = hash('sha256',uniqid(rand(),1));
  $stmt = $db->prepare("INSERT INTO user_invitations(user_id, token) VALUES(:user_id, :token)");
  $stmt->execute([
    "user_id" => $user_id,
    "token" => $token
  ]);
  
  if(send_invitation($data["email"], $token)){
    $message = "メールを送信しました";
  } else {
    $message = "メールの送信に失敗しました";
  }
  $db->commit();
  create_response(201, $message);
} catch(PDOException $e) {
  $db->rollBack();
  $message = [
    "error" => [
      "message" => $e->getMessage()
    ]
  ];
  create_response(500, $message);
  
}


?>