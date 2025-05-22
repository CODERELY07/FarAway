<?php
include './../../connection.php';

$user_id = $_GET['user_id'] ?? null;
$with_id = $_GET['with_id'] ?? null;

if (!$user_id || !$with_id) {
    die("Both user_id and with_id are required.");
}

// Get the chat partner's name
$stmt = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
$stmt->execute([$with_id]);
$partner = $stmt->fetch();

if (!$partner) {
    die("User not found.");
}
  
// Handle sending new message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message_text'])) {
    $message_text = $_POST['message_text'];
    $insert = $conn->prepare("INSERT INTO messages (message_text, sender_id, reciever_id) VALUES (?, ?, ?)");
    $insert->execute([$message_text, $user_id, $with_id]);
    header("Location: chat.php?user_id=$user_id&with_id=$with_id");
    exit;
}

// Fetch all messages between logged-in user and chat partner
$stmt = $conn->prepare("
    SELECT m.*, u.name AS sender_name
    FROM messages m
    JOIN users u ON m.sender_id = u.user_id
    WHERE (sender_id = ? AND reciever_id = ?) OR (sender_id = ? AND reciever_id = ?)
    ORDER BY sent_at ASC
");
$stmt->execute([$user_id, $with_id, $with_id, $user_id]);
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Chat with <?php echo htmlspecialchars($partner['name']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col justify-center items-center py-10 px-4">
     <div class="mb-10">
          <div class="md:flex md:items-center md:gap-12">
        <a class="block text-3xl text-teal-600" href="./../../index.php">
            <span class="sr-only">Home</span>
            <h1 class="logo text-blue-500">FarAway</h1>
        </a>
    </div>
    </div>
    <div class="w-full max-w-3xl bg-white rounded-lg shadow-lg p-6 flex flex-col h-[600px]">
        
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Chat with <?php echo htmlspecialchars($partner['name']); ?></h2>

        <div id="chat-box" class="flex-1 overflow-y-auto border border-gray-300 rounded-md p-4 mb-6 bg-gray-100">
            <?php if (count($messages) === 0): ?>
                <p class="text-gray-500 text-center mt-12">No messages yet. Start the conversation!</p>
            <?php else: ?>
                <?php foreach ($messages as $msg):
                    $isSender = $msg['sender_id'] == $user_id;
                ?>
                    <div class="mb-4 flex <?php echo $isSender ? 'justify-end' : 'justify-start'; ?>">
                        <div class="max-w-[70%] px-4 py-2 rounded-2xl
                            <?php echo $isSender ? 'bg-blue-600 text-white rounded-br-none' : 'bg-gray-300 text-gray-900 rounded-bl-none'; ?>">
                            <div class="text-sm font-semibold mb-1"><?php echo htmlspecialchars($msg['sender_name']); ?></div>
                            <div class="whitespace-pre-wrap"><?php echo htmlspecialchars($msg['message_text']); ?></div>
                            <div class="text-xs text-gray-700 mt-1 text-right opacity-75"><?php echo date('M d, Y h:i A', strtotime($msg['sent_at'])); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <form method="post" class="flex gap-4">
            <textarea name="message_text" rows="3" required
                class="flex-grow resize-none border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Type your message..."></textarea>
            <button type="submit" class="bg-blue-600 text-white font-semibold px-6 rounded-md hover:bg-blue-700 transition">Send</button>
        </form>
    </div>

    <script>
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</body>
</html>
