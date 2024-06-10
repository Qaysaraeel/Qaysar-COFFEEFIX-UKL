<?php
// Sertakan file koneksi ke database
include '../koneksi.php';

// Pastikan data yang diterima dari AJAX adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan id dan action dikirimkan
    if (isset($_POST['id']) && isset($_POST['action'])) {
        // Tangkap nilai id dan action dari AJAX
        $id = $_POST['id'];
        $action = $_POST['action'];

        // Lakukan tindakan sesuai dengan action yang diterima
        if ($action == 'cancel') {
            // Hapus pesanan dari database
            $delete_query = "DELETE FROM transaksi WHERE id_transaksi = $id";
            $result = mysqli_query($mysqli, $delete_query);

            // Cek apakah penghapusan berhasil dilakukan
            if ($result) {
                echo "success"; // Jika berhasil, kirimkan pesan success ke AJAX
            } else {
                echo "error"; // Jika gagal, kirimkan pesan error ke AJAX
            }
        } else {
            // Tangani tindakan lainnya (accept, process, complete, received)
            switch ($action) {
                case 'accept':
                    $new_status = 'Pesanan di proses';
                    break;
                case 'process':
                    $new_status = 'Pesanan sedang dibuat';
                    break;
                case 'complete':
                    $new_status = 'Pemesanan Selesai';
                    break;
                case 'received':
                    $new_status = 'Pesanan Diterima'; // Tambahkan case untuk menangani konfirmasi pesanan diterima
                    break;
                default:
                    // Jika action tidak sesuai, kembalikan pesan error
                    echo "error";
                    exit();
            }

            // Lakukan update status pada database
            $update_query = "UPDATE transaksi SET status = '$new_status' WHERE id_transaksi = $id";
            $result = mysqli_query($mysqli, $update_query);

            // Cek apakah update berhasil dilakukan
            if ($result) {
                echo "success"; // Jika berhasil, kirimkan pesan success ke AJAX
            } else {
                echo "error"; // Jika gagal, kirimkan pesan error ke AJAX
            }
        }
    } else {
        echo "error"; // Jika data tidak lengkap, kirimkan pesan error ke AJAX
    }
} else {
    echo "error"; // Jika metode request bukan POST, kirimkan pesan error ke AJAX
}
?>
