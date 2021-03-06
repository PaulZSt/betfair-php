<?php

namespace spec\Betfair\AccountApi;

use Betfair\Adapter\AdapterInterface;
use Betfair\Client\BetfairClientInterface;
use Betfair\Factory\MarketFilterFactoryInterface;
use Betfair\Factory\ParamFactory;
use Betfair\Factory\ParamFactoryInterface;

use Betfair\Model\Param;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AccountDetailsSpec extends ObjectBehavior
{
    protected $client;
    protected $adapterInterface;
    protected $paramFactory;
    protected $marketFilterFactory;

    public function let(
        BetfairClientInterface $client,
        AdapterInterface $adapterInterface,
        ParamFactoryInterface $paramFactory,
        MarketFilterFactoryInterface $marketFilterFactory
    ) {
        $this->client = $client;
        $this->adapterInterface =  $adapterInterface;
        $this->paramFactory = $paramFactory;
        $this->marketFilterFactory = $marketFilterFactory;

        $this->beConstructedWith(
            $this->client,
            $this->adapterInterface,
            $this->paramFactory,
            $this->marketFilterFactory
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Betfair\AccountApi\AccountDetails');
    }

    public function it_get_account_details(ParamFactory $paramFactory, Param $param, BetfairClientInterface $client, AdapterInterface $adapterInterface)
    {
        $paramFactory->create()->shouldBeCalled()->willReturn($param);
        $client->apiNgRequest("getAccountDetails", $param, "account")->shouldBeCalled()->willReturn("{account}");

        $adapterInterface->adaptResponse("{account}")->willReturn(array("account"));
        $this->getAccountDetails()->shouldReturn(array("account"));
    }
}
