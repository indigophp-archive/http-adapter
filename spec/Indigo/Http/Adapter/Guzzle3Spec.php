<?php

namespace spec\Indigo\Http\Adapter;

use Psr\Http\Message\RequestInterface as Request;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\RequestInterface as GuzzleRequest;
use Guzzle\Http\Message\Response as GuzzleResponse;
use PhpSpec\ObjectBehavior;

class Guzzle3Spec extends ObjectBehavior
{
    protected $client;

    function let(ClientInterface $client)
    {
        $this->beConstructedWith($client);
        $this->client = $client;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Adapter\Guzzle3');
        $this->shouldImplement('Indigo\Http\Adapter');
    }

    function it_should_return_a_response(Request $request, GuzzleRequest $guzzleRequest, GuzzleResponse $guzzleResponse)
    {
        $request->getMethod()->willReturn('GET');
        $request->getUrl()->willReturn('http://foo.com');
        $request->getProtocolVersion()->willReturn('1.1');
        $request->getHeaders()->willReturn([]);
        $request->getBody()->willReturn(null);

        $guzzleResponse->getStatusCode()->willReturn(200);
        $guzzleResponse->getProtocolVersion()->willReturn('1.1');
        $guzzleResponse->getHeaders()->willReturn([]);
        $guzzleResponse->getBody()->willReturn(null);

        $this->client->createRequest('GET', 'http://foo.com', ['version' => '1.1', 'headers' => []])->willReturn($guzzleRequest);
        $this->client->send($guzzleRequest)->willReturn($guzzleResponse);

        $response = $this->send($request);

        $response->getStatusCode()->shouldBe(200);
        $response->getProtocolVersion()->shouldBe('1.1');
    }
}
