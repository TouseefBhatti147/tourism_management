<?php session_start(); ?>
<?php
$projectDataJSON = 'null';
$pageError = '';
$projectId = isset($_GET['id']) ? trim($_GET['id']) : null;
$pageTitle = $projectId ? 'Edit Project' : 'Add New Project';
$cardTitle = $projectId ? 'Edit Project Details' : 'New Project Information';
$submitText = $projectId ? 'Update Project' : 'Add Project';
$cardType = $projectId ? 'card-success' : 'card-primary';

// Mock Data for demonstration (replace with actual DB fetch)
if ($projectId) {
    $project = [
        'id' => $projectId,
        'project_name' => 'Royal Orchard Multan',
        'project_url' => 'https://royalorchard.com',
        'teaser' => 'Luxury living with modern amenities.',
        // --- FIXED: Changed 'project_detail' to 'project_details' to match HTML input ID ---
        'project_details' => 'Royal Orchard Multan is a flagship housing project offering 5, 10, and 20 marla plots.',
        // --- FIXED: Changed 'project_image' (singular) to 'project_images' (plural) to match JS parsing ---
        'project_images' => '["../assets/img/project_multan_1.jpg","../assets/img/project_multan_2.jpg"]',
        'project_map' => '../assets/img/project_multan_map.png',
        'status' => 'Active'
    ];
    if ($project) {
        // --- WARNING: In a real app, this should be an AJAX fetch to a server endpoint (e.g., api_get_project.php)
        // NOT relying on PHP preloading mock data.
        $projectDataJSON = json_encode(['success' => true, 'data' => $project]);
    } else {
        $pageError = "Project not found for ID: " . $projectId;
        $projectDataJSON = json_encode(['success' => false, 'message' => $pageError]);
    }
}
$formDisabled = !empty($pageError);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Project - <?= $pageTitle ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/adminlte.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
.preview-image {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    margin: 4px;
    border: 2px solid #dee2e6;
    transition: transform 0.2s;
}
.preview-image:hover {
    transform: scale(1.05);
    border-color: #0d6efd;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">
<?php include("../includes/header.php"); ?>
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="..\index.php" class="brand-link">
        <span class="brand-text fw-light">Real Estate E-System</span>
        </a>
    </div>
    <?php include("../includes/sidebar.php"); ?>
</aside>

<main class="app-main">
    <div class="app-content-header mb-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3><?= $pageTitle ?></h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $pageTitle ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card <?= $cardType ?> mb-4 shadow-sm">
                        <div class="card-header"><h4><?= $cardTitle ?></h4></div>
                        <form id="projectForm" enctype="multipart/form-data" method="POST">
                            <div class="card-body">
                                <div id="apiResponse" class="alert" style="display:none;"></div>
                                <?php if($pageError): ?>
                                <div class="alert alert-danger"><?= $pageError ?></div>
                                <?php endif; ?>

                                <input type="hidden" name="id" id="projectId" value="<?= htmlspecialchars($projectId ?? '') ?>">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="projectName" class="form-label">Project Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="projectName" name="projectName" required <?= $formDisabled?'disabled':'' ?>>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="url" class="form-label">Project URL <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="project_url" name="project_url" placeholder="https://example.com" required <?= $formDisabled?'disabled':'' ?>>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label for="teaser" class="form-label">Teaser <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="teaser" name="teaser" rows="2" required <?= $formDisabled?'disabled':'' ?>></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" id="status" name="status" required <?= $formDisabled?'disabled':'' ?>>
                                            <option value="" disabled selected>Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="inActive">inActive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="projectDetail" class="form-label">Project Detail <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="project_details" name="project_details" rows="5" required <?= $formDisabled?'disabled':'' ?>></textarea>
                                </div>

                                <?php if($projectId): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Images</label>
                                    <div id="currentImagesPreview" class="d-flex flex-wrap"></div>
                                </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="projectImages" class="form-label"><?= $projectId?'Upload New Images (Replace All)':'Project Images' ?> <?= $projectId?'':'*' ?></label>
                                    <input type="file" class="form-control" id="projectImages" name="projectImages[]" multiple <?= $projectId?'':'required' ?> <?= $formDisabled?'disabled':'' ?>>
                                    <small class="form-text text-muted"><?= $projectId?'Leave blank to keep current images.':'Upload one or more images for the project slider.' ?></small>
                                </div>

                                <?php if($projectId): ?>
                                <div class="mb-3">
                                    <label class="form-label">Current Map</label>
                                    <div id="currentMapPreview"></div>
                                </div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="projectMap" class="form-label"><?= $projectId?'Upload New Map':'Project Map' ?> <?= $projectId?'':'*' ?></label>
                                    <input type="file" class="form-control" id="projectMap" name="projectMap" <?= $projectId?'':'required' ?> <?= $formDisabled?'disabled':'' ?>>
                                    <small class="form-text text-muted"><?= $projectId?'Leave blank to keep current map.':'Upload a single map image.' ?></small>
                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <button type="submit" id="submitButton" class="btn <?= $projectId?'btn-success':'btn-primary' ?>" <?= $formDisabled?'disabled':'' ?>><?= $submitText ?></button>
                                <a href="projects.php" class="btn btn-secondary ms-2">Cancel</a>
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
const preloadedData = <?= $projectDataJSON ?>;
const isUpdateMode = <?= $projectId?'true':'false' ?>;

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('projectForm');
    const apiResponseDiv = document.getElementById('apiResponse');
    const submitButton = document.getElementById('submitButton');

    if(isUpdateMode && preloadedData && preloadedData.success && preloadedData.data){
        populateForm(preloadedData.data);
    }

    form.addEventListener('submit', function(e){
        e.preventDefault();
        submitButton.disabled = true;
        submitButton.textContent = isUpdateMode?'Updating...':'Adding...';

        const formData = new FormData(this);
        formData.set('action', isUpdateMode?'update':'add');

        fetch('api_projects.php',{method:'POST',body:formData})
        .then(response=>{
            const ct = response.headers.get("content-type");
            if(ct && ct.indexOf("application/json")!==-1) return response.json();
            else return response.text().then(text=>{throw new Error("Server did not return JSON: "+text.substring(0,100)+"...");});
        })
        .then(result=>{
            showApiResponse(result.message,result.success);
            if(result.success){
                if(isUpdateMode) setTimeout(()=>window.location.reload(),1500);
                else form.reset();
            }
        })
        .catch(err=>{
            console.error(err);
            showApiResponse('Error: '+err.message,false);
        })
        .finally(()=>{
            submitButton.disabled=false;
            submitButton.textContent=isUpdateMode?'Update Project':'Add Project';
        });
    });

    function populateForm(data){
        document.getElementById('projectName').value = data.project_name||'';
        document.getElementById('project_url').value = data.project_url||'';
        document.getElementById('status').value = data.status||'inActive';
        document.getElementById('teaser').value = data.teaser||'';
        document.getElementById('project_details').value = data.project_details||'';

        const mapPreview = document.getElementById('currentMapPreview');
        if(data.project_map && mapPreview) mapPreview.innerHTML=`<img src="${data.project_map}" class="preview-image">`;

        const imagesPreview = document.getElementById('currentImagesPreview');
        imagesPreview.innerHTML='';
        try{
            // This line correctly looks for 'project_images' (plural) which now matches the PHP mock data structure.
            const images = JSON.parse(data.project_images); 
            if(images && images.length>0){
                images.forEach(img=>{imagesPreview.innerHTML+=`<img src="${img}" class="preview-image">`;});
            } else imagesPreview.innerHTML=`<p class="text-muted">No current images.</p>`;
        }catch(e){
             console.error("Error parsing project images JSON:", e);
        }
    }

    function showApiResponse(message,isSuccess){
        apiResponseDiv.textContent=message;
        apiResponseDiv.style.display='block';
        apiResponseDiv.className=isSuccess?'alert alert-success':'alert alert-danger';
    }
});
</script>
</body>
</html>