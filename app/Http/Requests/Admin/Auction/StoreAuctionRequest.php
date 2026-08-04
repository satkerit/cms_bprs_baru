<?php

namespace App\Http\Requests\Admin\Auction;

use App\Enums\AuctionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAuctionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $auctionImageMaxKb = get_upload_max_size('auction_image');

        return [
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'auction_number'     => 'required|string|unique:auctions,auction_number',
            'asset_type'         => 'required|in:tanah,rumah,ruko,apartemen,gedung,pabrik,kendaraan,mesin,lainnya',
            'asset_description'  => 'nullable|string',
            'building_condition' => 'nullable|string|max:255',
            'certificate_type'   => 'nullable|in:SHM,SHGB,SHP,AJB,PPJB,Girik,BPKB,Lainnya',
            'certificate_number' => 'nullable|string|max:255',
            'land_area'          => 'nullable|numeric|min:0',
            'building_area'      => 'nullable|numeric|min:0',
            'address'            => 'required|string',
            'village'            => 'nullable|string|max:255',
            'district'           => 'nullable|string|max:255',
            'city'               => 'nullable|string|max:255',
            'province'           => 'nullable|string|max:255',
            'postal_code'        => 'nullable|string|max:10',
            'debtor_name'        => 'nullable|string|max:255',
            'auction_type'       => 'required|in:eksekusi_hak_tanggungan,eksekusi_fidusia,eksekusi_hipotik,non_eksekusi_wajib,non_eksekusi_sukarela',
            'auction_date'       => 'nullable|date',
            'auction_time'       => 'nullable|date_format:H:i',
            'auction_location'   => 'required|string|max:255',
            'auction_url'        => 'nullable|url|max:255',
            'organizer_name'     => 'nullable|string|max:255',
            'limit_price'        => 'nullable|numeric|min:0',
            'estimated_price'    => 'nullable|numeric|min:0',
            'deposit_amount'     => 'nullable|numeric|min:0',
            'contact_name'       => 'nullable|string|max:255',
            'contact_phone'      => 'nullable|string|max:20',
            'contact_email'      => 'nullable|email|max:255',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string|max:500',
            'status'             => ['required', Rule::in(array_column(AuctionStatus::cases(), 'value'))],
            'is_featured'        => 'boolean',
            'published_at'       => 'nullable|date',
            'images'             => 'nullable|array',
            'images.*'           => "image|mimes:jpeg,png,jpg,webp|max:{$auctionImageMaxKb}|dimensions:min_width=400,min_height=300",
        ];
    }

    public function messages(): array
    {
        $auctionImageMaxMb = round(get_upload_max_size('auction_image') / 1024);

        return [
            'images.*.image'    => 'File harus berupa gambar.',
            'images.*.mimes'    => 'Format gambar harus JPEG, PNG, JPG, atau WebP.',
            'images.*.max'      => "Ukuran gambar maksimal {$auctionImageMaxMb}MB.",
        ];
    }
}
