<?php
require_once '../src/Database.php';
require_once '../src/UserKYC.php';

$csrf_token = '';
$edit_user = null;
$edit_mode = false;

// Get all users at the start
$all_users = [];
try {
    $all_users = UserKYC::getAll();
} catch (Exception $e) {
    $error = "Error loading users: " . htmlspecialchars($e->getMessage());
}

// Check if editing
if (isset($_GET['edit'])) {
    $edit_mode = true;
    try {
        $all_users_list = UserKYC::getAll();
        foreach ($all_users_list as $user) {
            if ($user['cand_id'] === $_GET['edit']) {
                $edit_user = $user;
                break;
            }
        }
    } catch (Exception $e) {
        $error = "Error loading user: " . htmlspecialchars($e->getMessage());
    }
}

// Handle KYC operations
if (isset($_POST['save_kyc'])) {
    try {
        $kyc_data = [
            'cand_id' => $_POST['cand_id'] ?? $_POST['cand_id_hidden'] ?? null,
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
        if (empty($kyc_data['cand_id']) || empty($kyc_data['roll_no'])) {
            throw new Exception('Candidate ID and Roll number are required');
        }
        UserKYC::save($kyc_data);
        // Reload users after save
        $all_users = UserKYC::getAll();
        $success_msg = "User saved successfully!";
        $edit_mode = false;
        $edit_user = null;
    } catch (Exception $e) {
        $error = "Error saving user: " . htmlspecialchars($e->getMessage());
    }
}

if (isset($_GET['delete_kyc'])) {
    try {
        UserKYC::delete($_GET['delete_kyc']);
        // Reload users after delete
        $all_users = UserKYC::getAll();
    } catch (Exception $e) {
        $error = "Error deleting user: " . htmlspecialchars($e->getMessage());
    }
}

$csrf_token = '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>KYC Management | DocPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #0f2854;
            --bg-light: #bde8f5;
            --text-dark: #2d2436;
        }
        body { 
            background-color: var(--bg-light); 
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-custom {
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: var(--primary) !important;
        }
        .nav-link {
            color: var(--text-dark) !important;
            font-weight: 600;
            transition: all 0.3s;
            margin: 0 10px;
        }
        .nav-link:hover {
            color: var(--primary) !important;
            transform: translateY(-2px);
        }
        .main-content { padding: 30px; }
        .table-card { background: white; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); padding: 20px; border: none; }
        .btn-primary { background-color: var(--primary); border: none; }
        .btn-primary:hover { background-color: #1c4d8d; }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar-custom">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <span class="navbar-brand"><i class="bi bi-file-earmark-text-fill me-2"></i>DocPortal</span>
            <a href="index.php" class="nav-link"><i class="bi bi-house-door-fill me-1"></i> Home</a>
        </div>
    </div>
</nav>

<div class="container-fluid main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>User KYC Management</h3>
                <?php if (!$edit_mode): ?>
                    <a href="?add=1" class="btn btn-primary">+ Add New User</a>
                <?php else: ?>
                    <a href="kyc.php" class="btn btn-secondary">Back to List</a>
                <?php endif; ?>
            </div>

            <?php if (isset($success_msg)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($success_msg) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($edit_mode || isset($_GET['add'])): ?>
                <!-- KYC Form (Add/Edit) -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white"><strong><?= $edit_mode ? 'Edit User KYC' : 'Add New User' ?></strong></div>
                    <div class="card-body">
                        <form method="POST" style="max-width: 600px;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Candidate ID *</label>
                                    <input type="text" name="cand_id" class="form-control" required value="<?= $edit_mode ? htmlspecialchars($edit_user['cand_id']) : '' ?>" <?= $edit_mode ? 'readonly' : '' ?>>
                                    <?php if ($edit_mode): ?>
                                        <input type="hidden" name="cand_id_hidden" value="<?= htmlspecialchars($edit_user['cand_id']) ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Roll Number *</label>
                                    <input type="text" name="roll_no" class="form-control" required value="<?= $edit_mode ? htmlspecialchars($edit_user['roll_no']) : '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="name" class="form-control" required value="<?= $edit_mode ? htmlspecialchars($edit_user['name']) : '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= $edit_mode ? htmlspecialchars($edit_user['email'] ?? '') : '' ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?= $edit_mode ? htmlspecialchars($edit_user['phone'] ?? '') : '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Position</label>
                                    <input type="text" name="position" class="form-control" value="<?= $edit_mode ? htmlspecialchars($edit_user['position'] ?? '') : '' ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Department</label>
                                    <input type="text" name="department" class="form-control" value="<?= $edit_mode ? htmlspecialchars($edit_user['department'] ?? '') : '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Joining (Start Date)</label>
                                    <input type="date" name="date_of_joining" class="form-control" value="<?= $edit_mode ? htmlspecialchars($edit_user['date_of_joining'] ?? '') : '' ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control" value="<?= $edit_mode ? htmlspecialchars($edit_user['date_of_birth'] ?? '') : '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control" value="<?= $edit_mode ? htmlspecialchars($edit_user['city'] ?? '') : '' ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">State</label>
                                    <input type="text" name="state" class="form-control" value="<?= $edit_mode ? htmlspecialchars($edit_user['state'] ?? '') : '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" name="pincode" class="form-control" value="<?= $edit_mode ? htmlspecialchars($edit_user['pincode'] ?? '') : '' ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Qualification</label>
                                    <input type="text" name="qualification" class="form-control" value="<?= $edit_mode ? htmlspecialchars($edit_user['qualification'] ?? '') : '' ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2"><?= $edit_mode ? htmlspecialchars($edit_user['address'] ?? '') : '' ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Designation</label>
                                <input type="text" name="designation" class="form-control" value="<?= $edit_mode ? htmlspecialchars($edit_user['designation'] ?? '') : '' ?>">
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" name="save_kyc" class="btn btn-primary">Save User</button>
                                <a href="kyc.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

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

            <?php if (!$edit_mode && !isset($_GET['add'])): ?>
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
                        <?php if (empty($all_users)): ?>
                            <tr><td colspan="6" class="text-center text-muted py-4">No users added yet</td></tr>
                        <?php else: ?>
                            <?php foreach($all_users as $user): ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($user['cand_id']) ?></span></td>
                                <td><span class="fw-bold"><?= htmlspecialchars($user['roll_no']) ?></span></td>
                                <td><?= htmlspecialchars($user['name']) ?></td>
                                <td><?= htmlspecialchars($user['position'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($user['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($user['phone'] ?? '-') ?></td>
                                <td class="text-end">
                                    <a href="?edit=<?= urlencode($user['cand_id']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <a href="?delete_kyc=<?= urlencode($user['cand_id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php require_once 'footer.php'; ?>
</body>
</html>
