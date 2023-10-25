<?php
include ('../app/inc.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
            </ul>
            <div class="d-flex">
                <button class="btn btn-outline-primary"  id="newuserbtn" type="submit">New User</button>
            </div>
        </div>
    </div>
</nav>
<table class="table">
    <thead>
        <tr>
            <th scope="col">First name</th>
            <th scope="col">Last name</th>
            <th scope="col">Position</th>
            <th scope="col">&nbsp;</th>
        </tr>
    </thead>
    <tbody id="userstable">
    </tbody>
</table>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="fname" class="col-form-label">First name:</label>
                        <input type="text" class="form-control" id="fname" name="fname">
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="col-form-label">Last name:</label>
                        <input type="text" class="form-control" id="lname" name="lname">
                    </div>
                    <div class="mb-3">
                        <label for="position" class="col-form-label">Position:</label>
                        <select class="form-select" id="position" name="position">
                            <option value="" selected>Select position</option>
                            <?php foreach (POSITIONS as $id => $name): ?>
                            <option value="<?= $id ?>"><?= $name ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closebtn">Close</button>
                    <button type="button" class="btn btn-primary" id="createuserbtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const POSITIONS = <?= json_encode(POSITIONS) ?>
</script>
<script src="./assets/scripts.js" type="application/javascript"></script>
</body>
</html>
