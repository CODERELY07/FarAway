<?php 
require_once './../../connection.php';
session_start();
$host_id = $_SESSION['user_id'];

include './../../partials/head.php'; 
?>

<main class="min-h-screen bg-gray-100">
    <div class="w-full flex flex-col md:flex-row">
        <?php include './../../partials/host/dashabord_sidebar.php';?>

        <div class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
            <?php
            // Count properties for this host
            $stmt = $conn->prepare("SELECT COUNT(*) FROM properties WHERE host_id = ?");
            $stmt->execute([$host_id]);
            $propertyCount = $stmt->fetchColumn();

            // Count bookings (active reservations)
            $stmt = $conn->prepare("
                SELECT COUNT(*) FROM reservation 
                WHERE property_id IN (SELECT property_id FROM properties WHERE host_id = ?)
            ");
            $stmt->execute([$host_id]);
            $bookingCount = $stmt->fetchColumn();

            // Count messages (total related to host)
            $stmt = $conn->prepare("
                SELECT COUNT(*) FROM messages 
                WHERE sender_id = ? OR reciever_id = ?
            ");
            $stmt->execute([$host_id, $host_id]);
            $messageCount = $stmt->fetchColumn();
            ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 gap-y-8 mt-8">
                <!-- Messages -->
                <div class="bg-white rounded-2xl shadow p-6 flex items-center space-x-4 hover:shadow-lg transition">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h6m-6 4h8m2 2l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-800"><?= $messageCount ?></div>
                        <div class="text-gray-500">Messages</div>
                    </div>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded-2xl shadow p-6 flex items-center space-x-4 hover:shadow-lg transition">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-800"><?= $bookingCount ?></div>
                        <div class="text-gray-500">Bookings</div>
                    </div>
                </div>

                <!-- Properties -->
                <div class="bg-white rounded-2xl shadow p-6 flex items-center space-x-4 hover:shadow-lg transition">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10l9-6 9 6v8a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4H9v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-8z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-800"><?= $propertyCount ?></div>
                        <div class="text-gray-500">Properties</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
