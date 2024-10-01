<?php
require_once(__DIR__ . "/../apps/function.php");

$tableBook = "book";
$tableCategory = "category";
$tableCategoryBook = "category_book";

if (isset($_GET['id']) && $_GET['id']) {
    $id = mysqli_real_escape_string($conn, $_GET['id']); // Escape the ID for security
    $sqlBook = "SELECT * FROM $tableBook WHERE id='$id'";
    $dataBook = read($tableBook, $sqlBook);

    if (empty($dataBook)) {
        echo "Data tidak ditemukan";
        exit;
    }
    $dataBook = $dataBook[0];

    $sqlCategoryBook = "SELECT category_id FROM $tableCategoryBook WHERE book_id='$id'";
    $dataCategoryBook = read($tableCategoryBook, $sqlCategoryBook);
    $currentCategoryId = !empty($dataCategoryBook) ? $dataCategoryBook[0]['category_id'] : '';

    $sqlCategories = "SELECT id, category_name FROM $tableCategory";
    $dataCategories = read($tableCategory, $sqlCategories);

} else {
    echo "ID tidak ditemukan";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD AYUMI</title>
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
                    <a href="../admin/" class="bg-black text-white rounded-full p-2">Admin</a>
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
            <h3 class="text-4xl font-bold mb-2">Admin Book</h3>
        </div>
    </header>

    <div class="section my-5">
        <div class="container">
            <h2 align="center"><b>Edit Data</b></h2>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <form action="../apps/proccess.php" class="m-5 p-5" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($dataBook['id']); ?>">
                <div class="mb-4">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" name="judul" id="judul"
                        value="<?php echo htmlspecialchars($dataBook['judul']); ?>">
                </div>
                <div class="mb-4">
                    <label for="pengarang">Pengarang</label>
                    <input type="text" class="form-control" name="pengarang" id="pengarang"
                        value="<?php echo htmlspecialchars($dataBook['pengarang']); ?>">
                </div>
                <div class="mb-4">
                    <label for="penerbit">Penerbit</label>
                    <input type="text" class="form-control" name="penerbit" id="penerbit"
                        value="<?php echo htmlspecialchars($dataBook['penerbit']); ?>">
                </div>
                <div class="mb-4">
                    <label for="tahun_terbit">Tahun Penerbit</label>
                    <input type="text" class="form-control" name="tahun_terbit" id="tahun_terbit"
                        value="<?php echo htmlspecialchars($dataBook['tahun_terbit']); ?>">
                </div>
                <div class="mb-4">
                    <label for="isbn">ISBN</label>
                    <input type="text" class="form-control" name="isbn" id="isbn"
                        value="<?php echo htmlspecialchars($dataBook['isbn']); ?>">
                </div>
                <div class="mb-4">
                    <label for="jumlah">Jumlah</label>
                    <input type="text" class="form-control" name="jumlah" id="jumlah"
                        value="<?php echo htmlspecialchars($dataBook['jumlah']); ?>">
                </div>
                <div class="mb-4">
                    <label for="category">Category</label>
                    <select class="form-control" name="category_id" id="category">
                        <option value="" disabled selected>Kategori tidak di tentukan</option>
                        <?php
                        if (!empty($dataCategories)) {
                            foreach ($dataCategories as $category) {
                                $selected = ($category['id'] == $currentCategoryId) ? 'selected' : '';
                                ?>
                                <option value="<?= htmlspecialchars($category['id']) ?>" <?= $selected ?>>
                                    <?= htmlspecialchars($category['category_name']) ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="cover">Cover Image</label>
                    <input type="url" class="form-control" name="cover" id="cover"
                        value="<?= htmlspecialchars($dataBook['cover_link']); ?>">
                    <?php if (!empty($dataBook['cover_link'])): ?>
                        <img src="<?= htmlspecialchars($dataBook['cover_link']); ?>" alt="Current Cover"
                            class="img-thumbnail mt-2" style="max-width: 150px;">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>