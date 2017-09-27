<?php

namespace App\Http\Controllers;

use Tmdb\Model\Search\SearchQuery\CompanySearchQuery;
use Tmdb\Model\Search\SearchQuery\ListSearchQuery;
use Tmdb\Model\Search\SearchQuery\MovieSearchQuery;
use Tmdb\Repository\MovieRepository;
use Tmdb\Helper\ImageHelper;
use Tmdb\Repository\SearchRepository;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoviesController
{
    private $movies;
    private $searches;
    private $helper;

    public function __construct(MovieRepository $movies, SearchRepository $searches, ImageHelper $helper)
    {
        $this->movies = $movies;
        $this->searches = $searches;
        $this->helper = $helper;
    }

    /**
     * Отобразить наиболее популярные фильмы
     *
     * @return Response
     */
    public function index()
    {
        $popular = $this->movies->getPopular();

        foreach ($popular as $movie)
        {
            $movies['id'][] = $movie->getId();
            $movies['title'][] = $movie->getTitle();

            $image = $movie->getPosterImage();
            $movies['image'][] = $this->helper->getHtml($image, 'w154', 200, 300);
        }

        return view('movies.index', ['movies' => $movies]);
    }

    /**
     * Отобразить информацию о фильме
     *
     * @param $id
     * @return mixed
     */
    function show($id)
    {
        $movie = $this->movies->load($id);
        $comments = Comments::all()->where('theme_id', $id);

        $authUserId = Auth::id();

        return view('movies.show', ['movie' => $movie, 'comments' => $comments, 'authUserId' => $authUserId]);
    }

    /**
     * Добавить в тему комментарий
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeComment(Request $request)
    {
        DB::table('comments')->insert([
            'user_id' => $request->user_id,
            'theme_id' => $request->theme_id,
            'body' => $request->body,
        ]);

        return redirect()->back();
    }

    /**
     * Отобразить представление для поиска
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        return view('movies.search');
    }

    public function searchFilms(Request $request)
    {
        $query = urlencode($request->search);
        $params = new MovieSearchQuery();
        $params->page(1);
        $searches = $this->searches->searchMovie($query, $params);

        if (count($searches) > 0) {
            foreach ($searches as $movie)
            {
                $movies['id'][] = $movie->getId();
                $movies['title'][] = $movie->getTitle();

                $image = $movie->getPosterImage();
                $movies['image'][] = $this->helper->getHtml($image, 'w154', 200, 300);
            }

            return view('movies.index', ['movies' => $movies]);
        } else {
            return redirect()->back();
        }
    }
}