<?php

namespace Behandam\Response\Resources;

use App\Traits\ResponsibleResourceTrait;
use Behandam\Response\Traits\BehandamAnonymousResourceCollectionTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    use ResponsibleResourceTrait;
    use BehandamAnonymousResourceCollectionTrait;
}
