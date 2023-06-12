<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\Redirector;
use App\Http\Requests\ArticleRequest;

class Articles extends Component
{
    // FORMDATA
    public $category;
    public $date;
    public $title;
    public $author;
    public $story;
    public $web_url;
    public $slug = null;

    protected function rules(): array
    {
        return (new ArticleRequest())->rules();
    }

    public function render()
    {
        return view('livewire.articles', [
            'articles' => Article::all()
        ]);
    }

    public function storeArticle() : Redirector
    {
        $validatedData = $this->validate();

        Article::create($validatedData);

        return to_route('articles')->with('flash.banner', 'The article has been saved!');
    }
}
