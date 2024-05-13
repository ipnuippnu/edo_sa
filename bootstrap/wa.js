const path = require('path');
const { Client, LocalAuth } = require('whatsapp-web.js');
const app = require('express')();
const server = require('http').createServer(app)
const io = require('socket.io')(server)
const multer = require('multer')

const port = process.env.PORT || 8080;

const wwebVersion = '2.2412.54';
const client = new Client({
    authStrategy: new LocalAuth({
        dataPath: path.join(__dirname, '../storage/framework/wa-web'),
    }),
    webVersionCache: {
        type: 'remote',
        remotePath: `https://raw.githubusercontent.com/wppconnect-team/wa-version/main/html/${wwebVersion}.html`,
    },
    puppeteer: {
        headless: false
    }
});

let qr = null;
let status = "LOADING";

client.on('qr', (data) => {
    status = "PLEASE SCANN QR!"
    qr = data
});

client.on('ready', () => {  
    status = "READY!"
    qr = null



    app.post('/send', upload.single('img'), async function(req, res)
    {
        await client.sendMessage(req.body.phone, req.body.message)
        res.send("Sukses")
    })

});

client.initialize();

io.on('connection', socket => {
    let currentQR = qr
    let currentStatus = status

    socket.emit('qr', currentQR)
    socket.emit('status', currentStatus)

    setInterval(() => {

        if(currentQR != qr)
        {
            currentQR = qr
            socket.emit('qr', currentQR)
        }
        
        if(currentStatus != status)
        {
            currentStatus = status
            socket.emit('status', currentStatus)
        }

    },1000)
})

app.get('/', function(req, res) {
    res.sendFile(path.join(__dirname, '../resources/views/wa-web/index.html'))
});

const upload = multer({dest: path.join(__dirname, '../storage/framework/axios-uploads')})

server.listen(port, function(){
    console.log('HTTP Server RUN')
})
