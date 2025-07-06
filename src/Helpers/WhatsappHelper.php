<?php
// Helper de envio de WhatsApp com fila, status e integração real (exemplo Z-API)
class WhatsappHelper {
    // Adiciona mensagem à fila
    public static function enviar($numero, $mensagem) {
        global $pdo;
        $sql = "INSERT INTO whatsapp_notifications (numero, mensagem) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$numero, $mensagem]);
        return true;
    }

    // Processa fila e envia mensagens (chamar via cron/job)
    public static function processarFila() {
        global $pdo;
        $sql = "SELECT * FROM whatsapp_notifications WHERE status = 'PENDENTE' ORDER BY created_at LIMIT 10";
        $pendentes = $pdo->query($sql)->fetchAll();
        foreach ($pendentes as $n) {
            $status = 'ENVIADA';
            $response = '';
            // Integração real (exemplo Z-API, substitua URL e token)
            $api_url = 'https://api.z-api.io/instance0000/token0000/send-text';
            $payload = json_encode(['phone'=> $n['numero'], 'message'=> $n['mensagem']]);
            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            $result = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $response = $result;
            if ($httpcode !== 200) $status = 'FALHOU';
            $sql2 = "UPDATE whatsapp_notifications SET status=?, response=?, sent_at=NOW() WHERE id=?";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([$status, $response, $n['id']]);
        }
    }

    // Centralização de templates
    public static function template($tipo, $dados=[]) {
        $templates = [
            'novo_pedido' => 'Novo pedido disponível para você!',
            'status' => 'Seu pedido está agora: '.$dados['status'] ?? '',
            // Adicione mais templates conforme necessário
        ];
        return $templates[$tipo] ?? '';
    }
}
