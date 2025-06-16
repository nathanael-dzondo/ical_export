<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=sejour2025;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$stmt = $pdo->query("SELECT arrive, depart FROM reservations");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=calendar.ics');

echo "BEGIN:VCALENDAR\r\n";
echo "VERSION:2.0\r\n";
echo "CALSCALE:GREGORIAN\r\n";
echo "PRODID:-//nuratec.fr//ftp//stagedampierre//Fr\r\n";

foreach ($reservations as $res) {
    if (!empty($res['arrive']) && !empty($res['depart'])) {
        $start = date('Ymd', strtotime($res['arrive']));
        $end = date('Ymd', strtotime($res['depart']));

        echo "BEGIN:VEVENT\r\n";
        echo "UID:" . uniqid() . "123nuratec@gmail.com\r\n";
        echo "DTSTAMP:" . date('Ymd\THis\Z') . "\r\n";
        echo "DTSTART;VALUE=DATE:$start\r\n";
        echo "DTEND;VALUE=DATE:$end\r\n";
        echo "SUMMARY:Réservé\r\n";
        echo "END:VEVENT\r\n";
    }
}

echo "END:VCALENDAR\r\n";
