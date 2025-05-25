<?php 
    require_once './../../connection.php';
    session_start();
    $host_id = $_SESSION['user_id'];

    include './../../partials/head.php'; 
?>

<main class="min-h-screen bg-gray-100 flex">
    
    <!-- Main content -->
    <div class="flex-1  p-10">
          <div class="md:flex md:items-center md:gap-12">
            <a class="block text-teal-600" href="./index.php">
                <span class="sr-only">Home</span>
                <h1 class="logo text-blue-500">Rentify</h1>
            </a>
        
    </div>
        <div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
            <h2 class="text-2xl font-semibold mb-6">Your Chat Contacts</h2>

            <?php
            // Fetch distinct chat partners for this host
            $stmt = $conn->prepare("
                SELECT DISTINCT u.user_id, u.name 
                FROM users u
                WHERE u.user_id != ?
                  AND u.user_id IN (
                      SELECT sender_id FROM messages WHERE reciever_id = ?
                      UNION
                      SELECT reciever_id FROM messages WHERE sender_id = ?
                  )
                ORDER BY u.name ASC
            ");
            $stmt->execute([$host_id, $host_id, $host_id]);
            $chatUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php if (count($chatUsers) === 0): ?>
                <p class="text-gray-600">You have no messages yet.</p>
            <?php else: ?>
                <ul class="divide-y divide-gray-200">
                    <?php foreach ($chatUsers as $user): ?>
                        <li class="py-3 flex items-center justify-between">
                            <div>
                                <span class="font-medium text-gray-900"><?php echo htmlspecialchars($user['name']); ?></span>
                            </div>
                            <a href="./views/user/chat.php?user_id=<?php echo $host_id; ?>&with_id=<?php echo $user['user_id']; ?>" 
                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                Chat
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</main>
