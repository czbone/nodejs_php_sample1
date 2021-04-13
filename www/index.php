<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="/socket.io/socket.io.js"></script>
    <title>Hello</title>
  </head>
  <body>
  	<div class="container">
    <h3>SocketIOテスト</h3>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" class="p-2">
  <div class="row"><div class="col-6">
  <div class="input-group">
    <input type="text" name="message" class="form-control" placeholder="メッセージ">
    <button type="submit" class="btn btn-secondary">送信する</button>
  </div>
  </div></div>
</form>

<h3>受信メッセージ</h3>
<div class="p-2">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = $_POST['message'];
    if (empty($name)) {
        echo "メッセージは空です";
    } else {
        echo $name;
    }
}
?>
</div>
	<script>
    var socket = io();
	socket.on('message', (msg) => {
          //$('#messages').append($('<li>').text(msg));
		  alert('message from server: ' + msg);
    });
    </script>
	</div>
  </body>
</html>
