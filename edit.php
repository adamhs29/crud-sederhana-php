<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_biodata = $_POST["id_biodata"];
    $nik = $_POST["nik"];
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];

    // Dapatkan nama file gambar lama sebelum menghapus data dari database
    $sql_select = "SELECT gambar FROM biodata WHERE id_biodata = $id_biodata";
    $result_select = $kon->query($sql_select);

    if ($result_select->num_rows > 0) {
        $row = $result_select->fetch_assoc();
        $gambar_lama = "gambar/" . $row['gambar'];

        // Hapus gambar lama dari folder
        if (file_exists($gambar_lama)) {
            unlink($gambar_lama);
        }
    }

    // Cek apakah file gambar diunggah
    if ($_FILES["gambar"]["error"] == UPLOAD_ERR_OK) {
        $gambar_name = $_FILES["gambar"]["name"];
        $gambar_tmp = $_FILES["gambar"]["tmp_name"];

        // Pindahkan file yang diunggah ke folder "gambar" dengan nama yang unik
        $gambar_path = "gambar/" . uniqid() . "_" . $gambar_name;
        move_uploaded_file($gambar_tmp, $gambar_path);

        // Update data dalam database termasuk nama file gambar yang baru
        $sql = "UPDATE biodata SET nik='$nik', nama='$nama', alamat='$alamat', gambar='$gambar_path' WHERE id_biodata=$id_biodata";
    } else {
        // Jika tidak ada file gambar diunggah, hanya update data tanpa mengganti gambar
        $sql = "UPDATE biodata SET nik='$nik', nama='$nama', alamat='$alamat' WHERE id_biodata=$id_biodata";
    }

    if ($kon->query($sql) === TRUE) {
        // Jika update berhasil, redirect ke halaman index
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $kon->error;
    }
}

$kon->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Biodata</title>
</head>
<body>
    <h2>Edit Biodata</h2>

    <?php
    include 'koneksi.php';

    if(isset($_GET['id_biodata'])) {
        $id_biodata = $_GET['id_biodata'];

        $sql = "SELECT * FROM biodata WHERE id_biodata = $id_biodata";
        $result = $kon->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <input type="hidden" name="id_biodata" value="<?php echo $row['id_biodata']; ?>">

                <label for="nik">NIK:</label>
                <input type="text" name="nik" value="<?php echo $row['nik']; ?>" required><br>

                <label for="nama">Nama:</label>
                <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required><br>

                <label for="alamat">Alamat:</label>
                <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>" required><br>

                <label for="gambar">Gambar:</label>
                <input type="file" name="gambar"><br>
                <img src="<?php echo $row['gambar']; ?>" alt="gambar" style="width: 100px; height: 100px;"><br>

                <input type="submit" value="Simpan Perubahan">
            </form>
    <?php
        } else {
            echo "Data tidak ditemukan.";
        }
    } else {
        echo "ID Biodata tidak ditemukan.";
    }

    $kon->close();
    ?>
    
    <br>
    <a href="index.php">Kembali ke Daftar Biodata</a>
</body>
</html>
