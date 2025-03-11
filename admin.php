<?php
// Connect to database
$servername = "localhost";
$username = "root"; // Default for XAMPP
$password = ""; // Default for XAMPP
$database = "skillcrafters";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Course Addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_course"])) {
    $course_name = htmlspecialchars($_POST["course_name"]);
    $sql = "INSERT INTO courses (name) VALUES ('$course_name')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Course added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding course');</script>";
    }
}

// Handle Course Deletion
if (isset($_GET["delete_course"])) {
    $id = $_GET["delete_course"];
    $sql = "DELETE FROM courses WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Course deleted!');</script>";
    }
}

// Fetch courses
$courses = $conn->query("SELECT * FROM courses");

// Fetch messages
$messages = $conn->query("SELECT * FROM contact_messages");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SkillCrafters</title>
    <link rel="stylesheet" href="admin_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="navbar navbar-dark bg-blue-600 shadow-lg">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Admin Panel</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-2xl font-bold mb-4">Manage Courses</h2>
        <form method="POST" class="mb-3">
            <input type="text" name="course_name" class="form-control" placeholder="Enter Course Name" required>
            <button type="submit" name="add_course" class="btn btn-primary mt-2">Add Course</button>
        </form>

        <ul class="list-group">
            <?php while ($row = $courses->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= $row["name"] ?>
                    <a href="?delete_course=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>

        <h2 class="text-2xl font-bold mt-5">Student Messages</h2>
        <table class="table">
            <tr><th>Name</th><th>Email</th><th>Message</th></tr>
            <?php while ($msg = $messages->fetch_assoc()): ?>
                <tr>
                    <td><?= $msg["name"] ?></td>
                    <td><?= $msg["email"] ?></td>
                    <td><?= $msg["message"] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <footer class="bg-gray-800 text-white text-center py-3 mt-5">
        <p>&copy; 2025 SkillCrafters. All Rights Reserved.</p>
    </footer>

</body>
</html>

<?php $conn->close(); ?>