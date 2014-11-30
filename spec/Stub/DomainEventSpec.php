<?php

namespace spec\Indigo\Http\Stub;

use PhpSpec\ObjectBehavior;

class DomaninEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Stub\DomainEvent');
        $this->shouldHaveType('Indigo\Http\Event\DomainEvent');
        $this->shouldImplement('League\Event\EventInterface');
    }

    function it_should_have_a_name()
    {
        $this->getName()->shouldBe('eventStub');
    }
}
