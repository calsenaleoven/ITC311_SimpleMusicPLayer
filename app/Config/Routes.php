<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'MusicController::index');
$routes->post('/music/uploadMusic', 'MusicController::uploadMusic');
$routes->post('/music/createPlaylist', 'MusicController::createPlaylist');
$routes->post('/music/addMusicToPlaylist', 'MusicController::addMusicToPlaylist');
$routes->get('/music/deleteMusicFromPlaylist', 'MusicController::deleteMusicFromPlaylist');
$routes->post('/music/searchMusic', 'MusicController::searchMusic');
$routes->get('api/getMusicOptions', 'MusicController::getMusicOptions');
