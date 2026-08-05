<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class LlmsTxtController extends Controller
{
    /**
     * Sajikan file llms.txt (spesifikasi https://llmstxt.org) agar AI crawler
     * memahami struktur & konten situs.
     */
    public function __invoke(): Response
    {
        $company = Cache::remember('llms_txt_company', 3600, fn() => CompanyInfo::getInfo());

        $name = $company?->name ?? 'BPRS Bangka Belitung';
        $address = $company?->address ?? '-';
        $phone = $company?->phone ?? '-';
        $email = $company?->email ?? '-';

        $content = "# {$name}\n\n"
            . "> Bank Perekonomian Rakyat Syariah (BPRS) Bangka Belitung — bank syariah "
            . "yang terdaftar dan diawasi oleh Otoritas Jasa Keuangan (OJK) dan peserta "
            . "penjaminan Lembaga Penjamin Simpanan (LPS). Melayani masyarakat Kepulauan "
            . "Bangka Belitung sesuai prinsip syariah.\n\n"
            . "## Informasi Kontak\n\n"
            . "- Alamat: {$address}\n"
            . "- Telepon: {$phone}\n"
            . "- Email: {$email}\n\n"
            . "## Halaman Penting\n\n"
            . "- [Beranda](https://www.bprsbabel.id/) — informasi utama, produk, dan berita terbaru\n"
            . "- [Produk & Layanan](https://www.bprsbabel.id/produk/simpanan-syariah) — simpanan syariah, pembiayaan syariah, deposito syariah\n"
            . "- [Simulasi Pembiayaan](https://www.bprsbabel.id/simulasi-pembiayaan) — hitung angsuran pembiayaan syariah\n"
            . "- [Berita & Artikel](https://www.bprsbabel.id/berita) — berita dan kegiatan bank\n"
            . "- [Lelang Agunan](https://www.bprsbabel.id/lelang) — daftar aset agunan yang dilelang\n"
            . "- [Kantor Cabang](https://www.bprsbabel.id/tentang-kami/kantor-cabang/kantor-pusat-operasional) — jaringan kantor cabang dan kas\n"
            . "- [Karier](https://www.bprsbabel.id/karir) — lowongan pekerjaan\n"
            . "- [Pengaduan Nasabah](https://www.bprsbabel.id/pengaduan-nasabah) — keluhan dan masukan nasabah\n"
            . "- [Whistleblowing](https://www.bprsbabel.id/whistleblowing) — lapor dugaan pelanggaran\n"
            . "- [Kebijakan Privasi](https://www.bprsbabel.id/kebijakan-privasi) — kebijakan privasi dan keamanan data\n";

        return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
