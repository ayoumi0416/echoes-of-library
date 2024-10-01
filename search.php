<?php
require_once("./apps/function.php");

// Ambil query pencarian dari URL
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Ambil data buku
$table = "book";
$dataBooks = read($table);

// Filter buku berdasarkan query pencarian
if ($query) {
    $dataBooks = array_filter($dataBooks, function ($book) use ($query) {
        return stripos($book['judul'], $query) !== false;
    });
}

$tableCategories = "category";
$dataCategories = read($tableCategories);

$tableCategoryBooks = "category_book";
$dataCategoryBooks = read($tableCategoryBooks);

if ($dataCategoryBooks === false) {
    echo 'Error: Tidak dapat mengambil data dari tabel category_book.';
}

$categoryBooks = [];
foreach ($dataCategoryBooks as $categoryBook) {
    $categoryId = $categoryBook['category_id'];
    $bookId = $categoryBook['book_id'];

    if (!isset($categoryBooks[$categoryId])) {
        $categoryBooks[$categoryId] = [];
    }
    $categoryBooks[$categoryId][] = $bookId;
}

// Pagination
$booksPerPage = 4;
$totalBooks = count($dataBooks);
$totalPages = ceil($totalBooks / $booksPerPage);
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max(1, min($page, $totalPages));
$startIndex = ($page - 1) * $booksPerPage;
$booksToDisplay = array_slice($dataBooks, $startIndex, $booksPerPage);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>

    <!-- Header -->
    <header>
        <div class="max-w-[1640px] mx-auto flex justify-between items-center p-4" style="background-color: #CBE2B5;">
            <div class="flex items-center">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl px-2">
                    Mi<span class="font-bold">Youll</span>
                </h1>
                <div class="hidden lg:flex items-center bg-gray-200 rounded-full p-1 text-[14px]">
                    <a href="./" class="bg-black text-white rounded-full p-2">Home</a>
                    <a href="./admin/" class="p-2">Admin</a>
                </div>
            </div>

            <form action="./search.php" method="get">
                <div class="bg-gray-200 rounded-full flex items-center px-2 w-[200px] sm:w-[400px] lg:w-[500px]">
                    <i class="fas fa-search"></i>
                    <input class="bg-transparent p-2 w-full focus:outline-none" type="text" placeholder="Search"
                        value="<?= $query; ?>" name="query" />
                </div>
            </form>

            <button class="bg-black text-white hidden md:flex items-center py-2 rounded-full" data-bs-toggle="modal"
                data-bs-target="#infoModal">
                <i class="fa-solid fa-info"></i>
            </button>
        </div>

        <div id="overlay" class="bg-black/80 w-full h-screen fixed z-10 top-0 left-0 hidden"></div>
    </header>

    <!-- Search card -->
    <section id="menu">
        <div class="max-w-[1640px] m-auto px-4 py-8">
            <h1 class="text-black font-bold text-4xl text-center text-heading">
                Our Books
            </h1>

            <div class="flex flex-col lg:flex-row justify-between p-4">
                <div>
                    <p class="font-bold text-gray-700">Category</p>
                    <div class="flex justify-between flex-wrap">
                        <button onclick="filterType('all')"
                            class="m-1 border-lime-600 text-lime-600 hover:bg-lime-600 hover:text-black">
                            All
                        </button>
                        <?php foreach ($dataCategories as $category): ?>
                            <?php
                            $categoryId = $category['id'];
                            ?>
                            <button onclick="filterType('<?= $category['category_name_id'] ?>')"
                                class="m-1 border-lime-600 text-lime-600 hover:bg-lime-600 hover:text-black">
                                <?= htmlspecialchars($category['category_name']) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div id="food-grid" class="grid grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
            <?php foreach ($booksToDisplay as $row): ?>
                    <?php
                    // Fetch categories for the current book
                    $bookCategories = array_map(function ($categoryBook) use ($row, $dataCategories) {
                        if ($categoryBook['book_id'] == $row['id']) {
                            foreach ($dataCategories as $category) {
                                if ($category['id'] == $categoryBook['category_id']) {
                                    return htmlspecialchars($category['category_name_id']);
                                }
                            }
                        }
                        return null;
                    }, $dataCategoryBooks);
                    $bookCategories = array_filter($bookCategories);  // Remove null values
                    $categoryClasses = implode(' ', $bookCategories);  // Convert to string
                
                    // Determine image source
                    $imageSrc = !empty($row['cover_link']) ? $row['cover_link'] : ('./assets/img/' . ($row['cover'] ?? 'default.png'));
                    ?>

                    <div class="food-card <?= $categoryClasses?> border rounded-lg shadow-lg hover:scale-105 duration-300">
                        <img src="<?= !empty($row['cover_link']) ? $row['cover_link'] : (!empty($row['cover']) ? './assets/img/' . $row['cover'] : './assets/img/' . $row['cover_link']); ?>"
                            alt="<?= $row['judul'] ?>" alt="Burger" class="w-full h-[200px] object-cover rounded-t-lg" />
                        <div class="flex justify-between p-2 py-4">
                            <div class="flex flex-column">
                                <p class="font-bold"><?= $row['judul'] ?></p>
                                <p><?= $row['penerbit'] ?></p>
                            </div>
                            <p>
                                <span class="bg-lime-500 text-black p-2 rounded-xl"> Read</span>
                            </p>
                        </div>
                    </div>
                <?php endforeach ?>
                </div>

                <div class="flwx justify-content-center mt-5">
                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </section>

    <!-- footer -->
    <footer class="footer-07">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h2 class="footer-heading"><a href="/" class="logo">Miyoull</a></h2>
                    <p class="menu">
                        <a href="#">Home</a>
                        <a href="#">Admin</a>
                        <a href="#">Info</a>
                        <a href="#">Best Seller</a>
                        <a href="#">Add Data</a>
                        <a href="#">Search</a>
                    </p>
                    <ul class="ftco-footer-social p-0">
                        <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top"
                                title="Twitter"><span class="fab fa-twitter"></span></a></li>
                        <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top"
                                title="Facebook"><span class="fab fa-facebook"></span></a></li>
                        <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top"
                                title="Instagram"><span class="fab fa-instagram"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <p class="copyright">
                        Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script> All rights reserved | This template
                        is made with <i class="ion-ios-heart" aria-hidden="true"></i> by <a href="/"
                            target="_blank">Miyoull</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

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


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>