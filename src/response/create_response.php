<?php

function create_response($status, $message)
{
  $json = json_encode($message, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);//phpの配列をJSON文字列にするときに日本語をエスケープしない＋返される結果をスペースを使って整える
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=utf-8");
  http_response_code($status);//httpレスポンスコードを設定
  echo $json;
}
?>