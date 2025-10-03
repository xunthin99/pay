<?php
if (getenv('APP_ENV') === 'dev') {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
}

$conn = new mysqli(getenv('MYSQL_HOSTNAME'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['query'])) {
    $sql = $_GET['query'];
    try {
        $result = $conn->query($sql);
        if ($result === true) {
            echo "Query executed successfully.";
        } elseif ($result) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($rows);
        } else {
            echo "No result.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No query provided.";
}
