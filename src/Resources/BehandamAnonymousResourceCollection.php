<?php

namespace Behandam\Response\Resources;

use App\Http\Responses\BehandamPaginatedResourceResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BehandamAnonymousResourceCollection extends AnonymousResourceCollection
{
    protected function preparePaginatedResponse($request)
    {
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (!is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return (new BehandamPaginatedResourceResponse($this))->toResponse($request);
    }
}
