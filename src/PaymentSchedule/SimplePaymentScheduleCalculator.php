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

class SimplePaymentScheduleCalculator implements PaymentScheduleCalculator
{
    /**
     * @var Schedule[]
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
    private $interestCapForPeriodInPercents;

    /**
     * @var float
     */
    private $totalInterest;

    /**
     * PaymentSchedule constructor.
     * @param Period[] $schedulePeriods
     * @param float $principalAmount
     * @param float $dailyInterestRate
     * @param float $interestCapForPeriodInPercents
     */
    public function __construct(
        $schedulePeriods,
        $principalAmount,
        $dailyInterestRate,
        $interestCapForPeriodInPercents = 0.0
    )
    {
        $this->schedulePeriods = $schedulePeriods;
        $this->principalAmount = $principalAmount;
        $this->dailyInterestRate = $dailyInterestRate;
        $this->interestCapForPeriodInPercents = $interestCapForPeriodInPercents;
        $this->totalInterest = 0;
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

    public function calculateSchedule()
    {
        /**
         * @var Payment[] $payments
         */
        $payments = [];
        $paymentPrincipal = $this->principalAmount/count($this->schedulePeriods);
        $totalPrincipalToPay = $this->principalAmount;

        for ($i=0; $i<count($this->schedulePeriods); $i++) {
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

    private function calculatePaymentInterest($remainingPrincipalAmount, $dailyInterestRate, $periodInDays)
    {
        return $remainingPrincipalAmount*$dailyInterestRate*$periodInDays;
    }
}