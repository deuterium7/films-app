<?php

namespace App\Http\Controllers;

use Tmdb\Repository\MovieRepository;
use Tmdb\Helper\ImageHelper;

class MoviesController
{
    private $movies;
    private $helper;

    public function __construct(MovieRepository $movies, ImageHelper $helper)
    {
        $this->movies = $movies;
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
        return view('movies.show', ['movie' => $movie]);
    }
}