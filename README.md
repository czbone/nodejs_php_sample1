# NodejsとPHPの連携サンプル

NginxでNodejsとPHPを同時に稼働させ、セッション情報共有や非同期通信を実行するサンプルプログラムです。

### 動作環境

以下のVagrant環境上で動作します。

https://github.com/czbone/lemp_nodejs_centos7

### サンプル

以下のパスに配置します。

+ Nodejsフロントエンドプログラム(node-server1, node-server2...)

/var/www/node-app

+ PHPフロントエンドプログラム(www)

/var/www/html
