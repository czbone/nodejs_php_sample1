const express = require('express')
const path = require('path')

const HOSTNAME = '127.0.0.1'
const PORT = 3000
const app = express()
const server = require('http').createServer(app)

// ### ルーティングの設定 ###
app.set('views', path.join(__dirname, 'views'))
app.set('view engine', 'ejs')

app.use(express.static(path.join(__dirname, 'public')))

const router = express.Router()

router.get('/', function (request, response) {
  response.render('index', { title: 'Hello!' })
})

router.get('/student', function (request, response) {
  response.render('index', { title: 'Hello, student!' })
})

router.get('/teacher', function (request, response) {
  response.render('index', { title: 'Hello, teacher!' })
})

app.use('/', router)

// ### Socket接続処理 ###
const io = require('socket.io')(server)

io.on('connection', (socket) => {
  console.log('connect by socket')
  socket.emit('message', 'hello')

  socket.on('disconnect', () => {
    console.log('user disconnected')
  })
  socket.on('message', (msg) => {
    io.emit('message', msg);
    console.log('message: ' + msg)
  })
  socket.on('event', (msg) => {
    console.log('event: ' + msg)
  })
})

const redis = require('socket.io-redis')
const adapter = io.adapter(redis({ host: '127.0.0.1', port: 6379 }))

// ### サーバ起動 ###
server.listen(PORT, HOSTNAME, () => {
  console.log(`Server running at http://${HOSTNAME}:${PORT}/`)
})
