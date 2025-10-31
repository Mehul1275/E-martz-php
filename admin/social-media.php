<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	// updating the database
	$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	$statement->execute(array($_POST['facebook'],'Facebook'));

	$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	$statement->execute(array($_POST['twitter'],'Twitter'));

	$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	$statement->execute(array($_POST['linkedin'],'LinkedIn'));

	// $statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	// $statement->execute(array($_POST['google_plus'],'Google Plus'));

	// $statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	// $statement->execute(array($_POST['pinterest'],'Pinterest'));

	$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	$statement->execute(array($_POST['youtube'],'YouTube'));

	$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	$statement->execute(array($_POST['instagram'],'Instagram'));

	// $statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	// $statement->execute(array($_POST['tumblr'],'Tumblr'));

	// $statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	// $statement->execute(array($_POST['flickr'],'Flickr'));

	// $statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	// $statement->execute(array($_POST['reddit'],'Reddit'));

	// $statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	// $statement->execute(array($_POST['snapchat'],'Snapchat'));

	$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
	$statement->execute(array($_POST['whatsapp'],'WhatsApp'));

	$success_message = 'Social Media Information is updated successfully.';
}
?>

<?php
// Initialize variables
$facebook = $twitter = $linkedin = $google_plus = $pinterest = $youtube = '';
$instagram = $tumblr = $flickr = $reddit = $snapchat = $whatsapp = '';

// Get social media URLs from database
$statement = $pdo->prepare("SELECT social_name, social_url FROM tbl_social");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
	switch($row['social_name']) {
		case 'Facebook': $facebook = $row['social_url']; break;
		case 'Twitter': $twitter = $row['social_url']; break;
		case 'LinkedIn': $linkedin = $row['social_url']; break;
		case 'Google Plus': $google_plus = $row['social_url']; break;
		case 'Pinterest': $pinterest = $row['social_url']; break;
		case 'YouTube': $youtube = $row['social_url']; break;
		case 'Instagram': $instagram = $row['social_url']; break;
		case 'Tumblr': $tumblr = $row['social_url']; break;
		case 'Flickr': $flickr = $row['social_url']; break;
		case 'Reddit': $reddit = $row['social_url']; break;
		case 'Snapchat': $snapchat = $row['social_url']; break;
		case 'WhatsApp': $whatsapp = $row['social_url']; break;
	}
}
?>

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

.modern-form-container {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: 1px solid #e3e6f0;
}

.social-media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
    padding: 2rem;
}

.social-input-group {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fc;
    border-radius: 10px;
    border: 2px solid #e3e6f0;
    transition: all 0.3s ease;
}

.social-input-group:hover {
    border-color: #667eea;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
}

.social-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.social-icon.facebook { background: linear-gradient(135deg, #1877f2, #166fe5); }
.social-icon.twitter { background: linear-gradient(135deg, #1da1f2, #0d8bd9); }
.social-icon.linkedin { background: linear-gradient(135deg, #0077b5, #005885); }
.social-icon.google-plus { background: linear-gradient(135deg, #dd4b39, #c23321); }
.social-icon.pinterest { background: linear-gradient(135deg, #bd081c, #8c0613); }
.social-icon.youtube { background: linear-gradient(135deg, #ff0000, #cc0000); }
.social-icon.instagram { background: linear-gradient(135deg, #e4405f, #833ab4); }
.social-icon.tumblr { background: linear-gradient(135deg, #00cf35, #00a82d); }
.social-icon.flickr { background: linear-gradient(135deg, #ff0084, #cc006a); }
.social-icon.reddit { background: linear-gradient(135deg, #ff4500, #cc3700); }
.social-icon.snapchat { background: linear-gradient(135deg, #fffc00, #ccca00); }
.social-icon.whatsapp { background: linear-gradient(135deg, #25d366, #1da851); }

.social-input {
    flex: 1;
    padding: 0.8rem 1rem;
    border: none;
    background: white;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.social-input:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.social-label {
    font-weight: 600;
    color: #2c3e50;
    min-width: 100px;
}

.modern-alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.modern-alert.success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
    border-left: 4px solid #28a745;
}

.modern-alert.error {
    background: linear-gradient(135deg, #f8d7da, #f1b0b7);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.modern-btn {
    background: linear-gradient(135deg, #1cc88a, #17a673);
    color: white;
    padding: 0.8rem 2rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.modern-btn:hover {
    background: linear-gradient(135deg, #17a673, #138f5f);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(28, 200, 138, 0.3);
    color: white;
    text-decoration: none;
}

.form-actions {
    padding: 2rem;
    background: #f8f9fc;
    border-top: 1px solid #e3e6f0;
    text-align: center;
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
        <i class="fa fa-share-alt"></i>
        Social Media Settings
    </h1>
    <div class="subtitle">Configure social media links and integration settings</div>
</div>

<?php
if($error_message != '') {
	echo "<div class='modern-alert error'><i class='fa fa-exclamation-triangle'></i> ".$error_message."</div>";
}
if($success_message != '') {
	echo "<div class='modern-alert success'><i class='fa fa-check-circle'></i> ".$success_message."</div>";
}
?>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<form class="form-horizontal" action="" method="post">
				<div class="modern-form-container slide-in">
					<div class="social-media-grid">
						<div class="social-input-group">
							<div class="social-icon facebook">
								<i class="fa fa-facebook"></i>
							</div>
							<div class="social-label">Facebook</div>
							<input type="text" class="social-input" name="facebook" value="<?php echo htmlspecialchars($facebook); ?>" placeholder="https://facebook.com/yourpage">
						</div>

						<div class="social-input-group">
							<div class="social-icon twitter">
								<i class="fa fa-twitter"></i>
							</div>
							<div class="social-label">Twitter</div>
							<input type="text" class="social-input" name="twitter" value="<?php echo htmlspecialchars($twitter); ?>" placeholder="https://twitter.com/youraccount">
						</div>

						<div class="social-input-group">
							<div class="social-icon linkedin">
								<i class="fa fa-linkedin"></i>
							</div>
							<div class="social-label">LinkedIn</div>
							<input type="text" class="social-input" name="linkedin" value="<?php echo htmlspecialchars($linkedin); ?>" placeholder="https://linkedin.com/company/yourcompany">
						</div>
<!-- 
						<div class="social-input-group">
							<div class="social-icon google-plus">
								<i class="fa fa-google-plus"></i>
							</div>
							<div class="social-label">Google Plus</div>
							<input type="text" class="social-input" name="google_plus" value="<?php echo htmlspecialchars($google_plus); ?>" placeholder="https://plus.google.com/youraccount">
						</div>

						<div class="social-input-group">
							<div class="social-icon pinterest">
								<i class="fa fa-pinterest"></i>
							</div>
							<div class="social-label">Pinterest</div>
							<input type="text" class="social-input" name="pinterest" value="<?php echo htmlspecialchars($pinterest); ?>" placeholder="https://pinterest.com/youraccount">
						</div> -->

						<div class="social-input-group">
							<div class="social-icon youtube">
								<i class="fa fa-youtube"></i>
							</div>
							<div class="social-label">YouTube</div>
							<input type="text" class="social-input" name="youtube" value="<?php echo htmlspecialchars($youtube); ?>" placeholder="https://youtube.com/c/yourchannel">
						</div>

						<div class="social-input-group">
							<div class="social-icon instagram">
								<i class="fa fa-instagram"></i>
							</div>
							<div class="social-label">Instagram</div>
							<input type="text" class="social-input" name="instagram" value="<?php echo htmlspecialchars($instagram); ?>" placeholder="https://instagram.com/youraccount">
						</div>
<!-- 
						<div class="social-input-group">
							<div class="social-icon tumblr">
								<i class="fa fa-tumblr"></i>
							</div>
							<div class="social-label">Tumblr</div>
							<input type="text" class="social-input" name="tumblr" value="<?php echo htmlspecialchars($tumblr); ?>" placeholder="https://youraccount.tumblr.com">
						</div>

						<div class="social-input-group">
							<div class="social-icon flickr">
								<i class="fa fa-flickr"></i>
							</div>
							<div class="social-label">Flickr</div>
							<input type="text" class="social-input" name="flickr" value="<?php echo htmlspecialchars($flickr); ?>" placeholder="https://flickr.com/photos/youraccount">
						</div>

						<div class="social-input-group">
							<div class="social-icon reddit">
								<i class="fa fa-reddit"></i>
							</div>
							<div class="social-label">Reddit</div>
							<input type="text" class="social-input" name="reddit" value="<?php echo htmlspecialchars($reddit); ?>" placeholder="https://reddit.com/u/youraccount">
						</div>

						<div class="social-input-group">
							<div class="social-icon snapchat">
								<i class="fa fa-snapchat"></i>
							</div>
							<div class="social-label">Snapchat</div>
							<input type="text" class="social-input" name="snapchat" value="<?php echo htmlspecialchars($snapchat); ?>" placeholder="https://snapchat.com/add/youraccount">
						</div> -->

						<div class="social-input-group">
							<div class="social-icon whatsapp">
								<i class="fa fa-whatsapp"></i>
							</div>
							<div class="social-label">WhatsApp</div>
							<input type="text" class="social-input" name="whatsapp" value="<?php echo htmlspecialchars($whatsapp); ?>" placeholder="https://wa.me/yournumber">
						</div>
					</div>

					<div class="form-actions">
						<button type="submit" class="modern-btn" name="form1">
							<i class="fa fa-save"></i> Update Social Media Settings
						</button>
					</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>