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
        $data['musiko'] = $this->musicModel->findAll();
        // Retrieve all playlist data from the database
        $playlistData = $this->playlistModel->findAll();

        // Initialize an array to store the structured audio data
        $audios = [];

        // Loop through each playlist
        foreach ($playlistData as $playlist) {
            $playlistId = $playlist['id'];

            // Retrieve music data for the current playlist
            $musicData = $this->playlistMusicModel->where('playlist_id', $playlistId)->findAll();

            foreach ($musicData as $music) {
            $musicId = $this->playlistMusicModel->where('music_id', $music['music_id'])->first();
            $musicDetails = $this->musicModel->find($musicId['music_id']);

                $audios[] = [
                    'music' => $musicDetails,
                    'playlist' => $playlist,
                ];
            }
            
        }

            // Load the view and pass the playlist and audio data
            return view('music', ['playlists' => $playlistData, 'audios' => $audios, 'musiko' => $data]);
    }


    // Helper function to check if an audio is in a playlist
    private function isAudioInPlaylist($audioId, $playlistId)
    {
        $playlistMusicModel = new PlaylistMusicModel();

        // Check if there's a record in the playlist_music table with the given audio and playlist IDs
        $record = $playlistMusicModel->where('music_id', $audioId)
                                     ->where('playlist_id', $playlistId)
                                     ->first();

        return $record !== null;
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

        $musicFile = $this->request->getFile('music_path');
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

              return redirect()->to('/')->with('success', 'Music uploaded successfully.');
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

            return redirect()->to('/')->with('success', 'Playlist created successfully.');
        } else {
            return redirect()->to('/')->with('error', 'Playlist name cannot be empty.');
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

            return redirect()->to('/')->with('success', 'Music added to the playlist successfully.');
        } else {
            return redirect()->to('/')->with('error', 'Please select a playlist and a music.');
        }
    }


    // Handle removing music from a playlist
    public function deleteMusicFromPlaylist()
    {
        $musicId = $this->request->getGet('musicId');
        $playlistId = $this->request->getGet('playlistId');

        if (!empty($musicId) && !empty($playlistId)) {
            // Delete the association in the playlist_music table
            $this->playlistMusicModel->where('music_id', $musicId)->where('playlist_id', $playlistId)->delete();

            return redirect()->to('/')->with('message', 'Music removed from playlist successfully.');
        } else {
            return redirect()->to('/')->with('error', 'Invalid music or playlist ID.');
        }
    }   


    // Handle music search
    public function searchMusic()
    {
        // Retrieve all playlist data from the database
        $playlistData = $this->playlistModel->findAll();

        // Initialize an array to store the structured audio data
        $audios = [];

        // Loop through each playlist
        foreach ($playlistData as $playlist) {
            $playlistId = $playlist['id'];

            // Retrieve music data for the current playlist
            $musicData = $this->playlistMusicModel->where('playlist_id', $playlistId)->findAll();

            foreach ($musicData as $music) {
            $musicId = $this->playlistMusicModel->where('music_id', $music['music_id'])->first();
            $musicDetails = $this->musicModel->find($musicId['music_id']);

                $audios[] = [
                    'music' => $musicDetails,
                    'playlist' => $playlist,
                ];
            }
            
        }
        
        $searchTerm = $this->request->getPost('searchTerm');

        if (!empty($searchTerm)) {
            // Search for music based on title or artist
            $musicData = $this->musicModel
                ->like('title', $searchTerm)
                ->orLike('artist', $searchTerm)
                ->findAll();

            // Load the view and pass the search results
            return view('music', ['music' => $musicData, 'searchTerm' => $searchTerm, 'playlists' => $playlistData, 'audios' => $audios]);
        } else {
            return redirect()->to('/')->with('error', 'Please enter a search term.');
        }
    }

    public function getMusicForPlaylist()
    {
        $playlistId = $this->request->getGet('playlistId');  // Get the playlist ID from the query parameter

        // Fetch music options for the specified playlist from your database
        // Assuming you have a method to fetch music for the playlist ID
        $musicForPlaylist = $this->playlistMusicModel->getMusicForPlaylist($playlistId);

        // Return the music options as JSON
        return $this->response->setJSON($musicForPlaylist);
    }


}
