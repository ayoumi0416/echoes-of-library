<?php
require_once(__DIR__ . "/../apps/function.php");

$table = "book";
$dataBooks = read($table);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <header>
        <div class="max-w-[1640px] mx-auto flex justify-between items-center p-4" style="background-color: #CBE2B5;">
            <div class="flex items-center">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl px-2">
                    Mi<span class="font-bold">Youll</span>
                </h1>
                <div class="hidden lg:flex items-center bg-gray-200 rounded-full p-1 text-[14px]">
                    <a href="../" class="p-2">Home</a>
                    <a href="./admin/" class="bg-black text-white rounded-full p-2">Admin</a>
                </div>
            </div>

            <div class="bg-gray-200 rounded-full flex items-center px-2 w-[200px] sm:w-[400px] lg:w-[500px]">
                <i class="fas fa-search"></i>
                <input class="bg-transparent p-2 w-full focus:outline-none" type="text" placeholder="Search foods" />
            </div>

            <button type="button" class="bg-black text-white hidden md:flex items-center py-2 rounded-full"
                data-bs-toggle="modal" data-bs-target="#infoModal">
                <i class="fa-solid fa-info"></i>
            </button>
        </div>

        <div id="overlay" class="bg-black/80 w-full h-screen fixed z-10 top-0 left-0 hidden"></div>
        <div class="heading-text my-5">
            <h3 class="text-4xl font-bold mb-2">Add Book</h3>
        </div>
    </header>

    <section id="addbook" class="my-5">
        <div class="container">
            <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] != ""): ?>
                <div class="alert <?= ($_SESSION['msg_type'] === 'success') ? 'alert-success' : 'alert-danger' ?>" id="alert-message" role="alert">
                    <?= htmlspecialchars($_SESSION['msg'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <?php
                unset($_SESSION['msg']);
            endif;
            ?>
            <a href="add.php" class="btn btn-primary mb-4"><i class="fa-solid fa-plus"></i> Add Here</a>
            <table class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun Penerbit</th>
                        <th>ISBN</th>
                        <th>Jumlah</th>
                        <th>Cover</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dataBooks as $index => $row):
                        $no = $index + 1;
                        ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $row['judul'] ?></td>
                            <td><?= $row['pengarang'] ?></td>
                            <td><?= $row['penerbit'] ?></td>
                            <td><?= $row['tahun_terbit'] ?></td>
                            <td><?= $row['isbn'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <!-- <td><img src="../assets/img/<?= $row['cover'] ?>" alt="<?= $row['judul'] ?>" style="width: 150px;height: 150px;object-fit: cover;"></td> -->
                            <td><img src="<?= !empty($row['cover_link']) ? $row['cover_link'] : (!empty($row['cover']) ? '../assets/img/' . $row['cover'] : '../assets/img/' . $row['cover_link']); ?>"
                                    alt="<?= $row['judul'] ?>" style="width: 150px;height: 150px;object-fit: cover;"></td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="./edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <form method="post" action="../apps/proccess.php" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="information" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="information">About Me</h1>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var alertMessage = document.getElementById('alert-message');
            if (alertMessage) {
                setTimeout(function () {
                    alertMessage.classList.add('fade-out');
                    setTimeout(function () {
                        alertMessage.style.display = 'none';
                    }, 500);
                }, 5000); 
            }
        });
    </script>
</body>

</html>