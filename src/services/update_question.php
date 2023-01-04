<?php
require_once '../dbconnect.php';
$db=getDb();

$db->beginTransaction();
try{
  $sql="UPDATE questions SET content=:content,supplement=:supplement WHERE id=:id";
  $stmt=$db->prepare($sql);
  $stmt->bindValue(":id",$_POST["id"]);
  $stmt->bindValue(":content",$_POST["content"]);
  $stmt->bindValue(":supplement",$_POST["supplement"]);
  $stmt->execute();

  
  if(!empty($_FILES['upload_image']['name'])){
    $image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['upload_image']['name'], '.'), 1);
    $image_path = dirname(__FILE__) . '/../assets/img/quiz/' . $image_name;
    move_uploaded_file($_FILES['upload_image']['tmp_name'],$image_path);
    $sql = "UPDATE questions SET image = :image WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":image", $image_name);
    $stmt->bindValue(":id",$_POST["id"]);
    $stmt->execute();
  }
  else{
    echo('失敗kkk');
  }

  $sql="UPDATE choices SET valid = :valid, name=:name WHERE id=:id";
  $stmt=$db->prepare($sql);

  for($i=0; $i < count($_POST["choices"]); $i++){
    $stmt->bindValue(":id",$_POST["question_id"][$i]);
    $stmt->bindValue(":name",$_POST["choices"][$i]);
    $stmt->bindValue(":valid",(int)$_POST["correctChoice"] === $i + 1 ? 1:0);
    $stmt->execute();
  };
  $db->commit();
  header('Location:http://localhost:8080/admin/index.php');
}
catch(Error $e){
  $db->rollback();
  echo'失敗' . $e->getMessage();
};
?>