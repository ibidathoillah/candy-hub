<?php

namespace GetCandy\Hub\Http\Controllers\OrderProcessing;

use GetCandy\Hub\Http\Controllers\Controller;

class ArticleController extends Controller
{

    public function getArticles()
    {
        return view('hub::order-processing.articles.index');
    }

    public function getArticle($id)
    {
        return view('hub::order-processing.articles.edit', [
            'id' => $id,
        ]);
    }


}
