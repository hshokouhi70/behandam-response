<?php

namespace Behandam\Response\Traits;

use Behandam\Response\Resources\BehandamAnonymousResourceCollection;

trait BehandamAnonymousResourceCollectionTrait
{
    protected static function newCollection($resource): BehandamAnonymousResourceCollection
    {
        return new BehandamAnonymousResourceCollection($resource, static::class);
    }
}
