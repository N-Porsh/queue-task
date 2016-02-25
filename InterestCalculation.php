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
     * and total sum = sum of original amount and total interest
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
}