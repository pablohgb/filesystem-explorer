<?php
require_once __DIR__ . '/createUploadFolderFile.php';
require_once __DIR__ . '/functions.php';

if (isset($_POST['getPath'])) {
    $customUrlPath = $_POST['getPath'];
    $urlItem = "root/$customUrlPath";
    createItem($urlItem);
    uploadItem($urlItem);
    deleteItem($urlItem);
} else {
    createItem('root');
    uploadItem('root');
    deleteItem('root');
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Local FileSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="dyScript.js" defer></script>
</head>

<body translate="no"> <!-- class="overflow-hidden" -->

    <header class="p-3 text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-start justify-content-center justify-content-lg-start">
                <a href="http://localhost/filesystem-explorer" class="px-2 d-flex align-items-center mb-2 mb-lg-0 m-2 text-white text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-rocket-takeoff" viewBox="0 0 16 16">
                        <path d="M9.752 6.193c.599.6 1.73.437 2.528-.362.798-.799.96-1.932.362-2.531-.599-.6-1.73-.438-2.528.361-.798.8-.96 1.933-.362 2.532Z" />
                        <path d="M15.811 3.312c-.363 1.534-1.334 3.626-3.64 6.218l-.24 2.408a2.56 2.56 0 0 1-.732 1.526L8.817 15.85a.51.51 0 0 1-.867-.434l.27-1.899c.04-.28-.013-.593-.131-.956a9.42 9.42 0 0 0-.249-.657l-.082-.202c-.815-.197-1.578-.662-2.191-1.277-.614-.615-1.079-1.379-1.275-2.195l-.203-.083a9.556 9.556 0 0 0-.655-.248c-.363-.119-.675-.172-.955-.132l-1.896.27A.51.51 0 0 1 .15 7.17l2.382-2.386c.41-.41.947-.67 1.524-.734h.006l2.4-.238C9.005 1.55 11.087.582 12.623.208c.89-.217 1.59-.232 2.08-.188.244.023.435.06.57.093.067.017.12.033.16.045.184.06.279.13.351.295l.029.073a3.475 3.475 0 0 1 .157.721c.055.485.051 1.178-.159 2.065Zm-4.828 7.475.04-.04-.107 1.081a1.536 1.536 0 0 1-.44.913l-1.298 1.3.054-.38c.072-.506-.034-.993-.172-1.418a8.548 8.548 0 0 0-.164-.45c.738-.065 1.462-.38 2.087-1.006ZM5.205 5c-.625.626-.94 1.351-1.004 2.09a8.497 8.497 0 0 0-.45-.164c-.424-.138-.91-.244-1.416-.172l-.38.054 1.3-1.3c.245-.246.566-.401.91-.44l1.08-.107-.04.039Zm9.406-3.961c-.38-.034-.967-.027-1.746.163-1.558.38-3.917 1.496-6.937 4.521-.62.62-.799 1.34-.687 2.051.107.676.483 1.362 1.048 1.928.564.565 1.25.941 1.924 1.049.71.112 1.429-.067 2.048-.688 3.079-3.083 4.192-5.444 4.556-6.987.183-.771.18-1.345.138-1.713a2.835 2.835 0 0 0-.045-.283 3.078 3.078 0 0 0-.3-.041Z" />
                        <path d="M7.009 12.139a7.632 7.632 0 0 1-1.804-1.352A7.568 7.568 0 0 1 3.794 8.86c-1.102.992-1.965 5.054-1.839 5.18.125.126 3.936-.896 5.054-1.902Z" />
                    </svg>
                </a>

                <div>
                    <form id="live-search" action="" class="styled" method="post">
                        <fieldset>
                            <input type="text" placeholder="Search here..." class="form-control me-2" id="searchBarInput" aria-label="Search">
                        </fieldset>
                    </form>

                    <ul id="ulClass" class="liveSearchBar displayNone">
                        <?php
                        require_once('functions.php');
                        dirToArray('root');
                        ?>
                    </ul>

                    <script id="rendered-js">
                        const form = document.getElementById('searchBarInput');

                        form.addEventListener('focus', (event) => {
                            document.getElementById("ulClass").style.display = "block";

                        }, true);

                        form.addEventListener('blur', (event) => {
                            setTimeout(function() {
                                document.getElementById("ulClass").style.display = "none";
                            }, 1000);
                        }, true);


                        $(document).ready(function() {
                            $("#searchBarInput").keyup(function() {

                                var filter = $(this).val(),
                                    count = 0;

                                $("ul li").each(function() {

                                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                                        $(this).fadeOut();

                                    } else {
                                        $(this).show();
                                        count++;
                                    }
                                });
                            });
                        });
                    </script>

                </div>

            </div>
        </div>
    </header>

    <main class="d-flex flex-row">
        <nav class="bg-info vh-100" style="width: 190px;">
            <div class="d-grid">
                <button type="button" class="btn btn-primary mx-2 mt-2" data-bs-toggle="modal" data-bs-target="#creatFolder">
                    Create new folder
                </button>
                <button type="button" class="btn btn-primary mx-2 mt-2" data-bs-toggle="modal" data-bs-target="#createFile">
                    Create new file
                </button>
                <button type="button" class="btn btn-primary mx-2 mt-2" data-bs-toggle="modal" data-bs-target="#uploadFile">
                    Upload file
                </button>
            </div>
            <hr class="my-4">
            <div class="p-2">
                <p class="m-1">Directory ROOT</p>
                <?php
                require_once __DIR__ . '/sideNavBar.php';
                sideNav('root');
                ?>
            </div>
        </nav>

        <div class="w-100 bg-light vh-100 overflow-auto">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Creation date</th>
                        <th scope="col">Last Modified Date</th>
                        <th scope="col">Extension</th>
                        <th scope="col">Size</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once __DIR__ . '/functions.php';
                    require_once __DIR__ . '/createUploadFolderFile.php';


                    if (isset($_POST['getPath'])) {
                        $customUrlPath = $_POST['getPath'];
                        $urlEvent = "root/$customUrlPath";
                        tableInsert($urlEvent);
                        createItem($urlEvent);
                    } else {
                        tableInsert('root');
                        createItem('root');
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

<div class="modal fade" id="creatFolder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create new folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="cfolderform">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Folder name:</span>
                        </div>
                        <input type="text" class="form-control" name="cfolder" placeholder="Type folder name..." aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" form="cfolderform" class="btn btn-primary" name="submit" value="Create Folder">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createFile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create new file</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="cfileform">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">File name:</span>
                        </div>
                        <input type="text" class="form-control" name="cfileName" placeholder="Type file name..." aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">File description:</span>
                        </div>
                        <input type="text" class="form-control" name="cfileDes" placeholder="Type file description..." aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="submitFile" form="cfileform" class="btn btn-primary" value="Create File" data-toggle="modal" data-target=".bd-example-modal-lg">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadFile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload file</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="ufileform">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupFile01">Upload</label>
                        <input type="file" name="myfile" class="form-control" id="inputGroupFile01">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="upload" form="ufileform" class="btn btn-primary" value="Upload File" data-toggle="modal" data-target=".bd-example-modal-lg">
            </div>
        </div>
    </div>
</div>

<!-- ******* Varying modal content ******** -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Preview</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row m-2">
                <div class="modal-body col-sm-8 p-0">
                </div>
                <content class="col-sm-4 bg-light p-2">
                    <h1 class="modal-title-info fs-5">Info</h1>
                    <hr>
                    <b>File name: </b>
                    <p class="modal-title-name d-inline">file.txt</p><br>
                    <b>Creation time: </b>
                    <p class="modal-title-ctime d-inline">dd/mm/yyyy</p><br>
                    <b>Modified day: </b>
                    <p class="modal-title-mtime d-inline">dd/mm/yyyy</p><br>
                    <b>Extension type: </b>
                    <p class="modal-title-extension d-inline text-uppercase">txt</p><br>
                    <b>File size: </b>
                    <p class="modal-title-size d-inline">12 KB</p>
                </content>
            </div>
            <div class="modal-footer modal-footer-close">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ******* DELETE Varying modal content ******** -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-delete">
                <form action="" method="post" id="Modaldelete">
                    <input type="hidden">
                </form>
            </div>
            <div class="modal-footer modal-footer-close">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="delete" form="delete" class="btn btn-warning" value="Delete" data-toggle="modal" modal-delete="content" data-bs-dismiss="modal" data-target=".bd-example-modal-lg">
            </div>
        </div>
    </div>
</div>