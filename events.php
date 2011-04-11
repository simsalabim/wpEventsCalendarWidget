<?php
require_once 'app/models/Event.php';
require_once 'app/core/utils/JSON.php';

$eventRecord = new Event();
$groupedEvents = $eventRecord->groupByDate();
header('Content-type: application/json');

echo json_encode($groupedEvents);