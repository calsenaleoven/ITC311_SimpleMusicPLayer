<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Music Player</h1>

        <!-- Upload Music Button -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadMusicModal">
            Upload Music
        </button>

        <!-- Modal for Uploading Music -->
        <div class="modal fade" id="uploadMusicModal" tabindex="-1" role="dialog" aria-labelledby="uploadMusicModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadMusicModalLabel">Upload Music</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Music Upload Form -->
                        <form action="music/uploadMusic" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="artist">Artist:</label>
                                <input type="text" class="form-control" id="artist" name="artist" required>
                            </div>
                            <div class="form-group">
                                <label for="file_path">Select Music File:</label>
                                <input type="file" class="form-control" id="file_path" name="file_path" accept=".mp3" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Playlist Button -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createPlaylistModal">
            Create Playlist
        </button>

        <!-- Modal for Creating Playlist -->
        <div class="modal fade" id="createPlaylistModal" tabindex="-1" role="dialog" aria-labelledby="createPlaylistModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPlaylistModalLabel">Create Playlist</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Playlist Creation Form -->
                        <form action="music/createPlaylist" method="post">
                            <div class="form-group">
                                <label for="playlistName">Playlist Name:</label>
                                <input type="text" class="form-control" id="playlistName" name="playlistName" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Playlist</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Music to Playlist Button -->
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addMusicToPlaylistModal">
            Add Music to Playlist
        </button>

        <!-- Modal for Adding Music to Playlist -->
        <div class="modal fade" id="addMusicToPlaylistModal" tabindex="-1" role="dialog" aria-labelledby="addMusicToPlaylistModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMusicToPlaylistModalLabel">Add Music to Playlist</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for Adding Music to Playlist -->
                        <form action="/music/addMusicToPlaylist" method="post">
                            <div class="form-group">
                                <label for="playlistId">Select Playlist:</label>
                                <select class="form-control" id="playlistId" name="playlistId" required>
                                    <!-- Populate this with playlist options -->
                                    <?php foreach ($playlists as $playlist): ?>
                                        <option value="<?= $playlist['id'] ?>"><?= $playlist['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="musicId">Select Music:</label>
                                <select class="form-control" id="musicId" name="musicId" required>
                                    <!-- Populate this with music options -->
                                    <?php if (isset($music)): ?>
                                        <?php foreach ($music as $track): ?>
                                            <option value="<?= $track['id'] ?>"><?= $track['title'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add to Playlist</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Remove Music from Playlist Button -->
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeMusicFromPlaylistModal">
            Remove Music from Playlist
        </button>

        <!-- Modal for Removing Music from Playlist -->
        <div class="modal fade" id="removeMusicFromPlaylistModal" tabindex="-1" role="dialog" aria-labelledby="removeMusicFromPlaylistModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="removeMusicFromPlaylistModalLabel">Remove Music from Playlist</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for Removing Music from Playlist -->
                        <form action="/music/removeMusicFromPlaylist" method="post">
                            <div class="form-group">
                                <label for="playlistIdRemove">Select Playlist:</label>
                                <select class="form-control" id="playlistIdRemove" name="playlistId" required>
                                    <!-- Populate this with playlist options -->
                                    <?php foreach ($playlists as $playlist): ?>
                                        <option value="<?= $playlist['id'] ?>"><?= $playlist['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="musicIdRemove">Select Music to Remove:</label>
                                <select class="form-control" id="musicIdRemove" name="musicId" required>
                                    <!-- Populate this with music options -->
                                    <?php if (isset($music) && is_array($music)): ?>
                                        <?php foreach ($music as $track): ?>
                                            <option value="<?= $track['id'] ?>"><?= $track['title'] ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="">No music available</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger">Remove from Playlist</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Music Form -->
        <form action="/music/searchMusic" method="post">
            <div class="form-group">
                <label for="searchTerm">Search Music:</label>
                <input type="text" class="form-control" id="searchTerm" name="searchTerm" placeholder="Enter title or artist">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Display Search Results -->
        <?php if (isset($searchTerm) && isset($music)): ?>
            <h3>Search Results for: <?= $searchTerm ?></h3>
            <ul>
                <?php foreach ($music as $track): ?>
                    <li>
                        <span class="music-title"><?= $track['title'] ?></span> by <span class="music-artist"><?= $track['artist'] ?></span>
                        <button class="btn btn-primary playButton" data-src="<?= base_url($track['file_path']) ?>">Play</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Audio Player -->
        <div>
            <p>Now Playing:</p>
            <p><span id="currentTitle"></span> by <span id="currentArtist"></span></p>
            <audio id="audioPlayer" controls>
                <source src="" type="audio/mpeg" id="audioSource">
                Your browser does not support the audio element.
            </audio>
        </div>

        <script>
            // JavaScript to handle audio playback
            const audioPlayer = document.getElementById('audioPlayer');
            const audioSource = document.getElementById('audioSource');
            const playButtons = document.querySelectorAll('.playButton');
            const currentTitle = document.getElementById('currentTitle');
            const currentArtist = document.getElementById('currentArtist');

            playButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const audioSrc = button.getAttribute('data-src');
                    const title = button.parentElement.querySelector('.music-title').textContent;
                    const artist = button.parentElement.querySelector('.music-artist').textContent;

                    audioSource.setAttribute('src', audioSrc);
                    audioPlayer.load();
                    audioPlayer.play();

                    currentTitle.textContent = title;
                    currentArtist.textContent = artist;
                });
            });
        </script>
    </div>

    <!-- Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
