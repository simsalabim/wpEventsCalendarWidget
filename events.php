<?php
require_once 'app/models/Event.php';

$eventRecord = new Event();
$groupedEvents = $eventRecord->groupByDate();
header('Content-type: application/json');

echo json_encode($groupedEvents);