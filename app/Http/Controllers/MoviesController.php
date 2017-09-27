<?php

namespace App\Http\Controllers;

use Tmdb\Model\Search\SearchQuery\CompanySearchQuery;
use Tmdb\Model\Search\SearchQuery\ListSearchQuery;
use Tmdb\Model\Search\SearchQuery\MovieSearchQuery;
use Tmdb\Repository\MovieRepository;
use Tmdb\Helper\ImageHelper;
use Tmdb\Repository\SearchRepository;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        $comments = Comment::with('user')->where('movie_id', $id)->get();

        $authUserId = Auth::id();

        return view('movies.show', compact('movie', 'comments', 'authUserId'));
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

    /**
     * Найти фильмы по запросу
     *
     * @param Request $request
     * @return Response
     */
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