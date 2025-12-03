<?php
session_start();
include('../config/db.php');
include('auth_check.php');
include('layout_admin.php');

layout_start("Manage Orders");
?>

<div class="card table-card shadow">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">All Orders</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $orders = $conn->query("SELECT * FROM orders ORDER BY id DESC");

                while ($o = $orders->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo $o['id']; ?></td>

                        <td><?php echo $o['customer_name'] ?? 'User#' . $o['user_id']; ?></td>

                        <td>₹<?php echo $o['total_amount']; ?></td>

                        <td><?php echo $o['payment_method']; ?></td>

                        <td>
                            <span class="badge 
                                <?php
                                echo match ($o['status']) {
                                    'Pending' => 'bg-secondary',
                                    'Accepted' => 'bg-info',
                                    'Preparing' => 'bg-warning',
                                    'Out for Delivery' => 'bg-primary',
                                    'Delivered' => 'bg-success',
                                    'Cancelled' => 'bg-danger',
                                    default => 'bg-dark'
                                };
                                ?>">
                                <?php echo $o['status']; ?>
                            </span>
                        </td>

                        <td><?php echo $o['created_at']; ?></td>

                        <td>
                            <a href="update_order.php?id=<?php echo $o['id']; ?>"
                                class="btn btn-sm btn-primary mb-1">
                                Update
                            </a>

                            <a href="delete_order.php?id=<?php echo $o['id']; ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this order?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>
</div>

<?php layout_end(); ?>