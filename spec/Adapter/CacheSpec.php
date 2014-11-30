<?php

namespace spec\Indigo\Http\Adapter;

use Indigo\Http\Adapter;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CacheSpec extends ObjectBehavior
{
    function let(Adapter $adapter)
    {
        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Adapter\Cache');
        $this->shouldUseTrait('Indigo\Http\Adapter\Decorator');
        $this->shouldUseTrait('Stash\Interfaces\PoolInterface');
        $this->shouldImplement('Indigo\Http\Adapter');
    }

    function it_should_allow_to_cache_a_response(Adapter $adapter, Request $request, Response $response)
    {
        $adapter->send($request)->willReturn($response);

        $request->getUrl()->willReturn('http://foo.com');
        $response->getHeader('ETag')->willReturn('etag');
        $response->getStatusCode()->willReturn(200);

        $this->send($request)->shouldReturn($response);

        $this->getItem(md5('http://foo.com'))->isMiss()->shouldReturn(false);
    }

    function it_should_return_a_cached_response(Adapter $adapter, Request $request, Response $response, Response $cached)
    {
        $adapter->send($request)->willReturn($response);

        $cached->getStatusCode()->willReturn(200);
        $cached->getHeader('ETag')->willReturn('etag');
        $this->getItem(md5('http://foo.com'))->set($cached);

        $request->getUrl()->willReturn('http://foo.com');
        $request->addHeader('If-Modified-Since', Argument::type('string'))->shouldBeCalled();
        $request->addHeader('If-None-Match', 'etag')->shouldBeCalled();
        $response->getStatusCode()->willReturn(304);

        $this->send($request)->shouldReturn($cached);
    }

    public function getMatchers()
    {
        return [
            'useTrait' => function ($subject, $trait) {
                return class_uses($subject, $trait);
            }
        ];
    }
}
