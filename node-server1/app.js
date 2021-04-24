const express = require('express')
const path = require('path')

const HOSTNAME = '127.0.0.1'
const PORT = 3000
const app = express()
const server = require('http').createServer(app)
const cookieParser = require('cookie-parser')
const session = require('express-session')
const redis = require('redis')
const RedisStore = require('connect-redis')(session)

// ### ルーティングの設定 ###
app.set('views', path.join(__dirname, 'views'))
app.set('view engine', 'ejs')

app.use(express.static(path.join(__dirname, 'public')))
app.use(cookieParser())

const redisClient = redis.createClient({ host: HOSTNAME, port: 6379 })
const sessionConfig = {
  store: new RedisStore({
    client: redisClient,
    // this is the default prefix used by redis-session-php
    prefix: 'session:php:'
  }),
  // use the default PHP session cookie name
  name: 'PHPSESSID',
  secret: 'node.js rules',
  resave: false,
  saveUninitialized: false
}
const sessionMiddleware = session(sessionConfig)
app.session = sessionMiddleware
app.use(sessionMiddleware)

const router = express.Router()

router.get('/', function (req, res) {
  // response.render('index', { title: 'Hello!' })
  // response.session.nodejs = 'Hello from node.js!'
  // response.send('<pre>' + JSON.stringify(response.session, null, '    ') + '</pre>')
  if (req.session.views) {
    req.session.views++
  } else {
    req.session.views = 1
  }
  res.render('index', { title: JSON.stringify(req.session, null, '    ') })
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

const socketRedis = require('socket.io-redis')
const adapter = io.adapter(socketRedis({ host: HOSTNAME, port: 6379 }))

io.on('connection', (socket) => {
  console.log('connect by socket')
  // socket.emit('message', 'hello')

  socket.on('disconnect', () => {
    console.log('user disconnected')
  })
  /* socket.on('message', (msg) => {
    console.log('get message....')
    io.emit('message', msg)
    console.log('message: ' + msg)
  })
  socket.on('event', (msg) => {
    console.log('get event....')
    console.log('event: ' + msg)
  }) */
})

// ### サーバ起動 ###
server.listen(PORT, HOSTNAME, () => {
  console.log(`Server running at http://${HOSTNAME}:${PORT}/`)
})
