<?php
session_start();
include '../config/db_connect.php';

if($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
}

// Get filter parameters
$user_type = isset($_GET['user_type']) ? $_GET['user_type'] : 'all';
$action = isset($_GET['action']) ? $_GET['action'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query
$sql = "SELECT * FROM system_logs WHERE 1=1";

if($user_type != 'all') {
    $sql .= " AND user_type='$user_type'";
}
if($action != 'all') {
    $sql .= " AND action='$action'";
}
if($search) {
    $sql .= " AND (details LIKE '%$search%' OR user_type LIKE '%$search%' OR action LIKE '%$search%' OR ip_address LIKE '%$search%')";
}

$sql .= " ORDER BY created_at DESC LIMIT 200";

$logs = mysqli_query($conn, $sql);

// Get unique actions and user types for filters
$user_types = mysqli_query($conn, "SELECT DISTINCT user_type FROM system_logs");
$actions = mysqli_query($conn, "SELECT DISTINCT action FROM system_logs");
?>
<!DOCTYPE html>
<html>
<head>
    <title>System Logs - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .filter-bar {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .filter-bar form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }
        .filter-bar select, .filter-bar input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .filter-bar button {
            padding: 8px 20px;
            background: #1a1a2e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .log-table {
            background: white;
            border-radius: 10px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #1a1a2e;
            color: white;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .badge-admin { background: #dc3545; color: white; }
        .badge-donor { background: #28a745; color: white; }
        .badge-nurse { background: #17a2b8; color: white; }
        .badge-hospital { background: #ffc107; color: black; }
        .clear-btn {
            background: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" style="background: #1a1a2e;">
            <h1>📋 System Activity Logs</h1>
            <p>Track all user activities in the system</p>
            <a href="dashboard.php" class="logout">← Back to Dashboard</a>
        </div>
        
        <!-- Filter Bar -->
        <div class="filter-bar">
            <form method="GET">
                <select name="user_type">
                    <option value="all">All User Types</option>
                    <?php while($ut = mysqli_fetch_assoc($user_types)): ?>
                        <option value="<?php echo $ut['user_type']; ?>" <?php echo $user_type == $ut['user_type'] ? 'selected' : ''; ?>>
                            <?php echo ucfirst($ut['user_type']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                
                <select name="action">
                    <option value="all">All Actions</option>
                    <?php while($act = mysqli_fetch_assoc($actions)): ?>
                        <option value="<?php echo $act['action']; ?>" <?php echo $action == $act['action'] ? 'selected' : ''; ?>>
                            <?php echo ucfirst($act['action']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                
                <input type="text" name="search" placeholder="Search logs..." value="<?php echo $search; ?>">
                <button type="submit">Filter</button>
                <?php if($user_type != 'all' || $action != 'all' || $search): ?>
                    <a href="system_logs.php" class="clear-btn" style="padding: 8px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;">Clear Filters</a>
                <?php endif; ?>
            </form>
        </div>
        
        <!-- Logs Table -->
        <div class="log-table">
            <table>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>User Type</th>
                        <th>Action</th>
                        <th>Details</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($logs) == 0): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px;">
                                No logs found.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php while($log = mysqli_fetch_assoc($logs)): ?>
                            <tr>
                                <td><?php echo date('Y-m-d H:i:s', strtotime($log['created_at'])); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $log['user_type']; ?>">
                                        <?php echo ucfirst($log['user_type']); ?>
                                    </span>
                                </td>
                                <td><?php echo ucfirst($log['action']); ?></td>
                                <td><?php echo htmlspecialchars($log['details']); ?></td>
                                <td><?php echo $log['ip_address']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 20px; text-align: center;">
            <a href="dashboard.php" class="btn">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>