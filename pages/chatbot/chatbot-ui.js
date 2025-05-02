document.getElementById('send-btn').addEventListener('click', function () {
    const msg = document.getElementById('chat-input').value;
    fetch('chatbot/chatbot.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'msg=' + encodeURIComponent(msg)
    })
    .then(res => res.text())
    .then(data => {
        const messages = document.getElementById('chat-messages');
        messages.innerHTML += `<p><b>Bạn:</b> ${msg}</p><p><b>Bot:</b> ${data}</p>`;
        document.getElementById('chat-input').value = ''; // Clear input after sending
    });
});
