<?php
// Include the necessary files
include 'report-functions.php';

// Fetch data from the database
$transportData = getTransportData();
$packageData = getPackageData();
$gradingData = getGradeData();

// Check if report generation is requested
if (isset($_POST['generate_report'])) {
    $reportContent = generateReportContent($transportData, $packageData, $gradingData);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Generation</title>
    <link rel="stylesheet" href="report.css">  <!-- Include custom styles -->
</head>
<body>
    <div class="container">
        <h1>Report Generation</h1>
        
        <!-- Form to trigger report generation -->
        <form action="index.php" method="POST">
            <button type="submit" name="generate_report" class="btn">Generate Report</button>
        </form>

        <?php if (isset($reportContent)): ?>
            <!-- Display the generated report -->
            <div class="report-container">
                <?php echo $reportContent; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
