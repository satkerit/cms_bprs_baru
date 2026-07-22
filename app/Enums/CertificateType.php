<?php

namespace App\Enums;

enum CertificateType: string
{
    case SHM = 'SHM';
    case SHGB = 'SHGB';
    case SHP = 'SHP';
    case AJB = 'AJB';
    case PPJB = 'PPJB';
    case Girik = 'Girik';
    case BPKB = 'BPKB';
    case Lainnya = 'Lainnya';

    public function label(): string
    {
        return match($this) {
            self::SHM => 'Sertifikat Hak Milik (SHM)',
            self::SHGB => 'Sertifikat Hak Guna Bangunan (SHGB)',
            self::SHP => 'Sertifikat Hak Pakai (SHP)',
            self::AJB => 'Akta Jual Beli (AJB)',
            self::PPJB => 'Perjanjian Pengikatan Jual Beli (PPJB)',
            self::Girik => 'Girik/Letter C',
            self::BPKB => 'BPKB (Kendaraan)',
            self::Lainnya => 'Lainnya',
        };
    }
}
