<?php
// check_server.php
// Upload this file to your public_html folder (or where sertifikasi.php is located)
// Access it via https://testing.lspdks.co.id/check_server.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Server Diagnostics</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current Directory: " . __DIR__ . "</p>";

// Check File Structure
echo "<h2>File Structure Check</h2>";

$vendorPath = __DIR__ . '/../vendor/autoload.php';
echo "Checking for vendor/autoload.php at: <code>" . htmlspecialchars($vendorPath) . "</code> ... ";
if (file_exists($vendorPath)) {
    echo "<span style='color:green; font-weight:bold;'>FOUND</span><br>";
    require_once $vendorPath;
    echo "Vendor autoload loaded successfully.<br>";
} else {
    echo "<span style='color:red; font-weight:bold;'>NOT FOUND</span><br>";
    echo "<p><strong>Possible Fix:</strong> Ensure you have uploaded the 'vendor' folder to the directory ABOVE 'public_html'. Or if you uploaded everything to 'public_html', you might need to adjust the paths.</p>";
}

$configPath = __DIR__ . '/../config/config.php';
echo "Checking for config/config.php at: <code>" . htmlspecialchars($configPath) . "</code> ... ";
if (file_exists($configPath)) {
    echo "<span style='color:green; font-weight:bold;'>FOUND</span><br>";
    
    // Try to include config but catch any immediate output/errors
    ob_start();
    include $configPath;
    $output = ob_get_clean();
    
    if (!empty($output)) {
        echo "<div style='background:#f8d7da; padding:10px; border:1px solid #f5c6cb;'><strong>Output from config.php:</strong><br>" . $output . "</div>";
    }
    
    echo "Config file included.<br>";
    
    // Check Database Connection
    echo "<h2>Database Connection Check</h2>";
    if (isset($db_host) && isset($db_name) && isset($username)) {
        echo "Configured Host: " . htmlspecialchars($db_host) . "<br>";
        echo "Configured DB Name: " . htmlspecialchars($db_name) . "<br>";
        echo "Configured User: " . htmlspecialchars($username) . "<br>";
        
        try {
            $dsn = "mysql:host=$db_host;dbname=$db_name";
            $testConn = new PDO($dsn, $username, $password);
            $testConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<span style='color:green; font-weight:bold;'>DATABASE CONNECTION SUCCESSFUL</span><br>";
            
            // Check if tables exist
            $stmt = $testConn->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "Tables found: " . implode(", ", $tables) . "<br>";
            
            if (in_array('skema', $tables)) {
                echo "Table 'skema' exists.<br>";
            } else {
                echo "<span style='color:red; font-weight:bold;'>Table 'skema' MISSING!</span><br>";
            }
            
        } catch (PDOException $e) {
            echo "<span style='color:red; font-weight:bold;'>DATABASE CONNECTION FAILED</span><br>";
            echo "Error: " . $e->getMessage() . "<br>";
            echo "<p><strong>Fix:</strong> Edit <code>config/config.php</code> and update the database credentials (host, username, password, dbname) to match your cPanel database details.</p>";
        }
    } else {
        echo "<span style='color:red;'>Database variables not found in config.php</span><br>";
    }
    
} else {
    echo "<span style='color:red; font-weight:bold;'>NOT FOUND</span><br>";
    echo "<p><strong>Fix:</strong> Ensure 'config' folder is uploaded to the directory ABOVE 'public_html'.</p>";
}

// Check Classes
echo "<h2>Class Check</h2>";
if (class_exists('App\Model\SkemaManager')) {
    echo "Class App\Model\SkemaManager: <span style='color:green;'>FOUND</span><br>";
} else {
    echo "Class App\Model\SkemaManager: <span style='color:red;'>NOT FOUND</span> (Check autoload and file names)<br>";
}

if (class_exists('App\Helper\UrlHelper')) {
    echo "Class App\Helper\UrlHelper: <span style='color:green;'>FOUND</span><br>";
} else {
    echo "Class App\Helper\UrlHelper: <span style='color:red;'>NOT FOUND</span><br>";
}

echo "<hr><p>End of Diagnostics</p>";
?>
