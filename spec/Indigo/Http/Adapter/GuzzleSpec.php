<?php

namespace spec\Indigo\Http\Adapter;

use Psr\Http\Message\OutgoingRequestInterface as Request;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\RequestInterface as GuzzleRequest;
use GuzzleHttp\Message\ResponseInterface as GuzzleResponse;
use PhpSpec\ObjectBehavior;

class GuzzleSpec extends ObjectBehavior
{
    protected $client;

    function let(ClientInterface $client)
    {
        $this->beConstructedWith($client);
        $this->client = $client;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Adapter\Guzzle');
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
