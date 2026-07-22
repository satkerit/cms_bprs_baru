<?php

namespace App\Enums;

enum AuctionStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case RegistrationOpen = 'registration_open';
    case RegistrationClosed = 'registration_closed';
    case AuctionScheduled = 'auction_scheduled';
    case AuctionOngoing = 'auction_ongoing';
    case AuctionCompleted = 'auction_completed';
    case Sold = 'sold';
    case Unsold = 'unsold';
    case Cancelled = 'cancelled';
    case Postponed = 'postponed';

    public function label(): string
    {
        return match($this) {
            self::Draft => 'Draft',
            self::Published => 'Dipublikasi',
            self::RegistrationOpen => 'Pendaftaran Dibuka',
            self::RegistrationClosed => 'Pendaftaran Ditutup',
            self::AuctionScheduled => 'Lelang Terjadwal',
            self::AuctionOngoing => 'Lelang Berlangsung',
            self::AuctionCompleted => 'Lelang Selesai',
            self::Sold => 'Terjual',
            self::Unsold => 'Tidak Terjual',
            self::Cancelled => 'Dibatalkan',
            self::Postponed => 'Ditunda',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Draft => 'gray',
            self::Published => 'blue',
            self::RegistrationOpen => 'green',
            self::RegistrationClosed => 'yellow',
            self::AuctionScheduled => 'purple',
            self::AuctionOngoing => 'orange',
            self::AuctionCompleted => 'indigo',
            self::Sold => 'emerald',
            self::Unsold => 'slate',
            self::Cancelled => 'red',
            self::Postponed => 'amber',
        };
    }
}
