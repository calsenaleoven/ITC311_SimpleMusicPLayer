<?php

namespace App\Models;

use CodeIgniter\Model;

class PlaylistMusicModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'playlist_music';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['playlist_id', 'music_id'];

    public function getMusicForPlaylist($playlistId)
    {
        // Load the MusicModel
        $musicModel = new MusicModel();

        // Fetch music associated with the playlist
        $query = $this->select('music_id')
            ->where('playlist_id', $playlistId)
            ->findAll();

        $musicIds = array_column($query, 'music_id');

        // Fetch music details for the retrieved music IDs
        $musicDetails = [];
        foreach ($musicIds as $musicId) {
            $music = $musicModel->find($musicId);
            if ($music) {
                $musicDetails[] = $music;
            }
        }

        return $musicDetails;
    }

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
