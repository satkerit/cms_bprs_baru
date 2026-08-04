<?php

namespace App\Enums;

enum AuctionStatus: string
{
    case Draft              = 'draft';
    case Published          = 'published';
    case RegistrationOpen   = 'registration_open';
    case RegistrationClosed = 'registration_closed';
    case Sold               = 'sold';
    case Cancelled          = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Draft              => 'Draft',
            self::Published          => 'Dipublikasi',
            self::RegistrationOpen   => 'Pendaftaran Dibuka',
            self::RegistrationClosed => 'Pendaftaran Ditutup',
            self::Sold               => 'Terjual',
            self::Cancelled          => 'Dibatalkan',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Draft              => 'zinc',
            self::Published          => 'blue',
            self::RegistrationOpen   => 'emerald',
            self::RegistrationClosed => 'amber',
            self::Sold               => 'purple',
            self::Cancelled          => 'red',
        };
    }
}
