<?php
/**
 * Created by PhpStorm.
 * User: АЛЕКС
 * Date: 26.09.2017
 * Time: 20:23
 */

namespace App\Http\Controllers;

use Tmdb\Laravel\Facades\Tmdb;
use Tmdb\Repository\MovieRepository;
use Tmdb\Helper\ImageHelper;

class WelcomeController
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
            $movies['title'][] = $movie->getTitle();

            $image = $movie->getPosterImage();
            $movies['image'][] = $this->helper->getHtml($image, 'w154', 200, 300);
        }

        return view('welcome', ['movies' => $movies]);
    }

    /**
     * Отобразить информацию о фильме
     *
     * @param $id
     * @return mixed
     */
    function show($id)
    {
        return Tmdb::getMoviesApi()->getMovie($id);
    }
}