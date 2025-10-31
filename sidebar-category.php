<?php require_once('header.php'); ?>

<!-- Page Content -->
<div class="page" style="padding: 40px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <!-- Categories Heading -->
                <div class="categories-header" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: var(--color-neutral-900);">
                        <i class="fa fa-tags me-2" style="color: var(--color-primary);"></i>
                        <?php echo LANG_VALUE_49; ?>
                    </h3>
                </div>
                
                <!-- Categories Sidebar -->
                <div class="card">
                    <div class="card-body p-0">
                        <div id="left" class="span3">
                            <div id="menu-group-1" class="category-sidebar">
                                <?php
                                $i = 0;
                                $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                $category_icons = [
                                    'Men' => 'fa-male',
                                    'Women' => 'fa-female',
                                    'Kids' => 'fa-child',
                                    'Electronics' => 'fa-laptop',
                                    'Health and Household' => 'fa-medkit',
                                    'Sports' => 'fa-futbol-o',
                                    'Books' => 'fa-book',
                                    'Fashion' => 'fa-shopping-bag',
                                    'Home' => 'fa-home',
                                    'Beauty' => 'fa-heart'
                                ];

                                foreach ($result as $row) {
                                    $i++;
                                    $icon_class = $category_icons[$row['tcat_name']] ?? 'fa-tag';
                                    ?>
                                    <div class="section">
                                        <button class="section-toggle">
                                            <span class="title">
                                                <i class="fa <?php echo $icon_class; ?> me-2"></i>
                                                <span><?php echo $row['tcat_name']; ?></span>
                                            </span>
                                            <i class="fa fa-chevron-right chevron"></i>
                                        </button>
                                        <div class="section-children">
                                            <?php
                                            $j = 0;
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
                                            $statement1->execute([$row['tcat_id']]);
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            
                                            foreach ($result1 as $row1) {
                                                $j++;
                                                ?>
                                                <div class="subsection">
                                                    <button class="sub-toggle">
                                                        <span><?php echo $row1['mcat_name']; ?></span>
                                                        <i class="fa fa-chevron-right sub-chevron"></i>
                                                    </button>
                                                    <div class="end-list">
                                                        <?php
                                                        $statement2 = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
                                                        $statement2->execute([$row1['mcat_id']]);
                                                        $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                                                        
                                                        foreach ($result2 as $row2) {
                                                            $isActive = (isset($_GET['id']) && $_GET['id'] == $row2['ecat_id']) ? 'active' : '';
                                                            ?>
                                                            <a href="product-category.php?id=<?php echo $row2['ecat_id']; ?>&type=end-category" class="<?php echo $isActive; ?>">
                                                                <?php echo $row2['ecat_name']; ?>
                                                            </a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Brands Dropdown -->
                <div class="top-brands-dropdown" style="margin-top: 25px;">
                    <div class="brands-dropdown-container">
                        <!-- Dropdown Header -->
                        <button class="brands-dropdown-trigger" id="brandsDropdownTrigger">
                            <div class="dropdown-header-content">
                                <i class="fa fa-certificate" style="color: var(--color-primary); margin-right: 10px;"></i>
                                <span class="dropdown-title">Top Brands</span>
                            </div>
                            <i class="fa fa-chevron-down dropdown-arrow"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="brands-dropdown-menu" id="brandsDropdownMenu">
                            <div class="dropdown-content">
                                <?php
                                try {
                                    $brandStmt = $pdo->prepare("SELECT id, company_name, fullname FROM sellers WHERE status = 1 AND email_verified = 1 ORDER BY company_name ASC LIMIT 50");
                                    $brandStmt->execute();
                                    $brands = $brandStmt->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    if ($brands) {
                                        foreach ($brands as $brand) {
                                            $company = htmlspecialchars($brand['company_name'], ENT_QUOTES, 'UTF-8');
                                            $seller = htmlspecialchars($brand['fullname'], ENT_QUOTES, 'UTF-8');
                                            ?>
                                            <a href="seller-store.php?id=<?php echo (int)$brand['id']; ?>" class="dropdown-item">
                                                <div class="dropdown-item-content">
                                                    <div class="brand-icon">
                                                        <i class="fa fa-store"></i>
                                                    </div>
                                                    <div class="brand-details">
                                                        <div class="brand-name"><?php echo $company; ?></div>
                                                        <div class="brand-owner">by <?php echo $seller; ?></div>
                                                    </div>
                                                </div>
                                                <div class="brand-chevron">
                                                    <i class="fa fa-chevron-right"></i>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="dropdown-empty">
                                            <i class="fa fa-info-circle"></i>
                                            <span>No brands available</span>
                                        </div>
                                        <?php
                                    }
                                } catch (Exception $e) {
                                    ?>
                                    <div class="dropdown-error">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        <span>Error loading brands</span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Price Range Filter -->
                <div class="price-filter-sidebar" style="margin-top: 25px;">
                    <div class="price-filter-container">
                        <!-- Price Filter Header -->
                        <div class="price-filter-header">
                            <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: var(--color-neutral-900); background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                <i class="fa fa-tags" style="color: var(--color-primary); margin-right: 10px;"></i>
                                Price Range
                            </h3>
                        </div>
                        
                        <!-- Price Filter Form -->
                        <div class="card" style="margin-top: 10px;">
                            <div class="card-body p-0">
                                <form class="price-filter-form" id="priceFilterForm">
                                    <div class="price-inputs">
                                        <div class="price-input-group">
                                            <label class="price-label">Min Price</label>
                                            <div class="input-wrapper">
                                                <span class="currency-symbol"></span>
                                                <input type="number" class="price-input" id="minPrice" name="min_price" 
                                                       placeholder="0" min="0" step="1" 
                                                       value="<?php echo isset($_GET['min_price']) ? (int)$_GET['min_price'] : ''; ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="price-input-group">
                                            <label class="price-label">Max Price</label>
                                            <div class="input-wrapper">
                                                <span class="currency-symbol"></span>
                                                <input type="number" class="price-input" id="maxPrice" name="max_price" 
                                                       placeholder="10000" min="0" step="1" 
                                                       value="<?php echo isset($_GET['max_price']) ? (int)$_GET['max_price'] : ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="price-actions">
                                        <button type="submit" class="btn-apply-price">
                                            <i class="fa fa-filter"></i>
                                            Apply Filter
                                        </button>
                                        
                                        <?php if (isset($_GET['min_price']) || isset($_GET['max_price'])): ?>
                                        <button type="button" class="btn-clear-price" id="clearPriceFilter">
                                            <i class="fa fa-times"></i>
                                            Clear
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Quick Price Ranges -->
                                    <div class="quick-ranges">
                                        <div class="quick-ranges-title">Quick Ranges:</div>
                                        <div class="quick-ranges-buttons">
                                            <button type="button" class="quick-range-btn" data-min="0" data-max="500">
                                                Under ₹500
                                            </button>
                                            <button type="button" class="quick-range-btn" data-min="500" data-max="1000">
                                                ₹500 - ₹1000
                                            </button>
                                            <button type="button" class="quick-range-btn" data-min="1000" data-max="2500">
                                                ₹1000 - ₹2500
                                            </button>
                                            <button type="button" class="quick-range-btn" data-min="2500" data-max="5000">
                                                ₹2500 - ₹5000
                                            </button>
                                            <button type="button" class="quick-range-btn" data-min="5000" data-max="">
                                                Above ₹5000
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Reset and Base Styles */
.category-sidebar * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Page Header */
.page-header {
    background: #fff;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.page-header-content {
    padding: 20px 0;
    border-bottom: 1px solid #e0e0e0;
}

.page-header h1 {
    margin: 0;
    padding: 0;
    font-size: 24px;
    font-weight: 600;
    color: var(--color-neutral-900);
    display: flex;
    align-items: center;
}

.page-header h1 i {
    color: var(--color-primary);
    margin-right: 12px;
    font-size: 22px;
}

/* Responsive adjustments */
@media (max-width: 767px) {
    .page-header h1 {
        font-size: 20px;
    }
    
    .page-header h1 i {
        font-size: 18px;
    }
}

/* Categories Header */
.categories-header {
    padding: 20px 25px 15px;
    margin-bottom: 10px;
    border-bottom: 1px solid #e0e0e0;
}

.categories-header .section-title {
    color: var(--color-neutral-900);
    font-size: 20px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    position: relative;
    padding-bottom: 10px;
}

.categories-header .section-title:after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 3px;
    background: var(--color-primary);
    border-radius: 2px;
}

.categories-header .section-title i {
    color: var(--color-primary);
    margin-right: 12px;
    font-size: 18px;
    width: 24px;
    text-align: center;
}

/* Categories Header */
.categories-header h3 {
    color: var(--color-neutral-900);
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.categories-header i {
    color: var(--color-primary);
    margin-right: 10px;
}

/* Main Sidebar Container */
.category-sidebar {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
}

/* Top Level Categories */
.section {
    border-bottom: 1px solid #f0f2f5;
}

.section:last-child {
    border-bottom: none;
}

.section-toggle {
    width: 100%;
    padding: 14px 20px;
    background: #fff;
    border: none;
    text-align: left;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.2s ease;
    font-size: 15px;
    font-weight: 600;
    color: var(--color-neutral-800);
}

.section-toggle:hover {
    background: #f8fafc;
    color: var(--color-primary);
}

.section-toggle .title {
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-toggle .title i {
    color: var(--color-primary);
    width: 20px;
    text-align: center;
}

/* Mid Level Categories */
.section-children {
    padding: 0 0 0 40px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.section.open .section-children {
    max-height: 5000px;
    padding: 8px 0 8px 40px;
}

.subsection {
    margin: 6px 0;
}

.sub-toggle {
    width: 100%;
    padding: 10px 15px;
    background: #f8fafc;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    text-align: left;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    font-weight: 500;
    color: var(--color-neutral-700);
    transition: all 0.2s ease;
}

.sub-toggle:hover {
    background: #f1f5ff;
    border-color: #d0e3ff;
    color: var(--color-primary);
}

/* End Level Categories */
.end-list {
    padding: 0 0 0 20px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.subsection.open .end-list {
    max-height: 5000px;
    padding: 8px 0 8px 20px;
}

.end-list a {
    display: block;
    padding: 8px 15px;
    margin: 4px 0;
    color: var(--color-neutral-600);
    text-decoration: none;
    font-size: 14px;
    border-radius: 4px;
    transition: all 0.2s ease;
    position: relative;
    padding-left: 25px;
}

.end-list a::before {
    content: '•';
    position: absolute;
    left: 10px;
    color: var(--color-primary);
    font-size: 16px;
    line-height: 1;
}

.end-list a:hover {
    background: #f8fafc;
    color: var(--color-primary);
    transform: translateX(4px);
}

/* Active State */
.end-list a.active {
    background: var(--color-primary-50);
    color: var(--color-primary);
    font-weight: 500;
}

/* Icons and Indicators */
.chevron, .sub-chevron {
    transition: transform 0.2s ease;
    color: var(--color-neutral-500);
    font-size: 12px;
}

.section.open .chevron,
.subsection.open .sub-chevron {
    transform: rotate(90deg);
    color: var(--color-primary);
}

/* Badge for Count */
.badge {
    background: var(--color-primary-100);
    color: var(--color-primary-700);
    border-radius: 10px;
    padding: 2px 8px;
    font-size: 11px;
    font-weight: 600;
    margin-left: 8px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .category-sidebar {
        border-radius: 0;
    }
    
    .section-toggle {
        padding: 12px 16px;
    }
    
    .section-children {
        padding-left: 30px;
    }
    
    .end-list {
        padding-left: 15px;
    }
}

/* Top Brands Dropdown Styles */
.top-brands-dropdown {
    position: relative;
}

.brands-dropdown-container {
    position: relative;
}

/* Dropdown Trigger Button */
.brands-dropdown-trigger {
    width: 100%;
    background: white;
    border: none;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s ease;
    font-size: 18px;
    font-weight: 600;
    color: var(--color-neutral-900);
}

.brands-dropdown-trigger:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.brands-dropdown-trigger:active {
    transform: translateY(0);
}

.dropdown-header-content {
    display: flex;
    align-items: center;
}

.dropdown-title {
    margin: 0;
}

.dropdown-arrow {
    font-size: 14px;
    color: var(--color-neutral-500);
    transition: transform 0.3s ease;
}

/* Rotate arrow when dropdown is open */
.brands-dropdown-trigger.active .dropdown-arrow {
    transform: rotate(180deg);
    color: var(--color-primary);
}

/* Dropdown Menu */
.brands-dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    margin-top: 8px;
    max-height: 400px;
    overflow-y: auto;
}

/* Show dropdown when active */
.brands-dropdown-menu.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-content {
    padding: 8px 0;
}

/* Dropdown Items */
.dropdown-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    color: var(--color-neutral-700);
    text-decoration: none;
    transition: all 0.2s ease;
    border-bottom: 1px solid #f8fafc;
}

.dropdown-item:last-child {
    border-bottom: none;
}

.dropdown-item:hover {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5ff 100%);
    color: var(--color-primary);
    text-decoration: none;
    transform: translateX(4px);
}

.dropdown-item-content {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    min-width: 0;
}

.brand-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    flex-shrink: 0;
}

.brand-details {
    flex: 1;
    min-width: 0;
}

.brand-name {
    font-weight: 600;
    font-size: 14px;
    color: var(--color-neutral-900);
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.brand-owner {
    font-size: 12px;
    color: var(--color-neutral-600);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.brand-chevron {
    color: var(--color-neutral-400);
    font-size: 12px;
    transition: all 0.2s ease;
    opacity: 0.7;
}

.dropdown-item:hover .brand-chevron {
    color: var(--color-primary);
    opacity: 1;
    transform: translateX(2px);
}

/* Empty and Error States */
.dropdown-empty,
.dropdown-error {
    padding: 20px;
    text-align: center;
    color: var(--color-neutral-500);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.dropdown-error {
    color: var(--color-danger);
}

.dropdown-empty i,
.dropdown-error i {
    font-size: 20px;
    opacity: 0.7;
}

/* Custom Scrollbar for Dropdown */
.brands-dropdown-menu::-webkit-scrollbar {
    width: 6px;
}

.brands-dropdown-menu::-webkit-scrollbar-track {
    background: #f8fafc;
    border-radius: 3px;
}

.brands-dropdown-menu::-webkit-scrollbar-thumb {
    background: var(--color-neutral-300);
    border-radius: 3px;
    transition: background 0.2s ease;
}

.brands-dropdown-menu::-webkit-scrollbar-thumb:hover {
    background: var(--color-primary);
}

/* Price Filter Styles */
.price-filter-sidebar {
    position: relative;
}

.price-filter-container {
    position: relative;
}

/* Price Filter Form */
.price-filter-form {
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

.price-inputs {
    padding: 20px;
}

.price-input-group {
    margin-bottom: 16px;
}

.price-input-group:last-child {
    margin-bottom: 0;
}

.price-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--color-neutral-700);
    margin-bottom: 8px;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.currency-symbol {
    position: absolute;
    left: 12px;
    color: var(--color-neutral-600);
    font-weight: 600;
    font-size: 14px;
    z-index: 1;
}

.price-input {
    width: 100%;
    padding: 12px 16px 12px 30px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    color: var(--color-neutral-900);
    background: #fafbfc;
    transition: all 0.3s ease;
    outline: none;
}

.price-input:focus {
    border-color: var(--color-primary);
    background: white;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.price-input::placeholder {
    color: var(--color-neutral-400);
    font-weight: 400;
}

/* Price Actions */
.price-actions {
    padding: 16px 20px;
    background: #f8fafc;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 10px;
}

.btn-apply-price {
    flex: 1;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
    color: white;
    border: none;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.btn-apply-price:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.btn-apply-price:active {
    transform: translateY(0);
}

.btn-clear-price {
    background: #fff;
    color: var(--color-neutral-600);
    border: 2px solid #e9ecef;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: all 0.3s ease;
}

.btn-clear-price:hover {
    border-color: #ff4757;
    color: #ff4757;
    background: #fff5f5;
}

/* Quick Price Ranges */
.quick-ranges {
    padding: 20px;
    border-top: 1px solid #e9ecef;
    background: white;
}

.quick-ranges-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--color-neutral-700);
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.quick-ranges-buttons {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.quick-range-btn {
    width: 100%;
    background: #f8fafc;
    color: var(--color-neutral-700);
    border: 1px solid #e9ecef;
    padding: 10px 14px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    text-align: left;
    transition: all 0.2s ease;
}

.quick-range-btn:hover {
    background: linear-gradient(135deg, #f1f5ff 0%, #e6f0ff 100%);
    border-color: var(--color-primary);
    color: var(--color-primary);
    transform: translateX(2px);
}

.quick-range-btn.active {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
    color: white;
    border-color: var(--color-primary);
}

/* Error States */
.price-input.error {
    border-color: #ff4757;
    background: #fff5f5;
}

.price-error-message {
    font-size: 12px;
    color: #ff4757;
    margin-top: 4px;
    display: none;
}

.price-input.error + .price-error-message {
    display: block;
}

/* Responsive Design for Dropdown */
@media (max-width: 768px) {
    .top-brands-dropdown {
        margin-top: 20px;
    }
    
    .brands-dropdown-trigger {
        padding: 16px;
        font-size: 16px;
    }
    
    .brands-dropdown-menu {
        max-height: 300px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }
    
    .dropdown-item {
        padding: 10px 16px;
    }
    
    .brand-icon {
        width: 32px;
        height: 32px;
        font-size: 12px;
    }
    
    .brand-name {
        font-size: 13px;
    }
    
    .brand-owner {
        font-size: 11px;
    }
    
    /* Price Filter Responsive */
    .price-filter-sidebar {
        margin-top: 20px;
    }
    
    .price-inputs {
        padding: 16px;
    }
    
    .price-actions {
        padding: 12px 16px;
        flex-direction: column;
        gap: 8px;
    }
    
    .btn-apply-price,
    .btn-clear-price {
        width: 100%;
        padding: 10px 14px;
    }
    
    .quick-ranges {
        padding: 16px;
    }
    
    .quick-range-btn {
        padding: 8px 12px;
        font-size: 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle sections
    document.querySelectorAll('.section-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const parent = this.parentElement;
            parent.classList.toggle('open');
        });
    });

    // Toggle subsections
    document.querySelectorAll('.sub-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const parent = this.parentElement;
            parent.classList.toggle('open');
        });
    });

    // Auto-expand active category
    const activeLink = document.querySelector('.end-list a.active');
    if (activeLink) {
        activeLink.closest('.subsection')?.classList.add('open');
        activeLink.closest('.section')?.classList.add('open');
    }
    
    // Brands dropdown functionality
    const dropdownTrigger = document.getElementById('brandsDropdownTrigger');
    const dropdownMenu = document.getElementById('brandsDropdownMenu');
    
    if (dropdownTrigger && dropdownMenu) {
        // Toggle dropdown on trigger click
        dropdownTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isActive = this.classList.contains('active');
            
            // Close all other dropdowns first
            closeAllDropdowns();
            
            if (!isActive) {
                // Open this dropdown
                this.classList.add('active');
                dropdownMenu.classList.add('active');
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdownTrigger.contains(e.target) && !dropdownMenu.contains(e.target)) {
                closeAllDropdowns();
            }
        });
        
        // Close dropdown on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAllDropdowns();
            }
        });
        
        // Function to close all dropdowns
        function closeAllDropdowns() {
            dropdownTrigger.classList.remove('active');
            dropdownMenu.classList.remove('active');
        }
        
        // Handle dropdown item clicks (for analytics or other purposes)
        dropdownMenu.addEventListener('click', function(e) {
            if (e.target.closest('.dropdown-item')) {
                // Optional: Add analytics or tracking here
                console.log('Brand clicked:', e.target.closest('.dropdown-item').href);
                // The link will navigate automatically
            }
        });
    }
    
    // Price Filter functionality
    const priceFilterForm = document.getElementById('priceFilterForm');
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    const clearPriceFilter = document.getElementById('clearPriceFilter');
    const quickRangeButtons = document.querySelectorAll('.quick-range-btn');
    
    if (priceFilterForm) {
        // Form submission
        priceFilterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            applyPriceFilter();
        });
        
        // Clear price filter
        if (clearPriceFilter) {
            clearPriceFilter.addEventListener('click', function() {
                minPriceInput.value = '';
                maxPriceInput.value = '';
                updateActiveQuickRange();
                applyPriceFilter();
            });
        }
        
        // Quick range buttons
        quickRangeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const minPrice = this.getAttribute('data-min');
                const maxPrice = this.getAttribute('data-max');
                
                minPriceInput.value = minPrice || '';
                maxPriceInput.value = maxPrice || '';
                
                updateActiveQuickRange();
                applyPriceFilter();
            });
        });
        
        // Input validation
        minPriceInput.addEventListener('input', function() {
            validatePriceInputs();
            updateActiveQuickRange();
        });
        
        maxPriceInput.addEventListener('input', function() {
            validatePriceInputs();
            updateActiveQuickRange();
        });
        
        // Initialize active quick range on page load
        updateActiveQuickRange();
    }
    
    function applyPriceFilter() {
        if (!validatePriceInputs()) {
            return;
        }
        
        const minPrice = minPriceInput.value;
        const maxPrice = maxPriceInput.value;
        const currentUrl = new URL(window.location.href);
        
        // Remove existing price parameters
        currentUrl.searchParams.delete('min_price');
        currentUrl.searchParams.delete('max_price');
        
        // Add new price parameters if they exist
        if (minPrice) {
            currentUrl.searchParams.set('min_price', minPrice);
        }
        if (maxPrice) {
            currentUrl.searchParams.set('max_price', maxPrice);
        }
        
        // Redirect to new URL
        window.location.href = currentUrl.toString();
    }
    
    function validatePriceInputs() {
        let isValid = true;
        const minPrice = parseFloat(minPriceInput.value) || 0;
        const maxPrice = parseFloat(maxPriceInput.value) || Infinity;
        
        // Remove previous error states
        minPriceInput.classList.remove('error');
        maxPriceInput.classList.remove('error');
        
        // Check if min price is greater than max price
        if (minPrice > 0 && maxPrice !== Infinity && minPrice > maxPrice) {
            minPriceInput.classList.add('error');
            maxPriceInput.classList.add('error');
            isValid = false;
        }
        
        // Check for negative values
        if (minPrice < 0) {
            minPriceInput.classList.add('error');
            isValid = false;
        }
        
        if (maxPrice < 0) {
            maxPriceInput.classList.add('error');
            isValid = false;
        }
        
        return isValid;
    }
    
    function updateActiveQuickRange() {
        const minPrice = parseFloat(minPriceInput.value) || null;
        const maxPrice = parseFloat(maxPriceInput.value) || null;
        
        quickRangeButtons.forEach(button => {
            const buttonMin = parseFloat(button.getAttribute('data-min')) || null;
            const buttonMax = parseFloat(button.getAttribute('data-max')) || null;
            
            const isActive = (
                (buttonMin === minPrice || (buttonMin === null && minPrice === null)) &&
                (buttonMax === maxPrice || (buttonMax === null && maxPrice === null))
            );
            
            button.classList.toggle('active', isActive);
        });
    }
});
</script>
