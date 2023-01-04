<?php
$dsn = 'mysql:dbname=posse;host=db';
$user = 'root';
$password = 'root';

$dbh = new PDO($dsn, $user, $password);


$questions = $dbh->query("SELECT * FROM questions")->fetchAll(PDO::FETCH_ASSOC);
$is_empty=count($questions) === 0;


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE 管理画面ダッシュボード</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="./assets/styles/common.css">
  <link rel="stylesheet" href="./admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="../assets/scripts/common.js" defer></script>
</head>
<body>
  <div class="wrapper">
    <main>
      <div class="menu">
        <a href="./questions/create.php">問題作成</a>

      </div>
      <div class="container">
        <h1 class="page-theme">問題一覧</h1>
        <?php if(!$is_empty){?>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>問題</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($questions as $question){ ?>
            <tr>
              <td id=<?=$question["id"]?>><?=$question["id"]?></td>
              <td>
              <a href="./questions/edit.php?id=<?=$question["id"]?>"><?=$question["content"]?></a><a href="../services/delete_question.php?id=<?=$question["id"]?>"><button>削除</button></a>
              </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
        <?php } else{?>
          問題がありません
        <?php }?>

      </div>

    </main>

  </div>
</body>
</html>