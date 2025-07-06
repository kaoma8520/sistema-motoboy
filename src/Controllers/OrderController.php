<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Helpers/DistanceHelper.php';

class OrderController {
    // Cria um novo pedido
    public static function createOrder($client_id, $origin_lat, $origin_lng, $dest_lat, $dest_lng, $weight_kg) {
        global $pdo;
        // Buscar entregadores online
        $sql = "SELECT id, name, is_online FROM users WHERE role = 'deliverer' AND is_online = 1";
        $stmt = $pdo->query($sql);
        $deliverers = $stmt->fetchAll();
        if (empty($deliverers)) {
            return ['error' => 'Nenhum entregador disponível no momento.'];
        }
        // Encontrar o entregador mais próximo
        $minDistance = null;
        $closestDeliverer = null;
        foreach ($deliverers as $d) {
            // Aqui você pode armazenar a localização do entregador em outra tabela, para simplificar vamos supor que está em users
            // Exemplo: $d['current_lat'], $d['current_lng']
            // Para este exemplo, vamos simular com valores fixos:
            $dLat = $origin_lat; // Substitua pelo valor real do entregador
            $dLng = $origin_lng; // Substitua pelo valor real do entregador
            $distance = DistanceHelper::haversine($origin_lat, $origin_lng, $dLat, $dLng);
            if ($minDistance === null || $distance < $minDistance) {
                $minDistance = $distance;
                $closestDeliverer = $d['id'];
            }
        }
        // Calcular distância real entre origem e destino
        $distance_km = DistanceHelper::haversine($origin_lat, $origin_lng, $dest_lat, $dest_lng);
        // Calcular valor do frete
        $base = 5.00; // tarifa fixa
        $por_km = 2.00; // valor por km
        $price = $base + ($distance_km * $por_km);
        if ($weight_kg > 5) {
            $price += $price * 0.2; // acréscimo de 20%
        }
        // Criar pedido
        $sql = "INSERT INTO orders (client_id, deliverer_id, origin_lat, origin_lng, dest_lat, dest_lng, distance_km, weight_kg, price, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'PENDENTE')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$client_id, $closestDeliverer, $origin_lat, $origin_lng, $dest_lat, $dest_lng, $distance_km, $weight_kg, $price]);
        $order_id = $pdo->lastInsertId();
        // Notificar entregador (mock)
        require_once __DIR__ . '/../Helpers/EmailHelper.php';
        require_once __DIR__ . '/../Helpers/WhatsappHelper.php';
        // Buscar e-mail e telefone do entregador
        $stmt = $pdo->prepare("SELECT email, phone FROM users WHERE id = ?");
        $stmt->execute([$closestDeliverer]);
        $entregador = $stmt->fetch();
        if ($entregador) {
            EmailHelper::enviar($entregador['email'], 'Novo pedido disponível', 'Você tem um novo pedido para aceitar!');
            WhatsappHelper::enviar($entregador['phone'], 'Novo pedido disponível para você!');
        }
        return ['order_id' => $order_id, 'price' => $price, 'deliverer_id' => $closestDeliverer];
    }
}
