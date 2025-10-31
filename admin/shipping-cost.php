<?php require_once('header.php'); ?>

<?php

if(isset($_POST['form1'])) {

    $valid = 1;

    if(empty($_POST['country_id'])) {
        $valid = 0;
        $error_message .= 'You must have to select a country.<br>';
    }

    if($_POST['amount'] == '') {
        $valid = 0;
        $error_message .= 'Amount can not be empty.<br>';
    } else {
        if(!is_numeric($_POST['amount'])) {
            $valid = 0;
            $error_message .= 'You must have to enter a valid number.<br>';
        }
    }

    if($valid == 1) {
        $statement = $pdo->prepare("INSERT INTO tbl_shipping_cost (country_id,amount) VALUES (?,?)");
        $statement->execute(array($_POST['country_id'],$_POST['amount']));

        $success_message = 'Shipping cost is added successfully.';
    }

}


if(isset($_POST['form2'])) {
    $valid = 1;

    if($_POST['amount'] == '') {
        $valid = 0;
        $error_message .= 'Amount can not be empty.<br>';
    } else {
        if(!is_numeric($_POST['amount'])) {
            $valid = 0;
            $error_message .= 'You must have to enter a valid number.<br>';
        }
    }

    if($valid == 1) {

        $statement = $pdo->prepare("UPDATE tbl_shipping_cost_all SET amount=? WHERE sca_id=1");
        $statement->execute(array($_POST['amount']));

        $success_message = 'Shipping cost for rest of the world is updated successfully.';

    }
}
?>


<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-truck"></i>
        Shipping Cost Management
    </h1>
    <div class="subtitle">Configure shipping costs for different countries and regions</div>
    <div style="margin-top: 1rem;">
        <button class="btn-add-new" onclick="location.reload()">
            <i class="fa fa-refresh"></i> Refresh Data
        </button>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="shippingSearch" class="search-box" placeholder="🔍 Search countries or amounts...">
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Total Entries: <span id="totalCount">0</span>
            </div>
        </div>
        <div class="col-md-3">
            <div style="padding: 0.8rem 0; text-align: right;">
                <button class="modern-btn btn-add-secondary" onclick="document.querySelector('form').scrollIntoView({behavior: 'smooth'})">
                    <i class="fa fa-plus"></i> Quick Add
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modern-container">
    <?php if($error_message): ?>
    <div class="modern-alert modern-alert-danger">
        <i class="fa fa-exclamation-triangle"></i>
        <div class="alert-content">
            <strong>Error!</strong>
            <p><?php echo $error_message; ?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if($success_message): ?>
    <div class="modern-alert modern-alert-success">
        <i class="fa fa-check-circle"></i>
        <div class="alert-content">
            <strong>Success!</strong>
            <p><?php echo $success_message; ?></p>
        </div>
    </div>
    <?php endif; ?>

    <div class="modern-card">
        <div class="card-header">
            <h3><i class="fa fa-plus-circle"></i> Add New Shipping Cost</h3>
            <p>Set shipping cost for a specific country</p>
        </div>
        <form class="modern-form" action="" method="post">
            <div class="form-card">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Select Country <span class="required">*</span></label>
                        <select name="country_id" class="modern-form-control modern-select">
                            <option value="">Select a country</option>
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                                $statement->execute(array($row['country_id']));
                                $total = $statement->rowCount();
                                if($total) {
                                    continue;
                                }
                                ?>
                                <option value="<?php echo $row['country_id']; ?>"><?php echo htmlspecialchars($row['country_name']); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Shipping Amount <span class="required">*</span></label>
                        <input type="text" class="modern-form-control" name="amount" placeholder="Enter shipping cost">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="modern-btn modern-btn-primary" name="form1">
                        <i class="fa fa-plus"></i> Add Shipping Cost
                    </button>
                </div>
            </div>
        </form>
    </div>




    <div class="modern-card">
        <div class="card-header">
            <h3><i class="fa fa-list"></i> Current Shipping Costs</h3>
            <p>Manage existing shipping costs by country</p>
        </div>


        <div class="modern-table-container slide-in">
            <div class="table-responsive">
                <table id="shippingTable" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="fa fa-globe"></i> Country Name</th>
                        <th><i class="fa fa-money"></i> Shipping Amount</th>
                        <th><i class="fa fa-cogs"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=0;
                    $statement = $pdo->prepare("SELECT * 
                                                FROM tbl_shipping_cost t1
                                                JOIN tbl_country t2 
                                                ON t1.country_id = t2.country_id 
                                                ORDER BY t2.country_name ASC");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $i++;
                        ?>
                        <tr>
                            <td><span class="row-number"><?php echo $i; ?></span></td>
                            <td>
                                <div class="country-info">
                                    <i class="fa fa-map-marker"></i>
                                    <strong><?php echo htmlspecialchars($row['country_name']); ?></strong>
                                </div>
                            </td>
                            <td>
                                <span class="amount-badge">
                                    <i class="fa fa-dollar"></i> <?php echo htmlspecialchars($row['amount']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="shipping-cost-edit.php?id=<?php echo $row['shipping_cost_id']; ?>" class="modern-btn modern-btn-primary modern-btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="#" class="modern-btn modern-btn-danger modern-btn-sm" data-href="shipping-cost-delete.php?id=<?php echo $row['shipping_cost_id']; ?>" data-toggle="modal" data-target="#confirm-delete">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                </table>
            </div>
        </div>
        
        <div class="info-banner">
            <i class="fa fa-info-circle"></i>
            <strong>Note:</strong> If a country is not listed above, the "Rest of the World" shipping cost will be applied.
        </div>
    </div>


    <div class="modern-card">
        <div class="card-header">
            <h3><i class="fa fa-globe"></i> Rest of the World Shipping</h3>
            <p>Default shipping cost for countries not listed above</p>
        </div>

        <?php
        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $amount = $row['amount'];
        }
        ?>
        
        <form class="modern-form" action="" method="post">
            <div class="form-card">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Default Shipping Amount <span class="required">*</span></label>
                        <input type="text" class="modern-form-control" name="amount" value="<?php echo htmlspecialchars($amount); ?>" placeholder="Enter default shipping cost">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="modern-btn modern-btn-success" name="form2">
                        <i class="fa fa-save"></i> Update Default Cost
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.modern-page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.modern-page-header h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.modern-page-header .subtitle {
    margin-top: 0.5rem;
    opacity: 0.9;
    font-size: 1.1rem;
}

.btn-add-new {
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(28, 200, 138, 0.3);
    cursor: pointer;
}

.btn-add-new:hover {
    background: linear-gradient(135deg, #17a673, #138d5a);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(28, 200, 138, 0.4);
    color: white;
}

.btn-add-secondary {
    background: linear-gradient(135deg, #36b9cc, #258391);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    border: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-size: 0.875rem;
    cursor: pointer;
}

.btn-add-secondary:hover {
    background: linear-gradient(135deg, #258391, #1e6b73);
    transform: translateY(-1px);
    color: white;
}

.modern-filter-bar {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
}

.modern-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.modern-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #dee2e6;
}

.card-header h3 {
    margin: 0 0 0.5rem 0;
    color: #495057;
    font-size: 1.5rem;
}

.card-header p {
    margin: 0;
    color: #6c757d;
    font-size: 1rem;
}

.form-card {
    padding: 2rem;
}

.form-row {
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #495057;
}

.required {
    color: #dc3545;
}

.modern-form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.modern-form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.modern-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid #dee2e6;
}

.modern-table-container .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.modern-table-container table {
    margin-bottom: 0;
}

.modern-table-container thead th {
    background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    border: none;
    font-weight: 600;
    color: #5a5c69;
    padding: 1rem 0.75rem;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.modern-table-container tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #e3e6f0;
}

.modern-table-container tbody tr:hover {
    background-color: #f8f9fc;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.search-box {
    width: 100%;
    padding: 0.8rem 1rem;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-box:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-box:hover {
    border-color: #a78bfa;
    box-shadow: 0 2px 8px rgba(167, 139, 250, 0.1);
}

.row-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    font-weight: 600;
    color: white;
    font-size: 0.85rem;
}

.country-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.country-info i {
    color: #28a745;
}

.amount-badge {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.info-banner {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
    padding: 1rem 2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-banner i {
    font-size: 1.25rem;
}

.modern-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.modern-btn i {
    margin-right: 0.5rem;
}

.modern-btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.modern-btn-sm i {
    margin-right: 0.25rem;
}

.modern-btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
}

.modern-btn-primary:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    color: white;
    text-decoration: none;
}

.modern-btn-success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
    color: white;
}

.modern-btn-success:hover {
    background: linear-gradient(135deg, #1e7e34, #155724);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    color: white;
    text-decoration: none;
}

.modern-btn-info {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: white;
}

.modern-btn-info:hover {
    background: linear-gradient(135deg, #138496, #117a8b);
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

.modern-btn-danger {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.modern-btn-danger:hover {
    background: linear-gradient(135deg, #c82333, #bd2130);
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

.modern-alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.modern-alert-danger {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.modern-alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    border: 1px solid #c3e6cb;
    color: #155724;
}

.modern-alert i {
    font-size: 1.25rem;
    margin-top: 0.125rem;
}

.alert-content {
    flex: 1;
}

.alert-content strong {
    display: block;
    margin-bottom: 0.25rem;
}

.alert-content p {
    margin: 0;
}

.fade-in {
    animation: fadeIn 0.6s ease-out;
}

.slide-in {
    animation: slideIn 0.8s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(url) {
    if (confirm('Are you sure you want to delete this shipping cost?')) {
        window.location.href = url;
    }
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('shippingSearch');
    const table = document.getElementById('shippingTable');
    const totalCountSpan = document.getElementById('totalCount');
    
    function updateTotalCount() {
        const visibleRows = table.querySelectorAll('tbody tr:not([style*="display: none"])');
        totalCountSpan.textContent = visibleRows.length;
    }
    
    // Initial count
    updateTotalCount();
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(function(row) {
            const countryName = row.cells[1].textContent.toLowerCase();
            const amount = row.cells[2].textContent.toLowerCase();
            
            if (countryName.includes(searchTerm) || amount.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        updateTotalCount();
    });
});
</script>

<?php require_once('footer.php'); ?>