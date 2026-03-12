<?php session_start(); ?>
<?php
$plotDataJSON = 'null';
$pageError = '';
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$pageTitle = $id ? 'Edit Plot Size' : 'Add New Plot Size';
$cardTitle = $id ? 'Edit Plot Size Details' : 'New Plot Size';
$submitText = $id ? 'Update Plot Size' : 'Add Plot Size';
$cardType = $id ? 'card-success' : 'card-primary';

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    $pageError = "Database connection failed: " . $db->connect_error;
}

if ($id && empty($pageError)) {
    $stmt = $db->prepare("SELECT * FROM size_cat WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $plot = $result->fetch_assoc();
        $plotDataJSON = json_encode(['success' => true, 'data' => $plot]);
    } else {
        $pageError = "⚠️ Record not found.";
        $plotDataJSON = json_encode(['success' => false]);
    }
    $stmt->close();
}
$db->close();
$formDisabled = !empty($pageError);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $pageTitle ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/adminlte.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">
<?php include("../includes/header.php"); ?>
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand">
    <a href="../index.php" class="brand-link">
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
      <div class="card <?= $cardType ?> mb-4 shadow-sm">
        <div class="card-header"><h4><?= $cardTitle ?></h4></div>
        <form id="plotForm" method="POST">
          <div class="card-body">
            <div id="apiResponse" class="alert" style="display:none;"></div>

            <input type="hidden" name="id" id="id" value="<?= htmlspecialchars($id ?? '') ?>">

            <div class="row mb-3">
              <div class="col-md-4">
                <label for="size" class="form-label">Size <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="size" name="size" required <?= $formDisabled?'disabled':'' ?>>
              </div>
              <div class="col-md-4">
                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="type" name="type" required <?= $formDisabled?'disabled':'' ?>>
              </div>
              <div class="col-md-4">
                <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="code" name="code" required <?= $formDisabled?'disabled':'' ?>>
              </div>
            </div>
          </div>

          <div class="card-footer text-end">
            <button type="submit" id="submitButton" class="btn <?= $id?'btn-success':'btn-primary' ?>" <?= $formDisabled?'disabled':'' ?>><?= $submitText ?></button>
            <a href="plot_size_list.php" class="btn btn-secondary ms-2">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
<?php include("../includes/footer.php"); ?>
</div>

<script>
const preloadedData = <?= $plotDataJSON ?>;
const isUpdateMode = <?= $id?'true':'false' ?>;

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('plotForm');
  const apiResponseDiv = document.getElementById('apiResponse');
  const submitButton = document.getElementById('submitButton');

  if (isUpdateMode && preloadedData && preloadedData.success && preloadedData.data) {
    const data = preloadedData.data;
    document.getElementById('size').value = data.size || '';
    document.getElementById('type').value = data.type || '';
    document.getElementById('code').value = data.code || '';
  }

  form.addEventListener('submit', e => {
    e.preventDefault();
    submitButton.disabled = true;
    submitButton.textContent = isUpdateMode ? 'Updating...' : 'Adding...';

    const formData = new FormData(form);
    formData.set('action', isUpdateMode ? 'update' : 'add');

    fetch('api_plot_size.php', { method: 'POST', body: formData })
      .then(r => r.json())
      .then(result => {
        showResponse(result.message, result.success);
        if (result.success) setTimeout(() => window.location.href = 'plot_size_list.php', 1000);
      })
      .catch(err => showResponse('Error: ' + err.message, false))
      .finally(() => {
        submitButton.disabled = false;
        submitButton.textContent = isUpdateMode ? 'Update Plot Size' : 'Add Plot Size';
      });
  });

  function showResponse(msg, success) {
    apiResponseDiv.textContent = msg;
    apiResponseDiv.style.display = 'block';
    apiResponseDiv.className = success ? 'alert alert-success' : 'alert alert-danger';
  }
});
</script>
</body>
</html>
