<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Acompanhar Entrega</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>#map{height:400px;width:100%;margin:20px auto;max-width:600px;}</style>
</head>
<body>
    <h2>Acompanhar Entrega</h2>
    <div id="map"></div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
    // Exemplo: origem e destino fixos, substitua por dados reais do pedido
    var origem = [-23.5, -46.6];
    var destino = [-23.6, -46.7];
    var entregador = [-23.55, -46.65]; // posição simulada
    var map = L.map('map').setView(origem, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);
    L.marker(origem).addTo(map).bindPopup('Origem').openPopup();
    L.marker(destino).addTo(map).bindPopup('Destino');
    var markerEntregador = L.marker(entregador, {color:'blue'}).addTo(map).bindPopup('Entregador');
    // Atualização simulada
    setInterval(function(){
        // Aqui você buscaria a posição real do entregador via AJAX
        // Exemplo: mover marcador
        var lat = markerEntregador.getLatLng().lat + 0.0005;
        var lng = markerEntregador.getLatLng().lng + 0.0005;
        markerEntregador.setLatLng([lat, lng]);
    }, 3000);
    </script>
    <a href="index.php">Voltar</a>
</body>
</html>
