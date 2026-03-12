<?php session_start(); ?>
<?php
$projectDataJSON = 'null';
$pageError = '';
$projectId = isset($_GET['id']) ? intval($_GET['id']) : null;

$pageTitle  = $projectId ? 'Edit Project' : 'Add New Project';
$cardTitle  = $projectId ? 'Edit Project Details' : 'New Project Information';
$submitText = $projectId ? 'Update Project' : 'Add Project';
$cardType   = $projectId ? 'card-success' : 'card-primary';

/* -------------------------
   Fetch project for edit
------------------------- */
if ($projectId) {
    $db = new mysqli("localhost", "root", "", "rdlpk_db1");

    if ($db->connect_error) {
        $pageError = "Database connection failed: " . $db->connect_error;
    } else {
        $stmt = $db->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $res->num_rows > 0) {
            $project = $res->fetch_assoc();

            // Convert single image values properly
            $projectDataJSON = json_encode([
                'success' => true,
                'data' => $project
            ]);

        } else {
            $pageError = "⚠️ Project not found!";
        }

        $stmt->close();
        $db->close();
    }
}

$formDisabled = !empty($pageError);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $pageTitle ?></title>
<link rel="stylesheet" href="../css/adminlte.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
.preview-image {
    width: 140px;
    height: 140px;
    border-radius: 8px;
    object-fit: cover;
    margin: 5px;
    border: 2px solid #ccc;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

<?php include("../includes/header.php"); ?>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <?php include("../includes/sidebar.php"); ?>
</aside>

<main class="app-main">

<div class="app-content-header mb-4">
    <div class="container-fluid">
        <h3><?= $pageTitle ?></h3>
    </div>
</div>

<div class="app-content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">

<div class="card <?= $cardType ?> shadow-sm">
<div class="card-header"><h4><?= $cardTitle ?></h4></div>

<form id="projectForm" enctype="multipart/form-data" method="POST">

<div class="card-body">

<div id="apiResponse" class="alert" style="display:none;"></div>

<input type="hidden" id="projectId" name="id" value="<?= $projectId ?>">

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Project Name *</label>
        <input type="text" class="form-control" id="projectName" name="projectName" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Project URL *</label>
        <input type="text" class="form-control" id="project_url" name="project_url" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-8">
        <label class="form-label">Teaser *</label>
        <textarea class="form-control" id="teaser" name="teaser" required></textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label">Status *</label>
        <select class="form-select" id="status" name="status" required>
            <option disabled selected>Select Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Project Details *</label>
    <textarea class="form-control" id="project_details" name="project_details" rows="4" required></textarea>
</div>

<!-- CURRENT PROJECT IMAGE -->
<?php if ($projectId): ?>
<div class="mb-3">
    <label class="form-label">Current Image</label>
    <div id="currentImagePreview"></div>
</div>
<?php endif; ?>

<div class="mb-3">
    <label class="form-label">Project Image *</label>
    <input type="file" class="form-control" id="projectImages" name="projectImages">
</div>

<!-- CURRENT MAP -->
<?php if ($projectId): ?>
<div class="mb-3">
    <label class="form-label">Current Map</label>
    <div id="currentMapPreview"></div>
</div>
<?php endif; ?>

<div class="mb-3">
    <label class="form-label">Project Map *</label>
    <input type="file" class="form-control" id="projectMap" name="projectMap">
</div>

</div>

<div class="card-footer text-end">
    <button type="submit" id="submitButton" class="btn btn-primary"><?= $submitText ?></button>
    <a href="projects.php" class="btn btn-secondary">Cancel</a>
</div>

</form>

</div>
</div>
</div>
</div>
</div>

</main>

<?php include("../includes/footer.php"); ?>
</div>

<script>
const preData = <?= $projectDataJSON ?>;
const updateMode = <?= $projectId ? 'true' : 'false' ?>;

document.addEventListener("DOMContentLoaded", () => {

    if (updateMode && preData.success) fillForm(preData.data);

    document.getElementById("projectForm").addEventListener("submit", submitForm);
});

function fillForm(data) {
    document.getElementById("projectName").value = data.project_name;
    document.getElementById("project_url").value = data.project_url;
    document.getElementById("teaser").value = data.teaser;
    document.getElementById("status").value = data.status;
    document.getElementById("project_details").value = data.project_details;

    // Single image preview
    if (data.project_images) {
        document.getElementById("currentImagePreview").innerHTML =
            `<img src="../assets/img/projects/${data.project_images}" class="preview-image">`;
    }

    // Single map preview
    if (data.project_map) {
        document.getElementById("currentMapPreview").innerHTML =
            `<img src="../assets/img/projects/${data.project_map}" class="preview-image">`;
    }
}

function submitForm(e) {
    e.preventDefault();

    const btn = document.getElementById("submitButton");
    btn.disabled = true;
    btn.textContent = "Saving...";

    let form = new FormData(this);
    form.set("action", updateMode ? "update" : "add");

    fetch("api_projects.php", { method: "POST", body: form })
        .then(r => r.json())
        .then(res => {
            showResponse(res.success, res.message);
            if (res.success)
                setTimeout(() => window.location = "projects.php", 800);
        })
        .catch(err => showResponse(false, err.message))
        .finally(() => {
            btn.disabled = false;
            btn.textContent = "<?= $submitText ?>";
        });
}

function showResponse(success, msg) {
    const box = document.getElementById("apiResponse");
    box.style.display = "block";
    box.className = success ? "alert alert-success" : "alert alert-danger";
    box.textContent = msg;
}
</script>
</body>
</html>
