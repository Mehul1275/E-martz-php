<?php require_once('header.php'); ?>

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

.modern-filter-bar {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
}

.modern-table-container {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
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

.slider-image {
    width: 120px;
    height: 80px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid #e3e6f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.slider-content {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.slider-heading {
    font-weight: 600;
    color: #2c3e50;
    font-size: 1rem;
}

.slider-text {
    color: #7f8c8d;
    font-size: 0.9rem;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.slider-button {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.button-text {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    padding: 0.3rem 0.6rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.button-url {
    font-size: 0.8rem;
    color: #27ae60;
    text-decoration: none;
}

.position-badge {
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-align: center;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.modern-btn {
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-edit {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #2980b9, #1f618d);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
    color: white;
    text-decoration: none;
}

.btn-delete {
    background: linear-gradient(135deg, #e74a3b, #c0392b);
    color: white;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #c0392b, #a93226);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(231, 74, 59, 0.3);
    color: white;
    text-decoration: none;
}

.btn-add {
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-add:hover {
    background: linear-gradient(135deg, #17a673, #138f5f);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(28, 200, 138, 0.3);
    color: white;
    text-decoration: none;
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

.modern-modal .modal-content {
    border-radius: 10px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.modern-modal .modal-header {
    background: linear-gradient(135deg, #e74a3b, #c0392b);
    color: white;
    border-radius: 10px 10px 0 0;
    border-bottom: none;
}

.modern-modal .modal-title {
    font-weight: 600;
}

.modern-modal .modal-body {
    padding: 2rem;
    font-size: 1.1rem;
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

<div class="modern-page-header fade-in" style="margin-top: -40px;">
    <h1>
        <i class="fa fa-image"></i>
        Slider Management
    </h1>
    <div class="subtitle">Manage homepage slider images and content</div>
    <div class="header-actions">
        <a href="slider-add.php" class="btn-action btn-add">
            <i class="fa fa-plus"></i> Add New Slider
        </a>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-8">
            <input type="text" id="sliderSearch" class="search-box" placeholder="🔍 Search sliders by heading, content, or button text...">
        </div>
        <div class="col-md-4">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Total Sliders: <span id="totalCount">0</span>
            </div>
        </div>
    </div>
</div>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="modern-table-container slide-in">
				<div class="table-responsive">
					<table id="sliderTable" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th width="50">#</th>
								<th width="150">Photo</th>
								<th width="200">Heading</th>
								<th width="250">Content</th>
								<th width="120">Button Text</th>
								<th width="120">Button URL</th>
								<th width="80">Position</th>
								<th width="140">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT
														
														id,
														photo,
														heading,
														content,
														button_text,
														button_url,
														position

							                           	FROM tbl_slider
							                           	
							                           	");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
							foreach ($result as $row) {
								$i++;
								?>
								<tr class="slider-row">
									<td style="font-weight: 600; color: #5a5c69;"><?php echo $i; ?></td>
									<td>
										<img src="../assets/uploads/<?php echo htmlspecialchars($row['photo']); ?>" 
											 alt="<?php echo htmlspecialchars($row['heading']); ?>" 
											 class="slider-image">
									</td>
									<td>
										<div class="slider-heading"><?php echo htmlspecialchars($row['heading']); ?></div>
									</td>
									<td>
										<div class="slider-text" title="<?php echo htmlspecialchars($row['content']); ?>">
											<?php echo htmlspecialchars(substr($row['content'], 0, 100)) . (strlen($row['content']) > 100 ? '...' : ''); ?>
										</div>
									</td>
									<td>
										<?php if (!empty($row['button_text'])): ?>
											<span class="button-text"><?php echo htmlspecialchars($row['button_text']); ?></span>
										<?php else: ?>
											<span class="text-muted">No button</span>
										<?php endif; ?>
									</td>
									<td>
										<?php if (!empty($row['button_url'])): ?>
											<div class="url-display">
												<a href="<?php echo htmlspecialchars($row['button_url']); ?>" 
												   class="button-url" target="_blank" title="<?php echo htmlspecialchars($row['button_url']); ?>">
													<?php echo htmlspecialchars(strlen($row['button_url']) > 30 ? substr($row['button_url'], 0, 30) . '...' : $row['button_url']); ?>
												</a>
												<i class="fa fa-external-link" style="margin-left: 5px; color: #27ae60;"></i>
											</div>
										<?php else: ?>
											<span class="text-muted">No URL</span>
										<?php endif; ?>
									</td>
									<td>
										<span class="position-badge"><?php echo htmlspecialchars($row['position']); ?></span>
									</td>
									<td>
										<div class="action-buttons">
											<a href="slider-edit.php?id=<?php echo $row['id']; ?>" class="modern-btn btn-edit">
												<i class="fa fa-edit"></i> Edit
											</a>
											<a href="#" class="modern-btn btn-delete" 
											   data-href="slider-delete.php?id=<?php echo $row['id']; ?>" 
											   data-toggle="modal" data-target="#confirm-delete"
											   data-slider-heading="<?php echo htmlspecialchars($row['heading']); ?>">
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
		</div>
	</div>
</section>


<div class="modal fade modern-modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <i class="fa fa-exclamation-triangle"></i> Delete Slider Confirmation
                </h4>
            </div>
            <div class="modal-body">
                <div style="text-align: center; margin-bottom: 1rem;">
                    <i class="fa fa-trash" style="font-size: 3rem; color: #e74a3b; margin-bottom: 1rem;"></i>
                </div>
                <p style="font-size: 1.1rem; text-align: center; margin-bottom: 1rem;">
                    Are you sure you want to delete this slider?
                </p>
                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid #e74a3b;">
                    <strong>⚠️ Warning:</strong> This action cannot be undone. The slider image and all associated data will be permanently removed from the homepage.
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e3e6f0; padding: 1rem 2rem;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right: 1rem;">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <a class="btn btn-danger btn-ok" style="background: linear-gradient(135deg, #e74a3b, #c0392b);">
                    <i class="fa fa-trash"></i> Delete Slider
                </a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize DataTable with proper configuration
    var table = $('#sliderTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "paging": true,
        "pageLength": 10,
        "order": [[ 6, "asc" ]], // Sort by position
        "columnDefs": [
            { "orderable": false, "targets": [1, 7] }, // Disable sorting for Photo and Action columns
            { "width": "50px", "targets": 0 },
            { "width": "150px", "targets": 1 },
            { "width": "200px", "targets": 2 },
            { "width": "250px", "targets": 3 },
            { "width": "120px", "targets": 4 },
            { "width": "120px", "targets": 5 },
            { "width": "80px", "targets": 6 },
            { "width": "140px", "targets": 7 }
        ],
        "language": {
            "emptyTable": "No sliders found",
            "info": "Showing _START_ to _END_ of _TOTAL_ sliders",
            "infoEmpty": "Showing 0 to 0 of 0 sliders",
            "infoFiltered": "(filtered from _MAX_ total sliders)",
            "lengthMenu": "Show _MENU_ sliders",
            "search": "Search:",
            "zeroRecords": "No matching sliders found",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
    
    // Custom search functionality
    const searchInput = document.getElementById('sliderSearch');
    const totalCount = document.getElementById('totalCount');
    
    // Update total count on page load
    totalCount.textContent = table.rows().count();
    
    searchInput.addEventListener('input', function() {
        table.search(this.value).draw();
        totalCount.textContent = table.rows({ search: 'applied' }).count();
    });
    
    // Enhanced delete modal
    $('#confirm-delete').on('show.bs.modal', function(e) {
        const sliderHeading = $(e.relatedTarget).data('slider-heading');
        if (sliderHeading) {
            $(this).find('.modal-body p').html(
                'Are you sure you want to delete the slider:<br><strong>"' + sliderHeading + '"</strong>?'
            );
        }
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
});
</script>

<?php require_once('footer.php'); ?>