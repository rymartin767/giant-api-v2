<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\Http\Request;
use App\Queries\FetchFlashcards;
use App\Http\Responses\EmptyResponse;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\CollectionResponse;
use App\Http\Resources\FlashcardCollection;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class FlashcardController
{
    public function __construct(
        private readonly FetchFlashcards $query
    ) {}

    public function __invoke(Request $request)
    {
        // !No Models Exist = Empty Response
        if (!Flashcard::exists()) {
            return new EmptyResponse();
        }

        // !Category Parameter Present
        if ($request->has('category')) {

            if (!$request->filled('category')) {
                $exception = new BadRequestException('Please check your request parameters.');
                return new ErrorResponse(401, $exception);
            }

            $flashcards = $this->query->handle(
                query: Flashcard::query(),
                category: request('category')
            )->get();
    
            if ($flashcards->isEmpty()) {
                return new EmptyResponse();
            }
    
            return new CollectionResponse(
                data: new FlashcardCollection($flashcards)
            );
        }

        // !Category Parameter Missing

        // Bad Parameter
        if ($request->collect()->isNotEmpty()) {
            $exception = new BadRequestException('Please check your request parameters.');
            return new ErrorResponse(401, $exception);
        }

        // Collection Handling
        $flashcards = $this->query->handle(
            query: Flashcard::query(),
        )->get();

        // Collection Handling: Empty Response
        if ($flashcards->isEmpty())
        {
            return new EmptyResponse();
        }

        return new CollectionResponse(
            data: new FlashcardCollection($flashcards)
        );
    }
}