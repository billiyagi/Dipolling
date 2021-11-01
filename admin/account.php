<?php include "template/menu.php"; ?>
    <div class="dib-admin-page-title fs-4 text-dark fw-bold">
        <i class="bi bi-person-circle"></i> Account
    </div>
    <form class="" action="index.html" method="post">
        <div class="mb-3 row">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="username" value="exampleuser0name">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
            <input type="email" class="form-control" id="email" placeholder="Email">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="name" placeholder="Full Name">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-lg mt-5"><i class="bi bi-check2-square"></i> Save Changes</button>
    </form>
<?php include "template/main.php"; ?>
