<?php
function createFolder()
{
    $folderName = trim($_POST['folder_name_create']);
    $directory = 'uploads/' . $folderName;

    if (!empty($folderName)) {
        if (!file_exists($directory)) {
            if (mkdir($directory, 0777, true)) {
                $_SESSION['message'] = ['text' => "Folder '$folderName' created successfully!", 'type' => 'success'];
            } else {
                $_SESSION['message'] = ['text' => "Cannot create folder '$folderName'.", 'type' => 'error'];
            }
        } else {
            $_SESSION['message'] = ['text' => "Folder '$folderName' already exists.", 'type' => 'warning'];
        }
    } else {
        $_SESSION['message'] = ['text' => "Please input a folder name.", 'type' => 'error'];
    }
}

function deleteFolder()
{
    $folderName = trim($_POST['folder_name_delete']) ?: $_POST['existing_folder'];
    $directory = 'uploads/' . $folderName;

    if (!empty($folderName)) {
        if (file_exists($directory)) {
            if (rmdir($directory)) {
                $_SESSION['message'] = ['text' => "Folder '$folderName' deleted successfully!", 'type' => 'success'];
            } else {
                $_SESSION['message'] = ['text' => "Cannot delete folder '$folderName'.", 'type' => 'error'];
            }
        } else {
            $_SESSION['message'] = ['text' => "Folder '$folderName' does not exist.", 'type' => 'warning'];
        }
    } else {
        $_SESSION['message'] = ['text' => "Please select a folder to delete.", 'type' => 'error'];
    }
}

function uploadImage()
{
    $folderName = trim($_POST['upload_folder']) ?: $_POST['existing_upload_folder'];
    $directory = 'uploads/' . $folderName;

    if (!empty($folderName) && file_exists($directory)) {
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileName = basename($_FILES['file']['name']);
            $targetFilePath = $directory . '/' . $fileName;

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/avif', 'image/gif', 'video/mp4', 'video/avi', 'video/mpeg'];
            $fileMimeType = mime_content_type($fileTmpPath);

            if (in_array($fileMimeType, $allowedMimeTypes)) {
                if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                    $_SESSION['message'] = ['text' => "File '$fileName' uploaded successfully to '$folderName'!", 'type' => 'success'];
                } else {
                    $_SESSION['message'] = ['text' => "Cannot upload file '$fileName'.", 'type' => 'error'];
                }
            } else {
                $_SESSION['message'] = ['text' => "Invalid file type. Only images and videos are allowed.", 'type' => 'error'];
            }
        } else {
            $_SESSION['message'] = ['text' => "Please select a file to upload.", 'type' => 'error'];
        }
    } else {
        $_SESSION['message'] = ['text' => "Please select a valid folder to upload.", 'type' => 'error'];
    }
}

function getExistingFolders() {
    $dirs = array_filter(glob('uploads/*'), 'is_dir');
    return $dirs;
}
?>
