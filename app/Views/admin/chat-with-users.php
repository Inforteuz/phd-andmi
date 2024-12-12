<?php 
require_once 'layouts/header.php';
require_once 'layouts/sidebar.php';
require_once 'layouts/topbar.php';
?>

<!-- Begin Page Content --> 
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Onlayn Chat</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- User Selection -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foydalanuvchini tanlang</h6>
                </div>
                <div class="card-body">
                    <!-- Search Input -->
                    <div class="mb-3">
                        <input type="text" id="searchInput" class="form-control" placeholder="Foydalanuvchi qidirish...">
                    </div>
                    <!-- User List -->
                    <div id="userList"></div>
                    <div id="noUserMessage" class="no-user-found" style="display: none;">
                        Foydalanuvchi topilmadi!
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Box -->
        <div class="col-lg-12 d-none" id="chatBox">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary" id="chatHeader">Chat Muloqoti</h6>
                    <!-- Close Button -->
                    <button type="button" class="close" aria-label="Close" id="closeChatButton">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <!-- Chat Container -->
                    <div class="chat-container" id="chatContainer"></div>
                    <!-- Chat Input -->
                    <div class="chat-input mt-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Xabar yozing..." id="chatInput" aria-label="Xabar" aria-describedby="button-send">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="sendMessageBtn"><i class="fas fa-paper-plane"></i> Yuborish</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->

<?php include 'layouts/footer.php'; ?>
<?php include 'layouts/logout-modal.php'; ?>
<?php include 'layouts/scripts.php'; ?>
<script>let usersData=[];function loadUserList(){fetch('fetch_users').then(response=>response.json()).then(data=>{usersData=data.users;updateUserList(usersData);}).catch(err=>{console.error(err);});}function updateUserList(users){const userListContainer=document.getElementById('userList');const noUserMessage=document.getElementById('noUserMessage');userListContainer.innerHTML='';if(users.length===0){noUserMessage.style.display='block';return;}noUserMessage.style.display='none';users.forEach(user=>{const userDiv=document.createElement('div');userDiv.classList.add('user-item','d-flex','align-items-center','mb-3');userDiv.setAttribute('data-user-id',user.user_id);const userImage=document.createElement('img');userImage.src=user.image_url?(user.image_url.startsWith('http')?user.image_url:window.location.origin+'/'+user.image_url):'default-avatar.png';userImage.alt=user.fullname;userImage.classList.add('user-image','rounded-circle','mr-3');userImage.style.width='50px';userImage.style.height='50px';const userInfo=document.createElement('div');userInfo.classList.add('user-info');userInfo.innerHTML=`<p class="user-name font-weight-bold">${user.fullname}</p><small class="text-muted">Ta’lim turi: ${user.degree}</small>`;userDiv.appendChild(userImage);userDiv.appendChild(userInfo);userDiv.addEventListener('click',()=>loadChat(user.user_id));userListContainer.appendChild(userDiv);});}document.getElementById('searchInput').addEventListener('input',function(){const searchQuery=this.value.toLowerCase();const filteredUsers=usersData.filter(user=>user.fullname.toLowerCase().includes(searchQuery));updateUserList(filteredUsers);const noUserMessage=document.getElementById('noUserMessage');noUserMessage.style.display=(filteredUsers.length===0&&searchQuery!=='')?'block':'none';});let selectedUserId=null;function loadChat(userId){selectedUserId=userId;document.getElementById('chatBox').classList.remove('d-none');document.getElementById('chatHeader').innerText='Chat: '+userId;fetch(`fetch_chat/${userId}`).then(response=>response.json()).then(data=>{const chatContainer=document.getElementById('chatContainer');chatContainer.innerHTML='';data.chats.forEach(chat=>{const messageDiv=document.createElement('div');messageDiv.classList.add('chat-message',chat.sender_id===selectedUserId?'user':'admin');messageDiv.innerHTML=`<p>${chat.message}</p><button class="delete-btn" onclick="deleteMessage(${chat.id})"><i class="fas fa-trash"></i></button>`;chatContainer.appendChild(messageDiv);});chatContainer.scrollTop=chatContainer.scrollHeight;}).catch(err=>{console.error(err);});}document.getElementById('sendMessageBtn').addEventListener('click',sendMessage);document.getElementById('chatInput').addEventListener('keydown',function(event){if(event.key==='Enter'){sendMessage();}});function sendMessage(){const messageInput=document.getElementById('chatInput');const message=messageInput.value.trim();if(message===''){return;}fetch('send_message',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({user_id:selectedUserId,message:message})}).then(()=>{messageInput.value='';loadChat(selectedUserId);}).catch(err=>{console.error(err);});}function deleteMessage(chatId){const adminId=<?=json_encode($_SESSION['user_id']);?>;if(confirm('Xabarni o\'chirishni xohlaysizmi?')){fetch('delete_message',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({message_id:chatId,admin_id:adminId})}).then(response=>response.json()).then(data=>{if(data.status==='success'){loadChat(selectedUserId);}else{alert('Xatolik: '+data.message);}}).catch(err=>{console.error(err);alert('Xatolik yuz berdi');});}}document.getElementById('closeChatButton').addEventListener('click',function(){document.getElementById('chatBox').classList.add('d-none');});loadUserList();setInterval(function(){if(selectedUserId){loadChat(selectedUserId);}},3000);</script>
</body>
</html>