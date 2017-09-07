<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage:
 * @created: 06/09/2017 13:30
 */

namespace cog\LoanPaymentsCalculator\PaymentSchedule;


use cog\LoanPaymentsCalculator\Payment\Payment;
use cog\LoanPaymentsCalculator\Period\Period;


class AnnuityPaymentScheduleCalculator implements PaymentScheduleCalculator
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
     * AnnuityPaymentScheduleCalculator constructor.
     * @param Period[] $schedulePeriods
     * @param float    $principalAmount
     * @param float    $dailyInterestRate
     */
    public function __construct($schedulePeriods, $principalAmount, $dailyInterestRate)
    {
        $this->schedulePeriods = $schedulePeriods;
        $this->principalAmount = $principalAmount;
        $this->dailyInterestRate = $dailyInterestRate;
    }

    /**
     * @inheritdoc
     */
    public function calculateSchedule()
    {
        $payments = [];
        $numberOfPeriods = count($this->schedulePeriods);
        $periodInterestRate = $this->calculateInterestPerPeriod();
        $paymentAmount = $this->calculateAnnuityPaymentAmount($periodInterestRate);
        $totalPrincipalToPay = $this->principalAmount;

        for ($i=0; $i<$numberOfPeriods; $i++) {
            $payment = new Payment($this->schedulePeriods[$i]);
            // Payment interest
            $paymentInterest = $totalPrincipalToPay * $periodInterestRate;
            $payment->setInterest($paymentInterest);
            // Payment principal
            $paymentPrincipal = $i == $numberOfPeriods-1 ? $totalPrincipalToPay : $paymentAmount - $paymentInterest;
            $payment->setPrincipal($paymentPrincipal);
            // Payment totals
            $totalPrincipalToPay-=$paymentPrincipal;
            $payment->setPrincipalBalanceLeft($totalPrincipalToPay);

            $payments[] = $payment;
        }

        return $payments;
    }

    /**
     * @param float $interestPerPeriod
     * @return float
     */
    private function calculateAnnuityPaymentAmount($interestPerPeriod)
    {
        // Payment = InterestPerPeriod x TotalPrincipal / 1 - ( 1 + InterestPerPeriod)^(-numberOfPeriods)
        return (($interestPerPeriod) *  $this->principalAmount) / (1 - pow(1 + ($interestPerPeriod), -count($this->schedulePeriods)));
    }

    /**
     * @return float
     */
    private function calculateInterestPerPeriod()
    {
        $startDate = $this->schedulePeriods[0]->startDate;
        $endDate = $this->schedulePeriods[count($this->schedulePeriods)-1]->endDate;
        $daysDiff = $startDate->diff($endDate)->days;

        return $this->dailyInterestRate * $daysDiff/count($this->schedulePeriods);
    }
}