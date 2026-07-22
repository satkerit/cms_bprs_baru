<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class Controller
{
    protected function executeTransaction(callable $callback, string $successMessage, string $redirectRoute): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();
            $result = $callback();
            DB::commit();
            return redirect()->route($redirectRoute)->with('success', $successMessage);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }

    protected function executeInTransaction(callable $callback): mixed
    {
        try {
            DB::beginTransaction();
            $result = $callback();
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
