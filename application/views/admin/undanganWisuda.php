<?php
// Set locale ke bahasa Indonesia
setlocale(LC_TIME, 'id_ID.UTF-7');
function tanggalIndo($tanggal)
{
    $bulanInggris = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    ];

    $hariInggris = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];

    $hari = $hariInggris[date('l', strtotime($tanggal))];
    $tanggal = date('d', strtotime($tanggal));
    $bulan = $bulanInggris[date('F', strtotime($tanggal))];
    $tahun = date('Y', strtotime($tanggal));
    $waktu = date('H.i', strtotime($tanggal));

    return "$hari, $tanggal $bulan $tahun";
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $undangan->nama_acara ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sacramento&family=Work+Sans:wght@100;300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('vendor/tema1/'); ?>style.css">
</head>

<body>

    <section id="hero" class="hero w-100 h-100 p-3 mx-auto text-center d-flex justify-content-center align-items-center text-white">
        <main class="d-flex flex-column align-items-center">
            <div class="logo"><img src="<?= base_url('vendor/tema1/img/'); ?>logo-amik.png" alt=""></div>
            <h2>Undangan Digital</h2>
            <h1><?= $undangan->nama_acara ?></h1>
            <p><?= $undangan->detail_acara ?></p>
            <div class="card">
                <div class="card-body">
                    <p><?= $tamu->nama_tamu ?></p>
                    <p><?= $tamu->no_hp ?></p>
                </div>
            </div>
            <a href="#home" class="btn btn-lg mt-4" onClick="enableScroll()">Lihat Undangan</a>
        </main>

    </section>

    <nav class="navbar navbar-expand-md bg-transparent sticky-top mynavbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="<?= base_url('vendor/tema1/img/'); ?>logo-amik.png" alt="">
            </a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Dino</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link" href="#home">Home</a>
                        <a class="nav-link" href="#info">Info</a>
                        <a class="nav-link" href="#gallery">Gallery</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <section id="home" class="home">
        <div class="container">
            <div class="row justify-content-center">
                <div class="text-center">
                    <h2>Assalamualaikum Wr. Wb.</h2> <br>
                </div>
                <div class="col-md-8 text-center">
                    <p>Mengharap hormat kehadiran Bapak/Ibu/Saudara/i pada acara </p>
                    <h1><?= $undangan->nama_acara ?></h1>
                    <h3><?= $undangan->detail_acara ?></h3>
                    <p>Yang akan diselenggarakan pada:</p>
                </div>

            </div>
            <div class="text-center">
                <h3>Hari: <span><?= strftime('%A', strtotime($undangan->waktu)) ?></span></h3>
                <h3>Tanggal: <span><?= date('d F Y', strtotime($undangan->waktu)) ?></span></h3>
                <h3>Waktu: <span><?= date('H:i', strtotime($undangan->waktu)) ?> - Selesai</span></h3>

                <h3>Tempat: <span><?= $undangan->tempat ?></span> </h3> <br>
            </div>
            <div class="text-center">
                <p>Demikian Undangan ini kami sampaikan,Atas perhatian dan kedatangan Bapak/Ibu/Saudara/i</p>
                <p>Kami ucapkan terimakasih.</p>
            </div>
            <div class="text-center">
                <h2>Wassalamualaikum Wr. Wb.</h2> <br>
            </div>
        </div>
    </section>


    <section id="info" class="info">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-10 text-center">
                    <h2>Informasi Acara</h2>
                    <p class="alamat">Alamat: <?= $undangan->tempat ?></p>

                    <a href="<?= $undangan->link_maps ?>" target="_blank" class="btn btn-light btn-sm my-3">Klik untuk
                        membuka peta</a>
                    <p class="description">Diharapkan untuk tidak salah alamat dan tanggal. Manakala tiba di tujuan namun tidak
                        ada tanda-tanda sedang dilangsungkan acara wisuda, boleh jadi Anda salah jadwal, atau salah tempat. Terima Kasih!</p>
                </div>
                <div class="card">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h5>QR Code </h5>
                        <img src="<?= $qr_code_url ?>" alt="QR Code" style="width: 300px">
                    </div>
                </div>


            </div>
    </section>

    <section id="gallery" class="gallery">
        <div class="container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-10 text-center">
                        <h2>Galeri Foto</h2>
                    </div>
                </div>
                <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 justify-content-center">
                    <div class="col mt-3">
                        <a href="<?= base_url('vendor/tema1/'); ?>img/gallery/wisuda1.jpg" data-toggle="lightbox" data-caption="" data-gallery="mygallery">
                            <img src="<?= base_url('vendor/tema1/'); ?>img/gallery/wisuda1.jpg" alt="" class="img-fluid w-100 rounded">
                        </a>
                    </div>
                    <div class="col mt-3">
                        <a href="<?= base_url('vendor/tema1/'); ?>img/gallery/wisuda2.jpeg" data-toggle="lightbox" data-caption="" data-gallery="mygallery">
                            <img src="<?= base_url('vendor/tema1/'); ?>img/gallery/wisuda2.jpeg" alt="" class="img-fluid w-100 rounded">
                        </a>
                    </div>
                    <div class="col mt-3">
                        <a href="<?= base_url('vendor/tema1/'); ?>img/gallery/wisuda3.jpeg" data-toggle="lightbox" data-caption="" data-gallery="mygallery">
                            <img src="<?= base_url('vendor/tema1/'); ?>img/gallery/wisuda3.jpeg" alt="" class="img-fluid w-100 rounded">
                        </a>
                    </div>
                    <div class="col mt-3">
                        <a href="<?= base_url('vendor/tema1/'); ?>img/gallery/wisuda4.jpg" data-toggle="lightbox" data-caption="" data-gallery="mygallery">
                            <img src="<?= base_url('vendor/tema1/'); ?>img/gallery/wisuda4.jpg" alt="" class="img-fluid w-100 rounded">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <small class="block">&copy; 2024 AMIK Taruna Probolinggo</small>
                    <small class="block">Design by <a href="https://www.instagram.com/rizkyymmm/?hl=en">@rizkyymmm</a>.</small>

                    <ul class=" mt-3">
                        <li><a href="https://www.instagram.com/official_amiktarunaprobolinggo/?hl=en"><i class="bi bi-instagram"></i></a></li>
                        <li><a href="https://www.youtube.com/@atpcreativity"><i class="bi bi-youtube"></i></a></li>
                        <li><a href="https://amik-taruna.ac.id/"><i class="bi bi-browser-chrome"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div id="audio-container">
        <audio id="song" autoplay loop>
            <source src="<?= base_url('vendor/tema1/'); ?>audio/sayonara-crawl.mp3" type="audio/mp3">
        </audio>

        <div class="audio-icon-wrapper" style="display: none;">
            <i class="bi bi-disc"></i>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>


    <script>
        const stickyTop = document.querySelector('.sticky-top');
        const offcanvas = document.querySelector('.offcanvas');

        offcanvas.addEventListener('show.bs.offcanvas', function() {
            stickyTop.style.overflow = 'visible';
        });

        offcanvas.addEventListener('hidden.bs.offcanvas', function() {
            stickyTop.style.overflow = 'hidden';
        });
    </script>

    <script>
        const rootElement = document.querySelector(":root");
        const audioIconWrapper = document.querySelector('.audio-icon-wrapper');
        const audioIcon = document.querySelector('.audio-icon-wrapper i');
        const song = document.querySelector('#song');
        let isPlaying = false;

        function disableScroll() {
            scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

            window.onscroll = function() {
                window.scrollTo(scrollTop, scrollLeft);
            }

            rootElement.style.scrollBehavior = 'auto';
        }

        function enableScroll() {
            window.onscroll = function() {}
            rootElement.style.scrollBehavior = 'smooth';
            // localStorage.setItem('opened', 'true');
            playAudio();
        }

        function playAudio() {
            song.volume = 0.1;
            audioIconWrapper.style.display = 'flex';
            song.play();
            isPlaying = true;
        }

        audioIconWrapper.onclick = function() {
            if (isPlaying) {
                song.pause();
                audioIcon.classList.remove('bi-disc');
                audioIcon.classList.add('bi-pause-circle');
            } else {
                song.play();
                audioIcon.classList.add('bi-disc');
                audioIcon.classList.remove('bi-pause-circle');
            }

            isPlaying = !isPlaying;
        }

        // if (!localStorage.getItem('opened')) {
        //   disableScroll();
        // }
        disableScroll();
    </script>
    <script>
        window.addEventListener("load", function() {
            const form = document.getElementById('my-form');
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                const data = new FormData(form);
                const action = e.target.action;
                fetch(action, {
                        method: 'POST',
                        body: data,
                    })
                    .then(() => {
                        alert("Konfirmasi kehadiran berhasil terkirim!");
                    })
            });
        });
    </script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const nama = urlParams.get('n') || '';
        const pronoun = urlParams.get('p') || 'Bapak/Ibu/Saudara/i';
        const namaContainer = document.querySelector('.hero h4 span');
        namaContainer.innerText = `${pronoun} ${nama},`.replace(/ ,$/, ',');

        document.querySelector('#nama').value = nama;
    </script>
</body>

</html>