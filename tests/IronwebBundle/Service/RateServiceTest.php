<?php

namespace tests\IronwebBundle\Service;

use IronwebBundle\Entity\Rate;
use IronwebBundle\Service\RateService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class RateServiceTest
 *
 * @package tests\IronwebBundle\Service
 *
 * @author  <ramseyer.claude@gumi-europe.com>
 */
class RateServiceTest extends KernelTestCase
{

    /** @var RateService */
    private $service;

    /**
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->service = self::$kernel->getContainer()->get('ironweb.api.rate');
    }

    /**
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function testCreateEntity()
    {
        $rate = $this->service->createEntity();

        $this->assertTrue($rate instanceof Rate);
        $this->assertEquals(null, $rate->getId(), 'Invalid rate id');
        $this->assertEquals(null, $rate->getArticle(), 'Invalid article');
    }

    /**
     *
     * @author <ramseyer.claude@gumi-europe.com>
     */
    public function testHydrate()
    {
        $rate      = new Rate();
        $user      = 'root';
        $rateValue = 4;
        $date      = '2016-01-01';
        $param     = array(
            'user' => $user,
            'rate' => $rateValue,
            'date' => $date
        );

        $this->service->hydrate($rate, $param);

        $this->assertEquals($user, $rate->getUser(), 'Bad hydratation user');
        $this->assertEquals($rateValue, $rate->getRate(), 'Bad hydratation rate');
        $this->assertEquals($date, $rate->getDate()->format('Y-m-d'), 'Bad hydratation date');
    }

}
