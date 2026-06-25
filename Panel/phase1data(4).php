<?php
session_start();

/* 🔒 Login check */
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}

/* 🔐 Role check */
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'superadmin') {

    $currentStatus = $_SESSION['status'] ?? 'Unknown';

    echo "
    <div style='
        margin: 80px auto;
        max-width: 500px;
        padding: 25px;
        border-radius: 10px;
        background: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
        font-family: Arial;
        text-align: center;
    '>
        <h3>Access Denied 🚫</h3>
        <p>
            Aapka status <strong>{$currentStatus}</strong> hai.<br>
            Aapko is page ka access nahi hai.
        </p>
        <a href='dashboard.php' style='
            display:inline-block;
            margin-top:15px;
            padding:8px 15px;
            background:#0f172a;
            color:#fff;
            text-decoration:none;
            border-radius:5px;
        '>Go Back</a>
    </div>";
    exit();
}

include 'head.php';
include 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>


<style>
.badge-success {
    background-color: #28a745;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}
.badge-danger {
    background-color: #dc3545;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
}
.modal-background {
    backdrop-filter: blur(5px);
}
</style>

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Submission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Player Registrations</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">Registered Players</h6>
        <hr />



        <!-- Table Card -->
        <div class="card bg">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Name</th>
                                <th>Reg. Code</th>
                                
                                <th>Age</th>
                                <th>Role</th>
                                <th>Reg Date</th>
                                <th>Mobile</th>
                                <th>Mail Sent</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Email</th>
                                <th>Reference</th>
                                <th>Source</th>
                                <th>Status</th>
                                 <th>Action</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                           <?php
// Initialize variables
$datef = $_POST['datef'] ?? '';
$datel = $_POST['datel'] ?? '';
$searchText = trim($_POST['universal'] ?? '');
$stateFilter = $_POST['state'] ?? '';
$playerFilter = $_POST['player'] ?? '';
$statusFilter = $_POST['status'] ?? '';
$filterApplied = false;
$filterNotice = [];

// Base query
$sql = "SELECT * FROM register WHERE 1";

// Apply filters
if (!empty($datef)) {
    $sql .= " AND DATE(`date`) >= '$datef'";
    $filterNotice[] = "From <strong>$datef</strong>";
    $filterApplied = true;
}
if (!empty($datel)) {
    $sql .= " AND DATE(`date`) <= '$datel'";
    $filterNotice[] = "To <strong>$datel</strong>";
    $filterApplied = true;
}
if (!empty($searchText)) {
    $escapedSearch = $con->real_escape_string($searchText);
    $sql .= " AND (
        name LIKE '%$escapedSearch%' OR
        reg LIKE '%$escapedSearch%' OR
        email LIKE '%$escapedSearch%' OR
        mobile LIKE '%$escapedSearch%' OR
        state LIKE '%$escapedSearch%' OR
        ref LIKE '%$escapedSearch%' OR
        player LIKE '%$escapedSearch%'
    )";
    $filterNotice[] = "Search: <strong>" . htmlspecialchars($searchText) . "</strong>";
    $filterApplied = true;
}
if (!empty($stateFilter)) {
    $sql .= " AND state = '" . $con->real_escape_string($stateFilter) . "'";
    $filterNotice[] = "State: <strong>" . htmlspecialchars($stateFilter) . "</strong>";
    $filterApplied = true;
}
if (!empty($playerFilter)) {
    $sql .= " AND player = '" . $con->real_escape_string($playerFilter) . "'";
    $filterNotice[] = "Role: <strong>" . htmlspecialchars($playerFilter) . "</strong>";
    $filterApplied = true;
}
if (!empty($statusFilter)) {
    $sql .= " AND status = '" . $con->real_escape_string($statusFilter) . "'";
    $filterNotice[] = "Status: <strong>" . htmlspecialchars($statusFilter) . "</strong>";
    $filterApplied = true;
}

// $sql .= " ORDER BY 
//     CASE 
//         WHEN `date` IS NULL OR `date` = '' THEN 1 
//         ELSE 0 
//     END,
//     `up` DESC,
//     `created_at` DESC 
//     LIMIT 3000";
$sql .= " ORDER BY 
    `up` DESC, 
    `created_at` DESC 
    LIMIT 3000";
$result = $con->query($sql);

// Role short form
$roleShorts = [
    'Batsman' => 'BAT',
    'Bowler' => 'BWL',
    'All Rounder' => 'AR',
    'Wicketkeeper/Batsman' => 'WK',
];
?>

<div class="search-cont mb-3">
    <form method="post" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; background: #f9f9f9; padding: 15px; border-radius: 6px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
        <input type="date" name="datef" value="<?= htmlspecialchars($datef) ?>" style="flex: 1 1 150px; padding: 5px;">
        <input type="date" name="datel" value="<?= htmlspecialchars($datel) ?>" style="flex: 1 1 150px; padding: 5px;">
        <input type="text" name="universal" placeholder="Search by Name, Reg Code, etc." value="<?= htmlspecialchars($searchText) ?>" style="flex: 2 1 200px; padding: 5px;">

        <select name="state" style="flex: 1 1 150px; padding: 5px;">
            <option value="">All States</option>
            <?php
            $stateRes = $con->query("SELECT DISTINCT state FROM register WHERE state IS NOT NULL AND state != '' ORDER BY state");
            while ($s = $stateRes->fetch_assoc()) {
                $sel = ($s['state'] === $stateFilter) ? 'selected' : '';
                echo "<option value=\"{$s['state']}\" $sel>{$s['state']}</option>";
            }
            ?>
        </select>

        <select name="player" style="flex: 1 1 150px; padding: 5px;">
            <option value="">All Roles</option>
            <?php
            $roles = ["Batsman", "Bowler", "All Rounder", "Wicketkeeper/Batsman"];
            foreach ($roles as $role) {
                $sel = ($role === $playerFilter) ? 'selected' : '';
                echo "<option value=\"$role\" $sel>$role</option>";
            }
            ?>
        </select>

        <select name="status" style="flex: 1 1 150px; padding: 5px;">
            <option value="">All Statuses</option>
            <option value="Success" <?= $statusFilter == 'Success' ? 'selected' : '' ?>>Success</option>
            <option value="Pending" <?= $statusFilter == 'Pending' ? 'selected' : '' ?>>Pending</option>
        </select>

        <input type="submit" value="Apply Filter" class="btn btn-primary btn-sm" style="flex: 0 0 auto; padding: 6px 12px;">

        <?php if ($filterApplied): ?>
            <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-danger btn-sm" style="flex: 0 0 auto; padding: 6px 12px;">Clear Filter</a>
        <?php endif; ?>
    </form>
</div>

<!-- Filter Applied Notice -->
<?php if (!empty($filterNotice)): ?>
    <div class="alert alert-info"><?= implode(' &nbsp;|&nbsp; ', $filterNotice) ?></div>
<?php endif; ?>

<!-- Table Rows -->
<?php
if ($result && $result->num_rows > 0) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $shortRole = $roleShorts[$row['player']] ?? $row['player'];

// Status Button and Action Buttons
$statusButton = '';
$actionButtons = '';
$isSuccess = $row['status'] === 'Success';

if ($isSuccess) {
    $statusButton = '<button class="btn btn-success btn-sm" disabled>Success</button>';
} else {
    $statusButton = '<a href="../send.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm" onclick="return confirm(\'Are you sure you want to mark this as Success?\')">Mark Success</a>';
    $actionButtons = '<button class="btn btn-danger btn-sm delete-btn" data-id="' . $row['id'] . '">Delete</button>';
}

echo "<tr>
    <td>" . ++$count . "</td>
    <td>" . htmlspecialchars($row['name'] ?? '', ENT_QUOTES) . "</td>
    <td>
        <a href=\"#\" class=\"openModal\" data-details='" . htmlspecialchars(json_encode($row), ENT_QUOTES) . "'>
            " . htmlspecialchars($row['reg'] ?? '', ENT_QUOTES) . "
        </a>
    </td>
    <td>" . htmlspecialchars($row['age'] ?? '', ENT_QUOTES) . "</td>
    <td>" . htmlspecialchars($shortRole ?? '', ENT_QUOTES) . "</td>
    <td>" . htmlspecialchars($row['date'] ?? '', ENT_QUOTES) . "</td>
    <td>" . htmlspecialchars($row['mobile'] ?? '', ENT_QUOTES) . "</td>
    <td>" . ($row['mailsent'] ? 'Yes' : 'No') . "</td>
    <td>" . htmlspecialchars($row['state'] ?? '', ENT_QUOTES) . "</td>
     <td>" . htmlspecialchars($row['city'] ?? '', ENT_QUOTES) . "</td>
     <td>" . htmlspecialchars($row['email'] ?? '', ENT_QUOTES) . "</td>
    <td>" . htmlspecialchars($row['ref'] ?? '', ENT_QUOTES) . "</td>
    <td>" . htmlspecialchars($row['source'] ?? '', ENT_QUOTES) . "</td>
    <td>" . $statusButton . "</td>
    <td>" . $actionButtons . "</td>
</tr>";
    }
} else {
    echo "<tr><td colspan='14' style='text-align:center;'>No Results Found</td></tr>";
}
$con->close();
?>

                        <!-- PHP code block to render rows goes here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="playerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-background" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Player Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this player's record?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-background" role="document">
    <div class="modal-content">
      <form method="post" action="update_player.php">
        <div class="modal-header">
          <h5 class="modal-title">Edit Player Details</h5>
          <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body" id="editModalContent"></div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Main logic for opening the view modal (unchanged)
    document.querySelectorAll('.openModal').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const data = JSON.parse(this.dataset.details);

            // ... (View Modal HTML generation logic remains here) ...

            const isSuccess = data.status === 'Success';
            const modalStyle = isSuccess
                ? 'background-color:#e6ffe6; border: 2px solid #28a745; padding:15px; border-radius:10px;'
                : '';

            let html = `<div style="${modalStyle}"><table class="table table-bordered">`;
            const datetime = data.created_at ?? '';
            let formattedDate = '', formattedTime = '';

            if (datetime) {
                const dt = new Date(datetime);
                formattedDate = dt.toLocaleDateString('en-IN', { day: '2-digit', month: '2-digit', year: 'numeric' });
                formattedTime = dt.toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit', hour12: true });
            }

            html += `<tr><th>Reg. Code</th><td><span style="font-weight:bold; font-size:16px; color:#007bff;">${data.reg ?? ''}</span></td></tr>`;
            html += `<tr><th>Name</th><td>${data.name ?? ''}</td></tr>`;
            html += `<tr><th>Age</th><td>${data.age ?? ''}</td></tr>`;
            html += `<tr><th>Role</th><td>${data.player ?? ''}</td></tr>`;
            html += `<tr><th>Registration Date</th><td>${formattedDate} at ${formattedTime}</td></tr>`;
            html += `<tr><th>Payment Date</th><td>${data.date ?? ''}</td></tr>`;
            html += `<tr><th>Email</th><td>${data.email ?? ''}</td></tr>`;
            html += `<tr><th>Mobile</th><td>${data.mobile ?? ''}</td></tr>`;
            html += `<tr><th>Mail Sent</th><td>${data.mailsent == 1 ? 'Yes' : 'No'}</td></tr>`;
            html += `<tr><th>State</th><td>${data.state ?? ''}</td></tr>`;
            html += `<tr><th>City</th><td>${data.city ?? ''}</td></tr>`;
            html += `<tr><th>Reference</th><td>${data.ref ?? ''}</td></tr>`;
            html += `<tr><th>Source</th><td>${data.source ?? ''}</td></tr>`;
            html += `<tr><th>Status</th><td><strong style="color: ${isSuccess ? 'green' : 'red'}">${data.status ?? ''}</strong></td></tr>`;
            html += '</table>';

            html += `<div class="text-end mt-3">`;

            if (isSuccess) {
                html += `<a href="../pdf1.php?reg=${encodeURIComponent(data.reg)}" target="_blank" class="btn btn-success me-2">
                            <i class="bx bxs-file-pdf"></i> Download PDF
                          </a>`;
            }

            html += `<button class="btn btn-warning" id="editButton">
                        <i class="bx bxs-edit"></i> Edit
                      </button>`;
            html += `</div></div>`;

            document.getElementById('modalContent').innerHTML = html;
            const playerModal = new bootstrap.Modal(document.getElementById('playerModal'));
            playerModal.show();

            // Handle the edit button click after the modal is shown
            document.getElementById('editButton').addEventListener('click', function() {
                playerModal.hide(); // Hide the view modal
                window.openEditModal(data); // Call the function to open the edit modal
            });
        });
    });

    // New logic for Delete button (unchanged)
    let playerIdToDelete;
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            playerIdToDelete = this.dataset.id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (playerIdToDelete) {
            // ... (Delete logic remains here) ...
            fetch('delete_player.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + playerIdToDelete,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Record deleted successfully!');
                    location.reload(); // Reload the page to show the updated table
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred during deletion.');
            });
        }
    });
});


/**
 * यह फ़ंक्शन Edit Modal के State ड्रॉपडाउन के बदलने पर City ड्रॉपडाउन को डायनेमिक रूप से पॉपुलेट (populate) करता है।
 * @param {string} initialState - डेटा से लोड करने के लिए प्रारंभिक State.
 * @param {string} initialCity - डेटा से लोड करने के लिए प्रारंभिक City.
 */
function setupDynamicCityLoad(initialState, initialCity) {
    const stateDropdown = $("#editState");
    const cityDropdown = $("#editCity");

    // 1. City ड्रॉपडाउन को पॉपुलेट करने के लिए एक reusable फ़ंक्शन
    const populateCityDropdown = (selectedState, selectedCity) => {
        cityDropdown.empty().append('<option value="">Select City</option>');
        
        if (selectedState) {
            // AJAX request to fetch city data. Path updated to "../city_data.json"
            $.getJSON("../city_data.json", function(cityData) { 
                const cities = cityData[selectedState];

                if (cities) {
                    $.each(cities, function(index, city) {
                        const isSelected = city === selectedCity ? "selected" : "";
                        cityDropdown.append(
                            $("<option></option>").attr("value", city).prop("selected", isSelected).text(city)
                        );
                    });
                } else if (selectedCity) {
                    // अगर State में कोई City नहीं है, लेकिन City डेटा मौजूद है
                    cityDropdown.append($("<option></option>").attr("value", selectedCity).prop("selected", true).text(selectedCity));
                }
            }).fail(function() {
                 console.error("Error loading city_data.json. Check path!");
                 // यदि JSON लोड नहीं होता है, तो केवल पहले से चयनित City को दिखाएं
                 if (selectedCity) {
                     cityDropdown.empty().append($("<option></option>").attr("value", selectedCity).prop("selected", true).text(selectedCity));
                 }
            });
        } else if (selectedCity) {
            // यदि कोई State चयनित नहीं है, तो भी पहले से चयनित City को दिखाएं
            cityDropdown.empty().append($("<option></option>").attr("value", selectedCity).prop("selected", true).text(selectedCity));
        }
    };

    // 2. State बदलने पर City ड्रॉपडाउन को अपडेट करें (Change Event)
    stateDropdown.off('change').on('change', function() {
        const selectedState = $(this).val();
        populateCityDropdown(selectedState, ''); // नया State, City खाली
    });
    
    // 3. Modal लोड होने पर (Initial Load)
    // तुरंत प्रारंभिक State और City के साथ ड्रॉपडाउन पॉपुलेट करें
    if (initialState) {
        populateCityDropdown(initialState, initialCity);
    } else if (initialCity) {
        // यदि State खाली है लेकिन City है, तो City को एक विकल्प के रूप में जोड़ें
        cityDropdown.empty().append($("<option></option>").attr("value", initialCity).prop("selected", true).text(initialCity));
    }
}


// The openEditModal function is defined globally to be accessible from the DOMContentLoaded handler
window.openEditModal = function(data) {
    const html = `
        <input type="hidden" name="id" value="${data.id}">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="${data.name}" class="form-control" required>
        </div>
        <div class="form-group mt-2">
            <label>Age Group</label>
            <select name="age" id="age" class="form-control" required>
                <option value="">Your Category</option>
                <option value="Under 14" ${data.age === "Under 14" ? "selected" : ""}>Under 14</option>
                <option value="Under 16" ${data.age === "Under 16" ? "selected" : ""}>Under 16</option>
                <option value="Under 19" ${data.age === "Under 19" ? "selected" : ""}>Under 19</option>
                <option value="19 above" ${data.age === "19 above" ? "selected" : ""}>19 above</option>
                <option value="Corporate" ${data.age === "Corporate" ? "selected" : ""}>Corporate</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <label>Role</label>
            <select name="player" id="player" class="form-control" required>
                <option value="">Your Speciality</option>
                <option value="Bowler" ${data.player === "Bowler" ? "selected" : ""}>Bowler</option>
                <option value="Batsman" ${data.player === "Batsman" ? "selected" : ""}>Batsman</option>
                <option value="Wicketkeeper/Batsman" ${data.player === "Wicketkeeper/Batsman" ? "selected" : ""}>Wicketkeeper/Batsman</option>
                <option value="All Rounder" ${data.player === "All Rounder" ? "selected" : ""}>All Rounder</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <label>Reg Code</label>
            <input type="text" name="reg" value="${data.reg}" class="form-control" readonly>
        </div>
        <div class="form-group mt-2">
            <label>Email</label>
            <input type="email" name="email" value="${data.email}" class="form-control">
        </div>
        <div class="form-group mt-2">
            <label>Mobile</label>
            <input type="text" name="mobile" value="${data.mobile}" class="form-control">
        </div>
        <div class="form-group mt-2">
            <label>State</label>
            <select name="state" id="editState" class="form-control" required>
                <option value="">Select State</option>
                <option value="Andaman and Nicobar Islands" ${data.state === "Andaman and Nicobar Islands" ? "selected" : ""}>Andaman and Nicobar Islands</option>
                <option value="Andhra Pradesh" ${data.state === "Andhra Pradesh" ? "selected" : ""}>Andhra Pradesh</option>
                <option value="Arunachal Pradesh" ${data.state === "Arunachal Pradesh" ? "selected" : ""}>Arunachal Pradesh</option>
                <option value="Assam" ${data.state === "Assam" ? "selected" : ""}>Assam</option>
                <option value="Bihar" ${data.state === "Bihar" ? "selected" : ""}>Bihar</option>
                <option value="Chandigarh" ${data.state === "Chandigarh" ? "selected" : ""}>Chandigarh</option>
                <option value="Chhattisgarh" ${data.state === "Chhattisgarh" ? "selected" : ""}>Chhattisgarh</option>
                <option value="Dadra and Nagar Haveli" ${data.state === "Dadra and Nagar Haveli" ? "selected" : ""}>Dadra and Nagar Haveli</option>
                <option value="Delhi" ${data.state === "Delhi" ? "selected" : ""}>Delhi</option>
                <option value="Goa" ${data.state === "Goa" ? "selected" : ""}>Goa</option>
                <option value="Gujarat" ${data.state === "Gujarat" ? "selected" : ""}>Gujarat</option>
                <option value="Haryana" ${data.state === "Haryana" ? "selected" : ""}>Haryana</option>
                <option value="Himachal Pradesh" ${data.state === "Himachal Pradesh" ? "selected" : ""}>Himachal Pradesh</option>
                <option value="Jammu and Kashmir" ${data.state === "Jammu and Kashmir" ? "selected" : ""}>Jammu and Kashmir</option>
                <option value="Jharkhand" ${data.state === "Jharkhand" ? "selected" : ""}>Jharkhand</option>
                <option value="Karnataka" ${data.state === "Karnataka" ? "selected" : ""}>Karnataka</option>
                <option value="Kerala" ${data.state === "Kerala" ? "selected" : ""}>Kerala</option>
                <option value="Madhya Pradesh" ${data.state === "Madhya Pradesh" ? "selected" : ""}>Madhya Pradesh</option>
                <option value="Maharashtra" ${data.state === "Maharashtra" ? "selected" : ""}>Maharashtra</option>
                <option value="Manipur" ${data.state === "Manipur" ? "selected" : ""}>Manipur</option>
                <option value="Meghalaya" ${data.state === "Meghalaya" ? "selected" : ""}>Meghalaya</option>
                <option value="Mizoram" ${data.state === "Mizoram" ? "selected" : ""}>Mizoram</option>
                <option value="Nagaland" ${data.state === "Nagaland" ? "selected" : ""}>Nagaland</option>
                <option value="Odisha" ${data.state === "Odisha" ? "selected" : ""}>Odisha</option>
                <option value="Puducherry" ${data.state === "Puducherry" ? "selected" : ""}>Puducherry</option>
                <option value="Punjab" ${data.state === "Punjab" ? "selected" : ""}>Punjab</option>
                <option value="Rajasthan" ${data.state === "Rajasthan" ? "selected" : ""}>Rajasthan</option>
                <option value="Sikkim" ${data.state === "Sikkim" ? "selected" : ""}>Sikkim</option>
                <option value="Tamil Nadu" ${data.state === "Tamil Nadu" ? "selected" : ""}>Tamil Nadu</option>
                <option value="Telangana" ${data.state === "Telangana" ? "selected" : ""}>Telangana</option>
                <option value="Tripura" ${data.state === "Tripura" ? "selected" : ""}>Tripura</option>
                <option value="Uttar Pradesh" ${data.state === "Uttar Pradesh" ? "selected" : ""}>Uttar Pradesh</option>
                <option value="Uttarakhand" ${data.state === "Uttarakhand" ? "selected" : ""}>Uttarakhand</option>
                <option value="West Bengal" ${data.state === "West Bengal" ? "selected" : ""}>West Bengal</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <label>City</label>
            <select name="city" id="editCity" class="form-control" required>
                <option value="${data.city ?? ''}" selected>${data.city || 'Select City'}</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <label>Reference</label>
            <input type="text" name="ref" value="${data.ref}" class="form-control">
        </div>
    `;
    document.getElementById('editModalContent').innerHTML = html;
    new bootstrap.Modal(document.getElementById('editModal')).show();

    // Call the function to set up dynamic city loading for the new modal content
    setupDynamicCityLoad(data.state, data.city);
};
</script>




<?php include 'searchbar.php'; ?>