// JavaScript for handling the modal
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('replyModal');
    var span = document.getElementsByClassName('close')[0];

    document.querySelectorAll('.reply-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('message_id').value = this.dataset.id;
            document.getElementById('subject').value = this.dataset.subject;
            document.getElementById('message').value = this.dataset.message;
            modal.style.display = 'block';
        });
    });

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});