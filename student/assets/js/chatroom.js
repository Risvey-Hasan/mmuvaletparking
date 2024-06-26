document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let messageInput = document.getElementById('message-input');
    let fileInput = document.getElementById('file-input');
    let formData = new FormData();

    if (messageInput.value.trim() !== "") {
        formData.append('message', messageInput.value.trim());
    }

    if (fileInput.files.length > 0) {
        formData.append('file', fileInput.files[0]);
    }

    fetch('helpers/send-message.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let chatBox = document.getElementById('chat-box');
                let newMessage = document.createElement('div');
                newMessage.className = 'chat-message user';

                if (data.message.type === 'text') {
                    newMessage.innerHTML = `<p>${data.message.content}</p>`;
                } else if (data.message.type === 'image') {
                    newMessage.innerHTML = `<img src="uploads/${data.message.content}" alt="Image">`;
                }

                chatBox.appendChild(newMessage);
                messageInput.value = '';
                fileInput.value = '';
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        })
        .catch(error => console.error('Error:', error));
});
