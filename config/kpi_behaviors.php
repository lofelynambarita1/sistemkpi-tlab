<?php

// config/kpi_behaviors.php

return [
    'integritas' => [
        'definisi' => 'Memiliki pribadi yang jujur dengan dapat menjaga kerahasiaan informasi pribadi, tim, dan Perusahaan',
        'min_capaian' => ['indikator' => 2, 'keterangan' => "- Mampu bertanggung jawab atas tindakan dan keputusan sendiri\n- Mengakui kesalahan dan bertanggung jawab atas konsekuensinya"],
        'indikator' => [
            1 => "1. Mengikuti aturan dan prosedur yang ditetapkan\n2. Membutuhkan pengawasan untuk memastikan kepatuhan",
            2 => "1. Mampu bertanggung jawab atas tindakan dan keputusan sendiri\n2. Mengakui kesalahan dan bertanggung jawab atas konsekuensinya",
            3 => "1. Mampu bertindak secara konsisten sesuai dengan nilai-nilai etika dalam berbagai situasi\n2. Membuat keputusan berdasarkan prinsip-prinsip etika yang kuat",
            4 => "1. Mampu mempengaruhi orang lain untuk bertindak dengan integritas",
            5 => "1. Menciptakan budaya organisasi yang menjunjung tinggi integritas"
        ]
    ],
        'speed' => [
        'definisi' => 'Kemampuan untuk mengerjakan suatu aktivitas secara berulang yang sama dan berkesinambungan dalam waktu sesingkat mungkin. Berhubungan dengan waktu penyelesaian tugas (pekerjaan) sesuai dengan waktu yang diberikan.',
        'min_capaian' => ['indikator' => 2, 'keterangan' => "Penyelesaian tugas sesuai dengan deadline waktu yang ditentukan (ontime)"],
        'indikator' => [
            1 => "1. Penyelesaian tugas lebih dari waktu yang diberikan",
            2 => "1. Penyelesaian tugas sesuai dengan deadline waktu yang ditentukan (ontime)",
            3 => "1. Penyelesaian tugas kurang dari deadline waktu yang ditentukan (intime)",
            4 => "1. Penyelesaian tugas kurang dari deadline waktu yang ditentukan (intime) dengan menggunakan cara baru untuk mempercepat penyelesaian\n2. Mampu menyelesaikan tugas-tugas yang sangat kompleks dengan mandiri",
            5 => "1. Penyelesaian tugas kurang dari deadline waktu yang ditentukan (intime) dengan menggunakan cara baru untuk mempercepat penyelesaian\n2. Mampu menyelesaikan tugas-tugas yang sangat kompleks dengan sangat efisien dalam situasi sulit"
        ]
    ],
        'ketelitian_kerja' => [
        'definisi' => 'Kemampuan untuk meminimalisir kesalahan dalam bekerja dengan memeriksa data dan informasi secara detail, seksama, cermat, tepat dan menyeluruh.',
        'min_capaian' => ['indikator' => 3, 'keterangan' => "1. Mampu menyelesaikan tugas dengan ketelitian yang konsisten dan meminimalkan kesalahan\n2. Mampu mengidentifikasi dan menghindari kesalahan dengan efektif"],
        'indikator' => [
            1 => "1. Membuat banyak kesalahan dan kurang memperhatikan detail",
            2 => "1. Mampu menyelesaikan tugas dengan tingkat ketelitian dasar dan menghindari kesalahan yang jelas\n2. Mulai memperhatikan detail, tetapi masih bisa membuat kesalahan",
            3 => "1. Mampu menyelesaikan tugas dengan ketelitian yang konsisten dan meminimalkan kesalahan\n2. Mampu mengidentifikasi dan menghindari kesalahan dengan efektif",
            4 => "1. Memiliki standar ketelitian yang tinggi\n2. Mampu menghasilkan pekerjaan yang berkualitas tinggi dan bebas dari kesalahan",
            5 => "1. Mampu mengantisipasi dan mencegah kesalahan sebelum terjadi\n2. Mampu mengembangkan sistem dan prosedur untuk meningkatkan ketelitian kerja"
        ]
    ],
        'penyesuaian_diri' => [
        'definisi' => "1. Beradaptasi terhadap perubahan situasi, menyusun kembali tugas-tugas dan prioritas selama perubahan terjadi dalam lingkup kerja dan organisasi.\n2. Fleksibel dalam perubahan situasi. Terbuka terhadap perubahan dan cara-cara yang berbeda dalam melakukan suatu hal, tidak bergantung secara berlebihan pada metode/proses yang lama.",
        'min_capaian' => ['indikator' => 3, 'keterangan' => "1. Menyesuaikan situasi, aturan dan metode cara kerja lama dengan menerapkan situasi, aturan dan metode baru atau proses baru.\n2. Mencari informasi dan sumber daya untuk membantu adaptasi"],
        'indikator' => [
            1 => "1. Cenderung mempertahankan cara lama dan menghindari hal-hal baru",
            2 => "1. Lambat dalam mengikuti perubahan dan masih menggunakan petunjuk/metode lama.\n2. Memerlukan dukungan dan informasi yang jelas tentang perubahan",
            3 => "1. Menyesuaikan situasi, aturan dan metode cara kerja lama dengan menerapkan situasi, aturan dan metode baru atau proses baru\n2. Mencari informasi dan sumber daya untuk membantu adaptasi",
            4 => "1. Mengikuti perubahan secara terbuka dan melakukan perubahan dengan sukarela\n2. Mencari cara untuk meningkatkan efektivitas dalam situasi, aturan dan metode baru",
            5 => "1. Menjadi agen perubahan yang aktif dan mendorong orang lain untuk beradaptasi.\n2. Mampu menciptakan lingkungan yang mendukung perubahan"
        ]
    ],
        'hasrat_berprestasi' => [
        'definisi' => 'Kepedulian yang tinggi pada pekerjaannya sehingga terdorong untuk bekerja dengan lebih baik atau di atas standar.',
        'min_capaian' => ['indikator' => 2, 'keterangan' => "Memiliki inisiatif dan menunjukan keinginan untuk mencapai standar kerja yang telah ditetapkan (minimum sama dengan prestasi rata-rata)."],
        'indikator' => [
            1 => "1. Memberikan usahanya dengan fokus pada tugas yang dengan prestasi rata rata.\n2. Tidak diperlukan suatu inisiatif untuk memulai suatu tugas atau cara kerja yang baru",
            2 => "1. Memiliki inisiatif dan menunjukan keinginan untuk mencapai standar kerja yang telah ditetapkan (minimum sama dengan prestasi rata-rata).",
            3 => "1. Mampu untuk bekerja untuk mencapai suatu standar kinerja yang ditetapkan oleh pihak manajemen",
            4 => "1. Berfikir mandiri dalam menetapkan ukuran keberhasilan kerjanya",
            5 => "1. Mempunyai kebijakan dalam sistem kerja, atau dalam kebiasaan kerjanya sendiri untuk memperbaiki kinerja"
        ]
    ],
        'komunikasi_interpersonal' => [
        'definisi' => 'Kemampuan untuk berkomunikasi secara efektif dengan orang lain, termasuk mendengar aktif, menunjukkan pemahaman, dan memberikan umpan balik baik, baik secara personal maupun dalam kelompok.',
        'min_capaian' => ['indikator' => 3, 'keterangan' => "1. Mampu menyampaikan pesan secara jelas, ringkas, dan persuasif\n2. Mampu mendengarkan secara aktif dan memahami perspektif orang lain"],
        'indikator' => [
            1 => "1. Cenderung pasif dalam interaksi\n2. Kesulitan dalam menyampaikan pesan secara jelas\n3. Kurang mampu mendengarkan secara aktif.",
            2 => "1. Mampu menyampaikan pesan secara cukup jelas\n2. Mulai menunjukkan kemampuan untuk mendengarkan\n3. Dapat merespon umpan balik dengan cukup baik",
            3 => "1. Mampu menyampaikan pesan secara jelas, ringkas, dan persuasif\n2. Mampu mendengarkan secara aktif dan memahami perspektif orang lain",
            4 => "1. Mampu memahami dan merespons emosi orang lain dengan baik\n2. Mampu membangun hubungan yang kuat dan saling percaya",
            5 => "1. Dapat memahami sudut pandang orang lain dan berikan umpan balik yang konstruktif."
        ]
    ],
        'pengelolaan_hubungan' => [
        'definisi' => 'Kemampuan untuk membangun, memelihara, dan mengembangkan hubungan yang positif dan produktif dengan orang lain.',
        'min_capaian' => ['indikator' => 3, 'keterangan' => "Mempertahankan hubungan pekerjaan. Termasuk obrolan yang tidak terstruktur, tetapi masih mengenai hubungan dengan pekerjaan."],
        'indikator' => [
            1 => "1. Mengucilkan diri, menghindari interaksi sosial.",
            2 => "1. Cenderung berfokus pada diri sendiri dan kebutuhan sendiri\n2. Kesulitan dalam memahami perspektif orang lain",
            3 => "1. Mempertahankan hubungan pekerjaan. Termasuk obrolan yang tidak terstruktur, tetapi masih mengenai hubungan dengan pekerjaan.",
            4 => "1. Membuat hubungan yang informal atau tidak resmi di lingkungan kerja, mengobrol tentang anak-anak, olah raga, berita dan sebagainya.",
            5 => "1. Sering menyelenggarakan kontak informal atau tidak resmi dilingkungan kerja, baik dengan tim internal maupun eksternal. Dengan sengaja melakukan usaha untuk membangun kesan hubungan yang baik."
        ]
    ],
        'kerjasama' => [
        'definisi' => 'Kemampuan untuk bekerja dalam kelompok dan aktif berpartisipasi dalam pencapaian tujuan.',
        'min_capaian' => ['indikator' => 3, 'keterangan' => "Berpartisipasi sebagai anggota tim yang baik, melakukan tugas/bagiannya dan mendukung keputusan tim."],
        'indikator' => [
            1 => "1. Tidak menerima keputusan tim dan tidak melaksanakan tugas yang diberikan",
            2 => "1. Tidak menerima keputusan tim tetapi tetap melaksanakan tugas yang diberikan",
            3 => "1. Berpartisipasi sebagai anggota tim yang baik, melakukan tugas/bagiannya dan mendukung keputusan tim",
            4 => "1. Selalu menjadikan orang lain tahu mengenai proses di dalam grup. Membagi informasi yang berguna dan relevan bagi anggota tim",
            5 => "1. Berpartisipasi sebagai anggota tim yang baik, melakukan tugas/bagiannya, mendukung keputusan tim dan memberikan masukan yang dapat diterima dalam tim."
        ]
    ],
        'fokus_pada_kualitas' => [
        'definisi' => 'Mendorong dan mempertahankan standar kualitas yang tinggi dalam pekerjaan.',
        'min_capaian' => ['indikator' => 3, 'keterangan' => "1. Bertanggung jawab untuk memberikan hasil sesuai standar yang ditetapkan\n2. Menyelesaikan tugas dengan tuntas\n3. Dapat diandalkan dan bertanggung jawab"],
        'indikator' => [
            1 => "1. Hasil pekerjaan tidak sesuai dengan standar yang ditentukan",
            2 => "1. Hasil pekerjaan sesuai dengan standar yang ditentukan tetapi tidak sesuai dengan timeline yang telah ditentukan",
            3 => "1. Bertanggung jawab untuk memberikan hasil sesuai standar yang ditetapkan\n2. Menyelesaikan tugas dengan tuntas\n3. Dapat diandalkan dan bertanggung jawab",
            4 => "1. Melakukan perbaikan cara kerja untuk mendapatkan hasil kerja yang efektif dan berkualitas tinggi\n2. Konsisten menghasilkan pekerjaan yang berkualitas tinggi",
            5 => "1. Menetapkan hasil kerja sendiri yang lebih tinggi dari standar hasil kerja yang ditetapkan tim.\n2. Melakukan usaha atau perubahan pada metode kerja untuk meningkatkan hasil kerja\n3. Menunjukkan usaha untuk mencapai hasil yang lebih baik\n4. Tangguh dalam menghadapi hambatan untuk mencapai hasil yang lebih melebihi standar"
        ]
    ],
        'customer_centric' => [
        'definisi' => 'Mampu memfasilitasi kebutuhan dan kepuasan pelanggan sebagai prioritas utama. Customer yang sesungguhnya atau rekan pemakai hasil kerja kita.',
        'min_capaian' => ['indikator' => 3, 'keterangan' => "Memonitor kepuasan customer, mendistribusikan informasi yang membantu kepada customer. Memberikan servis yang ramah dan bersikap sebagai sahabat"],
        'indikator' => [
            1 => "1. Memberikan respon seadanya atas pertanyaan/kebutuhan customer dan tidak berusaha untuk mencari akar permasalahan",
            2 => "1. Menindak lanjuti kebutuhan, permintaan, keluhan customer. Menjaga agar customer mengetahui perkembangan terbaru",
            3 => "1. Memonitor kepuasan customer, mendistribusikan informasi yang membantu kepada customer. Memberikan servis yang ramah dan bersikap sebagai sahabat",
            4 => "1. Memperbaiki masalah yang berkaitan dengan konsumen secara sungguh-sungguh",
            5 => "1. Selalu siap membantu terutama jika konsumen berada pada periode yang kritis. Memberikan nomor telepon rumah, atau cara akses lain yang mudah"
        ]
    ],
        'inovasi' => [
        'definisi' => 'Menghasilkan solusi inovatif, mencoba cara yang baru dan berbeda untuk menghadapi masalah dan peluang dalam situasi kerja',
        'min_capaian' => ['indikator' => 2, 'keterangan' => "Melakukan pengembangan yang sudah dilakukan sebelumnya untuk meningkatkan pekerjaan individu"],
        'indikator' => [
            1 => "1. Tidak melakukan hal-hal baru dalam pekerjaannya untuk meningkatkan kinerja",
            2 => "1. Melakukan pengembangan yang sudah dilakukan sebelumnya untuk meningkatkan pekerjaan individu",
            3 => "1. Melakukan pengembangan yang sudah dilakukan sebelumnya untuk meningkatkan pekerjaan dalam satu tim",
            4 => "1. Melakukan sesuatu yang baru dan belum pernah dilakukan dalam pekerjaan tersebut sebelumnya guna meningkatkan kinerja, namun sudah dilakukan di dalam tim lain",
            5 => "1. Melakukan sesuatu/pengembangan yang baru yang belum dilakukan sebelumnya untuk meningkatkan pekerjaan dalam satu tim"
        ]
    ],
        'berpikir_analitis' => [
        'definisi' => "1. Memecahkan masalah yang sulit melalui evaluasi yang seksama dan sistematis terhadap informasi, alternatif yang mungkin dan konsekuensinya\n2. Secara mendalam mampu menghasilkan solusi yang tepat untuk masalah-masalah yang sulit.\n3. Mempertimbangkan banyak sumber informasi, secara sistematis\n4. Mengolah dan mengevaluasi informasi dengan membandingkan berbagai arah tindakan, dan secara hati-hati mendiskusikannya sebelum membuat keputusan akhir.",
        'min_capaian' => ['indikator' => 2, 'keterangan' => "Dapat melakukan analisis masalah dengan data informasi yang tersedia"],
        'indikator' => [
            1 => "1. Kurang dapat menggali informasi yang dibutuhkan",
            2 => "1. Dapat melakukan analisis masalah dengan data informasi yang tersedia",
            3 => "1. Melihat hubungan mendasar.\n2. Menganalisa hubungan antara bagian dari persoalan.",
            4 => "1. Melihat hubungan mendasar.\n2. Menganalisa hubungan antara bagian dari persoalan.\n3. Membuat hubungan sebab akibat sederhana, dan mengkaji keuntungan dan kelemahan setiap alternatif.",
            5 => "1. Menganalisa hubungan antara bagian dari persoalan.\n2. Membuat hubungan sebab akibat sederhana, dan mengkaji keuntungan dan kelemahan setiap alternatif.\n3. Membutuhkan bantuan untuk menganalisis masalah"
        ]
    ],
        'berpikir_konseptual' => [
        'definisi' => 'Kemampuan untuk memahami konsep kompleks dan membuat koneksi logis antara ide-ide terkait.',
        'min_capaian' => ['indikator' => 2, 'keterangan' => "Menggunakan akal sehat, pengalaman masalah lalu untuk mengidentifikasi situasi atau masalah. Melihat kesamaan antara pemasalahan sekarang dan masalah lalu"],
        'indikator' => [
            1 => "1. Berpikir secara konkrit",
            2 => "1. Menggunakan akal sehat, pengalaman masalah lalu untuk mengidentifikasi situasi atau masalah. Melihat kesamaan antara pemasalahan sekarang dan masalah lalu",
            3 => "1. Mampu menerapkan konsep-konsep dasar untuk memecahkan masalah sederhana",
            4 => "1. Menerapkan dan memodifikasi konsep belajar secara wajar atau menerapkan pengetahuan masa lalu, kecenderungan dan hubungan antara berbagai situasi yang berbeda.",
            5 => "1. Menyatukan ide, isu, dan observasi menjadi konsep tunggal atau penjelasan yang jelas. Mengidentifikasi isu kunci dalam situasi kompleks"
        ]
    ],
        'business_acumen' => [
        'definisi' => 'Memahami konsep-konsep bisnis dan keuangan secara umum, memahami bisnis organisasi, dan menggunakan pengetahuan baik secara umum maupun spesifik untuk bekerja secara efektif.',
        'min_capaian' => ['indikator' => 2, 'keterangan' => "1. Pemahaman dasar tentang konsep-konsep bisnis yang relevan dengan peran mereka\n2. Memahami bagaimana pekerjaan berkontribusi pada tujuan tim atau departemen"],
        'indikator' => [
            1 => "1. Pemahaman dasar tentang konsep-konsep bisnis yang relevan dengan peran mereka\n2. Mampu mengikuti prosedur dan instruksi yang diberikan\n3. Memahami bagaimana pekerjaan berkontribusi pada tujuan tim atau departemen",
            2 => "1. Memahami alur kerja dasar departemen\n2. Mampu menggunakan perangkat lunak atau sistem yang relevan dengan pekerjaan mereka",
            3 => "1. Mampu menerapkan konsep-konsep bisnis dalam pekerjaan sehari-hari\n2. Dapat mengidentifikasi masalah dan mencari solusi yang sesuai dengan prosedur yang ada\n3. Mengelola waktu dan prioritas untuk menyelesaikan tugas-tugas",
            4 => "1. Mampu menganalisis situasi bisnis dan mengidentifikasi peluang untuk perbaikan.",
            5 => "1. Memberikan kontribusi yang signifikan pada tim atau departemen"
        ]
    ]
];