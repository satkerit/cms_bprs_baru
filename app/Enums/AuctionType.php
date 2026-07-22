<?php

namespace App\Enums;

enum AuctionType: string
{
    case EksekusiHakTanggungan = 'eksekusi_hak_tanggungan';
    case EksekusiFidusia = 'eksekusi_fidusia';
    case EksekusiHipotik = 'eksekusi_hipotik';
    case NonEksekusiWajib = 'non_eksekusi_wajib';
    case NonEksekusiSukarela = 'non_eksekusi_sukarela';

    public function label(): string
    {
        return match($this) {
            self::EksekusiHakTanggungan => 'Eksekusi Hak Tanggungan',
            self::EksekusiFidusia => 'Eksekusi Fidusia',
            self::EksekusiHipotik => 'Eksekusi Hipotik',
            self::NonEksekusiWajib => 'Non-Eksekusi Wajib',
            self::NonEksekusiSukarela => 'Non-Eksekusi Sukarela',
        };
    }
}
