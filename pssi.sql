-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 11, 2021 at 05:01 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pssi`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(13) NOT NULL COMMENT 'id berita',
  `judul_berita` varchar(100) NOT NULL COMMENT 'judul berita',
  `isi_berita` text NOT NULL COMMENT 'isi berita',
  `kategori_berita` varchar(50) NOT NULL COMMENT 'kategori/label',
  `status_berita` enum('Diterbitkan','Draft') NOT NULL COMMENT 'status berita',
  `penulis_berita` varchar(30) NOT NULL COMMENT 'penulis',
  `gambar_berita` varchar(255) NOT NULL COMMENT 'gambar',
  `tanggal_berita` varchar(25) DEFAULT NULL COMMENT 'tanggal berita',
  `tanggal_berita_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `judul_berita`, `isi_berita`, `kategori_berita`, `status_berita`, `penulis_berita`, `gambar_berita`, `tanggal_berita`, `tanggal_berita_update`) VALUES
(2, 'Pssi Akan Gelar Kongres Tahunan Akhir Bulan Februari', '&lt;p&gt;PSSI berencana menggelar Kongres Biasa Tahun 2021 di Jakarta, 27 Februari 2021 mendatang. Keputusan untuk tetap melangsungkan agenda rutin tahunan itu sesuai hasil rapat Komite Eksekutif pada 16 Desember 2020 lalu.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Melalui surat nomor 2847/PGD/677/XII-2020, PSSI juga telah menyebarkan pemberitahuan perihal kongres biasa tahun 2021 kepada anggotanya.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;quot;Sebagaimana statuta PSSI pasal 32 ayat (2), PSSI melalui rapat Komite Eksekutif pada tanggal 16 Desember 2020 memutuskan bahwa kongres biasa PSSI tahun 2021 akan diselenggarakan pada hari Sabtu, 27 Februari 2021 di Jakarta,&amp;quot; ungkap PSSI dalam&amp;nbsp;surat bertanda tangan Plt. Sekretaris Jenderal PSSI, Yunus Nusi.&lt;/p&gt;\r\n\r\n&lt;p&gt;Namun, belum diketahui apakah Kongres Biasa PSSI tahun depan akan berlangsung secara virtual atau tidak. Sebab, hingga saat ini wabah Covid-19 belum terkendali, bahkan cenderung terus meningkat.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;quot;Sehubungan dengan adanya pandemi Covid-19, PSSI masih mempertimbangakan opsi kehadiran baik secara langsung atau virtual dengan melihat situasi pandemi Covid-19, di waktu sebagaimana ditentukan pada poin satu. Keputusan terkait opsi kehadiran akan disampaikan kemudian,&amp;quot; lanjutnya.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;quot;Sebagaimana Statuta PSSI Pasal 32 ayat (3), usulan agenda Kongres Biasa PSSI dapat disampaikan secara tertulis oleh anggota PSSI selambat-lambatnya 45 (empat puluh lima) hari sebelum pelaksanaan Kongres Biasa PSSI, yaitu tanggal 13 Januari 2021,&amp;quot; jelasnya.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Surat tertanggal 21 Desember 2020 ini pun menyampaikan bahwa agenda resmi Kongres Biasa PSSI 2021 akan disampaikan kepada anggota tujuh hari sebelum kegiatan berlangsung. ***&lt;/p&gt;', 'berita', 'Diterbitkan', 'Ahmad Zaelani', 'berita718168.jpeg', 'Jumat, 25 Desember 2020', '2020-12-25 13:15:22'),
(3, 'Eka Ramdani Kembali Ke Persib Dan Putuskan Gantung Sepatu Usai Liga 1 2018', '&lt;p&gt;Liga 1 2018 menjadi panggung terakhir perjalanan karier sepakbola Eka Ramdani. Usai kompetisi, pemain yang akrab disapa Ebol ini memutuskan untuk gantung sepatu&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;PERSIB menjadi klub profesional terakhir dalam kariernya. Pemain kelahiran 18 Juni 1984 tersebut memang punya keinginan pensiun bersama Pangeran Biru.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Tahun 2018, Eka didatangkan dari Persela Lamongan. Eka memang bukan nama baru bagi Bobotoh. Memulai karier usia 16 tahun bersama PERSIB, hingga pindah ke Persijatim pada 2003-2004. Tahun berikutnya dia kembali ke PERSIB hingga 2011.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Kemudian pindah ke Persisam Samarinda, Pelita Bandung Raya, Semen Padang, Sriwijaya FC, hingga terakhir Persela Lamongan.&lt;/p&gt;\r\n\r\n&lt;p&gt;Pada Liga 1 2018, Eka tampil 14 laga dengan total bermain selama 404 menit untuk PERSIB.&amp;nbsp;&lt;br /&gt;\r\nData yang terhimpun, sejak 2009, pemain jebolan PERSIB junior tersebut sudah bermain selama 12.873 menit dari 166 laga. Mencetak 12 gol dengan 11 kartu kuning, tanpa kartu merah.***&lt;/p&gt;', 'berita', 'Diterbitkan', 'Ahmad Zaelani', 'berita466515.jpg', 'Jumat, 25 Desember 2020', '2020-12-25 13:14:44'),
(4, 'Terapkan Prokes, Praliga Akademi Persib U-13 Berjalan Sukses', '&lt;p&gt;Akademi PERSIB Kota Bogor menggelar Praliga Akademi PERSIB U-13 di Lapangan Yonif 315, pada 23-24 Desember 2020 kemarin. Kegiatan itu dinilai&amp;nbsp;sukses meski digelar di tengah pandemi Covid-19&amp;nbsp;berkat keterlibatan banyak pihak dalam penerapan protokol kesehatan (prokes).&lt;/p&gt;\r\n\r\n&lt;p&gt;Manajer Akademi PERSIB Kota Bogor, Dodi Irwan Suparno pun menyampaikan apresiasi kepada pihak Yonif 315 dalam penerapan protokol kesehatan itu. Protokol yang diterapkan meliputi pembatasan pengunjung, yang hanya meliputi pemain, ofisial dan panitia, penyediaan sarana cuci tangan, pengecekan suhu tubuh dan&amp;nbsp;&lt;em&gt;spray&lt;/em&gt;&amp;nbsp;disinfektan.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;quot;Akademi PERSIB sebagai tuan rumah sangat terbantu dengan adanya pihak Yonif 315. Terima kasih kepada Yonif 315 yang telah menyediakan fasilitas lapangan, juga membantu program kami bisa berjalan walau di tengah Covid-19, &amp;quot; kata Dodi.&lt;/p&gt;\r\n\r\n&lt;p&gt;Dodi menambahkan, Praliga Akademi PERSIB U-13 juga mendapat dukungan dari pihak-pihak lain, seperti Tim Gugus Tugas Percepatan Penanganan Covid-19 di Kota Bogor dan Asosiasi PSSI Kota Bogor hingga para orangtua siswa Akademi PERSIB Kota Bogor.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;quot;Kami juga mendapat rekomendasi dari Gugus Tugas Covid-19, Askot PSSI Kota Bogor, pemerintah kota, hingga orangtua siswa. Kalau banyak pihak yang mendukung, mudah-mudahan ini jadi awal yang baik untuk sepakbola Bogor, Jawa Barat dan Indonesia ke depannya, &amp;quot; jelasnya.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Ditemui di tempat yang&amp;nbsp;sama, Sekretaris Asosiasi PSSI Kota Bogor Irsan Tena menilai kegiatan Praliga Akademi PERSIB U-13 sebagai hal positif dan bisa menjadi acuan di dalam menggelar pembinaan pemain di usia muda.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;quot;Cuma karena masih masa pandemi, hal-hal seperti protokol kesehatan jika dilakukan dengan baik, saya rasa aman-aman saja. Alhamdulillah panitia menjalankan surat yang diberikan Satgas Covid-19. Intinya, ini sangat bagus untuk anak-anak di usia dini, &amp;quot; tuturnya. ****&amp;nbsp;&lt;/p&gt;', 'berita', 'Diterbitkan', 'Ahmad Zaelani', 'berita919778.jpg', 'Jumat, 25 Desember 2020', '2020-12-25 13:13:48'),
(5, '(25 Desember 2018) Persib Perkenalkan Prabu', '&lt;p&gt;Hari ini&amp;nbsp;dua tahun yang lalu, PERSIB secara resmi memperkenalkan maskot bernama Prabu kepada publik dan Bobotoh. Pengumuman itu disampaikan melalui akun media sosial resmi klub, 25 Desember 2018 dengan penuh suka cita.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Prabu sendiri merupakan singkatan dari julukan PERSIB, yakni Pangeran Biru. Penamaan tersebut juga diilhami dari nama salah satu tokoh yang pernah berkuasa di tatar Sunda, Prabu Siliwangi.&lt;/p&gt;\r\n\r\n&lt;p&gt;Itulah sebabnya, wujud maskot Prabu ini sangat identik dengan seekor Harimau Jawa (&lt;em&gt;Panthera tigris&lt;/em&gt;) bercorak loreng-loreng yang berbaju PERSIB.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Dari karakternya, Prabu adalah maskot yang ceria, atraktif, penuh semangat sekaligus jenaka. Ia pun selalu tampil menawan dan ramah setiap kali berjumpa dengan Bobotoh di dalam ataupun di luar stadion. Tak heran, setiap orang akan merasa sangat nyaman setiap kali bertemu dengan si Prabu.***&lt;/p&gt;', 'berita', 'Diterbitkan', 'Ahmad Zaelani', 'berita584758.jpg', 'Jumat, 25 Desember 2020', '2020-12-25 13:20:51'),
(6, 'Persib Pernah Bantai Persik 6-1 Di Isl 2009/2010', '&lt;p&gt;PERSIB pernah mengalahkan Persik Kediri dengan skor telak 6-1 di Stadion Si Jalak Harupat, Kabupaten Bandung dalam lanjutan kompetisi Indonesia Super League (ISL) 2009/2010, 26 Januari 2010.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Bermain di hadapan pendukungnya sendiri, skuad Pangeran Biru tampil beringas dengan kepercayaan diri tinggi. Namun begitu, baru pada menit ke-32, tim tuan rumah membuka keunggulan. Tendangan terukur dari dalam kotak penalti&amp;nbsp;&lt;em&gt;striker&lt;/em&gt;&amp;nbsp;Cristian Gonzales tak mampu diantisipasi kiper Persik&amp;nbsp;dan mengubah skor menjadi 1-0.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Empat menit jelang jeda turun minum, PERSIB menggandakan keunggulan. Kali ini, Hilton Moreira yang berhasil membuat seisi stadion bergumuruh. Babak pertama berakhir dengan keunggulan 2-0 untuk tuan rumah.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Di babak kedua, Pangeran Biru semakin mendominasi pertandingan. Sementara Persik lebih banyak terkurung di area pertahanan sendiri. Alhasil, PERSIB mampu menambah empat gol tambahan melalui Nova Arianto (52), Suchao Nutnum (63), Budi Sudarsono (79, 90). Sedangkan gol balasan Persik dicetak oleh Patricio Morales pada menit ke-55.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Berkat kemenangan ini, PERSIB melejit ke posisi tiga klasemen sementara dengan torehan 27 poin dari 17 pertandingan.***&lt;/p&gt;', 'berita liga', 'Diterbitkan', 'Ahmad Zaelani', 'berita911142.jpg', 'Jumat, 25 Desember 2020', '2020-12-29 20:16:27'),
(7, 'Budiman: Aqil Sangat Layak Bersaing Di Timnas', '&lt;p&gt;Asisten pelatih PERSIB&amp;nbsp;Budiman mengaku senang dengan pemanggilan&amp;nbsp;kembali kiper Aqil Savik untuk mengikuti pemusatan latihan bersama Tim Nasional Indonesia. Menurut eks pelatih Diklat PERSIB tersebut, Aqil memang sangat pantas untuk mencapai level ini berkat kerja keras dan kemampuan yang dimiliki.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;quot;Tentunya, sebagai pelatih ini satu keberhasilan&amp;nbsp;dan kebanggaan buat PERSIB karena ada pemain yang dipanggil timnas,&amp;quot; ungkap Budiman, Selasa 22 Desember 2020.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;quot;Saya yakin, Aqil pemain yang layak untuk dipanggil timnas dan bisa bersaing dengan pemain lain,&amp;quot; tambahnya.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;Sebagaimana diketahui, Aqil dipanggil untuk mengikuti program pemusatan latihan bersama skud Garuda guna menyongsong pesta olahraga Asia Tenggara (SEA Games) yang akan digelar tahun depan.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;quot;Semoga Aqil bisa sukses bersama Timnas dan dia bisa menjadi motivasi bagi pemain muda PERSIB lainnya, sukses Aqil,&amp;quot; ucap Budiman.***&lt;/p&gt;', 'berita', 'Diterbitkan', 'Ahmad Zaelani', 'berita735897.jpg', 'Jumat, 25 Desember 2020', '2020-12-25 13:29:09'),
(8, 'Ukur Performa Pemain, Akademi Persib Gunakan Perangkat Canggih', '&lt;p style=&quot;text-align:justify&quot;&gt;Akademi PERSIB Kota Bandung terus melakukan terobosan dalam meningkatkan kualitas pembinaan pemain. Salah satu yang terbaru adalah penggunaan perangkat yang dilengkapi sistem navigasi berbasis satelit. Melalui alat tersebut, tim pelatih bisa mendapat informasi akurat terkait performa pemain dan perkembangannya.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p style=&quot;text-align:justify&quot;&gt;Pelatih Akademi PERSIB&amp;nbsp;Imam Nurjaman menyatakan, tim pelatih ingin terus memberikan yang terbaik untuk para pemain, termasuk penerapan teknologi untuk&amp;nbsp;menunjang program latihan.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p style=&quot;text-align:justify&quot;&gt;&amp;quot;Setiap waktu, kami di Akademi PERSIB &amp;nbsp;ingin memberikan yang terbaik. Di sini, tim pelatih ingin mengukur performa pemain baik dalam latihan maupun pertandingan, dan bagaimana perkembangan pemain itu dalam berkontribusi untuk tim, &amp;nbsp;&amp;quot; ujar Imam, Selasa 22 Dsember 2020.&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p style=&quot;text-align:justify&quot;&gt;Ia menjelaskan, perangkat&amp;nbsp;tersebut bekerja dengan melacak pergerakan pemain di&amp;nbsp;lapangan. Selain pergerakan, alat itu juga mampu mendeteksi informasi pada tubuh pemain bersangkutan. Beberapa klub di dunia kabarnya telah menggunakan alat canggih tersebut .&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p style=&quot;text-align:justify&quot;&gt;&amp;quot;Semoga dengan adanya alat ini, kualitas pembinaan terhadap pemain di lingkungan Akademi PERSIB bisa lebih baik. Karena pada akhirnya nanti, manfaat tidak hanya untuk pemain dan tim tapi kembali untuk Akademi PERSIB lagi, &amp;quot; harapnya. ****&amp;nbsp;&lt;/p&gt;', 'berita', 'Diterbitkan', 'Ahmad Zaelani', 'berita446039.jpg', 'Jumat, 25 Desember 2020', '2020-12-25 13:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `berita_kategori`
--

CREATE TABLE `berita_kategori` (
  `id_kategori` int(10) NOT NULL COMMENT 'id kategori',
  `kategori_berita` varchar(50) NOT NULL COMMENT 'kategori berita'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `berita_kategori`
--

INSERT INTO `berita_kategori` (`id_kategori`, `kategori_berita`) VALUES
(1, 'berita'),
(2, 'berita liga');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_pemain`
--

CREATE TABLE `dokumen_pemain` (
  `id_pemain` int(11) NOT NULL COMMENT 'id dokumen pemain',
  `id_user` int(13) NOT NULL COMMENT 'id akun user',
  `dok_kartu_keluarga` varchar(100) DEFAULT NULL COMMENT 'dokumen kk',
  `dok_akte_lahir` varchar(100) DEFAULT NULL COMMENT 'dokumen akte',
  `dok_raport` varchar(100) DEFAULT NULL COMMENT 'dokumen raport'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dokumen_pemain`
--

INSERT INTO `dokumen_pemain` (`id_pemain`, `id_user`, `dok_kartu_keluarga`, `dok_akte_lahir`, `dok_raport`) VALUES
(5, 12, NULL, NULL, NULL),
(6, 13, NULL, NULL, NULL),
(7, 14, NULL, NULL, NULL),
(8, 15, NULL, NULL, NULL),
(9, 16, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_liga`
--

CREATE TABLE `jadwal_liga` (
  `id_jadwal` int(13) NOT NULL COMMENT 'id jadwal dan skor liga',
  `id_liga` int(13) NOT NULL COMMENT 'id liga',
  `minggu_ke` tinyint(4) NOT NULL COMMENT 'minggu tanding',
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `tanggal` varchar(10) NOT NULL COMMENT 'tanggal pertandingan',
  `jam` varchar(5) NOT NULL COMMENT 'jam mulai',
  `tim_tuan_rumah` tinyint(4) NOT NULL COMMENT 'tuan rumah',
  `tim_tamu` tinyint(4) NOT NULL COMMENT 'tim tamu',
  `skor_tuan_rumah` tinyint(3) NOT NULL DEFAULT 0 COMMENT 'skor tuan rumah',
  `skor_tim_tamu` tinyint(3) NOT NULL DEFAULT 0 COMMENT 'skor tamu',
  `tempat` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal_liga`
--

INSERT INTO `jadwal_liga` (`id_jadwal`, `id_liga`, `minggu_ke`, `hari`, `tanggal`, `jam`, `tim_tuan_rumah`, `tim_tamu`, `skor_tuan_rumah`, `skor_tim_tamu`, `tempat`) VALUES
(1, 12, 8, 'Minggu', '04-12-2020', '02:32', 1, 4, 4, 0, 'GBK'),
(2, 12, 2, 'Kamis', '05-12-2020', '07:00', 1, 5, 3, 3, 'GBK'),
(3, 12, 3, 'Jumat', '21-12-2020', '20:00', 5, 4, 0, 0, 'Persita Stadion');

-- --------------------------------------------------------

--
-- Table structure for table `liga`
--

CREATE TABLE `liga` (
  `id_liga` int(13) NOT NULL COMMENT 'id liga ',
  `nama_liga` varchar(64) NOT NULL COMMENT 'nama liga sepak bola',
  `tahun_penyelenggaraan` year(4) NOT NULL,
  `nama_penyelenggara` varchar(64) NOT NULL COMMENT 'penyelenggara liga',
  `jumlah_tim` tinyint(4) NOT NULL COMMENT 'jumlah tim peserta',
  `sistem_pertandingan` enum('Sistem Setengah Kompetisi','Sistem Kompetisi Penuh','Sistem Gugur Tunggal','Sistem Gugur Rangkap','Sistem Consulation','Sistem Kombinasi') NOT NULL COMMENT 'sistem pertandingan',
  `logo_liga` varchar(50) DEFAULT NULL COMMENT 'logo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `liga`
--

INSERT INTO `liga` (`id_liga`, `nama_liga`, `tahun_penyelenggaraan`, `nama_penyelenggara`, `jumlah_tim`, `sistem_pertandingan`, `logo_liga`) VALUES
(12, 'Liga Shopee', 2021, 'Anak Bola Sumsel', 8, 'Sistem Setengah Kompetisi', 'logo_liga_530316.png'),
(13, 'Festival Garuda Food', 2022, 'Garuda Food', 18, 'Sistem Setengah Kompetisi', 'logo_liga_548751.png');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(5) NOT NULL COMMENT 'id menu',
  `nama_menu` varchar(30) NOT NULL COMMENT 'nama menu',
  `kategori_menu` enum('single_menu','dropdown_menu','sub_menu') NOT NULL COMMENT 'kategori',
  `link_menu` varchar(100) NOT NULL COMMENT 'link menu',
  `urut` int(2) NOT NULL COMMENT 'urut',
  `parent` int(2) NOT NULL DEFAULT 0 COMMENT 'sub menu parent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `kategori_menu`, `link_menu`, `urut`, `parent`) VALUES
(3, 'Jadwal Pertandingan', 'single_menu', 'http://localhost/soccer/semua_jadwal.php', 4, 0),
(4, 'Berita', 'single_menu', 'http://localhost/soccer/semua_berita.php', 3, 0),
(5, 'Club', 'single_menu', 'http://localhost/soccer/semua_club.php', 5, 0),
(11, 'Profile', 'dropdown_menu', '#', 2, 0),
(12, 'Sejarah', 'sub_menu', 'http://localhost/soccer/profile.php?id_pages=1', 1, 11),
(13, 'Visi Misi', 'sub_menu', 'http://localhost/soccer/profile.php?id_pages=2', 2, 11),
(14, 'Struktur Organisasi', 'sub_menu', 'http://localhost/soccer/profile.php?id_pages=3', 3, 11),
(15, 'Login', 'single_menu', 'http://localhost/soccer/login.php', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id_pages` int(11) NOT NULL,
  `judul_pages` varchar(100) NOT NULL,
  `isi_pages` text NOT NULL,
  `penulis_pages` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id_pages`, `judul_pages`, `isi_pages`, `penulis_pages`) VALUES
(1, 'Sejarah', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque sit amet semper dui. Nam venenatis et purus id sollicitudin. Nulla ac arcu tristique, laoreet sapien quis, pellentesque lectus. Praesent ultrices erat tortor, eu vulputate leo congue sed. Aenean ac justo libero. Proin ipsum eros, sagittis at nisl eget, volutpat tristique justo. Nunc in arcu eu risus pulvinar blandit. Aenean pellentesque quis tortor nec sagittis. Nullam convallis at tellus at varius.&lt;/p&gt;\r\n\r\n&lt;p&gt;Aenean vulputate tellus libero, ac interdum arcu molestie a. Morbi ac malesuada neque, in eleifend dui. Aliquam quis quam ligula. Nam vel nisl eget turpis commodo viverra. Aenean mauris libero, molestie nec felis id, gravida interdum arcu. In et purus lorem. Integer ullamcorper in felis maximus ultrices. Cras arcu ante, ullamcorper nec elementum sed, viverra quis nisi. Proin tincidunt id sapien tincidunt facilisis. Sed varius turpis non molestie aliquam. Quisque egestas lacus et velit ultricies, lobortis finibus sem blandit. Vestibulum ante eros, rutrum ut augue in, consectetur vehicula purus. Sed tellus tellus, dictum et ligula ac, pretium fringilla elit. Suspendisse porta, enim non suscipit vulputate, nulla diam mollis lorem, at mollis lorem justo et ex. Nulla aliquet lacus suscipit nisl cursus, sed eleifend ligula consequat.&lt;/p&gt;\r\n\r\n&lt;p&gt;Aliquam fermentum elit at efficitur aliquet. Fusce non est cursus metus porta elementum eget nec lorem. Pellentesque sollicitudin pellentesque molestie. Quisque ut semper metus. Praesent volutpat eget libero eu dignissim. In eu ante convallis nisi malesuada sollicitudin eget egestas est. Integer vulputate risus sed lectus pulvinar, sit amet elementum felis dapibus. Aenean non est et est malesuada ultrices a et velit. Cras purus enim, gravida a enim sed, porttitor placerat nisi. Pellentesque nec molestie sapien, eu pulvinar lorem. Donec porttitor dictum turpis, non semper velit aliquam non. Ut feugiat in lectus nec iaculis.&lt;/p&gt;\r\n\r\n&lt;p&gt;Curabitur faucibus tincidunt risus vitae faucibus. Mauris lobortis lacus vitae semper convallis. Sed fermentum magna non euismod sodales. Etiam vel purus commodo, vestibulum eros eget, lacinia arcu. Praesent a justo auctor, ultrices arcu nec, blandit diam. Suspendisse neque nunc, pharetra in congue eget, consequat sit amet mauris. Praesent sit amet mauris at leo porttitor laoreet eget sit amet nisi. Praesent porta est ipsum, vitae aliquam orci feugiat quis. Integer sit amet tristique risus. Aliquam erat volutpat. Proin vulputate dignissim neque, eget laoreet nulla dapibus a.&lt;/p&gt;\r\n\r\n&lt;p&gt;Maecenas vulputate sit amet risus ac laoreet. Aliquam porttitor ornare metus elementum efficitur. Maecenas pharetra ipsum sit amet condimentum finibus. Aliquam vitae posuere est. Mauris gravida libero pulvinar dolor finibus, et sollicitudin arcu dictum. Curabitur vel eleifend sapien. Sed feugiat viverra purus. Aliquam auctor sodales odio ac tempus. Duis nec dolor augue. Maecenas sapien enim, mattis et consequat eget, mollis id justo. Vivamus suscipit tristique commodo. Quisque ut augue vel est egestas vehicula&lt;/p&gt;', 'Ahmad Zaelani'),
(2, 'Visi Misi', '&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec justo quis tellus consequat eleifend a eu ante. Donec ac vestibulum neque. Sed in malesuada nibh. Maecenas blandit dolor et mauris pretium, et vestibulum nisl placerat. Vestibulum blandit at libero cursus luctus. Aliquam porttitor vestibulum lectus non accumsan. Curabitur maximus semper ante, id laoreet nunc luctus a. Duis accumsan, nisi non aliquet tincidunt, ipsum dui convallis ipsum, vitae porttitor tellus libero id velit.&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Sed vitae aliquam sem, quis porta lectus. Vestibulum et aliquam eros, sit amet ultricies est. Sed consectetur imperdiet accumsan. Nam tincidunt imperdiet tempor. Cras neque eros, luctus eu dui ut, hendrerit aliquet metus. Aenean consequat enim magna, quis consequat odio maximus ac. Vestibulum pulvinar nisi sit amet eros volutpat, in tincidunt nulla consequat. Nulla aliquet, mi in ornare tristique, arcu lectus porta nisl, nec facilisis augue urna ac libero. Praesent sed nulla tincidunt nulla ultrices viverra. Nam sit amet vestibulum est.&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce in lorem lectus. Sed auctor ultricies felis ac aliquam. Ut bibendum malesuada velit, ut porttitor tellus eleifend ut. Etiam pulvinar sapien non condimentum pretium. Aenean scelerisque libero nulla. Maecenas nisl est, vestibulum sed purus volutpat, tempus ultrices ligula.&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent iaculis massa quis lacus vestibulum semper. Fusce mollis laoreet nisi, lobortis sodales turpis suscipit sit amet. Nam erat enim, molestie quis pulvinar auctor, viverra et mauris. Ut dignissim, metus nec blandit congue, risus dolor mollis velit, vel scelerisque lorem ligula et nibh. Mauris pretium, urna sed iaculis euismod, tellus nisi auctor erat, vitae hendrerit risus velit ac tellus. Donec porta sapien mauris. Nulla fringilla elit vel rutrum ultricies. Aenean pharetra faucibus urna malesuada tristique. Aenean libero lorem, egestas nec consectetur non, porta nec felis. Vestibulum a turpis ut libero congue dapibus et in felis. Nullam lobortis rutrum sem, eu varius arcu auctor eget. Maecenas quis nisi nisl. Suspendisse elementum imperdiet leo a pretium. Etiam rutrum tellus vitae felis convallis, a consectetur felis placerat. Nunc elementum nunc nec pellentesque imperdiet.&lt;/span&gt;&lt;/p&gt;', 'Ahmad Zaelani'),
(3, 'Struktur Organisasi', '&lt;ul&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Quisque quis nulla quis leo efficitur blandit.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Nulla quis ante ullamcorper enim dignissim porta.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Nam id enim suscipit, finibus orci et, congue ex.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;In tincidunt lacus sit amet ultrices volutpat.&lt;/span&gt;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Ut egestas sapien eu mauris elementum maximus.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Maecenas id odio mollis eros ullamcorper tincidunt.&lt;/span&gt;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Maecenas nec diam vitae enim aliquam ornare non sed arcu.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Aenean euismod nisi in lorem pretium, eget lobortis risus egestas.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Fusce vel lectus tincidunt, varius augue sed, egestas elit.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Duis ornare purus et odio volutpat vehicula.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Fusce sed lacus vitae sapien vehicula porttitor porttitor et enim.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Aenean tempor dolor molestie dui posuere, vitae malesuada est volutpat.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Vestibulum porta metus at congue tempus.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Curabitur eleifend metus eu turpis venenatis posuere.&lt;/span&gt;&lt;/li&gt;\r\n	&lt;li&gt;&lt;span style=&quot;font-size:14px&quot;&gt;Maecenas maximus purus vel urna pulvinar, eu rutrum justo pharetra.&lt;/span&gt;&lt;/li&gt;\r\n&lt;/ul&gt;', 'Ahmad Zaelani');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id_pengaturan` tinyint(1) NOT NULL COMMENT 'id',
  `nama_situs` varchar(75) NOT NULL COMMENT 'nama situs',
  `nama_aplikasi` varchar(75) NOT NULL COMMENT 'nama aplikasi',
  `nama_pengelola` varchar(75) NOT NULL COMMENT 'nama admin situs',
  `deskripsi_situs` text NOT NULL,
  `alamat_situs` text NOT NULL COMMENT 'alamat rumah situs',
  `status_situs` enum('Open','Maintenance') NOT NULL COMMENT 'buka tutup situs',
  `logo` varchar(25) NOT NULL COMMENT 'logo situs/aplikasi',
  `favicon` varchar(25) NOT NULL COMMENT 'icon situs'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id_pengaturan`, `nama_situs`, `nama_aplikasi`, `nama_pengelola`, `deskripsi_situs`, `alamat_situs`, `status_situs`, `logo`, `favicon`) VALUES
(1, 'PSSI Kab. OKU', 'e-Soccer', 'Ahmad Zaelani', 'PSSI DPC Kabupaten OKU', 'Jln. Raya parigi No 32 Tlp. (0265) 322 1495', 'Open', 'logo.png', 'icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `peserta_liga`
--

CREATE TABLE `peserta_liga` (
  `id_peserta` int(13) NOT NULL COMMENT 'id peserta liga',
  `id_liga` int(13) NOT NULL COMMENT 'id liga yang terdaftar',
  `id_club` tinyint(4) NOT NULL COMMENT 'id club'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `peserta_liga`
--

INSERT INTO `peserta_liga` (`id_peserta`, `id_liga`, `id_club`) VALUES
(10, 12, 1),
(11, 12, 5),
(12, 12, 4);

-- --------------------------------------------------------

--
-- Table structure for table `profile_admclub`
--

CREATE TABLE `profile_admclub` (
  `id_admclub` int(11) NOT NULL COMMENT 'id admin club',
  `id_user` int(13) NOT NULL COMMENT 'id akun',
  `id_club` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'id club admin',
  `nama_admclub` varchar(64) NOT NULL COMMENT 'nama admin club',
  `tempat_lahir` varchar(50) DEFAULT NULL COMMENT 'tempat lahir',
  `tgl_lahir` varchar(10) DEFAULT NULL COMMENT 'tgl lahir',
  `alamat` text DEFAULT NULL COMMENT 'alamat admin club',
  `kontak_admin` varchar(13) NOT NULL COMMENT 'nomor kontak admin club'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile_admclub`
--

INSERT INTO `profile_admclub` (`id_admclub`, `id_user`, `id_club`, `nama_admclub`, `tempat_lahir`, `tgl_lahir`, `alamat`, `kontak_admin`) VALUES
(1, 4, 1, 'Ridwan Kamil', 'ciamis', '21-01-1994', 'Dusun/Jln. babakan RT 01 RW 04 Desa parigi Kec. parigi Kab.OKU', '082127787598');

-- --------------------------------------------------------

--
-- Table structure for table `profile_club`
--

CREATE TABLE `profile_club` (
  `id_club` int(5) NOT NULL COMMENT 'id club',
  `nama_club` varchar(50) NOT NULL COMMENT 'nama club',
  `alamat_club` text NOT NULL COMMENT 'alamat club',
  `kontak_club` varchar(13) NOT NULL COMMENT 'kontak club',
  `logo_club` varchar(25) NOT NULL COMMENT 'logo club'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile_club`
--

INSERT INTO `profile_club` (`id_club`, `nama_club`, `alamat_club`, `kontak_club`, `logo_club`) VALUES
(1, 'Persib', 'Jln. Dago Bandung No 32', '412077044', 'club293247.png'),
(4, 'Persita', 'Jln. Karawaci No 7 Tangerang Selatan', '432077044', 'club867887.png'),
(5, 'PSM Makasar', 'Jln. Makasar Timur No 32', '442077044', 'club516617.png'),
(6, 'PSS Sleman', 'Selaman Yogyakarta No. 32', '45678', 'club430137.png');

-- --------------------------------------------------------

--
-- Table structure for table `profile_pemain`
--

CREATE TABLE `profile_pemain` (
  `id_pemain` int(11) NOT NULL COMMENT 'id pemain',
  `id_user` int(13) NOT NULL COMMENT 'id user akun',
  `id_club` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'id club pemain',
  `no_punggung_pemain` varchar(2) DEFAULT NULL COMMENT 'no punggung pemain',
  `posisi_pemain` enum('Goal Keeper','Bek Tengah','Bek Sayap','Gelandang','Gelandang Bertahan','Gelandang Tengah','Gelandang Serang','Gelandang Sayap','Penyerang') DEFAULT NULL COMMENT 'posisi pemain',
  `nama_pemain` varchar(64) NOT NULL COMMENT 'nama pemain',
  `nik` varchar(16) NOT NULL COMMENT 'nik pemain',
  `no_kk` varchar(16) DEFAULT NULL COMMENT 'no kk pemain',
  `tempat_lahir` varchar(50) DEFAULT NULL COMMENT 'tempat lahir ',
  `tgl_lahir` varchar(10) DEFAULT NULL COMMENT 'tgl lahir ',
  `tinggi_badan` varchar(5) DEFAULT NULL COMMENT 'tinggi badan',
  `berat_badan` varchar(5) DEFAULT NULL COMMENT 'berat badan',
  `golongan_darah` enum('','A','B','AB','O') NOT NULL COMMENT 'golongan darah',
  `alamat` text DEFAULT NULL COMMENT 'alamat lengkap',
  `kontak_pemain` varchar(13) NOT NULL COMMENT 'kontak pemain'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile_pemain`
--

INSERT INTO `profile_pemain` (`id_pemain`, `id_user`, `id_club`, `no_punggung_pemain`, `posisi_pemain`, `nama_pemain`, `nik`, `no_kk`, `tempat_lahir`, `tgl_lahir`, `tinggi_badan`, `berat_badan`, `golongan_darah`, `alamat`, `kontak_pemain`) VALUES
(6, 12, 1, '09', 'Gelandang Sayap', 'Palovi Hidayat', '3207243007980007', '3207243007980007', 'Jakarta', '20-11-2003', '165', '65', 'AB', 'Dusun/Jln. babakan RT 01 RW 04 Desa parigi Kec. parigi Kab.OKU', '087870693200'),
(7, 13, 5, '1', 'Goal Keeper', 'Toni Handika', '3207243007930006', '3207243007930006', 'bandung', '13-02-2002', '165', '65', 'AB', 'Dusun/Jln. babakan RT 01 RW 04 Desa parigi Kec. parigi Kab.OKU', '087870693200'),
(8, 14, 5, '2', 'Bek Tengah', 'Yayat Hardi', '3207243007930005', '3207243007930005', 'Ciamis', '28-01-2000', '165', '65', 'AB', 'Dusun/Jln. babakan RT 01 RW 04 Desa parigi Kec. parigi Kab.OKU', '087870693200'),
(9, 15, 1, '10', 'Penyerang', 'Jajat Sudrajat', '', '3207243007930008', 'Bandung', '02-03-2000', '165', '64', 'AB', 'Dusun/Jln. Bandung RT 09 RW 09 Desa Kacapiring Kec. Bandung Kab.Bandung', '087870693200'),
(10, 16, 1, '11', 'Gelandang Sayap', 'Windu Sarada', '3207243007930009', '3207243007930009', 'Bandung', '28-01-2000', '170', '68', 'AB', 'Dusun/Jln. Bandung RT 09 RW 09 Desa Kacapiring Kec. Bandung Kab.Bandung', '087870693200');

-- --------------------------------------------------------

--
-- Table structure for table `profile_petugas`
--

CREATE TABLE `profile_petugas` (
  `id_petugas` int(11) NOT NULL COMMENT 'id petugas',
  `id_user` int(13) NOT NULL COMMENT 'id akun user',
  `nama_petugas` varchar(64) NOT NULL COMMENT 'nama petugas',
  `tempat_lahir` varchar(50) DEFAULT NULL COMMENT 'tempat lahir',
  `tgl_lahir` varchar(10) DEFAULT NULL COMMENT 'tanggal lahir',
  `alamat` text DEFAULT NULL COMMENT 'alamat lengkap',
  `kontak_petugas` varchar(13) NOT NULL COMMENT 'kontak petugas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile_petugas`
--

INSERT INTO `profile_petugas` (`id_petugas`, `id_user`, `nama_petugas`, `tempat_lahir`, `tgl_lahir`, `alamat`, `kontak_petugas`) VALUES
(2, 3, 'Yohan Yogaswara', 'Ciamis', '27-08-1993', 'Dusun/Jln. babakan RT 01 RW 04 Desa parigi Kec. parigi Kab.OKU', '082127787593');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `rid` int(10) NOT NULL COMMENT 'id role',
  `name` varchar(64) NOT NULL COMMENT 'nama role',
  `weight` int(11) NOT NULL DEFAULT 0 COMMENT 'hak akses pengguna'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`rid`, `name`, `weight`) VALUES
(1, 'anonymous user', 0),
(2, 'pemain', 1),
(3, 'adminclub', 2),
(4, 'petugas', 3),
(5, 'administrator', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(13) NOT NULL COMMENT 'id of user',
  `nik` varchar(16) NOT NULL COMMENT 'username login',
  `password` varchar(255) NOT NULL COMMENT 'password',
  `role` varchar(15) NOT NULL COMMENT 'hak akses',
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `nama_user` varchar(64) NOT NULL,
  `foto_user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nik`, `password`, `role`, `status`, `nama_user`, `foto_user`) VALUES
(2, '3207243007930001', '$2y$10$JDmShiXLMi3RnUYfHHTQxOZhXp3EUmE0Hrub3W4wgzhav.qXXD6ma', 'administrator', 1, 'Ahmad Zaelani', 'user529313.jpg'),
(3, '3207243007930002', '$2y$10$gjTevavj.uiAGikxTNXOC.CYSzQGPYWDVJsdKPfwrXdpKpBgOBa4m', 'petugas', 1, 'Yohan Yogaswara', '271231.jpeg'),
(4, '3207243007930003', '$2y$10$DjvQ66biptM6fcwIQN38z.GVPz6WPItZJ9vMtXNMKUmskc8dql.A2', 'adminclub', 1, 'Ridwan Kamil', 'user371858.jpg'),
(12, '3207243007980007', '$2y$10$g65feq9TE/fEumKjTh37FOlmkRyW8YgIwG2nrclVo2vPzhIFV3.kK', 'pemain', 1, 'Palovi Hidayat', '968408.jpeg'),
(13, '3207243007930006', '$2y$10$nsjWV6Ez3yuzFvEnUIGCqO4MmD6sBPVuknnVQBCOvU7rKslzH79ju', 'pemain', 1, 'Toni Handika', '448050.jpeg'),
(14, '3207243007930005', '$2y$10$wMJ/Kbf7UYJRnOysMPVQlu.nPKXYQpu4VMH5T5KA/R7FKdFwujRy.', 'pemain', 1, 'Yayat Hardi', '632286.jpeg'),
(15, '3207243007930008', '$2y$10$OdEy0vzTFjR7DPP4s648h.zC9viF8e.boaoDA7759ZEYNl0wrTRX.', 'pemain', 1, 'Jajat Sudrajat', 'pemain809376.jpg'),
(16, '3207243007930009', '$2y$10$pGcHMNenMD2.0GSD2NNcF.ECbOQO5EmG2Cb0l1Qqj1OGJULzqNxKe', 'pemain', 1, 'Windu Sarada', 'pemain236374.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `berita_kategori`
--
ALTER TABLE `berita_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `dokumen_pemain`
--
ALTER TABLE `dokumen_pemain`
  ADD PRIMARY KEY (`id_pemain`);

--
-- Indexes for table `jadwal_liga`
--
ALTER TABLE `jadwal_liga`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `liga`
--
ALTER TABLE `liga`
  ADD PRIMARY KEY (`id_liga`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id_pages`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id_pengaturan`);

--
-- Indexes for table `peserta_liga`
--
ALTER TABLE `peserta_liga`
  ADD PRIMARY KEY (`id_peserta`);

--
-- Indexes for table `profile_admclub`
--
ALTER TABLE `profile_admclub`
  ADD PRIMARY KEY (`id_admclub`);

--
-- Indexes for table `profile_club`
--
ALTER TABLE `profile_club`
  ADD PRIMARY KEY (`id_club`);

--
-- Indexes for table `profile_pemain`
--
ALTER TABLE `profile_pemain`
  ADD PRIMARY KEY (`id_pemain`);

--
-- Indexes for table `profile_petugas`
--
ALTER TABLE `profile_petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(13) NOT NULL AUTO_INCREMENT COMMENT 'id berita', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `berita_kategori`
--
ALTER TABLE `berita_kategori`
  MODIFY `id_kategori` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id kategori', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dokumen_pemain`
--
ALTER TABLE `dokumen_pemain`
  MODIFY `id_pemain` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id dokumen pemain', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jadwal_liga`
--
ALTER TABLE `jadwal_liga`
  MODIFY `id_jadwal` int(13) NOT NULL AUTO_INCREMENT COMMENT 'id jadwal dan skor liga', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `liga`
--
ALTER TABLE `liga`
  MODIFY `id_liga` int(13) NOT NULL AUTO_INCREMENT COMMENT 'id liga ', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(5) NOT NULL AUTO_INCREMENT COMMENT 'id menu', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id_pages` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peserta_liga`
--
ALTER TABLE `peserta_liga`
  MODIFY `id_peserta` int(13) NOT NULL AUTO_INCREMENT COMMENT 'id peserta liga', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `profile_admclub`
--
ALTER TABLE `profile_admclub`
  MODIFY `id_admclub` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id admin club', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profile_club`
--
ALTER TABLE `profile_club`
  MODIFY `id_club` int(5) NOT NULL AUTO_INCREMENT COMMENT 'id club', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `profile_pemain`
--
ALTER TABLE `profile_pemain`
  MODIFY `id_pemain` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id pemain', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `profile_petugas`
--
ALTER TABLE `profile_petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id petugas', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `rid` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id role', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(13) NOT NULL AUTO_INCREMENT COMMENT 'id of user', AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
