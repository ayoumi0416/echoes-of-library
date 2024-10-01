<?php
include 'data.php';

session_start();

function create($data)
{
    global $conn;

    $judul = htmlspecialchars($data['judul']);
    $pengarang = htmlspecialchars($data['pengarang']);
    $penerbit = htmlspecialchars($data['penerbit']);
    $tahun_terbit = htmlspecialchars($data['tahun_terbit']);
    $isbn = htmlspecialchars($data['isbn']);
    $jumlah = htmlspecialchars($data['jumlah']);
    $cover_link = htmlspecialchars($data['cover_link']);
    $category_id = htmlspecialchars($data['category_id']);

    if ($cover_link !== false) {
        $sql = "INSERT INTO book (judul, pengarang, penerbit, tahun_terbit, isbn, jumlah, cover_link) VALUES ('$judul', '$pengarang', '$penerbit', '$tahun_terbit', '$isbn', '$jumlah', '$cover_link')";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $book_id = mysqli_insert_id($conn);

            $sqlCategory = "INSERT INTO category_book (category_id, book_id) VALUES ('$category_id', $book_id)";
            $queryCategory = mysqli_query($conn, $sqlCategory);
            if ($queryCategory) {
                return "Data Berhasil Ditambah";
            }
        } else {
            return "Gagal Menambahkan Data: " . mysqli_error($conn);
        }
    } else {
        return "Gagal Mengupload Image";
    }
}

function read($table, $sql = null)
{
    global $conn;

    if ($sql === null) {
        $sql = "SELECT * FROM " . mysqli_real_escape_string($conn, $table);
    }

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        return "Query Error: " . mysqli_error($conn);
    }

    return mysqli_fetch_all($query, MYSQLI_ASSOC);
}

function update($data)
{
    global $conn;

    $id = mysqli_escape_string($conn, $data['id']);
    $judul = mysqli_escape_string($conn, $data['judul']);
    $pengarang = mysqli_escape_string($conn, $data['pengarang']);
    $penerbit = mysqli_escape_string($conn, $data['penerbit']);
    $tahun_terbit = mysqli_escape_string($conn, $data['tahun_terbit']);
    $isbn = mysqli_escape_string($conn, $data['isbn']);
    $jumlah = mysqli_escape_string($conn, $data['jumlah']);
    $category_id = mysqli_escape_string($conn, $data['category_id']);

    $sql = "UPDATE book SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun_terbit='$tahun_terbit', isbn='$isbn', jumlah='$jumlah' WHERE id='$id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $sqlDeleteCategories = "DELETE FROM category_book WHERE book_id='$id'";
        $queryDeleteCategories = mysqli_query($conn, $sqlDeleteCategories);

        if ($queryDeleteCategories) {
            $sqlInsertCategory = "INSERT INTO category_book (category_id, book_id) VALUES ('$category_id', '$id')";
            $queryInsertCategory = mysqli_query($conn, $sqlInsertCategory);

            if ($queryInsertCategory) {
                return 'Data Berhasil Diupdate';
            } else {
                return 'Gagal menambahkan kategori baru: ' . mysqli_error($conn);
            }
        } else {
            return 'Gagal menghapus kategori lama: ' . mysqli_error($conn);
        }
    } else {
        return 'Gagal mengupdate data: ' . mysqli_error($conn);
    }
}


function delete($id)
{
    global $conn;
    $id = mysqli_escape_string($conn, $id);
    $sql = "DELETE FROM book WHERE id='$id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        return "Data berhasil dihapus.";
    } else {
        return "Gagal menghapus data: " . mysqli_error($conn);
    }
}

// function uploadImage($file)
// {
//     if ($file['error'] === UPLOAD_ERR_OK) {
//         $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
//         if (in_array($file['type'], $allowedTypes)) {
//             $uploadDir = __DIR__ . '/../assets/img/';
//             $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

//             $fileName = uniqid(rand(), true) . '.' . $fileExtension;
//             $uploadFile = $uploadDir . $fileName;

//             // Move the uploaded file
//             if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
//                 return $fileName;
//             } else {
//                 return false;
//             }
//         } else {
//             return false;
//         }
//     } else {
//         return false;
//     }
// }
