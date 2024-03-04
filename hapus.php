<?php
include 'koneksi.php';

if (isset($_GET['id_biodata'])) {
    $id_biodata = $_GET['id_biodata'];

    // Dapatkan nama file gambar sebelum menghapus data dari database
    $sql_select = "SELECT gambar FROM biodata WHERE id_biodata = $id_biodata";
    $result_select = $kon->query($sql_select);

    if ($result_select->num_rows > 0) {
        $row = $result_select->fetch_assoc();
        $gambar_file = "gambar/" . $row['gambar'];

        // Hapus file gambar dari folder
        if (file_exists($gambar_file)) {
            unlink($gambar_file);
        }
    }

    // Hapus data dari database
    $sql_delete = "DELETE FROM biodata WHERE id_biodata = $id_biodata";

    if ($kon->query($sql_delete) === TRUE) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Error: " . $sql_delete . "<br>" . $kon->error;
    }
} else {
    echo "ID Biodata tidak ditemukan.";
}

// Redirect ke halaman index setelah menghapus
header("Location: index.php");
exit();

$kon->close();
?>
