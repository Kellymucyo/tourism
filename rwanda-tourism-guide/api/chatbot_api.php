<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

// Check if message is provided
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($message)) {
    echo json_encode(['success' => false, 'error' => 'No message provided']);
    exit();
}

// Prepare the response
$response = [
    'success' => true,
    'response' => ''
];

// Simple FAQ responses (in a real app, you'd use OpenAI API)
$faq = [
    'hello|hi|hey' => 'Hello! How can I help you with your Rwanda travel plans?',
    'visa|entry requirements' => 'Most visitors can obtain a visa on arrival in Rwanda for $50 USD (valid for 30 days). An East African Tourist Visa ($100 USD) allows travel between Rwanda, Kenya, and Uganda. All visitors need a passport valid for at least 6 months and a yellow fever vaccination certificate.',
    'best time to visit|when to go' => 'The best time to visit Rwanda is during the dry seasons: June to September and December to February. These months offer the best conditions for gorilla trekking and wildlife viewing.',
    'currency|money' => 'The currency in Rwanda is the Rwandan Franc (RWF). US dollars are widely accepted. Credit cards are accepted in major hotels and restaurants. ATMs are available in cities.',
    'safety|is rwanda safe' => 'Rwanda is one of the safest countries in Africa for tourists. Normal precautions against petty theft are recommended. The emergency number is 112.',
    'gorilla trekking|mountain gorillas' => 'Gorilla trekking is available in Volcanoes National Park. Permits cost $1,500 per person and should be booked in advance. Treks can take 2-8 hours depending on gorilla location.',
    'language|what language' => 'The official languages are Kinyarwanda, English, French, and Swahili. English is widely spoken in tourist areas.',
    'thank you|thanks' => "You're welcome! Is there anything else I can help you with?",
    'goodbye|bye' => 'Goodbye! Have a wonderful time in Rwanda!'
];

// Check if message matches any FAQ
$matched = false;
foreach ($faq as $keywords => $answer) {
    $keywords = explode('|', $keywords);
    foreach ($keywords as $keyword) {
        if (stripos($message, $keyword) !== false) {
            $response['response'] = $answer;
            $matched = true;
            break 2;
        }
    }
}

// If no match found, use a generic response
if (!$matched) {
    $response['response'] = "I'm your Rwanda Tourism Assistant. I can help with information about visas, best times to visit, currency, safety, gorilla trekking, and more. Please ask me a specific question about traveling in Rwanda.";
}

echo json_encode($response);
?>