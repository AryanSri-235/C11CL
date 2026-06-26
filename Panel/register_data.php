<?php
session_start();
if (!isset($_SESSION['password'])) {
    header('location:../index.php');
    exit();
}

include 'head.php';
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle Update (from Modal)
if (isset($_POST['update_data'])) {
    $id    = (int) $_POST['id'];
    $name  = trim($_POST['name']  ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $city  = trim($_POST['city']  ?? '');

    $stmt = $con->prepare("UPDATE regdata SET name=?, email=?, phone=?, state=?, city=? WHERE id=?");
    $stmt->bind_param("sssssi", $name, $email, $phone, $state, $city, $id);
    $stmt->execute();
    $stmt->close();
}

// Build SQL — validate date inputs before interpolating
$search = $_POST['search_text'] ?? '';
$datef  = $_POST['datef'] ?? '';
$datel  = $_POST['datel'] ?? '';
// Allow only YYYY-MM-DD format to prevent injection via date fields
$datef = preg_match('/^\d{4}-\d{2}-\d{2}$/', $datef) ? $datef : '';
$datel = preg_match('/^\d{4}-\d{2}-\d{2}$/', $datel) ? $datel : '';
$conditions = [];

if (!empty($search)) {
    $search = $con->real_escape_string($search);
    $conditions[] = "(name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' OR state LIKE '%$search%' OR city LIKE '%$search%')";
}
if (!empty($datef) && !empty($datel)) {
    $conditions[] = "created_at BETWEEN '$datef 00:00:00' AND '$datel 23:59:59'";
} elseif (!empty($datef)) {
    $conditions[] = "created_at >= '$datef 00:00:00'";
} elseif (!empty($datel)) {
    $conditions[] = "created_at <= '$datel 23:59:59'";
}

$where = count($conditions) > 0 ? 'WHERE ' . implode(' AND ', $conditions) : '';
$sql = "SELECT * FROM regdata $where ORDER BY created_at DESC LIMIT 100";
$result = $con->query($sql);
?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Registered Users</div>
            <div class="ps-3">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">User List</li>
                </ol>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">User Records</h6>
        <hr />

        <!-- Filters -->
        <form method="post" class="row mb-3">
            <div class="col-md-2"><input type="date" name="datef" class="form-control" value="<?= $datef ?>"></div>
            <div class="col-md-2"><input type="date" name="datel" class="form-control" value="<?= $datel ?>"></div>
            <div class="col-md-4"><input type="text" name="search_text" class="form-control" placeholder="Search name, email, phone, city..." value="<?= $search ?>"></div>
            <div class="col-md-2"><input type="submit" value="Search" class="btn btn-primary w-100"></div>
            <div class="col-md-2"><a href="" class="btn btn-secondary w-100">Reset</a></div>
        </form>

        <!-- Table -->
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Date</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                  <tbody>
    <?php
    if ($result->num_rows > 0) {
        $sn = 0;
        $shown_names = []; // Array to store names that have already been shown

        while ($row = $result->fetch_assoc()) {
            if (in_array($row['name'], $shown_names)) {
                continue; // Skip this row if name is already shown
            }

            $shown_names[] = $row['name']; // Add name to shown list

            echo "<tr>
                <td>" . ++$sn . "</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['state']}</td>
                <td>{$row['city']}</td>
                <td>{$row['created_at']}</td>
                <td><button class='btn btn-sm btn-primary editBtn'
                    data-id='{$row['id']}'
                    data-name='{$row['name']}'
                    data-email='{$row['email']}'
                    data-phone='{$row['phone']}'
                    data-state='{$row['state']}'
                    data-city='{$row['city']}'
                    data-bs-toggle='modal' data-bs-target='#editModal'>Edit</button></td>
            </tr>";
        }

        if ($sn == 0) {
            echo "<tr><td colspan='8' class='text-center'>No unique names found</td></tr>";
        }
    } else {
        echo "<tr><td colspan='8' class='text-center'>No data found</td></tr>";
    }
    ?>
</tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit_id">
        <div class="mb-2">
          <label>Name</label>
          <input type="text" name="name" id="edit_name" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Email</label>
          <input type="email" name="email" id="edit_email" class="form-control">
        </div>
        <div class="mb-2">
          <label>Phone</label>
          <input type="text" name="phone" id="edit_phone" class="form-control">
        </div>
        <div class="mb-2">
          <label>State</label>
          <input type="text" name="state" id="edit_state" class="form-control">
        </div>
        <div class="mb-2">
          <label>City</label>
          <input type="text" name="city" id="edit_city" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="update_data" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Scripts -->
<script>
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('edit_id').value = btn.getAttribute('data-id');
        document.getElementById('edit_name').value = btn.getAttribute('data-name');
        document.getElementById('edit_email').value = btn.getAttribute('data-email');
        document.getElementById('edit_phone').value = btn.getAttribute('data-phone');
        document.getElementById('edit_state').value = btn.getAttribute('data-state');
        document.getElementById('edit_city').value = btn.getAttribute('data-city');
    });
});
</script>

<?php include 'foot.php'; ?>
