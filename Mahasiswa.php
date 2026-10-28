<?php
declare(strict_types=1);

require_once __DIR__ . '/Buku.php';

class Mahasiswa {
    private array $atributTamsbahan = [];

    // Constructor: validasi keadaan awal object.
    public function __construct(   #construct adalah method yang dipanggil otomatis ketika kelas menjadi objek
        public string $nim,
        public string $nama,
        public string $fakultas = "Belum diisi",
        public string $prodi,
        public string $asalSekolah,
        public int $semester,
        public string $hobi,
        public string $agama
    ) {
        
        if ($nim === '' || $nama === '' || $semester < 1 || $semester > 14) {
            throw new InvalidArgumentException('NIM, nama, dan semester harus valid.');
        }
    }

    //method untuk menambah pinjaman dengan tanggal
    public function pinjamBuku(Buku $buku, string $mulai, string $selesai): void {
        $this->bukuDipinjam[] = [
            'buku' => $buku,
            'mulai' => $mulai,
            'selesai' => $selesai
        ];
    }

    public function setBukuDipinjam(array $daftar): void {
        $this->bukuDipinjam[] = $daftar;
    }

    public function getBukuDipinjam(): array {
        return $this->bukuDipinjam ?? [];
    }

    public function ringkasan(): string {
        return $this->nim . ' - ' . $this->nama;
    }

    // Overloading property: menangani atribut DINAMIS yang tidak dideklarasikan.
    public function __set(string $nama, mixed $nilai): void {
        $this->atributTambahan[$nama] = $nilai;
    }
    public function __get(string $nama): mixed {
        return $this->atributTambahan[$nama] ?? null;
    }
    public function __isset(string $nama): bool {
        return isset($this->atributTambahan[$nama]);
    }
    public function __unset(string $nama): void {
        unset($this->atributTambahan[$nama]);
    }

    // Overloading method: hanya menerima alias yang sengaja disediakan.
    public function __call(string $nama, array $argumen): mixed {
        if ($nama === 'profilSingkat' && count($argumen) === 0) {
            return $this->ringkasan();
        }
        throw new BadMethodCallException('Method tidak tersedia: ' . $nama);
    }

    public function __destruct() {
        // Demonstrasi saja. Jangan echo di aplikasi CRUD/session:
        // destructor dapat dipanggil saat request selesai atau object dilepas.
        if (defined('DEMO_LIFECYCLE') && DEMO_LIFECYCLE) {
            error_log('Destructor Mahasiswa: ' . $this->nim);
        }
    }
}