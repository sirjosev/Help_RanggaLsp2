<?php

$basePart1 = 'sql/base_dump_part1.sql';
$basePart2 = 'sql/base_dump_part2.sql';
$insertData = 'sql/insert_data.sql';
$readmeFile = 'README.md';

// Read content
$sqlContent = "";
if (file_exists($basePart1)) {
    $sqlContent .= file_get_contents($basePart1);
} else {
    echo "Error: $basePart1 not found.\n";
    exit(1);
}

if (file_exists($basePart2)) {
    $sqlContent .= file_get_contents($basePart2);
} else {
    echo "Error: $basePart2 not found.\n";
    exit(1);
}

$sqlContent .= "\n\n-- GENERATED SKEMA DATA --\n\n";

if (file_exists($insertData)) {
    $sqlContent .= file_get_contents($insertData);
} else {
    echo "Error: $insertData not found.\n";
    exit(1);
}

// Read README
if (file_exists($readmeFile)) {
    $readmeContent = file_get_contents($readmeFile);
} else {
    // Create basic README if not exists
    $readmeContent = "# DKS Web Application\n\n";
}

// Append SQL to README
$newReadmeContent = $readmeContent . "\n\n## Database Setup (Full SQL Dump)\n\n```sql\n" . $sqlContent . "\n```\n";

// Write back to README
if (file_put_contents($readmeFile, $newReadmeContent) !== false) {
    echo "Successfully updated README.md with combined SQL dump.\n";
} else {
    echo "Error writing to README.md.\n";
    exit(1);
}

?>
