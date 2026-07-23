<?php

declare(strict_types=1);

namespace App\Livewire\Frontend\FinancingSimulation;

use App\Models\FinancingConfig;
use App\Services\FinancingCalculatorService;
use App\Helpers\CurrencyFormatter;
use Livewire\Component;
use Livewire\Attributes\Computed;

final class Calculator extends Component
{
    /** @var string Selected financing configuration ID */
    public string $financingType = '';

    /** @var string Raw principal input (may contain formatting) */
    public string $principalInput = '';

    /** @var string Raw tenor input */
    public string $tenorInput = '';

    /** @var string Raw down payment input (may contain formatting) */
    public string $downPaymentInput = '';

    /** @var string Raw projected revenue input (may contain formatting) */
    public string $projectedRevenueInput = '';

    /** @var array|null Calculation result */
    public ?array $result = null;

    /**
     * Initialize component with available configs.
     */
    public function mount(): void
    {
        $configs = FinancingConfig::getConfigs();

        if ($configs->isNotEmpty()) {
            $this->financingType = (string) $configs->first()->id;
        }
    }

    /**
     * Get available financing configurations.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, FinancingConfig>
     */
    #[Computed]
    public function configs(): \Illuminate\Database\Eloquent\Collection
    {
        return FinancingConfig::getConfigs();
    }

    /**
     * Get the currently selected financing configuration.
     */
    #[Computed]
    public function selectedConfig(): ?FinancingConfig
    {
        if (empty($this->financingType)) {
            return null;
        }

        return $this->configs()->firstWhere('id', $this->financingType);
    }

    /**
     * Reset dependent fields when financing type changes.
     */
    public function updatedFinancingType(): void
    {
        $this->resetFormFields();
    }

    /**
     * Calculate financing installment with defensive validation.
     */
    public function calculate(): void
    {
        $this->result = null;
        $this->resetValidation();

        $config = $this->selectedConfig();

        if ($config === null || empty($this->financingType)) {
            $this->addError('financingType', 'Jenis pembiayaan wajib dipilih.');
            return;
        }

        // --- Sanitize numeric inputs ---
        $cleanPrincipal = $this->sanitizeNumericInput($this->principalInput);
        $cleanTenor = $this->sanitizeNumericInput($this->tenorInput);
        $cleanDownPayment = $this->sanitizeNumericInput($this->downPaymentInput);
        $cleanProjectedRevenue = $this->sanitizeNumericInput($this->projectedRevenueInput);

        // --- Validate principal ---
        if ($cleanPrincipal < 1) {
            $this->addError('principalInput', 'Jumlah pembiayaan wajib diisi minimal Rp 1.000.');
            return;
        }

        if ($cleanPrincipal < $config->min_principal || $cleanPrincipal > $config->max_principal) {
            $this->addError(
                'principalInput',
                'Jumlah pembiayaan harus antara Rp '
                . number_format($config->min_principal, 0, ',', '.')
                . ' — Rp '
                . number_format($config->max_principal, 0, ',', '.')
            );
            return;
        }

        // --- Validate tenor ---
        if ($cleanTenor < 1 || $cleanTenor > 60) {
            $this->addError('tenorInput', 'Jangka waktu harus antara 1 — 60 bulan.');
            return;
        }

        // --- Validate down payment ---
        if ($config->dp_enabled && $cleanDownPayment > 0) {
            $dpPercentage = ($cleanDownPayment / $cleanPrincipal) * 100;
            $minDp = (float) ($config->dp_min_percentage ?? 0);
            $maxDp = (float) ($config->dp_max_percentage ?? 100);

            if ($dpPercentage < $minDp) {
                $minDpAmount = (int) round($cleanPrincipal * $minDp / 100);
                $this->addError(
                    'downPaymentInput',
                    'DP minimal ' . number_format($minDp, 0) . '% (Rp ' . number_format($minDpAmount, 0, ',', '.') . ')'
                );
                return;
            }

            if ($dpPercentage > $maxDp) {
                $maxDpAmount = (int) round($cleanPrincipal * $maxDp / 100);
                $this->addError(
                    'downPaymentInput',
                    'DP maksimal ' . number_format($maxDp, 0) . '% (Rp ' . number_format($maxDpAmount, 0, ',', '.') . ')'
                );
                return;
            }
        }

        // --- Validate projected revenue for profit sharing ---
        if ($config->isProfitSharing() && $cleanProjectedRevenue < 1) {
            $this->addError(
                'projectedRevenueInput',
                'Proyeksi pendapatan wajib diisi untuk pembiayaan modal kerja.'
            );
            return;
        }

        // --- Calculate ---
        $principalAfterDp = $cleanPrincipal - $cleanDownPayment;

        if ($principalAfterDp < 1) {
            $this->addError('downPaymentInput', 'DP tidak boleh melebihi jumlah pembiayaan.');
            return;
        }

        $service = new FinancingCalculatorService();
        $this->result = $service->calculate(
            $principalAfterDp,
            (float) $config->margin_rate,
            $cleanTenor,
            $config->calculation_type,
            $cleanProjectedRevenue
        );

        // Enrich result with config metadata
        $this->result['config_name'] = $config->name;
        $this->result['calculation_type'] = $config->calculation_type;
        $this->result['rate_label'] = $config->getRateLabel();
        $this->result['margin_percentage'] = (float) $config->margin_rate * 100;
        $this->result['monthly_margin_percentage'] = ((float) $config->margin_rate / 12) * 100;
        $this->result['original_principal'] = $cleanPrincipal;
        $this->result['down_payment'] = $cleanDownPayment;
        $this->result['dp_percentage'] = $cleanPrincipal > 0
            ? round(($cleanDownPayment / $cleanPrincipal) * 100, 2)
            : 0;

        if ($config->isProfitSharing() && $cleanProjectedRevenue > 0) {
            $this->result['projected_revenue'] = $cleanProjectedRevenue;
        }
    }

    /**
     * Reset all input fields and result.
     */
    public function resetCalculator(): void
    {
        $this->resetFormFields();
        $this->result = null;
        $this->resetValidation();
    }

    /**
     * Format a number to Indonesian Rupiah string.
     */
    public function formatRupiah(int $number): string
    {
        return CurrencyFormatter::formatFull($number);
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.frontend.financing-simulation.calculator');
    }

    /**
     * Strip non-numeric characters and return a clean integer.
     */
    private function sanitizeNumericInput(string $input): int
    {
        $cleaned = preg_replace('/[^0-9]/', '', $input);

        if ($cleaned === null || $cleaned === '') {
            return 0;
        }

        return (int) $cleaned;
    }

    /**
     * Reset input fields (preserves financing type).
     */
    private function resetFormFields(): void
    {
        $this->principalInput = '';
        $this->tenorInput = '';
        $this->downPaymentInput = '';
        $this->projectedRevenueInput = '';
    }
}
