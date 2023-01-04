<?php
  $dsn = 'mysql:dbname=posse;host=db';
  $user = 'root';
  $password = 'root';

  $dbh = new PDO($dsn, $user, $password);


  $questions = $dbh->query("SELECT * FROM questions")->fetchAll(PDO::FETCH_ASSOC);
  $id = $_GET['id'];
  $dbh -> beginTransaction();
  try {
    $sql = "DELETE FROM choices WHERE question_id = :question_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":question_id", $id);
    $stmt->execute();


    $sql = "DELETE FROM questions WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    $dbh -> commit();
    header('Location: /admin/index.php');
    echo('削除完了');
    exit();
    
  } catch (PDOException $e) {
    $pdo->rollBack();

    echo'エラー:'. $e -> getMessage();
  }

?>
