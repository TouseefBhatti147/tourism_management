<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

require_once("../classes/MemberPlot.php");

// DB Connection
$db = new mysqli("localhost","root","","rdlpk_db1");
if($db->connect_error){ die("DB Connection Failed"); }

$mpObj = new MemberPlot($db);

$id = $_GET['id'] ?? null;
$record = $id ? $mpObj->getById((int)$id) : null;

// Logged user → store silently
$loggedUid = $_SESSION['user_id'] ?? 0;

// Edit Mode Pre values
$editProjectId = $record['project_id'] ?? '';
$editSectorId  = $record['sector_id'] ?? '';
$editStreetId  = $record['street_id'] ?? '';
$editPlotId    = $record['plot_id'] ?? '';
$editMemberId  = $record['member_id'] ?? '';
$editInsPlan   = $record['insplan'] ?? '';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title><?= $id ? "Edit Assignment" : "Assign Plot to Member" ?></title>
<link rel="stylesheet" href="../css/adminlte.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

<?php include("../includes/header.php"); ?>
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <?php include("../includes/sidebar.php"); ?>
</aside>

<main class="app-main">
<div class="app-content">

    <div class="app-content-header d-flex justify-content-between align-items-center">
        <h3><?= $id ? "Update Member Plot" : "Assign Plot to Member" ?></h3>
        <a href="memberplot_list.php" class="btn btn-secondary">Back</a>
    </div>

    <div class="card">
    <div class="card-body">

    <form action="api_memberplot.php" method="post">

        <input type="hidden" name="action" value="<?= $id ? "update":"add" ?>">
        <input type="hidden" name="id" value="<?= $record['id'] ?? '' ?>">
        <input type="hidden" name="uid" value="<?= $loggedUid ?>"> <!-- HIDDEN AS REQUESTED -->

        <div class="row g-3 mb-3">

            <!-- PROJECT -->
            <div class="col-md-3">
                <label class="form-label">Project</label>
                <select id="projectSelect" class="form-select" required>
                    <option value="">Select Project</option>
                </select>
            </div>

            <!-- SECTOR -->
            <div class="col-md-3">
                <label class="form-label">Sector</label>
                <select id="sectorSelect" class="form-select" disabled required>
                    <option value="">Select Sector</option>
                </select>
            </div>

            <!-- STREET -->
            <div class="col-md-3">
                <label class="form-label">Street</label>
                <select id="streetSelect" class="form-select" disabled required>
                    <option value="">Select Street</option>
                </select>
            </div>

            <!-- PLOT -->
            <div class="col-md-3">
                <label class="form-label">Plot</label>
                <select id="plotSelect" name="plot_id" class="form-select" disabled required>
                    <option value="">Select Plot</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">

            <!-- MEMBER -->
            <div class="col-md-4">
                <label class="form-label">Member</label>
                <select name="member_id" id="memberSelect" class="form-select" required>
                    <option value="">Select Member</option>
                </select>
            </div>

            <!-- DATE -->
            <div class="col-md-4">
                <label class="form-label">Create Date</label>
                <input type="datetime-local" name="create_date" class="form-control"
                       value="<?= !empty($record['create_date']) ? date('Y-m-d\TH:i',strtotime($record['create_date'])):'' ?>">
            </div>

            <!-- NOI -->
            <div class="col-md-2">
                <label class="form-label">NOI</label>
                <input type="number" name="noi" class="form-control" value="<?= $record['noi'] ?? 1 ?>">
            </div>

            <!-- INSTALLMENT PLAN DROPDOWN (AUTO BASED ON PLOT) -->
            <div class="col-md-2">
                <label class="form-label">Installment Plan</label>
                <select name="insplan" id="insplan" class="form-select" required>
                    <option value="">Select Installment Plan</option>
                </select>
            </div>

        </div>

        <button class="btn btn-primary"><?= $id ? "Update" : "Save" ?></button>

    </form>

    </div></div>
</div></main>

<?php include("../includes/footer.php"); ?>
</div>


<script>
// ------------------ Load Projects ------------------
function loadProjects(sel = "") {
    $.getJSON("../projects/api_projects.php", function (res) {
        const $p = $("#projectSelect");
        $p.empty().append("<option value=''>Select Project</option>");

        if (res.success && res.data.length > 0) {
            res.data.forEach(x => {
                const selected = (String(x.id) === String(sel)) ? "selected" : "";
                $p.append(`<option value="${x.id}" ${selected}>${x.project_name}</option>`);
            });
        }

        // If editing, continue chain
        <?php if ($editProjectId): ?>
        if (sel) {
            loadSectors(sel, "<?= addslashes($editSectorId) ?>");
        }
        <?php endif; ?>
    });
}

// ------------------ Load Sectors ------------------
function loadSectors(pid, sel = "") {
    if (!pid) {
        $("#sectorSelect").prop("disabled", true).html("<option value=''>Select Sector</option>");
        $("#streetSelect").prop("disabled", true).html("<option value=''>Select Street</option>");
        $("#plotSelect").prop("disabled", true).html("<option value=''>Select Plot</option>");
        return;
    }

    $.getJSON(`../sectors/api_sectors.php?project_id=${pid}`, function (res) {
        const $s = $("#sectorSelect");
        $s.prop("disabled", false).empty().append("<option value=''>Select Sector</option>");

        if (res.success && res.data.length > 0) {
            res.data.forEach(sec => {
                const selected = (String(sec.sector_id) === String(sel)) ? "selected" : "";
                $s.append(`<option value="${sec.sector_id}" ${selected}>${sec.sector_name}</option>`);
            });
        }

        <?php if ($editSectorId): ?>
        if (sel) {
            loadStreets(pid, sel, "<?= addslashes($editStreetId) ?>");
        }
        <?php endif; ?>
    });
}

// ------------------ Load Streets ------------------
function loadStreets(pid, sid, sel = "") {
    if (!pid || !sid) {
        $("#streetSelect").prop("disabled", true).html("<option value=''>Select Street</option>");
        $("#plotSelect").prop("disabled", true).html("<option value=''>Select Plot</option>");
        return;
    }

    $.getJSON(`../streets/api_streets.php?project_id=${pid}&sector_id=${sid}`, function (res) {
        const $st = $("#streetSelect");
        $st.prop("disabled", false).empty().append("<option value=''>Select Street</option>");

        if (res.success && res.data.length > 0) {
            res.data.forEach(st => {
                const selected = (String(st.id) === String(sel)) ? "selected" : "";
                $st.append(`<option value="${st.id}" ${selected}>${st.street}</option>`);
            });
        }

        <?php if ($editStreetId): ?>
        if (sel) {
            loadPlots(pid, sid, sel, "<?= addslashes($editPlotId) ?>");
        }
        <?php endif; ?>
    });
}

// ------------------ Load Plots ------------------
function loadPlots(pid, sid, stid, sel = "") {
    if (!pid || !sid || !stid) {
        $("#plotSelect").prop("disabled", true).html("<option value=''>Select Plot</option>");
        return;
    }

    $.getJSON(
        `../plots/api_plots_dropdown.php?project_id=${pid}&sector_id=${sid}&street_id=${stid}`,
        function (res) {
            const $pl = $("#plotSelect");
            $pl.prop("disabled", false).empty().append("<option value=''>Select Plot</option>");

            if (res.success && res.data.length > 0) {
                res.data.forEach(pl => {
                    const selected = (String(pl.id) === String(sel)) ? "selected" : "";
                    const label = pl.plot_detail_address + " (" + pl.plot_size + ")";
                    $pl.append(`<option value="${pl.id}" ${selected}>${label}</option>`);
                });
            }

            <?php if ($editPlotId): ?>
            if (sel) {
                loadPlans(sel, "<?= addslashes($editInsPlan) ?>");
            }
            <?php endif; ?>
        }
    );
}

// ------------------ Load Members ------------------
function loadMembers(sel = "") {
    $.getJSON("../members/api_members_dropdown.php", function (res) {
        const $m = $("#memberSelect");
        $m.empty().append("<option value=''>Select Member</option>");

        if (res.success && res.data.length > 0) {
            res.data.forEach(m => {
                const selected = (String(m.id) === String(sel)) ? "selected" : "";
                const label = m.name + (m.username ? " (" + m.username + ")" : "");
                $m.append(`<option value="${m.id}" ${selected}>${label}</option>`);
            });
        }
    });
}

// -------------- Load Installment Plans --------------
function loadPlans(plotId, sel = "") {

    if (!plotId) return;

    $.getJSON(`../plots/api_get_plot.php?id=${plotId}`, p => {

        if (!p.success || !p.data) return;

        let sizeCat = p.data.size_cat_id;  // FINAL — using only size category

        $.getJSON(
            `../installment_plan/api_installment_plan_fetch.php?size_cat_id=${sizeCat}`, 
            plans => {

                console.log("Plans Loaded =>", plans); // Debug viewer

                let ins = $("#insplan");
                ins.empty().append("<option value=''>Select Installment Plan</option>");

                if (plans.success && plans.data.length > 0) {
                    plans.data.forEach(x => {
                        ins.append(
                            `<option value='${x.id}' ${x.id==sel?"selected":""}>
                                ${x.description} (TNO ${x.tno})
                            </option>`
                        );
                    });
                } else {
                    ins.append("<option value=''>No Installment Plan Found</option>");
                }
            }
        );
    });
}


// ===================== INIT & EVENTS =====================
$(document).ready(function () {
    // Initial loads
    loadProjects("<?= addslashes($editProjectId) ?>");
    loadMembers("<?= addslashes($editMemberId) ?>");

    // Project change -> enable sector
    $("#projectSelect").on("change", function () {
        const pid = $(this).val();
        loadSectors(pid);
        $("#sectorSelect").prop("disabled", false);
        $("#streetSelect").prop("disabled", true).html("<option value=''>Select Street</option>");
        $("#plotSelect").prop("disabled", true).html("<option value=''>Select Plot</option>");
        $("#insplan").empty().append("<option value=''>Select Installment Plan</option>");
    });

    // Sector change -> enable street
    $("#sectorSelect").on("change", function () {
        const pid = $("#projectSelect").val();
        const sid = $(this).val();
        loadStreets(pid, sid);
        $("#streetSelect").prop("disabled", false);
        $("#plotSelect").prop("disabled", true).html("<option value=''>Select Plot</option>");
        $("#insplan").empty().append("<option value=''>Select Installment Plan</option>");
    });

    // Street change -> enable plot
    $("#streetSelect").on("change", function () {
        const pid = $("#projectSelect").val();
        const sid = $("#sectorSelect").val();
        const stid = $(this).val();
        loadPlots(pid, sid, stid);
        $("#plotSelect").prop("disabled", false);
        $("#insplan").empty().append("<option value=''>Select Installment Plan</option>");
    });

    // Plot change -> load installment plans
    $("#plotSelect").on("change", function () {
        const plotId = $(this).val();
        loadPlans(plotId);
    });

    // If editing existing record -> rebuild full chain & plans
    <?php if ($editProjectId && $editSectorId && $editStreetId && $editPlotId): ?>
        loadSectors("<?= addslashes($editProjectId) ?>", "<?= addslashes($editSectorId) ?>");
        loadStreets("<?= addslashes($editProjectId) ?>", "<?= addslashes($editSectorId) ?>", "<?= addslashes($editStreetId) ?>");
        loadPlots("<?= addslashes($editProjectId) ?>", "<?= addslashes($editSectorId) ?>", "<?= addslashes($editStreetId) ?>", "<?= addslashes($editPlotId) ?>");
        loadPlans("<?= addslashes($editPlotId) ?>", "<?= addslashes($editInsPlan) ?>");
    <?php endif; ?>
});
</script>


</body>
</html>
