<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=sejour2025;charset=utf8', 'root', '');

// Lire les réservations confirmées
$stmt = $pdo->query("SELECT arrive, depart FROM reservations");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Début de l'export .ics
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=calendar.ics');

echo "BEGIN:VCALENDAR\r\n";
echo "VERSION:2.0\r\n";
echo "PRODID:-//nuratec.fr//ftp//stagedampierre//dzondoFR\r\n";
foreach ($reservations as $res) {
    $start = date('Ymd', strtotime($res['arrive']));
    $end = date('Ymd', strtotime($res['depart'])); // jour de départ NON inclus en iCal

    echo "BEGIN:VEVENT\r\n";
    echo "UID:" . uniqid() . "@tonsite.com\r\n";
    echo "DTSTAMP:" . date('Ymd\THis\Z') . "\r\n";
    echo "DTSTART;VALUE=DATE:$start\r\n";
    echo "DTEND;VALUE=DATE:$end\r\n";
    echo "SUMMARY:Réservé\r\n";
    echo "END:VEVENT\r\n";
}

echo "END:VCALENDAR\r\n";
