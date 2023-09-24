<?php

declare(strict_types=1);

class Budget
{
    private array $spent;
    private array $extraSavings;
    private string $startDate;
    private int $totalMonths;
    private float $yearlyAmount;
    private float $monthlyAmount;
    private float $totalSpent;
    private float $totalSaved;
    private float $totalRemaining;

    public function __construct(private string $type) 
    {
        $this->configureValues();
        $this->calculateBudget();
    }

    private function configureValues(): void
    {
        if ($this->type === 'house') {
            $this->type = 'Bolig';
            $this->yearlyAmount = 10000;
            $this->startDate = '2021-02-01';
            $this->spent = [
                'tv-inspektion + spul af kloak' => 4414.00,
                'slamsug af spildevandsledning' => 3909.75,
                'selvrisiko kloakreperation'    => 2432.00,
                'til gulvrenovation'            => 20000.00,
                'lukning af huller i facaden'   => 5339.85
            ];
            $this->extraSavings = [
                'kontant erstatning til kælder' => 8750.00
            ];
        }
        else {
            $this->type = 'Volvo';
            $this->yearlyAmount = 20000;
            $this->startDate = '2022-03-01';
            $this->spent = [
                'udbedringer før omsyn' => 3792.63,
                'partikelfilter skift' => 10497.25,
                'ny generator' => 3776.80,
                'ny udstødning' => 3865.00
            ];
            $this->extraSavings = [];
        }
    }

    private function calculateBudget(): void
    {
        $this->monthlyAmount = round($this->yearlyAmount / 12, 2);
        $this->totalMonths = $this->getMonthsPassedSince($this->startDate);
        $this->totalSaved = round( ($this->totalMonths * $this->monthlyAmount) + array_sum(array_values($this->extraSavings)), 2);
        $this->totalSpent = array_sum(array_values($this->spent));
        $this->totalRemaining = $this->totalSaved - $this->totalSpent;
    }

    private function getMonthsPassedSince(): int
    {
        $start = new DateTime($this->startDate);
        $current = new DateTime(date('Y-m-d'));
        $diff = $start->diff($current);
    
        $yearsInMonths = $diff->y * 12;
        $months = $diff->m;

        return $yearsInMonths + $months;
    }

    private function formatToDKK(float $amount): string 
    {
        return number_format($amount, 2, ',', '.');
    }

    public function getTotalSpent(): string 
    {
        return $this->formatToDKK($this->totalSpent);
    }

    public function getTotalRemaining(): string 
    {
        return $this->formatToDKK($this->totalRemaining);
    }

    public function getTotalSaved(): string 
    {
        return $this->formatToDKK($this->totalSaved);
    }

    public function getMonthlyAmount(): string 
    {
        return $this->formatToDKK($this->monthlyAmount);
    }

    public function getYearlyAmount(): string
    {
        return $this->formatToDKK($this->yearlyAmount);
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getSavingPeriod(): string 
    {
        if ($this->totalMonths > 12) {
            $years = floor($this->totalMonths / 12);
            $months = $this->totalMonths % 12;

            return $years . ' år og ' . $months . ' måneder';
        }

        return $this->totalMonths . ' måneder';
    }
}

$car = new Budget('car');
$house = new Budget('house');

$budgets = [$house, $car];