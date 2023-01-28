<?php
/*function send_invitation($email,$token){
  mb_language('Japanese');
  mb_internal_encoding('UTF-8');//mb_send_mail 日本語設定可能

  define('MAIL_TO_ADDRESS',$email);//define(定数名,値)定数を定義する関数　constはクラス内部オンリー
  define('MAIL_SUBJECT','POSSEアプリに招待されています');//件名
  define('MAIL_BODY','こちらから登録してください。http://localhost:8080/admin/auth/signup.php?token=$token&email=$email');
  define('MAIL_FROM_ADDRESS','designare@example.jp');
  define('MAIL_HEADER','Content-type: text/plain; chartest=UTF-8 \n'.//text/plain　テキストメール
                        'From:'. MAIL_FROM_ADDRESS. '\n'.//送信元メールアドレス
                        'Sender:'. MAIL_FROM_ADDRESS. '\n'.//実際の送信元メールアドレス
                        'Return-Path:'. MAIL_FROM_ADDRESS. '\n'.//メールが届かなかったときにメールが送り返される返信先
                        'Reply-To:'. MAIL_FROM_ADDRESS. '\n'.//返信先のメールアドレス
                        'Content-Transfer-Encoding: BASE64\n');//エンコード方式
  return mb_send_mail(MAIL_TO_ADDRESS, MAIL_SUBJECT, MAIL_BODY, MAIL_HEADER,'-f'.MAIL_FROM_ADDRESS);//-fオプションでreturn-pathを強制的に使用　なしだとメールサーバー側に指定されている値が割り当てられている

}*/

function send_invitation($email, $token)
{
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");
   
  define("MAIL_TO_ADDRESS", $email);
  define("MAIL_SUBJECT", "POSSEアプリに招待されています");
  define("MAIL_BODY", "こちらから登録してください。 http://localhost:8080/admin/auth/signup.php?token=$token&email=$email");
  define("MAIL_FROM_ADDRESS", "designare@exmple.jp");
  define("MAIL_HEADER", "Content-Type: text/plain; charset=UTF-8 \n".
                        "From: " . MAIL_FROM_ADDRESS . "\n".
                        "Sender: " . MAIL_FROM_ADDRESS ." \n".
                        "Return-Path: " . MAIL_FROM_ADDRESS . " \n".
                        "Reply-To: " . MAIL_FROM_ADDRESS . " \n".
                        "Content-Transfer-Encoding: BASE64\n");
  return mb_send_mail(MAIL_TO_ADDRESS , MAIL_SUBJECT , MAIL_BODY , MAIL_HEADER, "-f ".MAIL_FROM_ADDRESS);
}
?>