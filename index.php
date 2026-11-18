<?php
header('Content-Type: application/json');

// Simulated database of activated devices/users
$users = [
    '00:1A:79:XX:XX:XX' => [
        'status' => 'active',
        'expires_at' => '2026-12-31',
        'server_url' => 'http://your-iptv-server.com:8080',
        'username' => 'pro_user_01',
        'password' => 'securePass123'
    ]
];

$mac = isset($_POST['mac']) ? strtoupper(trim($_POST['mac'])) : '';

if (isset($users[$mac]) && $users[$mac]['status'] === 'active') {
    $user = $users[$mac];
    $playlistUrl = "{$user['server_url']}/get.php?username={$user['username']}&password={$user['password']}&type=m3u_plus&output=ts";
    
    echo json_encode([
        'success' => true,
        'message' => 'Device activated',
        'expires_at' => $user['expires_at'],
        'playlist_url' => $playlistUrl
    ]);
} else {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'MAC address not found or subscription expired.'
    ]);
}
?>
