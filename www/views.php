<?php
require_once('./lib/ExpressSessionHandler.php');
use danfsd\ExpressSessionHandler;
      
// Expressのexpress-sessionモジュールのsecretオプションに合わせる
const SESSION_SECRET = "node.js rules";

$handler = new ExpressSessionHandler(SESSION_SECRET);

// PHPのセッションハンドラをカスタマイズ
session_set_save_handler($handler, true);

// セッション読み込み開始
session_start();

// セッションにexpress-sessionモジュールで使用しているcookieパラメータを付加
$handler->populateSession();

if (isset($_SESSION['views'])) {
    $_SESSION['views']++;
} else {
    $_SESSION['views'] = 1;
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <title>PHPフロントエンド</title>
</head>

<body>
  <div class="d-flex flex-column min-vh-100 align-items-center py-5">
    <div class="card">
      <div class="card-header">
        <h4>PHPフロントエンド</h4>
      </div>
      <div class="card-body">
        <h5>アクセス数：<?php echo $_SESSION['views'];?>
        </h5>
        <input type="button" class="btn btn-primary" value="更新" onclick="window.location.reload();">
      </div>
    </div>
  </div>
  </div>
</body>

</html>