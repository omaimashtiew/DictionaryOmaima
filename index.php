


<?php
session_start();
include('db_config.php');

// Debugging: Check if the session is working
if (session_id() == '') {
    echo "Session not started.<br>";
} else {
    echo "Session started.<br>";
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Check POST data
    var_dump($_POST);

    // Retrieve the word from the form and sanitize
    $word = mysqli_real_escape_string($conn, $_POST['word']); 

    // Perform the query
    $sql = "SELECT definition FROM words WHERE word = '$word'";
    $result = $conn->query($sql);

    // Check if query is successful
    if ($result === false) {
        echo "Query failed: " . $conn->error;
        exit;
    }

    // Prepare the result message
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $definition = "Definition of '$word': " . $row['definition'];
    } else {
        $definition = "Word not found in the dictionary.";
    }

    // Store result in session and redirect
    $_SESSION['definition'] = $definition;

    // Debugging: Check session data
    var_dump($_SESSION);

    header("Location: index.php");
    exit;
}

// Check if result is available in session after redirect
if (isset($_SESSION['definition'])) {
    $message = $_SESSION['definition'];
    unset($_SESSION['definition']); // Clear session after displaying
}
?>

<!-- HTML Form for submitting word -->
<form action="index.php" method="post">
    <input type="text" name="word" placeholder="Enter word" required>
    <input type="submit" value="Submit">
</form>

<!-- Display result after redirect -->
<?php
if (isset($message)) {
    echo $message;
}
?>
