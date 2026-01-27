<?php
require_once '../src/Database.php';
require_once '../src/Auth.php';
require_once '../src/LetterManager.php';
require_once '../src/UserKYC.php';

if (isset($_GET['logout'])) {
    Auth::logout(); 
    header("Location: login.php"); 
    exit;
}

// Handle KYC operations
if (isset($_POST['save_kyc'])) {
    $kyc_data = [
        'cand_id' => $_POST['cand_id'],
        'roll_no' => $_POST['roll_no'],
        'name' => $_POST['name'],
        'email' => $_POST['email'] ?? null,
        'phone' => $_POST['phone'] ?? null,
        'position' => $_POST['position'] ?? null,
        'department' => $_POST['department'] ?? null,
        'date_of_joining' => $_POST['date_of_joining'] ?? null,
        'date_of_birth' => $_POST['date_of_birth'] ?? null,
        'address' => $_POST['address'] ?? null,
        'city' => $_POST['city'] ?? null,
        'state' => $_POST['state'] ?? null,
        'pincode' => $_POST['pincode'] ?? null,
        'qualification' => $_POST['qualification'] ?? null,
        'designation' => $_POST['designation'] ?? null,
    ];
    UserKYC::save($kyc_data);
    header("Location: admin.php?tab=kyc&success=1"); 
    exit;
}

if (isset($_GET['delete_kyc'])) {
    UserKYC::delete($_GET['delete_kyc']); // Now expects cand_id
    header("Location: admin.php?tab=kyc&deleted=1");
    exit;
}

require_once 'require_auth.php';

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fff8f3; font-family: 'Segoe UI', sans-serif; }
        .sidebar { background: #0f2854; color: white; min-height: 100vh; padding: 20px; }
        .main-content { padding: 30px; }
        .table-card { background: white; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); padding: 20px; border: none; }
        .nav-link { transition: all 0.3s; }
        .nav-link.active { background: rgba(255,255,255,0.2); border-radius: 8px; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar d-none d-md-block">
            <h4 class="mb-5">DocPortal</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-3">
                    <a href="?tab=letters" class="nav-link text-white <?= ($_GET['tab'] ?? 'letters') === 'letters' ? 'active' : '' ?>">Letters</a>
                </li>
                <li class="nav-item mb-3">
                    <a href="?tab=kyc" class="nav-link text-white <?= ($_GET['tab'] ?? '') === 'kyc' ? 'active' : '' ?>">KYC Management</a>
                </li>
                <li class="nav-item mb-3">
                    <a href="index.php" class="nav-link text-white">Dashboard</a>
                </li>
                <li class="nav-item mt-5">
                    <a href="?logout=1" class="btn btn-outline-light btn-sm w-100">Logout</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10 main-content">
            <?php 
            $tab = $_GET['tab'] ?? 'letters';
            
            if ($tab === 'letters'): ?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Documentation Repository</h3>
                    <span class="badge bg-primary px-3 py-2">Total: <?= count(LetterManager::getAllLetters()) ?> Records</span>
                </div>
                
                <div class="table-card">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Cand ID</th>
                                <th>Roll Number</th>
                                <th>Letter Type</th>
                                <th>Created On</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach(LetterManager::getAllLetters() as $l): ?>
                            <tr>
                                <td>#<?= $l['id'] ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($l['cand_id'] ?? '-') ?></span></td>
                                <td><span class="fw-bold"><?= htmlspecialchars($l['roll_no']) ?></span></td>
                                <td><span class="badge bg-info text-dark"><?= $l['type_name'] ?></span></td>
                                <td class="text-muted small"><?= date('M d, Y H:i', strtotime($l['created_at'])) ?></td>
                                <td class="text-end">
                                    <a href="view-letter.php?id=<?= $l['id'] ?>" class="btn btn-sm btn-outline-dark">View Letter</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif ($tab === 'kyc'): ?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>User KYC Management</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kycModal">+ Add New User</button>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        User KYC data saved successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['deleted'])): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        User KYC data deleted successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="table-card">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Cand ID</th>
                                <th>Roll Number</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach(UserKYC::getAll() as $user): ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($user['cand_id']) ?></span></td>
                                <td><span class="fw-bold"><?= htmlspecialchars($user['roll_no']) ?></span></td>
                                <td><?= htmlspecialchars($user['name']) ?></td>
                                <td><?= htmlspecialchars($user['position'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($user['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($user['phone'] ?? '-') ?></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#kycModal" onclick="editUser('<?= htmlspecialchars(json_encode($user), ENT_QUOTES) ?>')">Edit</button>
                                    <a href="?tab=kyc&delete_kyc=<?= urlencode($user['cand_id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- KYC Modal -->
<div class="modal fade" id="kycModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User KYC Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="kycForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Candidate ID *</label>
                            <input type="text" name="cand_id" class="form-control" required id="candId">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Roll Number *</label>
                            <input type="text" name="roll_no" class="form-control" required id="rollNo">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" name="position" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department</label>
                            <input type="text" name="department" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Joining (Start Date)</label>
                            <input type="date" name="date_of_joining" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Joining</label>
                            <input type="date" name="date_of_joining" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pincode</label>
                            <input type="text" name="pincode" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Qualification</label>
                            <input type="text" name="qualification" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Designation</label>
                        <input type="text" name="designation" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="save_kyc" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function editUser(userJson) {
    const user = JSON.parse(userJson);
    document.getElementById('candId').value = user.cand_id;
    document.getElementById('candId').readOnly = true;
    document.getElementById('rollNo').value = user.roll_no;
    document.querySelector('input[name="name"]').value = user.name;
    document.querySelector('input[name="email"]').value = user.email || '';
    document.querySelector('input[name="phone"]').value = user.phone || '';
    document.querySelector('input[name="position"]').value = user.position || '';
    document.querySelector('input[name="department"]').value = user.department || '';
    document.querySelector('input[name="date_of_joining"]').value = user.date_of_joining || '';
    document.querySelector('input[name="date_of_birth"]').value = user.date_of_birth || '';
    document.querySelector('input[name="city"]').value = user.city || '';
    document.querySelector('input[name="state"]').value = user.state || '';
    document.querySelector('input[name="pincode"]').value = user.pincode || '';
    document.querySelector('input[name="qualification"]').value = user.qualification || '';
    document.querySelector('input[name="designation"]').value = user.designation || '';
    document.querySelector('textarea[name="address"]').value = user.address || '';
    document.querySelector('.modal-title').textContent = 'Edit User KYC - ' + user.cand_id;
}

// Reset form when modal is closed
document.getElementById('kycModal').addEventListener('hide.bs.modal', function() {
    document.getElementById('kycForm').reset();
    document.getElementById('candId').readOnly = false;
    document.querySelector('.modal-title').textContent = 'User KYC Information';
});
</script>
</body>
</html>