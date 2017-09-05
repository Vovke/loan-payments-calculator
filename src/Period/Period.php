<?php

/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage:
 * @created: 14/06/2017 16:14
 */
namespace cog\LoanPaymentsCalculator\Period;

/**
 * Class Period
 */
class Period
{
    /**
     * @var \DateTime
     */
    public $startDate;

    /**
     * @var \DateTime
     */
    public $endDate;

    /**
     * @var int
     */
    public $daysLength;

    /**
     * Period constructor.
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     */
    public function __construct(\DateTime $startDate, \DateTime $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->daysLength = $startDate->diff($endDate)->days;
    }
}
