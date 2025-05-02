// AI Chatbot for Rwanda Tourism website

document.addEventListener('DOMContentLoaded', function() {
    const chatbotModal = document.getElementById('chatbotModal');
    const chatbotMessages = document.getElementById('chatbot-messages');
    const chatbotInput = document.getElementById('chatbot-input');
    const chatbotSend = document.getElementById('chatbot-send');
    const chatbotVoice = document.getElementById('chatbot-voice');
    
    if (!chatbotModal) return;
    
    // Initialize Speech Recognition
    let recognition;
    try {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        recognition = new SpeechRecognition();
        recognition.continuous = false;
        recognition.lang = 'en-US';
        
        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            chatbotInput.value = transcript;
        };
        
        recognition.onerror = function(event) {
            console.error('Speech recognition error', event.error);
            addBotMessage("Sorry, I couldn't understand that. Please try typing your question.");
        };
    } catch(e) {
        console.error('Speech recognition not supported', e);
        chatbotVoice.style.display = 'none';
    }
    
    // Add welcome message
    addBotMessage("Hello! I'm your Rwanda Tourism Assistant. How can I help you today?");
    
    // Handle send button click
    chatbotSend.addEventListener('click', sendMessage);
    
    // Handle Enter key in input
    chatbotInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
    
    // Handle voice button click
    if (recognition) {
        chatbotVoice.addEventListener('click', function() {
            try {
                recognition.start();
                chatbotVoice.innerHTML = '<i class="fas fa-microphone-slash"></i>';
                chatbotVoice.classList.add('btn-danger');
                chatbotVoice.classList.remove('btn-outline-success');
                
                recognition.onend = function() {
                    chatbotVoice.innerHTML = '<i class="fas fa-microphone"></i>';
                    chatbotVoice.classList.remove('btn-danger');
                    chatbotVoice.classList.add('btn-outline-success');
                };
            } catch(e) {
                console.error('Speech recognition error', e);
                addBotMessage("Voice input is not available right now. Please type your question.");
            }
        });
    }
    
    // Function to send user message
    function sendMessage() {
        const message = chatbotInput.value.trim();
        if (!message) return;
        
        addUserMessage(message);
        chatbotInput.value = '';
        
        // Show typing indicator
        const typingIndicator = document.createElement('div');
        typingIndicator.className = 'message bot-message';
        typingIndicator.innerHTML = '<div class="typing-indicator"><span></span><span></span><span></span></div>';
        chatbotMessages.appendChild(typingIndicator);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        
        // Send message to server (AJAX)
        fetch(`${BASE_URL}/api/chatbot_api.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `message=${encodeURIComponent(message)}`
        })
        .then(response => response.json())
        .then(data => {
            // Remove typing indicator
            chatbotMessages.removeChild(typingIndicator);
            
            if (data.success && data.response) {
                addBotMessage(data.response);
            } else {
                addBotMessage("Sorry, I couldn't process your request. Please try again later.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            chatbotMessages.removeChild(typingIndicator);
            addBotMessage("Sorry, there was an error processing your request.");
        });
    }
    
    // Function to add user message to chat
    function addUserMessage(text) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message user-message';
        messageDiv.innerHTML = `<div class="message-content">${escapeHtml(text)}</div>`;
        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }
    
    // Function to add bot message to chat
    function addBotMessage(text) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message bot-message';
        messageDiv.innerHTML = `<div class="message-content">${text}</div>`;
        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});