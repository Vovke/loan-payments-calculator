<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage: Payment
 * @created: 05/09/2017 10:55
 */

namespace cog\LoanPaymentsCalculator\Payment;


use cog\LoanPaymentsCalculator\Period\Period;

class Payment
{
    /**
     * @var Period
     */
    private $period;

    /**
     * @var float
     */
    private $principal;

    /**
     * @var float
     */
    private $interest;

    /**
     * @var $fees
     */
    private $fees;

    /**
     * @var float
     */
    private $principalBalanceLeft;

    /**
     * Payment constructor.
     * @param Period $period
     */
    public function __construct(Period $period)
    {
        $this->period = $period;
    }

    /**
     * @return Period
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /**
     * @return float
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * @param float $principal
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;
    }

    /**
     * @return float
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * @param float $interest
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;
    }

    /**
     * @return mixed
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * @param mixed $fees
     */
    public function setFees($fees)
    {
        $this->fees = $fees;
    }

    /**
     * @return float
     */
    public function getPrincipalBalanceLeft()
    {
        return $this->principalBalanceLeft;
    }

    /**
     * @param float $principalBalanceLeft
     */
    public function setPrincipalBalanceLeft($principalBalanceLeft)
    {
        $this->principalBalanceLeft = $principalBalanceLeft;
    }
}