<!DOCTYPE html>
<html>
<head>
    <title>Migration Lab</title>
</head>
<body>
    <h1>Cloud Migration Lab</h1>
    <h2>Host: <?php echo gethostname(); ?></h2>
    
    <?php 
    $db_host = getenv('DB_HOST') ?: 'localhost';
    $db_name = getenv('DB_NAME') ?: 'migration_lab';
    $db_user = getenv('DB_USER') ?: 'admin';
    $db_pass = getenv('DB_PASS') ?: '12345678';

    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Record visit
        $visitor_id = "student_" . uniqid();
        $stmt = $pdo->prepare("INSERT INTO visitors (student_name) VALUES (?)");
        $stmt->execute([$visitor_id]);

        // Get total visits
        $result = $pdo->query("SELECT COUNT(*) as count FROM visitors");
        $count = $result->fetch()['count'];

        echo "<div style='color: green;'>✅ Database: CONNECTED</div>";
        echo "<p>Total visits: <strong>$count</strong></p>";

    } catch (PDOException $e) {
        echo "<div style='color: red;'>❌ Database ERROR: " . $e->getMessage() . "</div>";
    }
    ?>
</body>
</html>
