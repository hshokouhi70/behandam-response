<?php

namespace Behandam\Response;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ResponseTransformer implements Responsable
{
    private string $config = 'behandam_response_transformer';

    /**
     * @var Request
     */
    private $request;

    /**
     * @param  Response|JsonResponse  $response
     */
    public function __construct(private $response) {}

    public static function transform($response): self
    {
        return new self($response);
    }

    public function toResponse($request)
    {
        $this->request = $request;

        return $this->shouldTransform()
            ? $this->newResponse()
            : $this->response;
    }

    public function newResponse(): BehandamResponse
    {
        $data = $this->response->getData();

        return BehandamResponse::from($data);
    }

    private function matchesRequestUriPattern(): bool
    {
        return $this->request->is(...$this->getConfig('uri.patterns'));
    }

    private function shouldTransform(): bool
    {
        return $this->shouldTransformResponse()
            && $this->matchesRequestUriPattern();
    }

    private function shouldTransformResponse(): bool
    {
        return $this->response instanceof JsonResponse
            && $this->response->isSuccessful();
    }

    private function getConfig($option = null)
    {
        return Arr::get(config($this->config), $option);
    }
}
