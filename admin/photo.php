<?php require_once('header.php'); ?>

<section class="modern-page-header fade-in" style="margin-top: -40px;">
	<div class="page-header">
		<h1 class="page-title">
			<i class="fa fa-image"></i>
			Photo Gallery Management
		</h1>
		<div class="page-actions">
			<a href="photo-add.php" class="modern-btn modern-btn-primary">
				<i class="fa fa-plus"></i> Add New Photo
			</a>
		</div>
	</div>
	<p style="margin: 0.5rem 0 0 0; color: #64748b;">Manage website photo gallery and images</p>
</section>


<section class="content">

  <div class="row">
    <div class="col-md-12">


      <div class="modern-table-container">
        <div class="table-responsive">
          <table id="example1" class="modern-table">
			<thead>
			    <tr>
			        <th width="50">#</th>
			        <th>Caption</th>
			        <th width="200">Photo Preview</th>
			        <th width="150">Actions</th>
			    </tr>
			</thead>
            <tbody>

            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_photo");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
	            	?>
	                <tr>
	                    <td><?php echo $i; ?></td>
	                    <td><?php echo htmlspecialchars($row['caption']); ?></td>
	                    <td class="text-center">
	                    	<img src="../assets/uploads/<?php echo htmlspecialchars($row['photo']); ?>" 
	                    		 alt="<?php echo htmlspecialchars($row['caption']); ?>" 
	                    		 class="photo-preview" 
	                    		 style="width: 120px; height: 80px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
	                    </td>
	                    <td>
	                        <a href="photo-edit.php?id=<?php echo $row['id']; ?>" class="modern-btn modern-btn-sm modern-btn-info">
	                        	<i class="fa fa-edit"></i> Edit
	                        </a>
	                        <a href="#" class="modern-btn modern-btn-sm modern-btn-danger" data-href="photo-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">
	                        	<i class="fa fa-trash"></i> Delete
	                        </a>
	                    </td>
	                </tr>
	                <?php
            	}
            	?>
            </tbody>
          </table>
        </div>
      </div> 

</section>


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
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>