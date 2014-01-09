<?php
require('tools/DatabaseManager.class.php');
$dbc = DatabaseManager::getDatabaseConnection();
$dbc->exec("INSERT INTO admin(email, password) VALUES('', '" . md5('') . "')");
echo "Instalation reussie, merci de supprimer ce fichier";