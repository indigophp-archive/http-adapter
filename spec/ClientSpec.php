<?php

namespace spec\Indigo\Http;

use Indigo\Http\Adapter;
use Psr\Http\Message\OutgoingRequestInterface as Request;
use Psr\Http\Message\IncomingResponseInterface as Response;
use Psr\Http\Message\StreamableInterface as Stream;
use League\Url\Url;
use PhpSpec\ObjectBehavior;

class ClientSpec extends ObjectBehavior
{
    function let(Adapter $adapter, Request $request, Response $response, Stream $stream)
    {
        $adapter->send($request)->willReturn($response);
        $response->getBody()->willReturn($stream);
        $stream->getContents()->willReturn('content');

        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Indigo\Http\Client');
    }

    function it_should_allow_to_have_base_url()
    {
        $this->getBaseUrl()->shouldHaveType('League\Url\UrlImmutable');
    }

    function it_should_allow_to_set_string_base_url()
    {
        $this->setBaseUrl('http://google.hu');

        $baseUrl = $this->getBaseUrl();
        $baseUrl->shouldHaveType('League\Url\UrlImmutable');
        $baseUrl->__toString()->shouldReturn('http://google.hu/');
    }

    function it_should_allow_to_set_a_url_base_url()
    {
        $url = Url::createFromUrl('http://google.hu');

        $this->setBaseUrl($url);

        $baseUrl = $this->getBaseUrl();
        $baseUrl->shouldHaveType('League\Url\UrlImmutable');
        $baseUrl->__toString()->shouldReturn('http://google.hu/');
    }

    function it_should_allow_to_send_a_request_with_a_relative_url(Adapter $adapter, Response $response)
    {
        $request = $this->createRequest('GET', 'relative/url/', []);
        $adapter->send($request)->willReturn($response);

        $this->get('relative/url/')->shouldReturn('content');
    }

    function it_should_allow_to_send_a_request(Request $request)
    {
        $this->send($request)->shouldReturn('content');
    }

    function it_should_allow_to_create_a_request()
    {
        $request = $this->createRequest('GET', 'http://google.hu', [
            'protocol_version' => '1.0',
            'body' => 'content',
            'headers' => [
                'X-Test' => '1'
            ],
        ]);

        $request->getMethod()->shouldReturn('GET');
        $request->getUrl()->shouldReturn('http://google.hu/');
        $request->getProtocolVersion()->shouldReturn('1.0');
        $request->getBody()->shouldImplement('Psr\Http\Message\StreamableInterface');
        $request->getHeader('X-Test')->shouldReturn('1');
    }

    function it_should_allow_to_send_get_request(Adapter $adapter, Response $response)
    {
        $request = $this->createRequest('GET', null, []);
        $adapter->send($request)->willReturn($response);

        $this->get()->shouldReturn('content');
    }

    function it_should_allow_to_send_post_request(Adapter $adapter, Response $response)
    {
        $request = $this->createRequest('POST', null, []);
        $adapter->send($request)->willReturn($response);

        $this->post()->shouldReturn('content');
    }

    function it_should_allow_to_send_put_request(Adapter $adapter, Response $response)
    {
        $request = $this->createRequest('PUT', null, []);
        $adapter->send($request)->willReturn($response);

        $this->put()->shouldReturn('content');
    }

    function it_should_allow_to_send_head_request(Adapter $adapter, Response $response)
    {
        $request = $this->createRequest('HEAD', null, []);
        $adapter->send($request)->willReturn($response);

        $this->head()->shouldReturn('content');
    }

    function it_should_allow_to_send_delete_request(Adapter $adapter, Response $response)
    {
        $request = $this->createRequest('DELETE', null, []);
        $adapter->send($request)->willReturn($response);

        $this->delete()->shouldReturn('content');
    }

    function it_should_allow_to_send_patch_request(Adapter $adapter, Response $response)
    {
        $request = $this->createRequest('PATCH', null, []);
        $adapter->send($request)->willReturn($response);

        $this->patch()->shouldReturn('content');
    }

    function it_should_allow_to_send_options_request(Adapter $adapter, Response $response)
    {
        $request = $this->createRequest('OPTIONS', null, []);
        $adapter->send($request)->willReturn($response);

        $this->options()->shouldReturn('content');
    }
}
