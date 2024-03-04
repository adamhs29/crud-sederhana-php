<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST["nik"];
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];

    // Cek apakah file gambar diunggah
    if ($_FILES["gambar"]["error"] == UPLOAD_ERR_OK) {
        $gambar_name = $_FILES["gambar"]["name"];
        $gambar_tmp = $_FILES["gambar"]["tmp_name"];

        // Pindahkan file yang diunggah ke folder "gambar" dengan nama yang unik
        $gambar_path = "gambar/" . uniqid() . "_" . $gambar_name;
        move_uploaded_file($gambar_tmp, $gambar_path);

        // Insert data beserta nama file gambar ke dalam database
        $sql = "INSERT INTO biodata (nik, nama, alamat, gambar) VALUES ('$nik', '$nama', '$alamat', '$gambar_path')";

        if ($kon->query($sql) === TRUE) {
            // Jika insert berhasil, redirect ke halaman index
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $kon->error;
        }
    } else {
        echo "File gambar tidak diunggah.";
    }
}

$kon->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Biodata</title>
</head>
<body>
    <h2>Tambah Biodata</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <label for="nik">NIK:</label>
        <input type="text" name="nik" required><br>

        <label for="nama">Nama:</label>
        <input type="text" name="nama" required><br>

        <label for="alamat">Alamat:</label>
        <input type="text" name="alamat" required><br>

        <label for="gambar">Gambar:</label>
        <input type="file" name="gambar" accept="image/*" required><br>

        <input type="submit" value="Tambah">
    </form>

    <a href="index.php">Kembali ke Daftar Biodata</a>
</body>
</html>
