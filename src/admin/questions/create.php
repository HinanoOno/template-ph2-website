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
      <div class="container">
        <h1 class="page-theme mb-4">問題作成</h1>
        <form action="../../services/create_question.php" method="post" enctype="multipart/form-data">
          <div class="form-item mb-4">
            <label for="question" class="form-label">問題文:</label>
            <input type="text" name="content" id="question" class="form-control required" placeholder="問題文を入力してください">
          </div>
          <div class="form-item mb-4">
            <label class="form-label">選択肢:</label>
            <input type="text" name="choices[]" class="form-control required" placeholder="選択肢1を入力してください">
            <input type="text" name="choices[]" class="form-control required" placeholder="選択肢2を入力してください">
            <input type="text" name="choices[]" class="form-control required" placeholder="選択肢3を入力してください">
          </div>
          <div class="form-item mb-4"> 
            <label class="form-label">正解の選択肢:</label>
            <div class="form-check">
              <input type="radio" name="correctChoice" id="correctChoice1" value="1">
              <label for="correctChoice1">選択肢1</label>
            </div>
            <div class="form-check">
              <input type="radio" name="correctChoice" id="correctChoice2" value="2">
              <label for="correctChoice2">選択肢2</label>
            </div>
            <div class="form-check">
              <input type="radio" name="correctChoice" id="correctChoice3" value="3">
              <label for="correctChoice3">選択肢3</label>
            </div>


          </div>
          <div class="form-item mb-4">
            <label for="upload_image" class="form-label">問題の画像</label>
            <input type="file" name="upload_image" id="upload_image" class="form-control required" placeholder="画像を追加してください">

          </div>
          <?php
            if(!empty($_FILES)){
              $filename=$_FILES['upload_image']['name'];
              $uploaded_path="/../assets/img/quiz".$filename;
              $result=move_uploaded_file($_FILES['upload_image'],$uploaded_path);
              if($result){
                $MSG='成功:'.$filename;
                $img_path=$uploaded_path;
              }
              else{
                $MSG='失敗:'.$_FILES['upload_image']['error'];
              }
            }else{
              $MSG='画像を選択してください';
            }
          ?>
          <p><?php if(!empty($MSG)) echo $MSG;?></p>
          <div class="form-item mb-4">
            <label for="supplement" class="form-label">補足:</label>
            <input type="text" name="supplement" id="supplement" class="form-control" placeholder="補足を入力してください">

          </div>
          <button type="submit" class="submit-btn" >問題作成</button>
        </form>
      </div>
    </main>
  </div>
</body>
