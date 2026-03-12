<?php
session_start();
$conn = new mysqli("localhost", "root", "", "rdlpk_db1");

if ($conn->connect_error) {
    die("Database error");
}

$projectId = intval($_GET['id'] ?? 0);

if ($projectId <= 0) {
    die("<h2 class='text-center text-danger mt-5'>Invalid Project ID</h2>");
}

$query = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$query->bind_param("i", $projectId);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    die("<h2 class='text-center text-danger mt-5'>Project not found</h2>");
}

$project = $result->fetch_assoc();

/* ------------------------------------------------------------
   HANDLE PROJECT IMAGE — supports JSON array or single filename
--------------------------------------------------------------- */

$firstImage = "/real_estate_esystem/assets/img/projects/default.jpg";

if (!empty($project['project_images'])) {

    $decoded = json_decode($project['project_images'], true);

    if (is_array($decoded) && count($decoded) > 0) {
        // JSON stored → use first image
        $firstImage = "/real_estate_esystem/admin/assets/img/projects/" . $decoded[0];
    } else {
        // Single filename stored
        $firstImage = "/real_estate_esystem/admin/assets/img/projects/" . $project['project_images'];
    }
}

/* ---------------------------------------
   PROJECT MAP
---------------------------------------- */

$projectMap = !empty($project['project_map'])
    ? "/real_estate_esystem/admin/assets/img/projects/" . $project['project_map']
    : "/real_estate_esystem/assets/img/projects/default.jpg";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project Details - Real Estate E-System</title>
    <?php require("header.php"); ?>
</head>

<body>

<?php require("navbar.php"); ?>

<!-- PAGE HEADER -->
<header class="contact-header position-relative">
    <img src="./assets/img/login-bg.jpeg" class="header-img" alt="Project Header">
    <div class="header-overlay"></div>
    <div class="header-content text-center">
        <h1 class="fw-bold text-white"><?= htmlspecialchars($project['project_name']) ?></h1>
        <p class="text-light">Explore complete details of the project</p>
    </div>
</header>


<!-- PROJECT DETAILS SECTION -->
<section class="py-5">
    <div class="container">

        <div class="row g-4 align-items-start">

            <!-- LEFT: PROJECT IMAGE -->
            <div class="col-md-6">
                <div class="shadow rounded">
                    <img src="<?= $firstImage ?>"
                         class="d-block w-100 rounded"
                         style="height: 350px; object-fit: cover;"
                         alt="Project Image">
                </div>
            </div>

            <!-- RIGHT: PROJECT INFO -->
            <div class="col-md-6">

                <h2 class="fw-bold mb-3"><?= htmlspecialchars($project['project_name']) ?></h2>

                <p class="text-muted mb-3">
                    <?= nl2br(htmlspecialchars($project['teaser'])) ?>
                </p>

                <ul class="list-group mb-4">
                    <li class="list-group-item">
                        <strong>URL:</strong>
                        <a href="<?= htmlspecialchars($project['project_url']) ?>" target="_blank">
                            <?= htmlspecialchars($project['project_url']) ?>
                        </a>
                    </li>

                    <li class="list-group-item">
                        <strong>Status:</strong>
                        <?= $project['status'] == 1 ? "Active" : "Inactive"; ?>
                    </li>

                    <li class="list-group-item">
                        <strong>Created On:</strong>
                        <?= date("d M Y", strtotime($project['create_date'])) ?>
                    </li>
                </ul>

                <a href="<?= htmlspecialchars($project['project_url']) ?>" 
                   class="btn btn-primary" 
                   target="_blank">
                    Visit Project Website
                </a>

            </div>
        </div>

    </div>
</section>


<!-- PROJECT DESCRIPTION -->
<section class="py-5" style="background:#f9f9f9;">
    <div class="container">

        <h3 class="fw-bold mb-4">Project Overview</h3>

        <p class="text-muted">
            <?= nl2br(htmlspecialchars($project['project_details'])) ?>
        </p>

    </div>
</section>


<!-- PROJECT MAP -->
<section class="py-5">
    <div class="container">

        <h3 class="fw-bold text-center mb-4">Project Map</h3>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <img src="<?= $projectMap ?>" 
                     class="w-100 rounded shadow" 
                     style="height:350px; object-fit:cover;">
            </div>
        </div>

    </div>
</section>


<?php require("footer.php"); ?>
<?php require("script.php"); ?>

</body>
</html>
