<?php
/**
 * @author: Vova Lando <vova.lando@gmail.com>
 * @package: LoanPaymentsCalculator
 * @subpackage: DateProvider
 * @created: 14/06/2017 15:04
 */
namespace cog\LoanPaymentsCalculator\DateProvider\DateDetermineStrategy;

/**
 * Interface DateDetermineStrategyInterface
 */
interface DateDetermineStrategyInterface
{
    /**
     * Returns closest raw possible day for payment
     *
     * @param \DateTime $startDate
     *
     * @return \DateTime
     */
    public function calculateNextDate(\DateTime $startDate);
}
