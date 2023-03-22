<?php

namespace App\Http\Controllers\Flashcards;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use App\Queries\FetchFlashcards;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\CollectionResponse;
use App\Http\Resources\FlashcardCollection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class IndexController
{
    public function __construct(
        private readonly FetchFlashcards $query
    ) {}

    public function __invoke(Request $request)
    {
        if ($request->missing('category') || !$request->filled('category')) {
            $exception = new BadRequestException('Please check your request parameters.');
            return new ErrorResponse(401, $exception);
        }

        $filteredData = $this->query->handle(
            query: Flashcard::query(),
            category: request('category')
        )->get();

        if ($filteredData->isEmpty())
        {
            return new EmptyResponse();
        }

        return new CollectionResponse(
            data: new FlashcardCollection($filteredData)
        );
    }
}