<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>

<body>

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
                    <input class="bg-transparent p-2 w-full focus:outline-none" type="text" placeholder="Search foods"
                        name="query" />
                </div>
            </form>

            <button class="bg-black text-white hidden md:flex items-center py-2 rounded-full" data-bs-toggle="modal"
                data-bs-target="#infoModal">
                <i class="fa-solid fa-info"></i>
            </button>
        </div>
    </header>

    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form>
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="txt" placeholder="User name" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="number" name="broj" placeholder="BrojTelefona" required="">
                <input type="password" name="pswd" placeholder="Password" required="">
                <button>Sign up</button>
            </form>
        </div>

        <div class="login">
            <form>
                <label for="chk" aria-hidden="true">Login</label>
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="pswd" placeholder="Password" required="">
                <button>Login</button>
            </form>
        </div>
    </div>


</body>

</html>