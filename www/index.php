<!doctype html>
<html lang="ja">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <script src="/socket.io/socket.io.js"></script>
  <title>Hello</title>
</head>

<body>
  <div class="container py-5 d-grid gap-3">
    <h3>送信テスト(SocketIO)</h3>
    <form method="post" class="mb-5">
      <div class="row">
        <div class="col-6">
          <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="メッセージ">
            <button type="submit" class="btn btn-secondary">送信する</button>
          </div>
        </div>
      </div>
    </form>

    <h3>受信メッセージ</h3>
    <div>
      <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = $_POST['message'];
    if (empty($name)) {
        echo "メッセージは空です";
    } else {
        echo $name;

        require_once('./TinyRedisClient.php');
        require_once('./Emitter.php');
        $redis = new TinyRedisClient('127.0.0.1:6379');
        //$redis = new \Redis(); // Using the Redis extension provided client
        //$redis->connect('127.0.0.1', '6379');
        $emitter = new SocketIO\Emitter($redis);
        //$emitter->emit('event', 'payload str');
        $emitter->emit('message', $name);
        //$emitter->emit('event', array('property' => 'much value', 'another' => 'very object'));
    }
}
      ?>
    </div>
    <script>
      var socket = io();
      socket.on('message', (msg) => {
        alert('message from server: ' + msg)
      })
    </script>
  </div>
</body>

</html>