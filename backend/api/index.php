<?php
// CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Función segura para capturar el Authorization header
function getAuthorizationHeader() {
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        return trim($_SERVER['HTTP_AUTHORIZATION']);
    }
    if (function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            return trim($headers['Authorization']);
        }
    }
    return null;
}

$token = getAuthorizationHeader();

if ($token !== 'Bearer UC2025-II51') {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

// OK
header('Content-Type: application/json');


$apikey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InZ4b3N6dWd2Z2lucnN0dHhuaWthIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTMzMjA0ODMsImV4cCI6MjA2ODg5NjQ4M30.BUdy45pw6RbgbHhN45q3zpaWgKCsDJH_s78HKemQ_PA';
$urlBase = 'https://vxoszugvginrsttxnika.supabase.co/rest/v1/usuarios';

$method = $_SERVER['REQUEST_METHOD'];
function callSupabase($method, $url, $data = null) {
    global $apikey;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $headers = [
        'apikey: ' . $apikey,
        'Authorization: Bearer ' . $apikey,
        'Content-Type: application/json',
        'Accept: application/json'
    ];

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $headers[] = 'Prefer: return=representation';
    } elseif ($method === 'PUT' || $method === 'PATCH') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $headers[] = 'Prefer: return=representation';
    } elseif ($method === 'DELETE') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

if ($method === 'GET') {
    echo callSupabase('GET', $urlBase);
}
elseif ($method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true);
    echo callSupabase('POST', $urlBase, $body);
}
elseif ($method === 'PUT') {
    $id = $_GET['id'] ?? null;
    if (!$id) { http_response_code(400); exit('ID requerido'); }
    $body = json_decode(file_get_contents('php://input'), true);
    $url = $urlBase . '?id=eq.' . $id;
    echo callSupabase('PATCH', $url, $body);
}
elseif ($method === 'DELETE') {
    $id = $_GET['id'] ?? null;
    if (!$id) { http_response_code(400); exit('ID requerido'); }
    $url = $urlBase . '?id=eq.' . $id;
    echo callSupabase('DELETE', $url);
}