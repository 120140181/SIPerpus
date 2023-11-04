<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Dashboard
            <small>
                <script type='text/javascript'>
                    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
                    var date = new Date();
                    var day = date.getDate();
                    var month = date.getMonth();
                    var thisDay = date.getDay(),
                        thisDay = myDays[thisDay];
                    var yy = date.getYear();
                    var year = (yy < 1000) ? yy + 1900 : yy;
                    document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
                    //
                </script>
            </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="alert alert-secondary" style="color: #383d41; background-color: #e2e3e5; border-color: #d6d8db;">
            Selamat Datang, <?= $_SESSION['fullname']; ?> di Halaman Admin Perpustakaaan
        </div>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <?php
                include "../../config/koneksi.php";
                $query_anggota = mysqli_query($koneksi, "SELECT * FROM user WHERE role = 'Anggota'");
                $row_anggota = mysqli_num_rows($query_anggota);
                ?>
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $row_anggota; ?></h3>

                        <p>Anggota</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="anggota" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <?php
                include "../../config/koneksi.php";
                $query_buku = mysqli_query($koneksi, "SELECT * FROM buku");
                $row_buku = mysqli_num_rows($query_buku);
                ?>
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $row_buku; ?></h3>

                        <p>Buku</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <a href="data-buku" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <?php
                include "../../config/koneksi.php";
                $query_peminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE tanggal_peminjaman > 0");
                $row_peminjaman = mysqli_num_rows($query_peminjaman);
                ?>
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= $row_peminjaman; ?></h3>

                        <p>Peminjaman</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-out"></i>
                    </div>
                    <a href="data-peminjaman" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <?php
                include "../../config/koneksi.php";
                $query_pengembalian = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE tanggal_pengembalian > 0");
                $row_pengembalian = mysqli_num_rows($query_pengembalian);
                ?>
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?= $row_pengembalian; ?></h3>

                        <p>Pengembalian</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in"></i>
                    </div>
                    <a href="data-peminjaman" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Buku fav -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Daftar Buku Favorit</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>Kategori</th>
                                        <th>Penerbit</th>
                                        <th>Pengarang</th>
                                        <th>Tahun Terbit</th>
                                        <th>isbn</th>
                                        <th>Jumlah Peminjaman</th>
                                    </tr>
                                </thead>
                                <?php
                                include "../../config/koneksi.php";

                                $no = 1;
                                // Query untuk menghitung jumlah peminjaman untuk setiap buku
                                $query = "SELECT judul_buku, COUNT(*) AS jumlah_pinjam FROM peminjaman GROUP BY judul_buku ORDER BY jumlah_pinjam DESC";

                                $result = $koneksi->query($query);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $judul_buku = $row['judul_buku'];
                                        $jumlah_pinjam = $row['jumlah_pinjam'];

                                        // Periksa apakah buku sudah ada dalam tabel "favorit"
                                        $check_query = "SELECT * FROM favorit WHERE judul_buku = '$judul_buku'";
                                        $check_result = $koneksi->query($check_query);

                                        if ($check_result->num_rows > 0) {
                                            // Jika buku sudah ada, perbarui jumlah peminjaman
                                            $update_query = "UPDATE favorit SET jumlah_pinjam = $jumlah_pinjam WHERE judul_buku = '$judul_buku'";
                                            $koneksi->query($update_query);
                                        } else {
                                            // Jika buku belum ada, tambahkan buku ke tabel "favorit"
                                            $insert_query = "INSERT INTO favorit (judul_buku, kategori_buku, penerbit_buku, pengarang, tahun_terbit, isbn, jumlah_pinjam) 
            SELECT judul_buku, kategori_buku, penerbit_buku, pengarang, tahun_terbit, isbn, $jumlah_pinjam FROM buku WHERE judul_buku = '$judul_buku'";
                                            $koneksi->query($insert_query);
                                        }
                                    }
                                } else {
                                    echo "Tidak ada data peminjaman.";
                                } {
                                ?>
                                    <tbody>
                                        <?php
                                        $favorit_query = "SELECT * FROM favorit";
                                        $favorit_result = $koneksi->query($favorit_query);

                                        if ($favorit_result->num_rows > 0) {
                                            while ($row = $favorit_result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . "</td>";
                                                echo "<td>" . $row['judul_buku'] . "</td>";
                                                echo "<td>" . $row['kategori_buku'] . "</td>";
                                                echo "<td>" . $row['penerbit_buku'] . "</td>";
                                                echo "<td>" . $row['pengarang'] . "</td>";
                                                echo "<td>" . $row['tahun_terbit'] . "</td>";
                                                echo "<td>" . $row['isbn'] . "</td>";
                                                echo "<td>" . $row['jumlah_pinjam'] . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "Tidak ada buku favorit.";
                                        }
                                        ?>
                            </table>
                        <?php
                                }
                        ?>
                        </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /fav -->

        <div class="row">
            <!-- -->
            <?php
            include "../../config/koneksi.php";
            $query = mysqli_query($koneksi, "SELECT * FROM identitas");
            $row = mysqli_fetch_assoc($query);

            ?>

        </div>
    </section>
    <!-- /.content -->
</div>