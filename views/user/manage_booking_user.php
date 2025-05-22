<?php
require_once './../../connection.php';
session_start();
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die('User not logged in.');
}

// Handle cancel (active reservations)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_reservation'])) {
    $reservationId = $_POST['reservation_id'];

    $stmt = $conn->prepare("SELECT * FROM reservation WHERE reservation_id = ? AND user_id = ?");
    $stmt->execute([$reservationId, $user_id]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reservation) {
        $conn->beginTransaction();

        $insert = $conn->prepare("
            INSERT INTO history (user_id, property_id, reservation_id, status, check_in_date, check_out_date)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $insert->execute([
            $user_id,
            $reservation['property_id'],
            $reservation['reservation_id'],
            'canceled',
            $reservation['check_in_date'],
            $reservation['check_out_date']
        ]);

        $delete = $conn->prepare("DELETE FROM reservation WHERE reservation_id = ?");
        $delete->execute([$reservationId]);

        $conn->commit();
        header("Location: manage_booking_user.php");
        exit;
    }
}

// Handle delete from history
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_history'])) {
    $historyId = $_POST['history_id'];

    // Verify record belongs to this user
    $stmt = $conn->prepare("SELECT * FROM history WHERE history_id = ? AND user_id = ?");
    $stmt->execute([$historyId, $user_id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        $delete = $conn->prepare("DELETE FROM history WHERE history_id = ?");
        $delete->execute([$historyId]);

        header("Location: manage_booking_user.php");
        exit;
    }
}

// Fetch active reservations
$stmt = $conn->prepare("
    SELECT r.*, p.name AS property_name, p.front_photo, p.city, p.street,p.host_id, p.price,
           u.name AS host_name, u.email AS host_email
    FROM reservation r
    JOIN properties p ON r.property_id = p.property_id
    JOIN users u ON p.host_id = u.user_id
    WHERE r.user_id = :user_id
    ORDER BY r.check_in_date DESC
");
$stmt->execute(['user_id' => $user_id]);
$active_reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch history
$stmt2 = $conn->prepare("
    SELECT h.*, p.name AS property_name, p.front_photo, p.city, p.street, p.price,
           u.name AS host_name, u.email AS host_email
    FROM history h
    JOIN properties p ON h.property_id = p.property_id
    JOIN users u ON p.host_id = u.user_id
    WHERE h.user_id = :user_id
    ORDER BY h.check_in_date DESC
");
$stmt2->execute(['user_id' => $user_id]);
$history = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HTML Layout -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6">My Bookings</h1>

    <!-- Active Reservations -->
    <section class="mb-10">
        <h2 class="text-2xl font-semibold mb-4">Active Reservations</h2>
        <?php if (empty($active_reservations)): ?>
            <p class="text-gray-500">No active reservations.</p>
        <?php else: ?>
            <?php foreach ($active_reservations as $res): ?>
                <div class="bg-white p-4 rounded shadow mb-4 flex space-x-4">
                    <img src="./../.<?= htmlspecialchars($res['front_photo']) ?>" class="w-32 h-32 object-cover rounded">
                    <div>
                        <h3 class="text-lg font-bold"><?= htmlspecialchars($res['property_name']) ?></h3>
                        <p class="text-sm text-gray-600"><?= $res['street'] ?>, <?= $res['city'] ?></p>
                        <p class="text-sm text-gray-600">₱<?= number_format($res['price'], 2) ?></p>
                        <p class="text-sm text-gray-600">Status: <span class="text-blue-600"><?= $res['status'] ?></span></p>
                        <p class="text-sm text-gray-600">Check-in: <?= $res['check_in_date'] ?> | Check-out: <?= $res['check_out_date'] ?></p>
                        <form method="POST" onsubmit="return confirm('Cancel this reservation?');" class="mt-2">
                            <input type="hidden" name="reservation_id" value="<?= $res['reservation_id'] ?>">
                            <button name="cancel_reservation" class="text-sm text-red-600 hover:underline">Cancel</button>
                        </form>
                        <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])):?>
                                    <a href="chat.php?user_id=<?php echo $_SESSION['user_id']; ?>&with_id=<?php echo $res['host_id']; ?>" class="bg-blue-600 mt-2 block hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded inline-flex items-center gap-2 shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4l16 8-16 8V4z" />
                                        </svg>
                                        Send Message
                                    </a>
                                <?php endif;?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <!-- Booking History -->
    <section>
        <h2 class="text-2xl font-semibold mb-4">Booking History</h2>
        <?php if (empty($history)): ?>
            <p class="text-gray-500">No booking history.</p>
        <?php else: ?>
            <?php foreach ($history as $h): ?>
                <div class="bg-gray-50 p-4 rounded shadow mb-4 flex space-x-4 items-start">
                    <img src="./../.<?= htmlspecialchars($h['front_photo']) ?>" class="w-32 h-32 object-cover rounded">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold"><?= htmlspecialchars($h['property_name']) ?></h3>
                        <p class="text-sm text-gray-600"><?= $h['street'] ?>, <?= $h['city'] ?></p>
                        <p class="text-sm text-gray-600">₱<?= number_format($h['price'], 2) ?></p>
                        <p class="text-sm text-gray-600">
                            Status:
                            <span class="<?= $h['status'] === 'canceled' ? 'text-red-600' : 'text-green-600' ?>">
                                <?= ucfirst($h['status']) ?>
                            </span>
                        </p>
                        <p class="text-sm text-gray-600">Check-in: <?= $h['check_in_date'] ?> | Check-out: <?= $h['check_out_date'] ?></p>
                    </div>
                    <form method="POST" onsubmit="return confirm('Delete this history record?');">
                        <input type="hidden" name="history_id" value="<?= $h['history_id'] ?>">
                        <button name="delete_history" class="text-red-600 hover:underline text-sm">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</body>
</html>
