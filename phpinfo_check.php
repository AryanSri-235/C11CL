<?php
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "PDO drivers: ";
echo (class_exists('PDO') ? implode(', ', PDO::getAvailableDrivers()) : 'PDO not loaded');
echo "\n";
echo "mysqli loaded: " . (extension_loaded('mysqli') ? 'YES' : 'NO') . "\n";
echo "pdo_mysql loaded: " . (extension_loaded('pdo_mysql') ? 'YES' : 'NO') . "\n";
echo "Loaded extensions: " . implode(', ', get_loaded_extensions()) . "\n";
echo "</pre>";
