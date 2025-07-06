<?php
class EmailHelper {
    public static function enviar($to, $subject, $message) {
        $headers = "From: sistema@motoboy.com\r\nContent-type: text/html; charset=UTF-8";
        return mail($to, $subject, $message, $headers);
    }
}
