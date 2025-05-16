
<?php 
require_once './../../connection.php';
session_start();
$host_id = $_SESSION['user_id'];

try {
    // Pending bookings
    $stmt = $conn->prepare("
        SELECT r.reservation_id, r.check_in_date, r.check_out_date, r.user_id, u.name AS guest_name, p.name AS property_name
        FROM reservation r
        JOIN properties p ON r.property_id = p.property_id
        JOIN users u ON r.user_id = u.user_id
        WHERE p.host_id = :host_id
        AND r.status = 'pending'
    ");
    $stmt->execute([':host_id' => $host_id]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Booked reservations
    $smtp = $conn->prepare("
        SELECT r.reservation_id, r.check_in_date, r.check_out_date, r.user_id, u.name AS guest_name, p.name AS property_name
        FROM reservation r
        JOIN properties p ON r.property_id = p.property_id
        JOIN users u ON r.user_id = u.user_id
        WHERE p.host_id = :host_id
        AND r.status = 'booked'
    ");
    $smtp->execute([':host_id' => $host_id]);
    $booked = $smtp->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

include './../../partials/head.php'; 
?>

<main class="min-h-screen bg-gray-100">
    <div class="w-full flex flex-col md:flex-row">
        <?php include './../../partials/host/dashabord_sidebar.php';?>
        <div class="flex-1 px-2 sm:px-6 md:px-8 py-6">
            <h1 class="text-xl sm:text-2xl font-bold mb-4">Pending Reservations</h1>

            <?php if (count($reservations) > 0): ?>
                <div class="overflow-x-auto mb-8 rounded-lg shadow">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg text-sm sm:text-base">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-2 sm:px-4 py-2 text-left">Reservation ID</th>
                                <th class="px-2 sm:px-4 py-2 text-left">Guest Name</th>
                                <th class="px-2 sm:px-4 py-2 text-left">Property</th>
                                <th class="px-2 sm:px-4 py-2 text-left">Check-in</th>
                                <th class="px-2 sm:px-4 py-2 text-left">Check-out</th>
                                <th class="px-2 sm:px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $r): ?>
                                <tr id="row-<?= $r['reservation_id'] ?>" class="border-t hover:bg-gray-50">
                                    <td class="px-2 sm:px-4 py-2"><?= $r['reservation_id'] ?></td>
                                    <td class="px-2 sm:px-4 py-2"><?= $r['guest_name'] ?></td>
                                    <td class="px-2 sm:px-4 py-2"><?= $r['property_name'] ?></td>
                                    <td class="px-2 sm:px-4 py-2"><?= $r['check_in_date'] ?></td>
                                    <td class="px-2 sm:px-4 py-2"><?= $r['check_out_date'] ?></td>
                                    <td class="px-2 sm:px-4 py-2 space-x-2">
                                        <button class="action-btn bg-green-500 text-white px-2 sm:px-3 py-1 rounded hover:bg-green-600 transition text-xs sm:text-sm" data-id="<?= $r['reservation_id'] ?>" data-action="accept">Accept</button>
                                        <button class="action-btn bg-red-500 text-white px-2 sm:px-3 py-1 rounded hover:bg-red-600 transition text-xs sm:text-sm" data-id="<?= $r['reservation_id'] ?>" data-action="decline">Decline</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-gray-600 mb-8">No pending reservations.</p>
            <?php endif; ?>

            <h1 class="text-xl sm:text-2xl font-bold mb-4">All Booked</h1>
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg text-sm sm:text-base">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-2 sm:px-4 py-2 text-left">Reservation ID</th>
                            <th class="px-2 sm:px-4 py-2 text-left">Guest Name</th>
                            <th class="px-2 sm:px-4 py-2 text-left">Property</th>
                            <th class="px-2 sm:px-4 py-2 text-left">Check-in</th>
                            <th class="px-2 sm:px-4 py-2 text-left">Check-out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($booked as $b): ?>
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-2 sm:px-4 py-2"><?= $b['reservation_id'] ?></td>
                                <td class="px-2 sm:px-4 py-2"><?= $b['guest_name'] ?></td>
                                <td class="px-2 sm:px-4 py-2"><?= $b['property_name'] ?></td>
                                <td class="px-2 sm:px-4 py-2"><?= $b['check_in_date'] ?></td>
                                <td class="px-2 sm:px-4 py-2"><?= $b['check_out_date'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".action-btn").click(function() {
                const id = $(this).data("id");
                const action = $(this).data("action");

                $.ajax({
                    url: 'controller/booking/manage_booking.php',
                    type: 'POST',
                    data: { reservation_id: id, action: action },
                    success: function(response) {
                        alert(response);
                        $("#row-" + id).remove(); // remove row on success
                    },
                    error: function(xhr) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            });
        });
    </script>
</main>
