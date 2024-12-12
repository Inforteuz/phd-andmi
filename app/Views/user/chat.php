<?php
require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';

// CSRF Tokenni yaratish
$csrfToken = \System\Security\Csrf::generateToken();
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Onlayn Chat</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Chat Box -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Chat Muloqoti</h6>
                </div>
                <div class="card-body">
                <div class="card-body">
                    <!-- Chat Container -->
                    <div id="chatContainer" class="chat-container" style="height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                        <div id="loadingMessage" class="loading-message" style="display: block;">
                        <p><center><i class="fas fa-circle-notch fa-spin" style="font-size: 18px; color: #3498db;"></i> Chat yuklanmoqda...</center></p>
                        <div class="spinner"></div>
                    </div>
                </div>
                    <!-- Chat Input Section -->
                    <div class="chat-input mt-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="message" placeholder="Xabar yozing..." id="chatInput" aria-label="Xabar" aria-describedby="button-send" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary" type="button" id="sendButton"><i class="fas fa-paper-plane"></i> Yuborish</button>
                            </div>
                        </div>
                        <!-- CSRF Token input -->
                        <input type="hidden" id="csrf_token" value="<?= $csrfToken ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->

<?php include 'layouts/logout-modal.php'; ?>
<?php include 'layouts/scripts.php'; ?>
<script>document.getElementById("sendButton").addEventListener("click", function() {sendMessage();}); document.getElementById("chatInput").addEventListener("keydown", function(event) {if (event.key === "Enter" && !event.shiftKey) {event.preventDefault(); sendMessage();}}); function loadChat() {const loadingMessage = document.getElementById('loadingMessage'); if (loadingMessage) {loadingMessage.style.display = 'none';} fetch('/user/fetchChat').then(response => response.json()).then(data => {const chatContainer = document.getElementById('chatContainer'); chatContainer.innerHTML = ''; const currentUserId = '<?= $_SESSION['user_id'] ?? "" ?>'; if (data.status === 'success') {data.data.forEach(chat => {let userImage = chat.user_image ? chat.user_image : ''; let roleClass = chat.role === 'admin-message' ? 'superadmin' : 'user-message'; const userFullname = chat.fullname || 'Foydalanuvchi'; const imageUrl = chat.user_image ? `${userImage}` : (chat.role === 'admin' ? '<?= $this->base_url("/assets/img/admin.png") ?>' : '<?= $this->base_url("/assets/img/person.png") ?>'); const deleteButton = chat.user_id === currentUserId ? `<button class="btn btn-danger btn-sm ml-2" onclick="deleteMessage('${chat.id}')"><i class="fas fa-trash"> O‘chirish</button></i>` : ''; const messageHTML = `<div class="chat-message ${roleClass}"><div class="d-flex align-items-center mb-2"><img src="<?= $this->base_url('${imageUrl}') ?>" alt="${userFullname}" class="chat-icon rounded-circle" style="width: 40px; height: 40px; margin-right: 10px;"><div><p><strong>${chat.role === 'admin' ? 'Admin' : 'Foydalanuvchi'} (${userFullname}):</strong> ${chat.message} ${deleteButton}</p><span class="text-muted" style="font-size: 0.8rem;">${chat.created_at}</span></div></div></div>`; chatContainer.innerHTML += messageHTML;});}});} function deleteMessage(id) {const csrfToken = document.getElementById('csrf_token').value; if (confirm("Ushbu xabarni o‘chirishni istaysizmi?")) {fetch('/user/deleteMessage', {method: 'POST', headers: {'Content-Type': 'application/x-www-form-urlencoded'}, body: new URLSearchParams({id: id, csrf_token: csrfToken})}).then(response => {if (!response.ok) {throw new Error(`Server xatoligi: ${response.statusText}`);} return response.text();}).then(text => {try {const data = JSON.parse(text); if (data.status === 'success') {loadChat();} else {console.error("Xabarni o‘chirishda xatolik:", data.message);}} catch (e) {console.error("Javobni parse qilishda xatolik:", e); console.error("Javob matni:", text);}}).catch(err => {console.error("Xatolik yuz berdi:", err); console.error("Xatolik tavsifi:", err.stack);});}} function sendMessage() {const chatInput = document.getElementById('chatInput'); const message = chatInput.value.trim(); const csrfToken = document.getElementById('csrf_token').value; if (message !== '') {fetch('/user/sendMessage', {method: 'POST', headers: {'Content-Type': 'application/x-www-form-urlencoded'}, body: new URLSearchParams({message: message, csrf_token: csrfToken})}).then(response => response.json()).then(data => {console.log("sendMessage response:", data); if (data.status === 'success') {chatInput.value = ''; loadChat();} else {console.error("Xato yuz berdi:", data.message);}}).catch(err => {console.error("Xatolik yuz berdi:", err);});}} setInterval(loadChat, 3000);</script>
</body>
</html>