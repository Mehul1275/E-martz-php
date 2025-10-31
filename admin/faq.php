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

.faq-title {
    font-weight: 600;
    color: #2c3e50;
    font-size: 1rem;
    line-height: 1.4;
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
        <i class="fa fa-question-circle"></i>
        FAQ Management
    </h1>
    <div class="subtitle">Manage frequently asked questions and help content</div>
    <div class="header-actions">
        <a href="faq-add.php" class="btn-action btn-add">
            <i class="fa fa-plus"></i> Add New FAQ
        </a>
    </div>
</div>

<div class="modern-filter-bar fade-in">
    <div class="row">
        <div class="col-md-8">
            <input type="text" id="faqSearch" class="search-box" placeholder="🔍 Search FAQ by title...">
        </div>
        <div class="col-md-4">
            <div style="padding: 0.8rem 0; font-weight: 600; color: #5a5c69;">
                <i class="fa fa-info-circle"></i> Total FAQs: <span id="totalCount">0</span>
            </div>
        </div>
    </div>
</div>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="modern-table-container slide-in">
        <div class="table-responsive">
					<table id="example1" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th width="30">#</th>
								<th width="100">Title</th>
								<th width="80">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT * FROM tbl_faq");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
								$i++;
								?>
								<tr class="faq-row">
									<td style="font-weight: 600; color: #5a5c69;"><?php echo $i; ?></td>
									<td>
										<div class="faq-title"><?php echo htmlspecialchars($row['faq_title']); ?></div>
									</td>
									<td>
										<div class="action-buttons">
											<a href="faq-edit.php?id=<?php echo $row['faq_id']; ?>" class="modern-btn btn-edit">
												<i class="fa fa-edit"></i> Edit
											</a>
											<a href="#" class="modern-btn btn-delete" 
											   data-href="faq-delete.php?id=<?php echo $row['faq_id']; ?>" 
											   data-toggle="modal" data-target="#confirm-delete"
											   data-faq-title="<?php echo htmlspecialchars($row['faq_title']); ?>">
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
                    <i class="fa fa-exclamation-triangle"></i> Delete FAQ Confirmation
                </h4>
            </div>
            <div class="modal-body">
                <div style="text-align: center; margin-bottom: 1rem;">
                    <i class="fa fa-trash" style="font-size: 3rem; color: #e74a3b; margin-bottom: 1rem;"></i>
                </div>
                <p style="font-size: 1.1rem; text-align: center; margin-bottom: 1rem;">
                    Are you sure you want to delete this FAQ?
                </p>
                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid #e74a3b;">
                    <strong>⚠️ Warning:</strong> This action cannot be undone. The FAQ and its content will be permanently removed from the help section.
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e3e6f0; padding: 1rem 2rem;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right: 1rem;">
                    <i class="fa fa-times"></i> Cancel
                </button>
                <a class="btn btn-danger btn-ok" style="background: linear-gradient(135deg, #e74a3b, #c0392b);">
                    <i class="fa fa-trash"></i> Delete FAQ
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('faqSearch');
    const faqRows = document.querySelectorAll('.faq-row');
    const totalCount = document.getElementById('totalCount');
    
    // Update total count on page load
    totalCount.textContent = faqRows.length;
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;
        
        faqRows.forEach(function(row) {
            const title = row.querySelector('.faq-title').textContent.toLowerCase();
            
            if (title.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        totalCount.textContent = visibleCount;
    });
    
    // Enhanced delete modal
    $('#confirm-delete').on('show.bs.modal', function(e) {
        const faqTitle = $(e.relatedTarget).data('faq-title');
        if (faqTitle) {
            $(this).find('.modal-body p').html(
                'Are you sure you want to delete the FAQ:<br><strong>"' + faqTitle + '"</strong>?'
            );
        }
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
});
</script>

<?php require_once('footer.php'); ?>