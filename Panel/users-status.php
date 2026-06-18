<?php

session_start();
if (!isset($_SESSION['password'])) {
	header('location:login.php');
}
?>
<?php include 'head.php'; ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Users Settings</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">User Status</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->

		<div class="card">
			<div class="card-body">
				<div class="d-lg-flex align-items-center mb-4 gap-3">
					<div class="position-relative">
						<input type="text" class="form-control ps-5 radius-30" placeholder="Search User Name" oninput="search()" id="searchInput"> <span
							class="position-absolute top-50 product-show translate-middle-y"><i
								class="bx bx-search"></i></span>
					</div>
													
					<div class="ms-auto"><a href="add-user.php" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i
								class="bx bxs-plus-square"></i>Add New User</a></div>
				</div>
				<div>
				    <h3 id="searchResults" style="padding: 0 38px;"></h3>
				</div>
				<div class="table-responsive">
					<?php
					if (isset($_SESSION['stop'])) {
						echo $_SESSION['stop'];
						unset($_SESSION['stop']);
					}
					?>
					<table class="table mb-0">
						<thead style="color:black;" class="table-light">
							<tr>
								<th>S.No</th>
								<th>User Name</th>
								<th>Password</th>
								<th>Status</th>
								<th>Log In</th>
								<th>Log Out</th>
								<th>View Details</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include 'db.php';

							$sql = "SELECT * FROM history ORDER BY id DESC LIMIT 10";
							$result = $con->query($sql);

							if ($result->num_rows > 0) {
								$count = 0;
								while ($row = $result->fetch_assoc()) {
									echo '<tr>
                <td>' . ++$count . '</td>
                <td>' . $row["username"] . '</td>
                <td>' . $row["password"] . '</td>
                <td>' . $row["status"] . '</td>
                <td>' . $row["login"] . '</td>
                <td>' . $row["logout"] . '</td>
                <td><a href="user-details.php?uname=' . $row["username"] . '"><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></a></td>';

									$inner_sql = "SELECT stoper FROM user WHERE username='" . $row["username"] . "'";
									$inner_result = $con->query($inner_sql);

									if ($inner_result->num_rows > 0) {
										$inner_row = $inner_result->fetch_assoc();
										if ($inner_row["stoper"] == 'Stop') {
											echo '<td><a href="stopuser.php?uname=' . $row["username"] . '" class="btn btn-danger text-white px-3">Stop</a></td>';
										} else {
											echo '<td><a href="stopuser.php?uname=' . $row["username"] . '" class="btn btn-outline-danger px-3">Stop</a></td>';
										}
									} else {
										echo '<td>0 results</td>';
									}

									echo '</tr>';
								}
							} else {
								echo "<tr><td colspan='8'>0 results</td></tr>";
							}

							$con->close();
							?>


						</tbody>
					</table>
				</div>
			</div>
		</div>


	</div>
</div>
<!--end page wrapper -->
<?php include 'foot.php'; ?>

<script>
    function search() {
  const searchText = document.getElementById('searchInput').value.toLowerCase();

  // Make an AJAX request to PHP script passing the search query
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const results = JSON.parse(xhr.responseText);
        console.log('Received results:', results); // Log received results
        displaySearchResults(results);
      } else {
        console.error('Error fetching data');
      }
    }
  };

  // Modify the URL to your PHP script that performs the database search
  const url = `search-users-status.php?query=${searchText}`;
  console.log('Request URL:', url); // Log request URL
  xhr.open('GET', url, true);
  xhr.send();
}

function displaySearchResults(results) {
  const searchResultsContainer = document.getElementById('searchResults');
  searchResultsContainer.innerHTML = '';

  if (results.length === 0) {
    searchResultsContainer.innerHTML = 'No results found';
  } else {
    console.log('Received results:', results); // Log received results for debugging
    results.forEach(result => {
      const resultElement = document.createElement('div');
      const anchorTag = document.createElement('a');
      anchorTag.href = `user-details.php?uname=${result.username}`; // Adjust URL as needed
      anchorTag.textContent = `${result.username}`;
      resultElement.appendChild(anchorTag);
      searchResultsContainer.appendChild(resultElement);
    });
  }
}

</script>