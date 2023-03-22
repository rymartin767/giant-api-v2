<?php

namespace App\Http\Controllers\Events;

use App\Models\Event;
use App\Queries\FetchEvents;
use App\Http\Responses\EmptyResponse;
use App\Http\Resources\EventCollection;
use App\Http\Responses\CollectionResponse;

class IndexController
{
    public function __construct(
        private readonly FetchEvents $query
    ) {}

    public function __invoke()
    { 
        $events = $this->query->handle(
            query: Event::query()
        )->get();

        if ($events->isEmpty())
        {
            return new EmptyResponse();
        }

        return new CollectionResponse(
            data: new EventCollection($events),
        );
    }
}