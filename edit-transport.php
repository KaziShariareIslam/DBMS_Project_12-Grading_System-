<?php
session_start();
include '../config/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$transport_id = $_GET['id'];

// Fetch the transport record to edit
$query = "SELECT * FROM transport WHERE id = '$transport_id'";
$result = mysqli_query($conn, $query);
$transport = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_transport_name = mysqli_real_escape_string($conn, $_POST['transport_name']);
    $new_tracking_number = mysqli_real_escape_string($conn, $_POST['tracking_number']);
    
    $query = "UPDATE transport SET transport_name = '$new_transport_name', tracking_number = '$new_tracking_number' WHERE id = '$transport_id'";
    if (mysqli_query($conn, $query)) {
        header('Location: index.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transport</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Transport</h1>
        <form action="edit-transport.php?id=<?php echo $transport['id']; ?>" method="POST">
            <input type="text" name="transport_name" value="<?php echo $transport['transport_name']; ?>" required>
            <input type="text" name="tracking_number" value="<?php echo $transport['tracking_number']; ?>" required>
            <button type="submit" class="btn">Update Transport</button>
        </form>
    </div>
</body>
</html>
