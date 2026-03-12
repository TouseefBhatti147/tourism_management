<?php session_start(); ?>
<?php
$id       = $_GET['id'] ?? null;
$pageTitle = $id ? "Edit Member" : "Add Member";
$btnText   = $id ? "Update Member" : "Add Member";

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

require_once("../classes/Member.php");
$memberObj = new Member($db);
$data      = $id ? $memberObj->getById($id) : null;

// Load countries
$countriesRes = $db->query("SELECT id, country_name FROM countries ORDER BY country_name ASC");

// Load cities for existing member's country (for edit)
$currentCountryId = $data['country_id'] ?? null;
$citiesRes = null;
if ($currentCountryId) {
    $cid = (int)$currentCountryId;
    $citiesRes = $db->query("SELECT id, city_name FROM cities WHERE country_id = {$cid} ORDER BY city_name ASC");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= $pageTitle ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Member Form" />
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

    <style>
        .member-image-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <?php require("../includes/header.php"); ?>

    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
            <a href="../index.php" class="brand-link">
                <span class="brand-text fw-light">Real Estate E-System</span>
            </a>
        </div>
        <?php include("../includes/sidebar.php"); ?>
    </aside>

    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h3><?= $pageTitle ?></h3>
                <a href="member_list.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card card-primary mb-4">
                    <div class="card-header">
                        <h4 class="mb-0"><?= $pageTitle ?></h4>
                    </div>

                    <form id="memberForm" enctype="multipart/form-data">
                        <div class="card-body">

                            <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">

                            <!-- Tabs -->
                            <ul class="nav nav-tabs mb-3" id="memberTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="personal-tab" data-bs-toggle="tab"
                                            data-bs-target="#personal" type="button" role="tab">
                                        Personal Info
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#contact" type="button" role="tab">
                                        Contact & Address
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="nominee-tab" data-bs-toggle="tab"
                                            data-bs-target="#nominee" type="button" role="tab">
                                        Nominee Info
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="account-tab" data-bs-toggle="tab"
                                            data-bs-target="#account" type="button" role="tab">
                                        Account & Status
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="memberTabContent">

                                <!-- PERSONAL INFO -->
                                <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" name="name" class="form-control" required
                                                   value="<?= htmlspecialchars($data['name'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" required
                                                   value="<?= htmlspecialchars($data['username'] ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Father/Spouse</label>
                                            <input type="text" name="sodowo" class="form-control"
                                                   value="<?= htmlspecialchars($data['sodowo'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Title (Mr/Mrs etc.)</label>
                                            <input type="text" name="title" class="form-control"
                                                   value="<?= htmlspecialchars($data['title'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">CNIC</label>
                                            <input type="text" name="cnic" class="form-control"
                                                   value="<?= htmlspecialchars($data['cnic'] ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" name="dob" class="form-control"
                                                   value="<?= htmlspecialchars($data['dob'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Business Title</label>
                                            <input type="text" name="business_title" class="form-control"
                                                   value="<?= htmlspecialchars($data['business_title'] ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Profile Image</label>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <input type="file" name="image" class="form-control" accept="image/*"
                                                       onchange="previewImage(event)">
                                            </div>
                                            <div class="ms-3">
                                                <?php if (!empty($data['image'])): ?>
                                                    <img id="imagePreview"
                                                         src="../assets/img/member_images/<?= htmlspecialchars($data['image']) ?>"
                                                         alt="Preview" class="member-image-preview">
                                                <?php else: ?>
                                                    <img id="imagePreview"
                                                         src="https://via.placeholder.com/120x120?text=No+Image"
                                                         alt="Preview" class="member-image-preview">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- CONTACT & ADDRESS -->
                                <div class="tab-pane fade" id="contact" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($data['address'] ?? '') ?></textarea>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Country</label>
                                            <select name="country_id" id="countrySelect" class="form-select" required>
                                                <option value="">Select Country</option>
                                                <?php if ($countriesRes): ?>
                                                    <?php while ($c = $countriesRes->fetch_assoc()): ?>
                                                        <option value="<?= $c['id'] ?>"
                                                            <?= isset($data['country_id']) && $data['country_id'] == $c['id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($c['country_name']) ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">City</label>
                                            <select name="city_id" id="citySelect" class="form-select" required>
                                                <option value="">Select City</option>
                                                <?php if ($citiesRes): ?>
                                                    <?php while ($ct = $citiesRes->fetch_assoc()): ?>
                                                        <option value="<?= $ct['id'] ?>"
                                                            <?= isset($data['city_id']) && $data['city_id'] == $ct['id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($ct['city_name']) ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">State</label>
                                            <input type="text" name="state" class="form-control"
                                                   value="<?= htmlspecialchars($data['state'] ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control"
                                                   value="<?= htmlspecialchars($data['phone'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                   value="<?= htmlspecialchars($data['email'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">RWA</label>
                                            <input type="text" name="rwa" class="form-control"
                                                   value="<?= htmlspecialchars($data['rwa'] ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Create Date</label>
                                        <input type="text" name="create_date" class="form-control"
                                               placeholder="e.g. 2025-01-01"
                                               value="<?= htmlspecialchars($data['create_date'] ?? '') ?>">
                                    </div>
                                </div>

                                <!-- NOMINEE INFO -->
                                <div class="tab-pane fade" id="nominee" role="tabpanel">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nominee Name</label>
                                            <input type="text" name="nomineename" class="form-control"
                                                   value="<?= htmlspecialchars($data['nomineename'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nominee CNIC</label>
                                            <input type="text" name="nomineecnic" class="form-control"
                                                   value="<?= htmlspecialchars($data['nomineecnic'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- ACCOUNT & STATUS -->
                                <div class="tab-pane fade" id="account" role="tabpanel">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                   placeholder="<?= $id ? 'Leave blank to keep existing' : '' ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Member Type</label>
                                            <input type="text" name="mtype" class="form-control"
                                                   value="<?= htmlspecialchars($data['mtype'] ?? '') ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Login Status</label>
                                            <input type="text" name="login_status" class="form-control"
                                                   value="<?= htmlspecialchars($data['login_status'] ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                <?php
                                                $statusVal = $data['status'] ?? '';
                                                $options = ['Active', 'Inactive', 'Blocked'];
                                                ?>
                                                <option value="">Select Status</option>
                                                <?php foreach ($options as $opt): ?>
                                                    <option value="<?= $opt ?>"
                                                        <?= $statusVal === $opt ? 'selected' : '' ?>>
                                                        <?= $opt ?>
                                                    </option>
                                                <?php endforeach; ?>
                                                <?php if ($statusVal && !in_array($statusVal, $options)): ?>
                                                    <option value="<?= htmlspecialchars($statusVal) ?>" selected>
                                                        <?= htmlspecialchars($statusVal) ?>
                                                    </option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">FP (Fingerprint / Extra Info)</label>
                                            <textarea name="fp" class="form-control" rows="3"><?= htmlspecialchars($data['fp'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- /.tab-content -->

                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary"><?= $btnText ?></button>
                            <a href="member_list.php" class="btn btn-secondary ms-2">Cancel</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </main>

    <?php include("../includes/footer.php"); ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="../js/adminlte.js"></script>

<script>
function previewImage(event) {
    const img = document.getElementById('imagePreview');
    if (event.target.files && event.target.files[0]) {
        img.src = URL.createObjectURL(event.target.files[0]);
    }
}

// Load cities when country changes
document.getElementById('countrySelect').addEventListener('change', function () {
    const countryId = this.value;
    const citySelect = document.getElementById('citySelect');

    citySelect.innerHTML = '<option value="">Loading...</option>';

    if (!countryId) {
        citySelect.innerHTML = '<option value="">Select Country First</option>';
        return;
    }

    fetch('api_member.php?action=get_cities&country_id=' + countryId)
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                let options = '<option value="">Select City</option>';
                res.data.forEach(c => {
                    options += `<option value="${c.id}">${c.city_name}</option>`;
                });
                citySelect.innerHTML = options;
            } else {
                citySelect.innerHTML = '<option value="">No cities found</option>';
            }
        })
        .catch(err => {
            console.error(err);
            citySelect.innerHTML = '<option value="">Error loading cities</option>';
        });
});

// Submit form via fetch (AJAX)
document.getElementById('memberForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const fd = new FormData(this);
    fd.append('action', <?= $id ? "'update'" : "'add'" ?>);

    fetch('api_member.php', {
        method: 'POST',
        body: fd
    })
    .then(r => r.json())
    .then(res => {
        alert(res.message);
        if (res.success) {
            window.location.href = 'member_list.php';
        }
    })
    .catch(err => alert('Error: ' + err.message));
});
</script>

</body>
</html>
