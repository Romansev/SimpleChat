const chatId = 1;

let userId;

// Определяем userId
if (localStorage.getItem('userId') != null) {
    userId = localStorage.getItem('userId');
} else {
    userId = (+new Date).toString(36);
    localStorage.setItem('userId', userId);
}

// СОздаем подключение
let conn = new WebSocket('ws://localhost:85');
conn.onopen = function (e) {
    console.log("Connection established!");

    let data = {
        'chatId': chatId,
        'action': 'connection',
        'userId': localStorage.getItem('userId'),
    };

    conn.send(JSON.stringify(data));
};

// При получении сообщения добавляем его в список
conn.onmessage = function (e) {
    console.log('Пришло сообщение: ' + e.data);
    let messages = JSON.parse(e.data);

    for (let i in messages) {
        let msg = messages[i];

        let messBlock = document.getElementById('messages');
        let pNode = document.createElement('p');
        pNode.innerHTML = msg.time + '<b> ' + msg.user + ' </b>: ' + msg.message;

        messBlock.append(pNode);
    }
};

document.getElementById('submit').addEventListener('click', function (event) {
    console.log('click');
}, false);

function sendMsg() {
    let msgField = document.getElementById('message'),
        msg = msgField.value,
        msgObj = {
            'chatId': chatId,
            'user': localStorage.getItem('userId'),
            'action': 'sendMessage',
            'message': msg,
        };

    console.log(msgObj);

    conn.send(JSON.stringify(msgObj));


    msgField.value = '';
}