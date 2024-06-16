<?php
session_start();
include '../koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['id_user'];
    $data = json_decode(file_get_contents('php://input'), true);
    $id_produk = $data['id_produk'];

    if ($id_user && $id_produk) {
        // Check if the product is already a favorite
        $check_favorite = "SELECT * FROM favorites WHERE id_user = '$id_user' AND id_produk = '$id_produk'";
        $result = mysqli_query($mysqli, $check_favorite);
        if (mysqli_num_rows($result) > 0) {
            // If it is already a favorite, remove it
            $delete_favorite = "DELETE FROM favorites WHERE id_user = '$id_user' AND id_produk = '$id_produk'";
            if (mysqli_query($mysqli, $delete_favorite)) {
                echo json_encode(['success' => true, 'action' => 'removed']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to remove favorite']);
            }
        } else {
            // If it is not a favorite, add it
            $insert_favorite = "INSERT INTO favorites (id_user, id_produk) VALUES ('$id_user', '$id_produk')";
            if (mysqli_query($mysqli, $insert_favorite)) {
                echo json_encode(['success' => true, 'action' => 'added']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to add favorite']);
            }
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid user or product ID']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
