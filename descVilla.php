<<<<<<< HEAD

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include 'koneksi.php';

// Mengambil ID villa dari URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

// Mengambil data villa
$query = mysqli_query($conn, "SELECT * FROM villa WHERE id_villa = $id");
$data = mysqli_fetch_assoc($query);

// Jika villa tidak ditemukan
if (!$data) {
    echo "Villa tidak ditemukan!";
    exit;
}

// Mengambil villa sebelumnya
$queryPrev = mysqli_query($conn, "SELECT id_villa FROM villa WHERE id_villa < $id ORDER BY id_villa DESC LIMIT 1");
$prev = mysqli_fetch_assoc($queryPrev);

// Mengambil villa berikutnya
$queryNext = mysqli_query($conn, "SELECT id_villa FROM villa WHERE id_villa > $id ORDER BY id_villa ASC LIMIT 1");
$next = mysqli_fetch_assoc($queryNext);

// Daftar gambar villa
$gambarVilla = [
    1 => 'biru.jpg',
    2 => 'ping.png',
    3 => 'pink.jpg',
    4 => 'pinkie.jpg',
    5 => 'biru.jpg'
];

$gambar = isset($gambarVilla[$id]) ? $gambarVilla[$id] : 'biru.jpg';
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Villa</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body style="background-color: #0b1f3a">

    <!-- NAVBAR -->
<?php
include 'header.php';

$query_villa = "SELECT * FROM villa LIMIT 4";
$result_villa = mysqli_query($conn, $query_villa);
?>



    <!-- DETAIL VILLA -->
    <section class="py-5">

        <div class="container">

            <!-- TOMBOL KEMBALI -->
            <div class="mb-4">

                <a href="index.php" class="btn btn-warning fw-bold px-4 py-2">
                    ← Kembali
                </a>

            </div>


            <div class="d-flex align-items-center justify-content-center gap-3">

                <!-- PANAH KIRI -->
                <?php if ($prev) { ?>

                    <a
                        href="descVilla.php?id=<?php echo $prev['id_villa']; ?>"
                        class="btn btn-outline-light rounded-circle fw-bold d-flex justify-content-center align-items-center flex-shrink-0"
                        style="width: 55px; height: 55px; font-size: 25px">

                        ←

                    </a>

                <?php } else { ?>

                    <div style="width: 55px;"></div>

                <?php } ?>


                <!-- CARD DETAIL VILLA -->
                <div
                    class="card border-0 rounded-4 overflow-hidden flex-grow-1"
                    style="background-color: #1b3358; max-width: 1100px">

                    <div class="row g-0 align-items-center">


                        <!-- FOTO VILLA -->
                        <div class="col-lg-5 text-center p-4">

                            <img
                                src="pict/<?php echo htmlspecialchars($gambar); ?>"
                                class="img-fluid rounded-3"
                                style="max-height: 500px; object-fit: contain"
                                alt="Foto Villa">

                        </div>


                        <!-- INFORMASI VILLA -->
                        <div class="col-lg-7 p-4 p-lg-5">

                            <span class="badge bg-warning text-dark px-4 py-2 mb-3">

                                DETAIL VILLA

                            </span>


                            <!-- NAMA VILLA -->
                            <h1 class="display-5 fw-bold text-warning">

                                <?php echo htmlspecialchars($data['nama_villa']); ?>

                            </h1>


                            <!-- HARGA -->
                            <h4 class="text-light fw-bold mt-3">

                                <?php echo htmlspecialchars($data['harga']); ?>

                            </h4>


                            <!-- DESKRIPSI -->
                            <p class="lead text-light mt-4">

                                <?php echo htmlspecialchars($data['deskripsi']); ?>

                            </p>


                            <hr class="border-light">


                            <!-- INFORMASI TAMBAHAN -->
                            <div class="row mt-4">

                                <div class="col-6 mb-3">

                                    <h6 class="text-warning fw-bold">
                                        👥 Kapasitas
                                    </h6>

                                    <p class="text-light">
                                        <?php echo htmlspecialchars($data['kapasitas']); ?>
                                    </p>

                                </div>


                                <div class="col-6 mb-3">

                                    <h6 class="text-warning fw-bold">
                                        🛏 Jumlah Kamar
                                    </h6>

                                    <p class="text-light">
                                        <?php echo htmlspecialchars($data['jumlah_kamar']); ?>
                                    </p>

                                </div>

                            </div>


                            <!-- TOMBOL BOOKING -->
                            <a
                                href="booking.php?id_villa=<?php echo $data['id_villa']; ?>"
                                class="btn btn-warning fw-bold px-4 py-2 mt-2">

                                Pesan Sekarang

                            </a>

                        </div>

                    </div>

                </div>


                <!-- PANAH KANAN -->
                <?php if ($next) { ?>

                    <a
                        href="descVilla.php?id=<?php echo $next['id_villa']; ?>"
                        class="btn btn-outline-warning rounded-circle fw-bold d-flex justify-content-center align-items-center flex-shrink-0"
                        style="width: 55px; height: 55px; font-size: 25px">

                        →

                    </a>

                <?php } else { ?>

                    <div style="width: 55px;"></div>

                <?php } ?>

            </div>

        </div>

    </section>


    <!-- FOOTER -->
    <?php 
include 'footer.php'; 
?>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>

</body>
</html>
