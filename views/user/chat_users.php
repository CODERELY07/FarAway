<?php
include './../../connection.php';

$user_id = $_GET['user_id'] ?? null;

if (!$user_id) {
    die("User ID is required.");
}

// Get unique chat partners who sent or received messages with the current user
$stmt = $conn->prepare("
    SELECT DISTINCT u.user_id, u.name
    FROM users u
    WHERE u.user_id IN (
        SELECT sender_id FROM messages WHERE reciever_id = ?
        UNION
        SELECT reciever_id FROM messages WHERE sender_id = ?
    ) AND u.user_id != ?
");
$stmt->execute([$user_id, $user_id, $user_id]);
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Chats</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10 px-4">
    <h2 class="text-3xl font-semibold mb-8 text-gray-800">Your Chat Users</h2>

    <?php if (count($users) === 0): ?>
        <p class="text-gray-600">You have no chats yet.</p>
    <?php else: ?>
        <ul class="w-full max-w-md space-y-4">
            <?php foreach ($users as $user): ?>
                <li>
                    <a href="chat.php?user_id=<?php echo $user_id; ?>&with_id=<?php echo $user['user_id']; ?>"
                       class="block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-5 rounded-lg shadow flex items-center gap-3 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M12 4v6" />
                        </svg>
                        Chat with <?php echo htmlspecialchars($user['name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
