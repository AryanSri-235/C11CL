<?php
/**
 * C11CL — Database Setup Script
 * Run once: http://localhost:8000/setup_db.php
 * Creates required tables in the remote MySQL database.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if (!$con) {
    die('<p style="color:red;font-family:monospace">❌ Cannot connect to database. Check Aiven IP allowlist.</p>');
}

echo '<style>body{font-family:monospace;padding:30px;background:#111;color:#0f0;} .ok{color:#0f0;} .err{color:red;} h2{color:#fff;}</style>';
echo '<h2>C11CL — Database Setup</h2>';

$tables = [];

// -------------------------------------------------------
// Table 1: register  (Phase-1 registrations)
// -------------------------------------------------------
$tables['register'] = "CREATE TABLE IF NOT EXISTS `register` (
    `id`         INT(11) NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) DEFAULT NULL,
    `reg`        VARCHAR(100) DEFAULT NULL,
    `age`        VARCHAR(10)  DEFAULT NULL,
    `mobile`     VARCHAR(20)  DEFAULT NULL,
    `email`      VARCHAR(255) DEFAULT NULL,
    `player`     VARCHAR(100) DEFAULT NULL,
    `state`      VARCHAR(100) DEFAULT NULL,
    `city`       VARCHAR(100) DEFAULT NULL,
    `ref`        VARCHAR(100) DEFAULT NULL,
    `source`     VARCHAR(100) DEFAULT 'Website',
    `created_at` DATETIME     DEFAULT NULL,
    `up`         DATETIME     DEFAULT NULL,
    `regCount`   INT(5)       DEFAULT 1,
    `status`     VARCHAR(50)  DEFAULT 'Pending',
    `mailsent`   TINYINT(1)   DEFAULT 0,
    `wasent`     TINYINT(1)   DEFAULT 0,
    `paydate`    DATE         DEFAULT NULL,
    `paytime`    TIME         DEFAULT NULL,
    `payid`      VARCHAR(255) DEFAULT NULL,
    `amount`     DECIMAL(10,2) DEFAULT NULL,
    `tshirt_size` VARCHAR(10) DEFAULT NULL,
    `lower_size`  VARCHAR(10) DEFAULT NULL,
    `food_pref`   VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `reg` (`reg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// -------------------------------------------------------
// Table 2: register-second  (Phase-2 / kit registrations)
// -------------------------------------------------------
$tables['register-second'] = "CREATE TABLE IF NOT EXISTS `register-second` (
    `id`         INT(11) NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) DEFAULT NULL,
    `reg`        VARCHAR(100) DEFAULT NULL,
    `reg2`       VARCHAR(100) DEFAULT NULL,
    `age`        VARCHAR(10)  DEFAULT NULL,
    `mobile`     VARCHAR(20)  DEFAULT NULL,
    `email`      VARCHAR(255) DEFAULT NULL,
    `player`     VARCHAR(100) DEFAULT NULL,
    `state`      VARCHAR(100) DEFAULT NULL,
    `city`       VARCHAR(100) DEFAULT NULL,
    `ref`        VARCHAR(100) DEFAULT NULL,
    `tshirt_size` VARCHAR(10) DEFAULT NULL,
    `lower_size`  VARCHAR(10) DEFAULT NULL,
    `food_pref`   VARCHAR(50) DEFAULT NULL,
    `paydate`    DATE         DEFAULT NULL,
    `paytime`    TIME         DEFAULT NULL,
    `payid`      VARCHAR(255) DEFAULT NULL,
    `amount`     DECIMAL(10,2) DEFAULT NULL,
    `created_at` DATETIME     DEFAULT NULL,
    `up`         DATETIME     DEFAULT NULL,
    `mailsent`   TINYINT(1)   DEFAULT 0,
    `wasent`     TINYINT(1)   DEFAULT 0,
    `regCount`   INT(5)       DEFAULT 1,
    `status`     VARCHAR(50)  DEFAULT 'Pending',
    PRIMARY KEY (`id`),
    UNIQUE KEY `reg2` (`reg2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// -------------------------------------------------------
// Table 3: blog
// -------------------------------------------------------
$tables['blog'] = "CREATE TABLE IF NOT EXISTS `blog` (
    `id`           INT(11) NOT NULL AUTO_INCREMENT,
    `title`        VARCHAR(500) DEFAULT NULL,
    `slug`         VARCHAR(500) DEFAULT NULL,
    `content`      LONGTEXT     DEFAULT NULL,
    `excerpt`      TEXT         DEFAULT NULL,
    `featured_img` VARCHAR(500) DEFAULT NULL,
    `category`     VARCHAR(200) DEFAULT NULL,
    `author`       VARCHAR(200) DEFAULT 'Admin',
    `publish_date` DATE         DEFAULT NULL,
    `status`       VARCHAR(50)  DEFAULT 'published',
    `created_at`   DATETIME     DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// -------------------------------------------------------
// Table 4: regdata
// -------------------------------------------------------
$tables['regdata'] = "CREATE TABLE IF NOT EXISTS `regdata` (
    `id`         INT(11) NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) DEFAULT NULL,
    `email`      VARCHAR(255) DEFAULT NULL,
    `phone`      VARCHAR(20)  DEFAULT NULL,
    `state`      VARCHAR(100) DEFAULT NULL,
    `city`       VARCHAR(100) DEFAULT NULL,
    `created_at` DATETIME     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


// -------------------------------------------------------
// Table 5: user
// -------------------------------------------------------
$tables['user'] = "CREATE TABLE IF NOT EXISTS `user` (
    `id`         INT(11) NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) DEFAULT NULL,
    `username`   VARCHAR(255) DEFAULT NULL,
    `password`   VARCHAR(255) DEFAULT NULL,
    `number`     VARCHAR(20)  DEFAULT NULL,
    `email`      VARCHAR(255) DEFAULT NULL,
    `role`       VARCHAR(50)  DEFAULT NULL,
    `status`     VARCHAR(50)  DEFAULT NULL,
    `fb`         VARCHAR(255) DEFAULT NULL,
    `insta`      VARCHAR(255) DEFAULT NULL,
    `ref`        VARCHAR(50)  DEFAULT NULL,
    `picture`    VARCHAR(255) DEFAULT NULL,
    `stoper`     VARCHAR(50)  DEFAULT 'Go',
    `isActive`   TINYINT(1)   DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// -------------------------------------------------------
// Table 6: history
// -------------------------------------------------------
$tables['history'] = "CREATE TABLE IF NOT EXISTS `history` (
    `id`         INT(11) NOT NULL AUTO_INCREMENT,
    `username`   VARCHAR(255) DEFAULT NULL,
    `password`   VARCHAR(255) DEFAULT NULL,
    `status`     VARCHAR(50)  DEFAULT NULL,
    `ip`         VARCHAR(50)  DEFAULT NULL,
    `login`      VARCHAR(50)  DEFAULT NULL,
    `logout`     VARCHAR(50)  DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// -------------------------------------------------------
// Table 7: founding_owner_inquiries
// -------------------------------------------------------
$tables['founding_owner_inquiries'] = "CREATE TABLE IF NOT EXISTS `founding_owner_inquiries` (
    `id`                 INT(11) NOT NULL AUTO_INCREMENT,
    `player_name`        VARCHAR(255) DEFAULT NULL,
    `user_designation`   VARCHAR(255) DEFAULT NULL,
    `brand_company_name` VARCHAR(255) DEFAULT NULL,
    `contact_phone`      VARCHAR(20)  DEFAULT NULL,
    `contact_email`      VARCHAR(255) DEFAULT NULL,
    `user_location`      VARCHAR(255) DEFAULT NULL,
    `chosen_package`     VARCHAR(100) DEFAULT NULL,
    `brand_brief`        TEXT         DEFAULT NULL,
    `created_at`         DATETIME     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";




// -------------------------------------------------------
// Run each CREATE TABLE
// -------------------------------------------------------
$all_ok = true;
foreach ($tables as $name => $sql) {
    $result = $con->query($sql);
    if ($result !== false) {
        echo "<p class='ok'>✅ Table <strong>`$name`</strong> — OK</p>";
    } else {
        echo "<p class='err'>❌ Table <strong>`$name`</strong> — ERROR: " . db_error() . "</p>";
        $all_ok = false;
    }
}

// -------------------------------------------------------
// Verify tables exist
// -------------------------------------------------------
echo "<h2>Table Verification</h2>";
$res = $con->query("SHOW TABLES");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $tableName = reset($row);
        echo "<p class='ok'>📋 Found table: <strong>{$tableName}</strong></p>";
    }
} else {
    echo "<p class='err'>Could not list tables: " . db_error() . "</p>";
}

if ($all_ok) {
    // Check if the user table is empty, and seed a default admin account
    $checkUser = $con->query("SELECT COUNT(*) as count FROM `user`");
    if ($checkUser) {
        $data = $checkUser->fetch_assoc();
        if ($data['count'] == 0) {
            $seedSql = "INSERT INTO `user` (name, username, password, number, email, role, status, stoper, isActive) 
                        VALUES ('Administrator', 'admin', 'admin123', '9999999999', 'admin@c11cl.com', 'owner', 'superadmin', 'Go', 0)";
            if ($con->query($seedSql)) {
                echo "<p class='ok'>👤 Seeded default admin account: <strong>admin</strong> / <strong>admin123</strong></p>";
            } else {
                echo "<p class='err'>❌ Failed to seed default user: " . db_error() . "</p>";
            }
        }
    }
    echo "<h2 style='color:#0f0'>🎉 Setup complete! All tables are ready.</h2>";
    echo "<p>You can now delete or password-protect this file.</p>";
} else {
    echo "<h2 class='err'>⚠️ Some tables had errors — check above.</h2>";
}

$con->close();
?>
