<?php

namespace App\Http\Responses;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Support\Arr;

class BehandamPaginatedResourceResponse extends PaginatedResourceResponse
{
    public function toResponse($request)
    {
        $resource = $this->resource->resource->toArray();

        $response = response()->json(
            $this->wrap(
                array_merge($resource['data'], $this->paginationInformation($request)),
            ),
            $this->calculateStatus(),
            [],
            $this->resource->jsonOptions(),
        );

        $callback = function ($response) use ($request) {
            $response->original = $this->resource->resource->map(function ($item) {
                return is_array($item) ? Arr::get($item, 'resource') : $item->resource;
            });

            $this->resource->withResponse($request, $response);
        };

        return tap($response, $callback);
    }

    protected function paginationInformation($request)
    {
        $paginated = $this->resource->resource->toArray();

        $default = [
            'meta' => $this->meta($paginated),
        ];

        if (
            method_exists($this->resource, 'paginationInformation') ||
            $this->resource->hasMacro('paginationInformation')
        ) {
            return $this->resource->paginationInformation($request, $paginated, $default);
        }

        return $default;
    }

    protected function meta($paginated): array
    {
        return Arr::except($paginated, [
            'data',
            'links',
            'path',
            'first_page_url',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
        ]);
    }
}
