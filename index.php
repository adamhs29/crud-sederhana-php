<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Biodata</title>
</head>
<body>
    <h2>Daftar Biodata</h2>
    <table border="1">
        <tr>            
            <th>NIK</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>

        <?php
        include 'koneksi.php';

        $sql = "SELECT * FROM biodata";
        $result = $kon->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";                
                echo "<td>" . $row['nik'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td>" . $row['alamat'] . "</td>";
                echo "<td><img src='" . $row['gambar'] . "' alt='gambar' style='width:50px;height:50px;'></td>";
                echo "<td><a href='edit.php?id_biodata=" . $row['id_biodata'] . "'>Edit</a> | <a href='hapus.php?id_biodata=" . $row['id_biodata'] . "'>Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada data.</td></tr>";
        }

        $kon->close();
        ?>
    </table>

    <br>
    <a href="tambah.php">Tambah Biodata Baru</a>
</body>
</html>
