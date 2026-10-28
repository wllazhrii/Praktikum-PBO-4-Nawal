<?php
declare(strict_types=1);

class Buku {
    public function __construct(
        public string $idBuku,
        public string $judul,
        public string $penulis,
        public int $tahun
    ) {}

    public function tampilInfo(): string {
        return "\"{$this->judul}\" karya {$this->penulis} ({$this->tahun})";
    }
}