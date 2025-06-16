<?php
$pdo = new PDO(
    'mysql:host=' . getenv('db_host') . ';dbname=' . getenv('db_name') . ';charset=utf8',
    getenv('db_user'),
    getenv('db_pass')
);

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
