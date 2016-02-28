<?php

/**
 * Created by PhpStorm.
 * User: Porsh
 * Date: 25.02.2016
 * Time: 19:05
 */
class InterestCalculation
{

    public $interest = null;

    /**
     * InterestCalculation constructor.
     * @param $sum
     * @param $days
     */
    public function __construct($sum, $days)
    {
        $this->sum = $sum;
        $this->days = $days;
    }

    /**
     * Calculate interest = sum of all days interests
     */
    public function calculateInterest()
    {
        $totalInterest = 0;
        for ($i = 1; $i <= $this->days; $i++) {

            if ($i % 3 == 0 && $i % 5 == 0) {
                $dailyPercent = 0.03;
            } elseif ($i % 3 == 0) {
                $dailyPercent = 0.01;
            } elseif ($i % 5 == 0) {
                $dailyPercent = 0.02;
            } else {
                $dailyPercent = 0.04;
            }

            $dailyInterest = round($this->sum * $dailyPercent, 2);
            $totalInterest += $dailyInterest;
        }

        $this->interest = $totalInterest;
    }

    /**
     * Validate input data for calculation
     *
     * @param $data - array
     * @return bool
     */
    public static function validateInput($data)
    {
        // limit days to 100 years;
        $maxDays = 36500;

        if (count($data) != 2 || !isset($data['sum'], $data['days']) || $data['days'] > $maxDays) {
            return false;
        }

        $func = function ($value) {
            return floatval($value);
        };
        $data = array_map($func, $data);

        foreach ($data as $val) {
            if ($val < 1) return false;
        }

        return true;
    }
}