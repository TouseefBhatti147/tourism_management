<?php session_start(); ?>
<?php
// --- PHP Data Fetching Block ---
$projectDataJSON = 'null';
$pageError = '';

// We need the ID from the URL to fetch data
if (!isset($_GET['id'])) {
	$pageError = 'No project ID found in the URL. Please load this page with ?id=PROJECT_ID';
} else {
	try {
		// Adjust these paths if your file structure is different
		// These paths are based on your add_project.php includes
		// NOTE: These includes assume the necessary files exist relative to this file's location.
		// If you are missing these includes, you will get fatal errors.
		// require_once '../includes/db_connection.php'; 
		// require_once '../classes/project.php'; 

		// $pdo = Database::getConnection();
		// $projectService = new Project($pdo);
		
		$projectId = trim($_GET['id']);
		// $project = $projectService->getProjectById($projectId); // Requires getProjectById() to be public
		
		// MOCK DATA since actual backend is not available
		$project = [
			'id' => $projectId,
			'project_name' => 'Royal Orchard Multan',
			'project_url' => 'https://royalorchard.com',
			'teaser' => 'Luxury living with modern amenities.',
			'project_detail' => 'Royal Orchard Multan is a flagship housing project offering 5, 10, and 20 marla plots, as well as luxury villas. It includes a grand mosque, a commercial area, parks, and 24/7 security.',
			'project_image' => '["../assets/img/project_multan_1.jpg", "../assets/img/project_multan_2.jpg"]',
			'project_map' => '../assets/img/project_multan_map.png',
			'status' => 'Active'
		];


		if ($project) {
			// Encode the data as JSON to be safely embedded in JavaScript
			$projectDataJSON = json_encode(['success' => true, 'data' => $project]);
		} else {
			$pageError = 'Project not found.';
			$projectDataJSON = json_encode(['success' => false, 'message' => $pageError]);
		}
	} catch (\PDOException $e) {
		$pageError = 'Database connection failed: ' . $e->getMessage();
	} catch (\Exception $e) {
		$pageError = 'An error occurred: ' . $e->getMessage();
	}
}
// --- End of PHP Block ---
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Edit Project</title> <!-- Changed Title -->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Edit Project" /> <!-- Changed Title -->
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="Admin Dashboard..." />
    <meta name="keywords" content="bootstrap 5, admin dashboard, accessible, WCAG" />
    <meta name="supported-color-schemes" content="light dark" />

    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/adminlte.css" />

    <!-- Style for image previews -->
    <style>
        .preview-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 0.5rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            border: 2px solid #dee2e6;
        }
    </style>
  </head>

  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <?php require("../includes/header.php");?>

      <!-- Sidebar -->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
            <a href="..\index.php" class="brand-link">
            <span class="brand-text fw-light">Real Estate E-System</span>
          </a>
        </div>
        <?php include("../includes/sidebar.php"); ?>
      </aside>

      <!-- Main Content -->
      <main class="app-main">
        <!-- App Content Header -->
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Edit Project</h3> <!-- Changed Header -->
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="projects.php">Projects</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Project</li> <!-- Changed Breadcrumb -->
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- App Content -->
        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-success mb-4">
                  <div class="card-header">
                    <h3 class="card-title mb-0">Edit Project Details</h3> <!-- Changed Card Title -->
                  </div>
                  <!-- /.card-header -->
                  
                  <!-- Form starts here -->
                  <form id="updateProjectForm" enctype="multipart/form-data" method="POST"> <!-- Changed Form ID -->
                    <div class="card-body">

                      <!-- Form Message Feedback -->
                      <!-- Renamed from formMessage to apiResponse for consistency with script -->
                      <div id="apiResponse" class="alert" style="display: none;"></div>
                      
                      <!-- Error Message Area for page load errors -->
                      <div id="pageErrorMessage" class="<?php echo $pageError ? '' : 'd-none'; ?> alert alert-danger" role="alert">
                          <?php echo $pageError; ?>
                      </div>

                      <!-- Hidden ID field -->
                      <input type="hidden" name="id" id="projectId">

                      <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="projectName" name="projectName" required>
                      </div>

                      <div class="mb-3">
                        <label for="url" class="form-label">Project URL <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="https://example.com" required>
                      </div>

                      <div class="mb-3">
                        <label for="teaser" class="form-label">Teaser <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="teaser" name="teaser" rows="2" required></textarea>
                      </div>

                      <div class="mb-3">
                        <label for="projectDetail" class="form-label">Project Detail <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="projectDetail" name="projectDetail" rows="5" required></textarea>
                      </div>

                      <!-- Modified Project Images Section -->
                      <div class="mb-3">
                        <label class="form-label">Current Images</label>
                        <div id="currentImagesPreview" class="my-2 d-flex flex-wrap">
                            <!-- JS will populate this -->
                            <p class="text-muted">Loading...</p>
                        </div>
                        <label for="projectImages" class="form-label">Upload New Images</label>
                        <input type="file" class="form-control" id="projectImages" name="projectImages[]" multiple >
                        <small class="form-text text-muted">Uploading new images will replace *all* current images.</small>
                      </div>

                      <!-- Modified Project Map Section -->
                        <div class="mb-3">
                        <label class="form-label">Current Map</label>
                        <div id="currentMapPreview" class="my-2">
                            <!-- JS will populate this -->
                            <p class="text-muted">Loading...</p>
                        </div>
                        <label for="projectMap" class="form-label">Upload New Map</label>
                        <input type="file" class="form-control" id="projectMap" name="projectMap" >
                        <small class="form-text text-muted">Leave blank to keep the current map.</small>
                      </div>

                      <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                          <option value="" disabled>Select Status</option>
                          <option value="Active">Active</option>
                          <option value="inActive">inActive</option>
                        </select>
                      </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" id="submitButton" class="btn btn-success">Update Project</button> <!-- Changed Button Text -->
                      <a href="projects.php" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
              </div>
            </div>
          </div>
        </div>
      </main>

      <?php include("../includes/footer.php"); ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../js/adminlte.js"></script>

    <!-- AJAX Form Submission Script -->
    <script>
      // --- 1. Pass data from PHP to JavaScript ---
      const preloadedData = <?php echo $projectDataJSON; ?>;

      document.addEventListener('DOMContentLoaded', () => {
          const form = document.getElementById('updateProjectForm');
          const apiResponseDiv = document.getElementById('apiResponse');
          const submitButton = document.getElementById('submitButton');
          const pageErrorDiv = document.getElementById('pageErrorMessage');

          // --- 2. Get Project ID from URL (still needed for the hidden field) ---
          const urlParams = new URLSearchParams(window.location.search);
          const projectId = urlParams.get('id');
          
          if (projectId) {
              document.getElementById('projectId').value = projectId;
          }

          // --- 3. Populate Form from Preloaded Data ---
          if (preloadedData && preloadedData.success && preloadedData.data) {
              populateForm(preloadedData.data);
          } else if (pageErrorDiv.textContent === '') {
              // Only show this if the PHP error block is empty
              showApiResponse('Failed to load project data.', false);
          }

          // --- 4. Form Submission Handler ---
          form.addEventListener('submit', function(event) {
              event.preventDefault();
              submitButton.disabled = true;
              submitButton.textContent = 'Updating...';
              
              const formData = new FormData(this);
              
              // *** IMPORTANT: Set the action parameter for the unified API ***
              formData.set('action', 'update');
              
              // Use your actual path to the unified API file
              // Assuming api_projects.php is in the same directory as the old file
              fetch('api_projects.php', { // <-- TARGET CHANGE HERE
                  method: 'POST',
                  body: formData
              })
              .then(response => {
                  const contentType = response.headers.get("content-type");
                  if (contentType && contentType.indexOf("application/json") !== -1) {
                      return response.json();
                  } else {
                      return response.text().then(text => {
                          throw new Error("Server did not return JSON. Response: " + text);
                      });
                  }
              })
              .then(result => {
                  showApiResponse(result.message, result.success);
                  // If successful, reload the page to see file changes
                  if(result.success) {
                      setTimeout(() => {
                          window.location.reload(); 
                      }, 1500);
                  }
              })
              .catch(err => {
                  console.error('Submit Error:', err);
                  showApiResponse('An error occurred during submission. ' + err.message, false);
              })
              .finally(() => {
                  submitButton.disabled = false;
                  submitButton.textContent = 'Update Project';
              });
          });

          // --- Helper Functions ---
          function populateForm(data) {
              document.getElementById('projectName').value = data.project_name || '';
              document.getElementById('url').value = data.project_url || '';
              // Use the exact value from your <select> options
              document.getElementById('status').value = data.status || 'inActive'; 
              document.getElementById('teaser').value = data.teaser || '';
              document.getElementById('projectDetail').value = data.project_detail || '';
              
              // Show current map preview
              const mapPreview = document.getElementById('currentMapPreview');
              if (data.project_map) {
                  // Assuming the path is correct to display
                  mapPreview.innerHTML = `<img src="${data.project_map}" alt="Project Map" class="preview-image">`;
              } else {
                  mapPreview.innerHTML = `<p class="text-muted">No current map.</p>`;
              }

              // Show current images preview
              const imagesPreview = document.getElementById('currentImagesPreview');
              imagesPreview.innerHTML = ''; // Clear first
              try {
                  const images = JSON.parse(data.project_image);
                  if (images && images.length > 0) {
                      images.forEach(img_path => {
                          imagesPreview.innerHTML += `<img src=\"${img_path}\" alt=\"Project Image\" class=\"preview-image\">`;
                      });
                  } else {
                      imagesPreview.innerHTML = `<p class=\"text-muted\">No current images.</p>`;
                  }
              } catch(e) {
                  imagesPreview.innerHTML = `<p class=\"text-muted\">No current images.</p>`;
              }
          }
          
          function showApiResponse(message, isSuccess) {
              apiResponseDiv.textContent = message;
              apiResponseDiv.style.display = 'block';
              if (isSuccess) {
                  apiResponseDiv.className = 'alert alert-success';
              } else {
                  apiResponseDiv.className = 'alert alert-danger';
              }
          }
      });
    </script>

  </body>
</html>