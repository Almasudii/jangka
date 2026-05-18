<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileDesaController extends Controller
{
    /**
     * Data profil untuk setiap desa berdasarkan nama desa.
     * Kunci array menggunakan nama desa (lowercase, tanpa spasi) agar mudah dicocokkan.
     */
    private function getProfilDesa(string $namaDesa): array
    {
        $profils = [

            'Banyuanyar' => [
                'nama'    => 'Desa Banyuanyar',
                'alamat'  => 'Jl. Raya Banyuanyar No. 1, Kecamatan Sampang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Banyuanyar merupakan salah satu desa tertua di Kecamatan Sampang yang telah berdiri sejak abad ke-18. Nama "Banyuanyar" berasal dari bahasa Madura yang berarti "air baru", merujuk pada sumber mata air segar yang ditemukan oleh para pendiri desa. Seiring berjalannya waktu, desa ini berkembang menjadi pusat pertanian dan perdagangan lokal yang penting bagi masyarakat sekitar.',
                'visi'    => 'Terwujudnya Desa Banyuanyar yang maju, mandiri, dan sejahtera berbasis pertanian dan kearifan lokal.',
                'misi'    => [
                    'Meningkatkan kualitas sumber daya manusia melalui pendidikan dan pelatihan.',
                    'Mengembangkan sektor pertanian berbasis teknologi modern.',
                    'Memperkuat tata kelola pemerintahan desa yang transparan dan akuntabel.',
                    'Meningkatkan infrastruktur dasar desa untuk mendukung kesejahteraan warga.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Abdurrahman',
                    'Sekretaris Desa'  => 'Bapak Moh. Syafi\'i',
                    'Bendahara'        => 'Ibu Siti Romlah',
                    'Kaur Pemerintahan' => 'Bapak Zainal Arifin',
                    'Kaur Pembangunan' => 'Bapak Fathurrahman',
                ],
                'potensi' => 'Desa Banyuanyar memiliki potensi unggulan di sektor pertanian padi dan jagung, serta industri kecil pengolahan hasil pertanian. Sumber daya air yang melimpah menjadikan desa ini subur dan produktif sepanjang tahun.',
            ],

            'Dalpenang' => [
                'nama'    => 'Desa Dalpenang',
                'alamat'  => 'Jl. Raya Dalpenang No. 5, Kecamatan Sampang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Dalpenang berdiri sejak tahun 1920-an dan merupakan hasil pemekaran dari wilayah Sampang Kota. Nama "Dalpenang" dipercaya berasal dari kata "dalem" (dalam) dan "penang" (pinang), mencerminkan banyaknya pohon pinang yang tumbuh di kawasan ini pada masa lampau. Desa ini dikenal sebagai kawasan yang ramah dan religius dengan tradisi gotong royong yang kuat.',
                'visi'    => 'Mewujudkan Desa Dalpenang yang berdaya, religius, dan berdaya saing dalam pembangunan berkelanjutan.',
                'misi'    => [
                    'Memperkuat nilai-nilai keagamaan dan budaya lokal sebagai pondasi pembangunan.',
                    'Meningkatkan kesejahteraan warga melalui pemberdayaan ekonomi kreatif.',
                    'Membangun infrastruktur desa yang memadai dan merata.',
                    'Mendorong partisipasi aktif masyarakat dalam pembangunan desa.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Mustofa Kamal',
                    'Sekretaris Desa'  => 'Ibu Nur Hasanah',
                    'Bendahara'        => 'Bapak Ruslan Effendi',
                    'Kaur Pemerintahan' => 'Bapak Moh. Hasan',
                    'Kaur Pembangunan' => 'Ibu Halimah',
                ],
                'potensi' => 'Potensi utama Desa Dalpenang terletak pada sektor perdagangan dan jasa, mengingat lokasinya yang strategis dekat pusat kota Sampang. Industri rumahan seperti kerajinan anyaman bambu dan olahan makanan tradisional juga menjadi andalan warga.',
            ],

            'Gunung Maddah' => [
                'nama'    => 'Desa Gunung Maddah',
                'alamat'  => 'Jl. Raya Desa No. 1, Kecamatan Sampang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Gunung Maddah berdiri sejak tahun 1950 dan terus berkembang menjadi salah satu desa yang maju di Kecamatan Sampang. Nama desa ini diambil dari nama bukit kecil yang berada di wilayahnya, yakni "Gunung Maddah", yang dalam bahasa Madura berarti "bukit pujian". Konon bukit ini dulunya menjadi tempat para ulama melantunkan pujian dan doa.',
                'visi'    => 'Menjadi desa mandiri dan sejahtera berlandaskan gotong royong dan nilai-nilai keislaman.',
                'misi'    => [
                    'Meningkatkan kualitas sumber daya manusia.',
                    'Mengembangkan potensi ekonomi lokal.',
                    'Menjaga kelestarian lingkungan.',
                    'Memperkuat peran lembaga desa dalam pelayanan masyarakat.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Sulton Mairi',
                    'Sekretaris Desa'  => 'Ibu HJ. Arwati',
                    'Bendahara'        => 'Bapak Almasudi',
                    'Kaur Pemerintahan' => 'Bapak Abd. Halim',
                    'Kaur Pembangunan' => 'Bapak Syamsul Arifin',
                ],
                'potensi' => 'Pertanian, peternakan, dan wisata alam menjadi potensi utama desa ini. Pemandangan perbukitan yang indah berpotensi dikembangkan sebagai destinasi agrowisata yang menarik wisatawan.',
            ],

            'Karang Dalem' => [
                'nama'    => 'Desa Karang Dalem',
                'alamat'  => 'Jl. Karang Dalem Raya No. 3, Kecamatan Sampang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Karang Dalem merupakan desa yang terbentuk dari komunitas masyarakat petani yang bermigrasi dari berbagai penjuru Madura sejak abad ke-19. Kata "Karang" berarti tempat pemukiman dan "Dalem" berarti dalam/inti, sehingga desa ini dimaknai sebagai inti dari pemukiman yang berkembang. Kini desa ini dikenal sebagai salah satu penghasil tembakau terbesar di Kecamatan Sampang.',
                'visi'    => 'Terwujudnya Desa Karang Dalem yang produktif, harmonis, dan berkelanjutan.',
                'misi'    => [
                    'Meningkatkan produksi pertanian tembakau dan palawija secara berkelanjutan.',
                    'Memperkuat kelembagaan dan tata kelola pemerintahan desa.',
                    'Meningkatkan akses layanan kesehatan dan pendidikan bagi warga.',
                    'Membangun kerukunan antar warga melalui kegiatan sosial dan budaya.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak Moh. Yunus',
                    'Sekretaris Desa'  => 'Bapak Abd. Rohim',
                    'Bendahara'        => 'Ibu Siti Aminah',
                    'Kaur Pemerintahan' => 'Bapak Ismail',
                    'Kaur Pembangunan' => 'Bapak Haidar Ali',
                ],
                'potensi' => 'Desa Karang Dalem unggul dalam produksi tembakau berkualitas tinggi yang dipasarkan hingga luar Madura. Selain itu, sektor peternakan sapi dan kambing menjadi sumber penghasilan tambahan yang signifikan bagi warga.',
            ],

            'Polagan' => [
                'nama'    => 'Desa Polagan',
                'alamat'  => 'Jl. Raya Polagan No. 7, Kecamatan Sampang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Polagan memiliki sejarah panjang yang berkaitan erat dengan sejarah Kabupaten Sampang secara keseluruhan. Nama "Polagan" berasal dari bahasa Madura kuno yang berarti "tempat persinggahan". Dahulu kawasan ini menjadi tempat beristirahat para pedagang yang melintas antara Sampang dan kota-kota lainnya di Madura. Seiring waktu, kawasan persinggahan ini berkembang menjadi permukiman tetap yang ramai.',
                'visi'    => 'Desa Polagan yang unggul, sejahtera, dan berbudaya dalam bingkai pembangunan yang inklusif.',
                'misi'    => [
                    'Mengembangkan potensi perdagangan dan jasa secara optimal.',
                    'Meningkatkan kualitas infrastruktur jalan dan fasilitas umum.',
                    'Memberdayakan pelaku UMKM lokal melalui pelatihan dan akses permodalan.',
                    'Melestarikan budaya dan tradisi lokal sebagai identitas desa.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Sahrul Anam',
                    'Sekretaris Desa'  => 'Ibu Maimunah',
                    'Bendahara'        => 'Bapak Lutfi Hakim',
                    'Kaur Pemerintahan' => 'Bapak Sulaiman',
                    'Kaur Pembangunan' => 'Bapak Fauzan Rizki',
                ],
                'potensi' => 'Perdagangan antar wilayah masih menjadi tulang punggung perekonomian Desa Polagan. Selain itu, sektor kuliner tradisional Madura dan kerajinan tangan lokal mulai dikembangkan sebagai produk unggulan desa.',
            ],

            'Tanggumong' => [
                'nama'    => 'Desa Tanggumong',
                'alamat'  => 'Jl. Tanggumong No. 2, Kecamatan Sampang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Tanggumong adalah desa yang tumbuh dari kawasan persawahan yang subur di pinggiran Kota Sampang. Nama "Tanggumong" dalam bahasa Madura berarti "menunggui" atau "menjaga", konon karena wilayah ini dahulu digunakan sebagai pos penjagaan keamanan oleh para tetua desa. Desa ini telah berkembang pesat sejak era kemerdekaan dan kini menjadi kawasan semi-urban yang dinamis.',
                'visi'    => 'Mewujudkan Desa Tanggumong yang aman, nyaman, dan berdaya saing tinggi.',
                'misi'    => [
                    'Meningkatkan keamanan dan ketertiban lingkungan desa.',
                    'Mengoptimalkan potensi lahan pertanian yang ada.',
                    'Mendorong pertumbuhan ekonomi warga melalui sektor informal dan UMKM.',
                    'Meningkatkan kualitas layanan pemerintahan desa yang responsif.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak Moh. Saleh',
                    'Sekretaris Desa'  => 'Bapak Hairul Anwar',
                    'Bendahara'        => 'Ibu Ruqayyah',
                    'Kaur Pemerintahan' => 'Bapak Zainul Abidin',
                    'Kaur Pembangunan' => 'Bapak Ahmad Faris',
                ],
                'potensi' => 'Letak strategis Desa Tanggumong yang berbatasan langsung dengan Kota Sampang menjadikannya potensial untuk pengembangan properti dan perdagangan. Sektor pertanian padi sawah juga masih menjadi andalan mata pencaharian warga.',
            ],

            'Panggung' => [
                'nama'    => 'Desa Panggung',
                'alamat'  => 'Jl. Raya Panggung No. 4, Kecamatan Sampang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Panggung mendapatkan namanya dari sebuah bangunan panggung kayu besar yang dahulu berdiri di tengah desa dan digunakan untuk berbagai kegiatan adat dan seni budaya Madura. Bangunan bersejarah itu kini tidak ada lagi, namun namanya tetap diabadikan sebagai identitas desa. Desa ini dikenal sebagai pusat seni budaya Madura, khususnya seni tari dan musik tradisional.',
                'visi'    => 'Desa Panggung sebagai pusat seni budaya Madura yang maju dan lestari.',
                'misi'    => [
                    'Melestarikan dan mengembangkan seni budaya Madura sebagai aset desa.',
                    'Meningkatkan kesejahteraan seniman dan pelaku budaya lokal.',
                    'Membangun pariwisata budaya yang berdampak positif bagi perekonomian warga.',
                    'Meningkatkan kualitas pendidikan berbasis kearifan lokal.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Badrus Salam',
                    'Sekretaris Desa'  => 'Bapak Moh. Iqbal',
                    'Bendahara'        => 'Ibu Farida Hanum',
                    'Kaur Pemerintahan' => 'Bapak Khoirul Umam',
                    'Kaur Pembangunan' => 'Bapak Arif Hidayat',
                ],
                'potensi' => 'Desa Panggung kaya akan warisan budaya Madura termasuk seni tari rondhing, musik saronen, dan tradisi karapan sapi. Potensi wisata budaya ini sedang dikembangkan untuk menarik pengunjung dari luar daerah.',
            ],

            'Pasean' => [
                'nama'    => 'Desa Pasean',
                'alamat'  => 'Jl. Raya Pasean No. 9, Kecamatan Sampang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Pasean adalah desa yang letaknya di pesisir utara Kabupaten Sampang dengan sejarah yang erat kaitannya dengan kehidupan nelayan. Nama "Pasean" berasal dari kata "pasea" dalam bahasa Madura yang berarti "pesisir" atau "pantai". Masyarakat desa ini telah lama menggantungkan hidup dari hasil laut dan perdagangan ikan, menjadikannya desa nelayan yang berpengalaman.',
                'visi'    => 'Terwujudnya Desa Pasean yang sejahtera berbasis kelautan dan perikanan yang berkelanjutan.',
                'misi'    => [
                    'Meningkatkan kapasitas nelayan melalui pelatihan dan modernisasi alat tangkap.',
                    'Mengembangkan industri pengolahan hasil laut bernilai tambah tinggi.',
                    'Menjaga kelestarian ekosistem pesisir dan laut.',
                    'Meningkatkan infrastruktur pelabuhan dan fasilitas nelayan.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Nasir Hasyim',
                    'Sekretaris Desa'  => 'Bapak Misbahul Munir',
                    'Bendahara'        => 'Ibu Nurul Aini',
                    'Kaur Pemerintahan' => 'Bapak Ach. Fauzi',
                    'Kaur Pembangunan' => 'Bapak Rahmat Hidayat',
                ],
                'potensi' => 'Kekayaan laut menjadi potensi utama Desa Pasean. Hasil tangkapan ikan, udang, dan cumi-cumi menjadi komoditas unggulan. Selain itu, pengembangan tambak garam dan budidaya ikan bandeng juga tengah digalakkan.',
            ],

            'Taman Sareh' => [
                'nama'    => 'Desa Taman Sareh',
                'alamat'  => 'Jl. Taman Sareh No. 6, Kecamatan Sampang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Taman Sareh dahulu merupakan kawasan kebun dan taman milik seorang tokoh setempat yang disegani. Nama "Taman Sareh" sendiri berasal dari kata "taman" (taman/kebun) dan "sareh" yang dalam bahasa Madura berarti "rela" atau "ikhlas", mencerminkan karakter masyarakatnya yang dikenal ramah dan ikhlas. Desa ini mulai resmi berdiri sebagai desa definitif pada tahun 1965.',
                'visi'    => 'Desa Taman Sareh yang hijau, harmonis, dan mandiri pangan.',
                'misi'    => [
                    'Mengembangkan pertanian hortikultura yang produktif dan ramah lingkungan.',
                    'Menciptakan lingkungan desa yang asri dan bersih.',
                    'Meningkatkan pendapatan warga melalui diversifikasi hasil pertanian.',
                    'Memperkuat kegotongroyongan dan solidaritas sosial warga desa.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak Hj. Wahyudi',
                    'Sekretaris Desa'  => 'Ibu Lilik Andriani',
                    'Bendahara'        => 'Bapak Moh. Tohir',
                    'Kaur Pemerintahan' => 'Bapak Supriadi',
                    'Kaur Pembangunan' => 'Bapak Rizal Kurniawan',
                ],
                'potensi' => 'Desa Taman Sareh dikenal sebagai penghasil buah-buahan tropis seperti mangga, pisang, dan pepaya. Lahan pertaniannya yang subur juga ditanami berbagai jenis sayuran yang dipasok ke pasar-pasar di Sampang.',
            ],

            'Kebanaran' => [
                'nama'    => 'Desa Kebanaran',
                'alamat'  => 'Jl. Raya Kebanaran No. 11, Kecamatan Sampang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Kebanaran memiliki asal-usul nama dari kata "kebenaran" yang diserap ke dalam bahasa Madura menjadi "Kebanaran". Konon, desa ini didirikan oleh sekelompok ulama dan tokoh masyarakat yang menjunjung tinggi nilai kejujuran dan keadilan. Tradisi keagamaan dan pendidikan pesantren mengakar kuat di desa ini sejak ratusan tahun silam.',
                'visi'    => 'Desa Kebanaran yang berakhlak mulia, cerdas, dan mandiri.',
                'misi'    => [
                    'Memperkuat pendidikan agama dan pesantren sebagai pondasi karakter warga.',
                    'Meningkatkan akses dan kualitas pendidikan formal dari tingkat dasar hingga menengah.',
                    'Mengembangkan ekonomi berbasis pesantren dan produk halal.',
                    'Membangun infrastruktur dan fasilitas publik yang memadai.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak KH. Mahfudz',
                    'Sekretaris Desa'  => 'Bapak Abd. Karim',
                    'Bendahara'        => 'Ibu Aisyah Rahmawati',
                    'Kaur Pemerintahan' => 'Bapak Syaifudin',
                    'Kaur Pembangunan' => 'Bapak Nurul Huda',
                ],
                'potensi' => 'Keberadaan pesantren-pesantren besar menjadikan Desa Kebanaran sebagai pusat pendidikan agama di wilayah ini. Ekonomi berbasis pesantren seperti produksi makanan halal, koperasi santri, dan jasa pendidikan menjadi potensi yang terus berkembang.',
            ],

            'Karang Anyar' => [
                'nama'    => 'Desa Karang Anyar',
                'alamat'  => 'Jl. Karang Anyar Raya No. 8, Kecamatan Sampang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Karang Anyar adalah desa yang terbilang lebih muda dibandingkan desa-desa sekitarnya. "Karang Anyar" berarti "tempat tinggal baru" dalam bahasa Jawa-Madura, mencerminkan asal-usulnya sebagai pemukiman baru yang dibuka pada sekitar tahun 1930-an oleh para perantau yang menetap. Kini desa ini telah berkembang menjadi kawasan yang padat dan makmur.',
                'visi'    => 'Mewujudkan Desa Karang Anyar yang dinamis, inovatif, dan sejahtera.',
                'misi'    => [
                    'Mendorong inovasi dalam pengelolaan sumber daya desa.',
                    'Meningkatkan layanan administrasi desa yang cepat dan transparan.',
                    'Mengembangkan potensi pemuda sebagai agen perubahan desa.',
                    'Meningkatkan kualitas infrastruktur dan sarana prasarana desa.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Syaiful Bahri',
                    'Sekretaris Desa'  => 'Ibu Dewi Kurniasari',
                    'Bendahara'        => 'Bapak Muharrom',
                    'Kaur Pemerintahan' => 'Bapak Agus Salim',
                    'Kaur Pembangunan' => 'Bapak Fatkhur Rozi',
                ],
                'potensi' => 'Desa Karang Anyar memiliki potensi di sektor perdagangan, industri kecil, dan pertanian hortikultura. Populasi pemuda yang besar menjadi aset tersendiri untuk pengembangan ekonomi kreatif dan digital.',
            ],

            'Camplong' => [
                'nama'    => 'Desa Camplong',
                'alamat'  => 'Jl. Raya Camplong No. 1, Kecamatan Camplong, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Camplong adalah ibukota Kecamatan Camplong yang telah berkembang sejak era kolonial Belanda. Nama "Camplong" dipercaya berasal dari kata dalam bahasa Belanda atau Portugis lama yang berarti "perkemahan" atau "kawasan permukiman". Desa ini tumbuh sebagai pusat administratif dan perdagangan kecamatan dengan sejarah yang kaya dan beragam.',
                'visi'    => 'Camplong sebagai desa pusat kecamatan yang maju, bersih, dan berdaya saing.',
                'misi'    => [
                    'Meningkatkan fungsi Camplong sebagai pusat pelayanan publik kecamatan.',
                    'Mengembangkan sektor perdagangan dan jasa yang profesional.',
                    'Membangun lingkungan yang bersih, hijau, dan nyaman bagi warga.',
                    'Meningkatkan partisipasi masyarakat dalam pembangunan desa.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Imam Basori',
                    'Sekretaris Desa'  => 'Bapak Wahid Hasyim',
                    'Bendahara'        => 'Ibu Masriyah',
                    'Kaur Pemerintahan' => 'Bapak Rofi\'i',
                    'Kaur Pembangunan' => 'Bapak Syamsuddin',
                ],
                'potensi' => 'Sebagai pusat kecamatan, Camplong memiliki keunggulan di sektor perdagangan, kuliner, dan jasa. Pasar tradisional Camplong menjadi pusat ekonomi yang ramai dan menggerakkan perekonomian seluruh kecamatan.',
            ],

            'Torjun' => [
                'nama'    => 'Desa Torjun',
                'alamat'  => 'Jl. Raya Torjun No. 3, Kecamatan Torjun, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Torjun merupakan ibukota Kecamatan Torjun yang telah ada sejak zaman pra-kemerdekaan. Nama "Torjun" diyakini berasal dari bahasa Madura yang berarti "tertuju" atau "tujuan", karena kawasan ini dahulu menjadi tujuan utama para pedagang dan wisatawan yang melintasi jalur tengah Madura. Desa ini dikenal dengan tradisi pengolahan garam dan pertanian lahan kering.',
                'visi'    => 'Desa Torjun yang produktif, berdaulat pangan, dan berdaya saing regional.',
                'misi'    => [
                    'Meningkatkan produksi pertanian lahan kering dan pengolahan garam.',
                    'Memperkuat peran koperasi dan lembaga ekonomi desa.',
                    'Meningkatkan kualitas SDM melalui pendidikan dan vokasi.',
                    'Membangun infrastruktur irigasi yang mendukung sektor pertanian.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak Moh. Ridwan',
                    'Sekretaris Desa'  => 'Bapak Rudi Hartono',
                    'Bendahara'        => 'Ibu Sri Wahyuni',
                    'Kaur Pemerintahan' => 'Bapak Hamdan',
                    'Kaur Pembangunan' => 'Bapak Ach. Zainudin',
                ],
                'potensi' => 'Produksi garam rakyat dan pertanian palawija menjadi tulang punggung ekonomi Desa Torjun. Lahan tambak garam yang luas berpotensi dikembangkan menjadi industri garam beryodium berkualitas ekspor.',
            ],

            'Jrengik' => [
                'nama'    => 'Desa Jrengik',
                'alamat'  => 'Jl. Raya Jrengik No. 5, Kecamatan Jrengik, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Jrengik merupakan desa induk di Kecamatan Jrengik yang memiliki sejarah panjang sebagai pusat pemerintahan lokal. Nama "Jrengik" berasal dari nama pohon yang dahulu banyak tumbuh di kawasan ini, yang dalam bahasa Madura dikenal sebagai "jrengik" (sejenis pohon keras berdaun lebat). Desa ini terkenal dengan tradisi batik Madura yang telah diwariskan turun-temurun.',
                'visi'    => 'Desa Jrengik sebagai pusat batik Madura yang lestari dan bernilai ekonomi tinggi.',
                'misi'    => [
                    'Melestarikan dan mengembangkan seni batik Madura sebagai produk unggulan desa.',
                    'Meningkatkan kapasitas pengrajin batik melalui pelatihan dan akses pasar.',
                    'Mengembangkan desa wisata batik yang menarik wisatawan lokal dan mancanegara.',
                    'Meningkatkan taraf hidup pengrajin dan pelaku industri batik.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Ibu Hj. Sumariyah',
                    'Sekretaris Desa'  => 'Bapak Abd. Aziz',
                    'Bendahara'        => 'Bapak Samsul Hadi',
                    'Kaur Pemerintahan' => 'Ibu Rodiah',
                    'Kaur Pembangunan' => 'Bapak Fathul Bari',
                ],
                'potensi' => 'Batik Jrengik adalah produk unggulan yang sudah dikenal di tingkat nasional. Motif khas Madura dengan warna-warna cerah dan berani menjadi daya tarik tersendiri. Selain batik, sektor pertanian dan peternakan juga menjadi sumber penghasilan warga.',
            ],

            'Omben' => [
                'nama'    => 'Desa Omben',
                'alamat'  => 'Jl. Raya Omben No. 1, Kecamatan Omben, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Omben adalah pusat Kecamatan Omben yang terletak di dataran tinggi Kabupaten Sampang. Nama "Omben" berasal dari kata "omben" dalam bahasa Madura yang berarti "minuman" atau "sumber air", merujuk pada sumber mata air jernih yang dahulu menjadi andalan masyarakat setempat. Kawasan ini dikenal sebagai daerah penghasil jagung terbaik di Madura.',
                'visi'    => 'Desa Omben yang subur, sehat, dan mandiri berbasis pertanian dan air bersih.',
                'misi'    => [
                    'Mengoptimalkan sumber daya air untuk pertanian dan kebutuhan warga.',
                    'Meningkatkan produksi jagung dan pertanian dataran tinggi secara berkelanjutan.',
                    'Meningkatkan layanan kesehatan dasar bagi seluruh warga desa.',
                    'Membangun sarana air bersih yang merata ke seluruh pelosok desa.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Abd. Mukthi',
                    'Sekretaris Desa'  => 'Bapak Kamaluddin',
                    'Bendahara'        => 'Ibu Masyitah',
                    'Kaur Pemerintahan' => 'Bapak Sirajul Munir',
                    'Kaur Pembangunan' => 'Bapak Moh. Tholib',
                ],
                'potensi' => 'Pertanian jagung Desa Omben telah dikenal hingga ke seluruh Jawa Timur. Selain jagung, singkong dan ubi jalar juga menjadi komoditas unggulan. Sumber mata air alami di desa ini berpotensi dikembangkan menjadi objek wisata alam.',
            ],

            'Tambelangan' => [
                'nama'    => 'Desa Tambelangan',
                'alamat'  => 'Jl. Raya Tambelangan No. 2, Kecamatan Tambelangan, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Tambelangan adalah pusat Kecamatan Tambelangan yang terletak di wilayah selatan Kabupaten Sampang. Konon nama "Tambelangan" berasal dari kata "tambal" (menambal/memperbaiki) dan "langan" (jalan), karena dahulu kawasan ini terkenal sebagai tempat para pandai besi dan pengrajin yang memperbaiki peralatan pertanian dan kendaraan tradisional. Desa ini dikenal sebagai kawasan industri kerajinan logam.',
                'visi'    => 'Desa Tambelangan yang terampil, produktif, dan berdaya saing industri.',
                'misi'    => [
                    'Mengembangkan industri kerajinan logam dan pandai besi secara modern.',
                    'Meningkatkan keterampilan warga melalui balai latihan kerja desa.',
                    'Memperluas akses pasar produk kerajinan lokal hingga tingkat nasional.',
                    'Meningkatkan infrastruktur industri dan fasilitas produksi.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak Busyro Karim',
                    'Sekretaris Desa'  => 'Bapak Imam Syafi\'i',
                    'Bendahara'        => 'Ibu Khusnul Khatimah',
                    'Kaur Pemerintahan' => 'Bapak Edi Sutrisno',
                    'Kaur Pembangunan' => 'Bapak Moh. Shodiq',
                ],
                'potensi' => 'Industri kerajinan logam tradisional menjadi ciri khas Desa Tambelangan. Produk-produk seperti cangkul, sabit, dan peralatan dapur berbahan logam buatan pengrajin lokal dikenal kuat dan tahan lama. Potensi ini sedang dikembangkan ke arah produk ekspor.',
            ],

            'Ketapang' => [
                'nama'    => 'Desa Ketapang',
                'alamat'  => 'Jl. Raya Ketapang No. 4, Kecamatan Ketapang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Ketapang mendapat namanya dari pohon Ketapang (Terminalia catappa) yang dahulu tumbuh lebat di sepanjang tepi pantai kawasan ini. Sebagai desa pesisir di utara Kabupaten Sampang, Ketapang memiliki sejarah panjang sebagai pelabuhan tradisional yang menghubungkan Madura dengan daratan Jawa. Aktivitas pelayaran dan perdagangan antar pulau menjadi nafas kehidupan desa sejak berabad-abad lalu.',
                'visi'    => 'Desa Ketapang sebagai pintu gerbang maritim yang sejahtera dan berdaya.',
                'misi'    => [
                    'Mengembangkan potensi maritim dan pelayaran tradisional secara modern.',
                    'Meningkatkan kesejahteraan nelayan dan keluarganya.',
                    'Membangun dan merevitalisasi infrastruktur pelabuhan dan pesisir.',
                    'Menjaga keberlanjutan sumber daya laut melalui pengelolaan yang bertanggung jawab.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Jamaludin',
                    'Sekretaris Desa'  => 'Bapak Moh. Qosim',
                    'Bendahara'        => 'Ibu Nor Aida',
                    'Kaur Pemerintahan' => 'Bapak Aris Munandar',
                    'Kaur Pembangunan' => 'Bapak Zulkifli',
                ],
                'potensi' => 'Sektor perikanan tangkap dan budidaya menjadi andalan utama Desa Ketapang. Pelabuhan tradisional yang ada berpotensi dikembangkan untuk mendukung pariwisata bahari dan ekspor hasil laut. Produksi terasi dan ikan asin Ketapang juga sudah dikenal luas.',
            ],

            'Sokobanah' => [
                'nama'    => 'Desa Sokobanah',
                'alamat'  => 'Jl. Raya Sokobanah No. 1, Kecamatan Sokobanah, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Sokobanah adalah pusat Kecamatan Sokobanah yang terletak di ujung timur laut Kabupaten Sampang. Nama "Sokobanah" berasal dari kata "soko" (tiang/penyangga) dan "banah" yang berarti "wilayah" atau "daerah" dalam bahasa Madura kuno, menggambarkan peran strategis desa ini sebagai penyangga wilayah paling utara kabupaten. Desa ini berbatasan langsung dengan Kabupaten Pamekasan.',
                'visi'    => 'Desa Sokobanah sebagai beranda timur laut Sampang yang maju dan sejahtera.',
                'misi'    => [
                    'Mengembangkan potensi daerah perbatasan sebagai peluang ekonomi strategis.',
                    'Meningkatkan konektivitas dan aksesibilitas desa ke pusat kabupaten.',
                    'Membangun kawasan pertanian terpadu yang produktif dan modern.',
                    'Meningkatkan kualitas layanan dasar pendidikan dan kesehatan.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Moh. Rasyid',
                    'Sekretaris Desa'  => 'Bapak Ahmad Zaini',
                    'Bendahara'        => 'Ibu Suhaibah',
                    'Kaur Pemerintahan' => 'Bapak Hasani',
                    'Kaur Pembangunan' => 'Bapak Abd. Hamid',
                ],
                'potensi' => 'Posisi Desa Sokobanah sebagai daerah perbatasan menjadikannya strategis untuk perdagangan lintas kecamatan dan kabupaten. Pertanian jagung, tembakau, dan peternakan sapi menjadi komoditas utama yang menopang perekonomian warga.',
            ],

            'Karang Penang' => [
                'nama'    => 'Desa Karang Penang',
                'alamat'  => 'Jl. Raya Karang Penang No. 6, Kecamatan Karang Penang, Kabupaten Sampang, Jawa Timur',
                'sejarah' => 'Desa Karang Penang merupakan pusat Kecamatan Karang Penang yang terletak di wilayah selatan Kabupaten Sampang, berbatasan dengan Kabupaten Sumenep. Nama desa ini berasal dari gabungan kata "karang" (tempat pemukiman) dan "penang" (pinang), merujuk pada banyaknya pohon pinang yang dahulu menghiasi perbukitan di kawasan ini. Desa ini dikenal sebagai penghasil ternak sapi berkualitas.',
                'visi'    => 'Desa Karang Penang sebagai sentra peternakan unggul yang berkelanjutan dan sejahtera.',
                'misi'    => [
                    'Mengembangkan peternakan sapi dan kambing sebagai komoditas unggulan desa.',
                    'Meningkatkan kualitas bibit ternak melalui program inseminasi buatan.',
                    'Membangun koperasi peternak yang kuat dan mandiri.',
                    'Meningkatkan kualitas pendidikan dan kesehatan hewan ternak.',
                ],
                'struktur' => [
                    'Kepala Desa'      => 'Bapak H. Sutrisno',
                    'Sekretaris Desa'  => 'Bapak Moh. Hasyim',
                    'Bendahara'        => 'Ibu Rofiqoh',
                    'Kaur Pemerintahan' => 'Bapak Samsuri',
                    'Kaur Pembangunan' => 'Bapak Ahmad Fauzi',
                ],
                'potensi' => 'Sentra peternakan sapi Madura menjadi kebanggaan Desa Karang Penang. Sapi Madura yang terkenal dengan ketangguhannya banyak diperdagangkan dari sini ke berbagai daerah. Selain peternakan, pertanian jagung dan kacang tanah juga menjadi andalan warga.',
            ],

        ];

        return $profils[$namaDesa] ?? $this->getDefaultProfil($namaDesa);
    }

    /**
     * Profil default jika nama desa tidak ditemukan dalam daftar.
     */
    private function getDefaultProfil(string $namaDesa): array
    {
        return [
            'nama'    => 'Desa ' . $namaDesa,
            'alamat'  => 'Kabupaten Sampang, Jawa Timur',
            'sejarah' => 'Informasi sejarah desa ' . $namaDesa . ' sedang dalam proses pengumpulan data.',
            'visi'    => 'Mewujudkan desa yang maju, mandiri, dan sejahtera.',
            'misi'    => [
                'Meningkatkan kualitas sumber daya manusia.',
                'Mengembangkan potensi ekonomi lokal.',
                'Menjaga kelestarian lingkungan dan budaya.',
            ],
            'struktur' => [
                'Kepala Desa'      => '-',
                'Sekretaris Desa'  => '-',
                'Bendahara'        => '-',
            ],
            'potensi' => 'Potensi desa sedang dalam proses inventarisasi.',
        ];
    }

    /**
     * Tampilkan profil desa berdasarkan desa_id user yang sedang login.
     */
    public function index()
    {
        $user = auth()->user();

        // Ambil nama desa dari relasi, fallback ke 'Tidak Diketahui'
        $namaDesa = $user->desa?->nama_desa ?? 'Tidak Diketahui';

        $profil = $this->getProfilDesa($namaDesa);

        return inertia('ProfilDesa', [
            'profil'   => $profil,
            'namaDesa' => $namaDesa,
        ]);
    }
}