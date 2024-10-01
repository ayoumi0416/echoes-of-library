<?php
session_start();
require "./function.php";

$result = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'create') {
            $requiredFields = ['judul', 'pengarang', 'penerbit', 'tahun_terbit', 'isbn', 'jumlah'];
            $valid = true;

            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $valid = false;
                    $_SESSION['msg'] = "Semua data harus diisi.";
                    $_SESSION['msg_type'] = "error";
                    break;
                }
            }

            if ($valid) {
                $data = [
                    'judul' => htmlspecialchars($_POST['judul']),
                    'pengarang' => htmlspecialchars($_POST['pengarang']),
                    'penerbit' => htmlspecialchars($_POST['penerbit']),
                    'tahun_terbit' => htmlspecialchars($_POST['tahun_terbit']),
                    'isbn' => htmlspecialchars($_POST['isbn']),
                    'jumlah' => htmlspecialchars($_POST['jumlah']),
                    // 'cover' => isset($_FILES['cover']) ? $_FILES['cover'] : null,
                    'cover_link' => isset($_POST['cover_link']) ? htmlspecialchars($_POST['cover_link']) : '',
                    'category_id' => htmlspecialchars($_POST['category_id']),
                ];
                $result = create($data);
                $_SESSION['msg'] = $result;
                $_SESSION['msg_type'] = 'success';
            }

            header("Location: ../admin/");
            exit();
        } else if ($action === 'update') {
            $requiredFields = ['judul', 'pengarang', 'penerbit', 'tahun_terbit', 'isbn', 'jumlah'];
            $valid = true;

            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $valid = false;
                    $_SESSION['msg'] = "Semua data harus diisi.";
                    $_SESSION['msg_type'] = 'error';
                    break;
                }
            }

            if ($valid) {
                $data = [
                    'id' => (int)$_POST['id'],
                    'judul' => htmlspecialchars($_POST['judul']),
                    'pengarang' => htmlspecialchars($_POST['pengarang']),
                    'penerbit' => htmlspecialchars($_POST['penerbit']),
                    'tahun_terbit' => htmlspecialchars($_POST['tahun_terbit']),
                    'isbn' => htmlspecialchars($_POST['isbn']),
                    'jumlah' => htmlspecialchars($_POST['jumlah']),
                    'cover_link' => isset($_POST['cover_link']) ? htmlspecialchars($_POST['cover_link']) : '',
                    'category_id' => htmlspecialchars($_POST['category_id']),
                ];
                $result = update($data);
                $_SESSION['msg'] = $result;
                $_SESSION['msg_type'] = 'success';
            }

            header("Location: ../admin/");
            exit();
        } else if ($action === 'delete') {
            $id = $_POST['id'] ?? null;
            if ($id !== null) {
                $result = delete($id);
                $_SESSION['msg'] = $result;
                $_SESSION['msg_type'] = 'success';
            } else {
                $_SESSION['msg'] = "ID tidak ditemukan.";
                $_SESSION['msg_type'] = "error";
            }
            header("Location: ../admin/");
            exit();
        }
    }
}
?>
