<?php
// Include the database connection
include '../config/db.php';

// Fetch transport data from the database
function getTransportData() {
    global $conn;
    $query = "SELECT * FROM transport";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fetch package data from the database
function getPackageData() {
    global $conn;
    $query = "SELECT * FROM packages";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fetch grading data from the database, including crop_name
function getGradeData() {
    global $conn;
    // Updated query to fetch crop_name along with grade details
    $query = "
        SELECT grades.id, grades.grade, grades.inspector_id, grades.inspection_date, crops.crop_name
        FROM grades
        JOIN crops ON grades.crop_id = crops.id
    ";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Generate HTML table rows for transport data
function generateTransportRows($transportData) {
    $rows = '';
    foreach ($transportData as $transport) {
        $rows .= "<tr>
                    <td>{$transport['id']}</td>
                    <td>{$transport['transport_name']}</td>
                    <td>{$transport['tracking_number']}</td>
                    <td>{$transport['latitude']}</td>
                    <td>{$transport['longitude']}</td>
                  </tr>";
    }
    return $rows;
}

// Generate HTML table rows for package data
function generatePackageRows($packageData) {
    $rows = '';
    foreach ($packageData as $package) {
        // Check if 'description' exists in the package data
        $description = isset($package['description']) ? $package['description'] : 'N/A'; // Default to 'N/A' if description is not set

        $rows .= "<tr>
                    <td>{$package['id']}</td>
                    <td>{$package['package_name']}</td>
                    <td>{$description}</td>
                    <td>{$package['created_at']}</td>
                  </tr>";
    }
    return $rows;
}

// Generate HTML table rows for grading data
function generateGradingRows($gradingData) {
    $rows = '';
    foreach ($gradingData as $grade) {
        $rows .= "<tr>
                    <td>{$grade['id']}</td>
                    <td>{$grade['crop_name']}</td> <!-- Now showing crop_name -->
                    <td>{$grade['grade']}</td>
                    <td>{$grade['inspector_id']}</td>
                    <td>{$grade['inspection_date']}</td>
                  </tr>";
    }
    return $rows;
}

// Generate full report content
function generateReportContent($transportData, $packageData, $gradingData) {
    $transportRows = generateTransportRows($transportData);
    $packageRows = generatePackageRows($packageData);
    $gradingRows = generateGradingRows($gradingData);

    return "
        <div class='report-header'>
            <h2>Report Generated on: " . date('Y-m-d') . "</h2>
        </div>

        <h3>Transport Data</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Transport Name</th>
                    <th>Tracking Number</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                </tr>
            </thead>
            <tbody>
                $transportRows
            </tbody>
        </table>

        <h3>Package Data</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Package Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                $packageRows
            </tbody>
        </table>

        <h3>Grading Data</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Crop Name</th> <!-- Showing crop name in grading data -->
                    <th>Grade</th>
                    <th>Inspector ID</th>
                    <th>Inspection Date</th>
                </tr>
            </thead>
            <tbody>
                $gradingRows
            </tbody>
        </table>
    ";
}
?>
