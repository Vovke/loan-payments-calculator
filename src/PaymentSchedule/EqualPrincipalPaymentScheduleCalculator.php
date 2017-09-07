<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage:
 * @created: 05/09/2017 16:56
 */

namespace cog\LoanPaymentsCalculator\PaymentSchedule;

use cog\LoanPaymentsCalculator\Payment\Payment;
use cog\LoanPaymentsCalculator\Period\Period;
use cog\LoanPaymentsCalculator\Schedule\Schedule;

/**
 * Class EqualPrincipalPaymentScheduleCalculator
 * @package cog\LoanPaymentsCalculator\PaymentSchedule
 */
class EqualPrincipalPaymentScheduleCalculator implements PaymentScheduleCalculator
{
    /**
     * @var Period[]
     */
    private $schedulePeriods;

    /**
     * @var float
     */
    private $principalAmount;

    /**
     * @var float
     */
    private $dailyInterestRate;

    /**
     * @var float
     */
    private $totalInterest;

    /**
     * PaymentSchedule constructor.
     * @param Period[] $schedulePeriods
     * @param float    $principalAmount
     * @param float    $dailyInterestRate
     */
    public function __construct(
        $schedulePeriods,
        $principalAmount,
        $dailyInterestRate
    ){
        $this->schedulePeriods = $schedulePeriods;
        $this->principalAmount = $principalAmount;
        $this->dailyInterestRate = $dailyInterestRate;
        $this->totalInterest = 0.0;
    }

    /**
     * @return float
     */
    public function getTotalInterest()
    {
        return $this->totalInterest;
    }

    /**
     * @param float $totalInterest
     */
    public function setTotalInterest($totalInterest)
    {
        $this->totalInterest = $totalInterest;
    }

    /**
     * @inheritdoc
     */
    public function calculateSchedule()
    {
        /**
         * @var Payment[] $payments
         */
        $payments = [];
        $numberOfPeriods = count($this->schedulePeriods);
        $paymentPrincipal = $this->principalAmount/$numberOfPeriods;
        $totalPrincipalToPay = $this->principalAmount;

        for ($i=0; $i<$numberOfPeriods ; $i++) {
            $payment = new Payment($this->schedulePeriods[$i]);
            // Payment principal
            $payment->setPrincipal($paymentPrincipal);
            // Payment interest
            $paymentInterest = $this->calculatePaymentInterest($totalPrincipalToPay, $this->dailyInterestRate, $payment->getPeriod()->daysLength);
            $payment->setInterest($paymentInterest);
            // Payment totals
            $totalPrincipalToPay-=$paymentPrincipal;
            $payment->setPrincipalBalanceLeft($totalPrincipalToPay);

            $payments[] = $payment;
            $this->totalInterest += $paymentInterest;
        }

        return $payments;
    }

    /**
     * @param float   $remainingPrincipalAmount
     * @param float   $dailyInterestRate
     * @param integer $periodInDays
     * @return float
     */
    private function calculatePaymentInterest($remainingPrincipalAmount, $dailyInterestRate, $periodInDays)
    {
        return $remainingPrincipalAmount*$dailyInterestRate*$periodInDays;
    }
}