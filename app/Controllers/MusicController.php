<?php

namespace App\Controllers;

use App\Models\MusicModel;
use App\Models\PlaylistModel;
use App\Models\PlaylistMusicModel;

class MusicController extends BaseController
{
    protected $musicModel;
    protected $playlistModel;
    protected $playlistMusicModel;

    public function index()
    {
        // Retrieve playlist data from the database (replace this with your actual playlist retrieval logic)
        $playlistData = $this->playlistModel->findAll();

        // Load the view and pass the playlist data
        return view('music', ['playlists' => $playlistData]);
    }

    public function __construct()
    {
        // Load necessary models
        $this->musicModel = new MusicModel();
        $this->playlistModel = new PlaylistModel();
        $this->playlistMusicModel = new PlaylistMusicModel();
    }

    // Handle music upload
    public function uploadMusic()
    {
        $musicFile = $this->request->getFile('file_path');

        if ($musicFile->isValid() && !$musicFile->hasMoved()) {
            $newName = $musicFile->getRandomName();
            $musicFile->move(ROOTPATH . 'public/uploads', $newName);

            // Store the file path in the database
            $data = [
                'title' => $this->request->getPost('title'),
                'artist' => $this->request->getPost('artist'),
                'file_path' => 'uploads/' . $newName
            ];

            $this->musicModel->insert($data);

            return redirect()->to('music')->with('success', 'Music uploaded successfully.');
        } else {
            return redirect()->to('music')->with('error', 'Invalid music file.');
        }
    }


    // Handle playlist creation
    public function createPlaylist()
    {
        $playlistName = $this->request->getPost('playlistName');

        if (!empty($playlistName)) {
            $data = [
                'name' => $playlistName
            ];

            $this->playlistModel->insert($data);

            return redirect()->to('music')->with('success', 'Playlist created successfully.');
        } else {
            return redirect()->to('music')->with('error', 'Playlist name cannot be empty.');
        }
    }


    // Handle adding music to a playlist
    public function addMusicToPlaylist()
    {
        $playlistId = $this->request->getPost('playlistId');
        $musicId = $this->request->getPost('musicId');

        if (!empty($playlistId) && !empty($musicId)) {
            $data = [
                'playlist_id' => $playlistId,
                'music_id' => $musicId
            ];

            // Insert the association in the playlist_music table
            $this->playlistMusicModel->insert($data);

            return redirect()->to('/music')->with('success', 'Music added to the playlist successfully.');
        } else {
            return redirect()->to('/music')->with('error', 'Please select a playlist and a music.');
        }
    }


    // Handle removing music from a playlist
    public function removeMusicFromPlaylist()
    {
        $playlistId = $this->request->getPost('playlistId');
        $musicId = $this->request->getPost('musicId');

        if (!empty($playlistId) && !empty($musicId)) {
            // Delete the association from the playlist_music table
            $this->playlistMusicModel->where('playlist_id', $playlistId)
                ->where('music_id', $musicId)
                ->delete();

            return redirect()->to('/music')->with('success', 'Music removed from the playlist successfully.');
        } else {
            return redirect()->to('/music')->with('error', 'Please select a playlist and a music.');
        }
    }


    // Handle music search
    public function searchMusic()
    {
        $searchTerm = $this->request->getPost('searchTerm');

        if (!empty($searchTerm)) {
            // Search for music based on title or artist
            $musicData = $this->musicModel
                ->like('title', $searchTerm)
                ->orLike('artist', $searchTerm)
                ->findAll();

            // Load the view and pass the search results
            return view('music', ['music' => $musicData, 'searchTerm' => $searchTerm]);
        } else {
            return redirect()->to('/music')->with('error', 'Please enter a search term.');
        }
    }

}
