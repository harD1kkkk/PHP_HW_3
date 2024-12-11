<?php
session_start();
require_once 'function/functions.php';

$folders = getExistingFolders();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create_folder':
                createFolder();
                break;
            case 'delete_folder':
                deleteFolder();
                break;
            case 'upload_image':
                uploadImage();
                break;
        }
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
}

if (isset($_SESSION['message']) && is_array($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Upload Files</title>
</head>
<body>
    <div class="container">
        <?php if (isset($message)): ?>
            <p class='message <?= $message['type'] ?>'><?= $message['text'] ?></p>
        <?php endif; ?>
        <h2>Create Folder</h2>
        <form method="post">
            <div class="form-group">
                <label for="folder_name_create">Folder Name</label>
                <input type="text" id="folder_name_create" name="folder_name_create" required>
            </div>
            <input type="hidden" name="action" value="create_folder">
            <button type="submit">Create Folder</button>
        </form>
    </div>

    <div class="container">
        <h2>Delete Folder</h2>
        <form method="post">
            <div class="form-group delete-group">
                <input type="text" id="folder_name_delete" name="folder_name_delete">
                <span class="or-label">or</span>
                <select id="existing_folder" name="existing_folder">
                    <option value="">Select a folder</option>
                    <?php foreach ($folders as $folder): ?>
                        <option value="<?= basename($folder) ?>"><?= basename($folder) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="action" value="delete_folder">
            <button type="submit">Delete Folder</button>
        </form>
    </div>

    <div class="container">
        <h2>Upload Images</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group upload-group">
                <div style="flex: 1;">
                    <label for="upload_folder">Folder Name</label>
                    <input type="text" id="upload_folder" name="upload_folder">
                </div>
                <span style="display: flex !important; align-items: center !important; justify-content: center !important; width: 100px; height: 50px;">or</span>


                <div style="flex: 1;">
                    <label for="existing_upload_folder">Select Folder</label>
                    <select id="existing_upload_folder" name="existing_upload_folder">
                        <option value="">Select a folder</option>
                        <?php foreach ($folders as $folder): ?>
                            <option value="<?= basename($folder) ?>"><?= basename($folder) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="file">Select Images</label>
                <input type="file" id="file" name="file" multiple required>
            </div>
            <input type="hidden" name="action" value="upload_image">
            <button type="submit">Upload Images</button>
        </form>
    </div>
</body>
</html>
