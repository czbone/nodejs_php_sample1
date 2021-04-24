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

// ルーティングの設定
const router = express.Router()

router.get('/', function (req, res) {
  if (req.session.views) {
    req.session.views++
  } else {
    req.session.views = 1
  }
  res.render('index', { viewcount: req.session.views })
})

app.use('/', router)

// ### サーバ起動 ###
server.listen(PORT, HOSTNAME, () => {
  console.log(`Server running at http://${HOSTNAME}:${PORT}/`)
})
