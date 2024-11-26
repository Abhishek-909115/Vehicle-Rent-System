<?php
include '../../config/config.php';

// Fetch all rented vehicles
$query = "SELECT * FROM Vehicle WHERE is_rented = 1";
$stmt = $db->prepare($query);
$stmt->execute();
$rented_vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicle_id = $_POST['vehicle_id'];

    // Update the vehicle's is_rented status to 0 (available)
    $update_query = "UPDATE Vehicle SET is_rented = 0 WHERE vehicle_id = :vehicle_id";
    $update_stmt = $db->prepare($update_query);
    $update_stmt->bindParam(':vehicle_id', $vehicle_id);
    $update_stmt->execute();

    // Optionally, you can set a success message or redirect
    header("Location: return_vehicle.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Vehicle</title>
</head>
<body>
    <h1>Return Vehicle</h1>
    <?php if (isset($_GET['success'])): ?>
        <p style="color: green;">Vehicle returned successfully!</p>
    <?php endif; ?>

    <h2>Rented Vehicles</h2>
    <form method="POST">
        <select name="vehicle_id" required>
            <option value="">Select a vehicle to return</option>
            <?php foreach ($rented_vehicles as $vehicle): ?>
                <option value="<?= htmlspecialchars($vehicle['vehicle_id']); ?>">
                    <?= htmlspecialchars($vehicle['vehicle_id']) . " - " . htmlspecialchars($vehicle['vehicle_type']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Return Vehicle</button>
    </form>
</body>
</html>

