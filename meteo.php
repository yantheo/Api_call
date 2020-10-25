<?php
require_once 'class/OpenWeather.php';
$meteo = new OpenWeather('e7f4b7dec0829f334c0d6f58123d39f2');
$forecast = $meteo->getForecast(48.8534, 2.3488);
$today = $meteo->getToday('paris');
?>
<h1>
    La météo sur les 7 prochains jours à Paris
</h1>
<div>
    <ul>
        <li>
        En ce moment : <?= $today['description']?> (<?= $today['temp']?> degrés)
        </li>
        <?php foreach ($forecast as $day) :?>
        <li><?= $day['date']->format('d/m/Y') ?> : <?= $day['description']?> (<?= $day['temp']?> degrés)</li>
        <?php endforeach ?>
    </ul>
</div>




