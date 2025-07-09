<?php

/** @var yii\web\View $this */

$this->title = 'Bản Đồ Quy Hoạch TP.HCM';
$this->registerCssFile('https://unpkg.com/leaflet/dist/leaflet.css');
$this->registerJsFile('https://unpkg.com/leaflet/dist/leaflet.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<div id="map"></div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  var map = L.map('map').setView([10.7769, 106.7009], 11);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
  L.tileLayer.wms('https://geodata-stnmt.tphcm.gov.vn/geoserver/tnmt/wms?', {
    layers: 'tnmt:KHSDD_2018_TPHCM',
    format: 'image/png',
    transparent: true,
    attribution: 'Sở TN‑MT TP.HCM'
  }).addTo(map);
</script>

