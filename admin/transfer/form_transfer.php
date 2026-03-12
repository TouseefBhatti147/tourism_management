<?php
session_start();
$db = new mysqli("localhost","root","","rdlpk_db1");
if($db->connect_error){ die("DB error"); }

$loggedUid = $_SESSION['user_id'] ?? 0;
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>Transfer Plot</title>

<?php include("../../admin/includes/headerLinks.php"); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

<?php include("../../admin/includes/header.php"); ?>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <?php include("../../admin/includes/sidebar.php"); ?>
</aside>

<main class="app-main">
<div class="app-content">

<!-- PAGE HEADER -->
<div class="app-content-header d-flex justify-content-between align-items-center">
    <h3>Transfer Plot</h3>
    <a href="transfer_list.php" class="btn btn-secondary">Back</a>
</div>

<div class="card">
<div class="card-body">

<form id="transferForm">

<input type="hidden" name="action" value="add">
<input type="hidden" name="uid" value="<?= $loggedUid ?>">

<!-- This hidden field will store OWNER ID -->
<input type="hidden" name="transferfrom_id" id="fromHidden">


<!-- ROW 1 : Project / Sector / Street / Plot -->
<div class="row g-3 mb-3">

    <div class="col-md-3">
        <label class="form-label">Project</label>
        <select id="projectSelect" class="form-select" required>
            <option value="">Select Project</option>
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Sector</label>
        <select id="sectorSelect" class="form-select" disabled required>
            <option value="">Select Sector</option>
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Street</label>
        <select id="streetSelect" class="form-select" disabled required>
            <option value="">Select Street</option>
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Plot</label>
        <select name="plot_id" id="plotSelect" class="form-select" disabled required>
            <option value="">Select Plot</option>
        </select>
    </div>

</div>


<!-- ROW 2 : Transfer From / Transfer To / Date -->
<div class="row g-3 mb-3">

    <div class="col-md-4">
        <label class="form-label">Transfer From (Owner)</label>
        <select id="fromSelect" class="form-select" disabled>
            <option value="">Select Owner</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Transfer To</label>
        <select name="transferto_id" id="toSelect" class="form-select" required>
            <option value="">Select New Buyer</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Transfer Date</label>
        <input type="date" name="create_date" class="form-control" value="<?= date('Y-m-d') ?>">
    </div>

</div>

<button class="btn btn-primary">Save Transfer</button>

</form>

</div>
</div>

</div>
</main>

<?php include("../../admin/includes/footer.php"); ?>
</div>

<?php include("../../admin/includes/scripts.php"); ?>


<script>

/* ----------------------------------------------------------
   LOAD PROJECTS
---------------------------------------------------------- */
function loadProjects() {
$.getJSON("../projects/api_projects.php", res => {
        let p = $("#projectSelect");
        p.empty().append("<option value=''>Select Project</option>");
        res.data.forEach(x => {
            p.append(`<option value="${x.id}">${x.project_name}</option>`);
        });
    });
}

/* ----------------------------------------------------------
   LOAD SECTORS
---------------------------------------------------------- */
function loadSectors(pid){
    $.getJSON(`../sectors/api_sectors.php?project_id=${pid}`, res => {
        let s = $("#sectorSelect");
        s.prop("disabled", false).empty().append("<option value=''>Select Sector</option>");
        res.data.forEach(x => {
            s.append(`<option value="${x.sector_id}">${x.sector_name}</option>`);
        });
    });
}

/* ----------------------------------------------------------
   LOAD STREETS
---------------------------------------------------------- */
function loadStreets(pid, sid){
    $.getJSON(`../streets/api_streets.php?project_id=${pid}&sector_id=${sid}`, res => {
        let st = $("#streetSelect");
        st.prop("disabled", false).empty().append("<option value=''>Select Street</option>");
        res.data.forEach(x => {
            st.append(`<option value="${x.id}">${x.street}</option>`);
        });
    });
}

/* ----------------------------------------------------------
   LOAD PLOTS (Alotted only by status field)
---------------------------------------------------------- */
function loadPlots(pid, sid, stid){
    $.getJSON(
        `../plots/api_plots_dropdown.php?project_id=${pid}&sector_id=${sid}&street_id=${stid}&status=Allotted`,
        res => {
            let p = $("#plotSelect");
            p.prop("disabled", false).empty().append("<option value=''>Select Plot</option>");
            res.data.forEach(x => {
                p.append(`<option value="${x.id}">${x.plot_detail_address} (${x.plot_size})</option>`);
            });
        }
    );
}

/* ----------------------------------------------------------
   LOAD OWNER OF SELECTED PLOT
---------------------------------------------------------- */
$("#plotSelect").on("change", function() {
    let plotId = $(this).val();

    if (!plotId) return;

    $.getJSON(`../plots/api_plot_owner.php?plot_id=${plotId}`, function(res) {

        if (res.success) {

            // Fill owner dropdown (disabled)
            $("#fromSelect")
                .empty()
                .append(`<option value="${res.owner_id}">${res.owner_name}</option>`)
                .prop("disabled", true);

            // Set hidden field for submission
            $("#fromHidden").val(res.owner_id);

        } else {

            $("#fromSelect")
                .empty()
                .append("<option>No owner found</option>")
                .prop("disabled", true);

            $("#fromHidden").val("");
        }
    });

});


/* ----------------------------------------------------------
   LOAD MEMBERS (for Transfer To only)
---------------------------------------------------------- */
function loadMembers(){
    $.getJSON("../members/api_members_dropdown.php", res => {
        res.data.forEach(x => {
            $("#toSelect").append(`<option value="${x.id}">${x.name}</option>`);
        });
    });
}


/* ----------------------------------------------------------
   SAVE TRANSFER
---------------------------------------------------------- */
$("#transferForm").on("submit", function(e){
    e.preventDefault();

    $.post("api_transfer.php", $(this).serialize(), function(res){
        alert(res.message);
        if(res.success){
            window.location.href = "transfer_list.php";
        }
    }, "json");
});


/* ----------------------------------------------------------
   INIT
---------------------------------------------------------- */
$(function(){
    loadProjects();
    loadMembers();

    $("#projectSelect").on("change", function(){
        loadSectors($(this).val());
    });

    $("#sectorSelect").on("change", function(){
        loadStreets($("#projectSelect").val(), $(this).val());
    });

    $("#streetSelect").on("change", function(){
        loadPlots($("#projectSelect").val(), $("#sectorSelect").val(), $(this).val());
    });

});

</script>

</body>
</html>
