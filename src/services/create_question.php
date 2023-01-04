<?php
require_once'../dbconnect.php';
$db=getDb();

/*if(isset($_POST['upload'])){
  $image = uniqid(mt_rand(), true);//ファイル名をユニーク化
  $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
  $file = "images/$image";
  $sql = "INSERT INTO images(name) VALUES (:image)";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':image', $image, PDO::PARAM_STR);
  if (!empty($_FILES['image']['name'])) {//ファイルが選択されていれば$imageにファイル名を代入
    move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $image);//imagesディレクトリにファイル保存
    if (exif_imagetype($file)) {//画像ファイルかのチェック
      $message = '画像をアップロードしました';
      $stmt->execute();
    } else {
      $message = '画像ファイルではありません';
    }
  }
}*/
/*if(!empty($_FILES)){
  $filename=$_FILES['upload_image']['name'];
  
  $uploaded_path="/../assets/img/quiz/".$filename;
  echo $uploaded_path;
  $result=move_uploaded_file($_FILES['upload_image']['tmp_name'],$uploaded_path);
  if($result){
    $MSG='成功:'.$filename;
    $img_path=$uploaded_path;
  }
  else{
    $MSG='失敗:'.$_FILES['upload_image']['error'];
  }
}else{
  $MSG='画像を選択してください';
}*/


//画像ファイルにユニーク名をつける
$image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['upload_image']['name'], '.'), 1); //substr一部をsttrchr文字が最後に出てくるところ 最後の.が現れる場所を取得し、それ以降の文字を取得＝拡張子をユニーク名にくっつける
$image_path = dirname(__FILE__) . '/../assets/img/quiz/' . $image_name;
 
if(!empty($_FILES['upload_image']['name'])){
  move_uploaded_file($_FILES['upload_image']['tmp_name'],$image_path);
}
else{
  echo('失敗');
}



$stmt = $db -> prepare('INSERT INTO questions(content,image,supplement) VALUES(:content,:image,:supplement)');
$stmt->bindValue(":content", $_POST["content"]);
$stmt->bindValue(":image",$image_name);
$stmt->bindValue(":supplement", $_POST["supplement"]);
$stmt->execute();


$stmt = $db->prepare("INSERT INTO choices(name, valid, question_id) VALUES(:name, :valid, :question_id)");
$lastInsertId= $db->lastInsertId();
for($i=0; $i < count($_POST["choices"]); $i++){
  $stmt->bindValue(":name",$_POST["choices"][$i]);
  $stmt->bindValue(":valid",(int)$_POST["correctChoice"] === $i + 1 ? 1:0);
  $stmt->bindValue(":question_id",$lastInsertId);
  $stmt->execute();
};
header("Location: ". "http://localhost:8080/admin/index.php");
?>