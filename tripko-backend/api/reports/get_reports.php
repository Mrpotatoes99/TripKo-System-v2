<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// More permissive CORS headers for local development
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once(__DIR__ . '/../../config/db.php');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Method not allowed');
    }

    // Get and validate period parameter
    $period = isset($_GET['period']) ? intval($_GET['period']) : 30;
    if ($period <= 0) {
        $period = 30; // Default to 30 days if invalid
    }
    
    $startDate = date('Y-m-d', strtotime("-$period days"));

    // Get monthly visitor data
    $sql = "SELECT 
        DATE_FORMAT(visit_date, '%Y-%m') as month,
        SUM(visitor_count) as total_visitors
        FROM visitors_tracking 
        WHERE visit_date >= ?
        GROUP BY DATE_FORMAT(visit_date, '%Y-%m')
        ORDER BY month";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $startDate);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $monthlyData = [];
    $totalVisitors = 0;
    while ($row = $result->fetch_assoc()) {
        $monthlyData[] = [
            'month' => $row['month'],
            'count' => intval($row['total_visitors'])
        ];
        $totalVisitors += intval($row['total_visitors']);
    }

    // Get most visited spot
    $sql = "SELECT 
        ts.name,
        t.town_name,
        SUM(vt.visitor_count) as total_visits
        FROM visitors_tracking vt
        JOIN tourist_spots ts ON vt.spot_id = ts.spot_id
        JOIN towns t ON ts.town_id = t.town_id
        WHERE vt.visit_date >= ?
        GROUP BY ts.spot_id, ts.name, t.town_name
        ORDER BY total_visits DESC
        LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $startDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $popularSpot = $result->fetch_assoc();

    // Get transport type distribution
    $sql = "SELECT 
        tt.type,
        COUNT(DISTINCT rtt.route_id) as route_count
        FROM transportation_type tt
        LEFT JOIN route_transport_types rtt ON tt.transport_type_id = rtt.transport_type_id
        GROUP BY tt.transport_type_id, tt.type
        ORDER BY route_count DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $typeDistribution = [];
    while ($row = $result->fetch_assoc()) {
        $typeDistribution[] = [
            'type' => $row['type'],
            'count' => intval($row['route_count'])
        ];
    }

    // Get most popular route
    $sql = "SELECT 
        CONCAT(rt1.name, ' → ', rt2.name) as route_name,
        rt1.town as from_town,
        rt2.town as to_town
        FROM transport_route tr
        JOIN route_terminals rt1 ON tr.origin_terminal_id = rt1.terminal_id
        JOIN route_terminals rt2 ON tr.destination_terminal_id = rt2.terminal_id
        LEFT JOIN route_transport_types rtt ON tr.route_id = rtt.route_id
        GROUP BY tr.route_id, rt1.name, rt2.name, rt1.town, rt2.town
        ORDER BY COUNT(rtt.id) DESC
        LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $popularRoute = $result->fetch_assoc();

    // Calculate visitor trend
    $previousPeriodStart = date('Y-m-d', strtotime("-" . ($period * 2) . " days"));
    $sql = "SELECT 
        SUM(CASE WHEN visit_date >= ? THEN visitor_count ELSE 0 END) as current_period,
        SUM(CASE WHEN visit_date < ? AND visit_date >= ? THEN visitor_count ELSE 0 END) as previous_period
        FROM visitors_tracking
        WHERE visit_date >= ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $startDate, $startDate, $previousPeriodStart, $previousPeriodStart);
    $stmt->execute();
    $result = $stmt->get_result();
    $trendResult = $result->fetch_assoc();

    $trend = 0;
    if ($trendResult['previous_period'] > 0) {
        $trend = (($trendResult['current_period'] - $trendResult['previous_period']) / $trendResult['previous_period']) * 100;
    }

    $response = [
        'success' => true,
        'tourism' => [
            'totalVisitors' => $totalVisitors,
            'visitorTrend' => round($trend, 1),
            'monthlyData' => $monthlyData,
            'popularSpot' => $popularSpot ? $popularSpot['name'] : null,
            'popularSpotLocation' => $popularSpot ? $popularSpot['town_name'] : null
        ],
        'transport' => [
            'typeDistribution' => $typeDistribution,
            'popularRoute' => [
                'name' => $popularRoute ? $popularRoute['route_name'] : null,
                'fromTown' => $popularRoute ? $popularRoute['from_town'] : null,
                'toTown' => $popularRoute ? $popularRoute['to_town'] : null
            ]
        ]
    ];

    echo json_encode($response, JSON_NUMERIC_CHECK);

} catch (Exception $e) {
    error_log("Error in get_reports.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'debug' => [
            'period' => $period ?? null,
            'startDate' => $startDate ?? null
        ]
    ]);
}
?>