<?php

namespace App\Services;

use App\Models\BoardMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BoardMemberService
{
    /**
     * Get paginated board member list with filters.
     */
    public function list(?string $search = null, ?string $type = null, int $perPage = 15): mixed
    {
        /** @var Builder<BoardMember> $query */
        $query = BoardMember::orderBy('type')->orderBy('order_position');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($type) {
            $query->where('type', $type);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Create a new board member.
     *
     * @param array<string, mixed> $data
     * @return array{success: bool, member?: BoardMember, error?: string}
     */
    public function create(array $data, ?string $photoPath = null): array
    {
        try {
            DB::beginTransaction();

            $data = $this->sanitizeArrays($data);

            if ($photoPath) {
                $data['photo'] = $photoPath;
            }

            $member = BoardMember::create($data);

            DB::commit();
            $this->invalidateCache();

            return ['success' => true, 'member' => $member];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Board member creation failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Update an existing board member.
     *
     * @param array<string, mixed> $data
     * @return array{success: bool, member?: BoardMember, error?: string}
     */
    public function update(BoardMember $member, array $data, ?string $photoPath = null): array
    {
        try {
            DB::beginTransaction();

            $data = $this->sanitizeArrays($data);

            if ($photoPath) {
                if ($member->photo) {
                    Storage::disk('public')->delete($member->photo);
                }
                $data['photo'] = $photoPath;
            }

            $member->update($data);

            DB::commit();
            $this->invalidateCache();

            return ['success' => true, 'member' => $member->fresh()];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Board member update failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Delete a board member and its associated photo.
     */
    public function delete(BoardMember $member): array
    {
        try {
            DB::beginTransaction();

            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }

            $member->delete();

            DB::commit();
            $this->invalidateCache();

            return ['success' => true];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Board member deletion failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'error' => 'Gagal menghapus anggota dewan. Silakan coba lagi.'];
        }
    }

    /**
     * Filter empty values from array fields.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function sanitizeArrays(array $data): array
    {
        foreach (['education', 'experience'] as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                $data[$field] = array_values(
                    array_filter($data[$field], fn($v) => is_string($v) && !empty(trim($v)))
                );
            }
        }

        return $data;
    }

    /**
     * Invalidate board member-related caches.
     */
    public function invalidateCache(): void
    {
        Cache::forget(config('cache-keys.board_members', 'board_members') . '_komisaris');
        Cache::forget(config('cache-keys.board_members', 'board_members') . '_direksi');
        Cache::forget(config('cache-keys.board_members', 'board_members') . '_pengawas_syariah');
    }
}
