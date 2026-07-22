<?php

namespace App\Enums;

enum AssetType: string
{
    case Tanah = 'tanah';
    case Rumah = 'rumah';
    case Ruko = 'ruko';
    case Apartemen = 'apartemen';
    case Gedung = 'gedung';
    case Pabrik = 'pabrik';
    case Kendaraan = 'kendaraan';
    case Mesin = 'mesin';
    case Lainnya = 'lainnya';

    public function label(): string
    {
        return match($this) {
            self::Tanah => 'Tanah',
            self::Rumah => 'Rumah Tinggal',
            self::Ruko => 'Ruko/Rukan',
            self::Apartemen => 'Apartemen/Kondominium',
            self::Gedung => 'Gedung Komersial',
            self::Pabrik => 'Pabrik/Gudang',
            self::Kendaraan => 'Kendaraan',
            self::Mesin => 'Mesin/Peralatan',
            self::Lainnya => 'Lainnya',
        };
    }
}
