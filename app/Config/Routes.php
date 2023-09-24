<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'MusicController::index');
$routes->post('/music/uploadMusic', 'MusicController::index');
$routes->post('/music/createPlaylist', 'MusicController::index');
$routes->post('/music/addMusicToPlaylist', 'MusicController::index');
$routes->post('/music/removeMusicFromPlaylist', 'MusicController::index');
$routes->post('/music/searchMusic', 'MusicController::index');
