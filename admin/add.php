<?php
require_once(__DIR__ . "/../apps/function.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>

    <!-- Navbar -->
    <header>
        <div class="max-w-[1640px] mx-auto flex justify-between items-center p-4" style="background-color: #CBE2B5;">
            <div class="flex items-center">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl px-2">
                    Mi<span class="font-bold">Youll</span>
                </h1>
                <div class="hidden lg:flex items-center bg-gray-200 rounded-full p-1 text-[14px]">
                    <a href="../" class="p-2">Home</a>
                    <a href="../admin/" class="bg-black text-white rounded-full p-2">Admin</a>
                </div>
            </div>

            <div class="bg-gray-200 rounded-full flex items-center px-2 w-[200px] sm:w-[400px] lg:w-[500px]">
                <i class="fas fa-search"></i>
                <input class="bg-transparent p-2 w-full focus:outline-none" type="text" placeholder="Search foods" />
            </div>

            <button class="bg-black text-white hidden md:flex items-center py-2 rounded-full" data-bs-toggle="modal" data-bs-target="#infoModal">
                <i class="fa-solid fa-info"></i>
            </button>
        </div>
    </header>

    <!-- add data -->
    <div class="section my-4">
        <div class="container">
            <h2 align="center" class="text-4xl tambah"><b>Tambah Data</b></h2>
        </div>
    </div>
    <div class="form-section">
        <div class="container pb-5">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <form action="./../apps/proccess.php" class="custom-bg p-4" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="action" value="create">
                        <div class="mb-4">
                            <label for="nama">Judul</label>
                            <input type="text" class="form-control" name="judul" id="judul">
                        </div>
                        <div class="mb-4">
                            <label for="brand">Pengarang</label>
                            <input type="text" class="form-control" name="pengarang" id="pengarang">
                        </div>
                        <div class="mb-4">
                            <label for="penerbit">Penerbit</label>
                            <input type="text" class="form-control" name="penerbit" id="penerbit">
                        </div>
                        <div class="mb-4">
                            <label for="tahun_penerbit">Tahun Penerbit</label>
                            <input type="text" class="form-control" name="tahun_terbit" id="tahun_terbit">
                        </div>
                        <div class="mb-4">
                            <label for="isbn">ISBN</label>
                            <input type="text" class="form-control" name="isbn" id="isbn">
                        </div>
                        <div class="mb-4">
                            <label for="jumlah">Jumlah</label>
                            <input type="text" class="form-control" name="jumlah" id="jumlah">
                        </div>
                        <div class="mb-4">
                            <label for="category">Category</label>
                            <select class="form-control" name="category_id" id="category">
                                <?php
                                $sql = "SELECT id, category_name FROM category";
                                $query = mysqli_query($conn, $sql);
                                if(mysqli_num_rows($query) > 0) {
                                    while($row = mysqli_fetch_assoc($query)) {
                                ?>
                                <option value="<?= $row['id'] ?>"><?= $row['category_name'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="coverLink">Cover URL</label>
                            <input type="url" class="form-control" name="cover_link" id="coverLink">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="infoModalLabel">About Me</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>This website was created by Tsabitha Ayoumi class XI RPL.</p>
                  <p> I designed this Web Library task with an idea that I had thought of spontaneously.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.muzhaffar.com/assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>