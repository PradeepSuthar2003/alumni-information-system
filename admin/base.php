<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <style>
    .user_profile {
        background-color: transparent;
        border: none;
        color: white;
    }

    th {
        font-size: 10px;
    }

    td {
        font-size: 10px;
        overflow: hidden;
    }

    td::-webkit-scrollbar {
        overflow: hidden;
    }
    </style>
</head>

<body>

    <!--Navbar-->

    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="./index.php" class="nav-link px-2 text-secondary">Home</a></li>
                    <li><a href="./users.php" class="nav-link px-2 text-white">Users</a></li>
                    <li><a href="./alumni.php" class="nav-link px-2 text-white">All Alumni</a></li>
                </ul>

                <div class="text-end">
                    <a href="logout.php"><button type="button" class="btn btn-outline-light me-2">Logout</button></a>
                    <button type="button" class="user_profile">
                        <h6>Hello, <?php echo $_SESSION['admin_name']; ?></h6>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>