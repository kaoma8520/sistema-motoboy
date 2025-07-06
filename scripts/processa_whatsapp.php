<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Helpers/WhatsappHelper.php';
WhatsappHelper::processarFila();
echo "Fila processada.";
