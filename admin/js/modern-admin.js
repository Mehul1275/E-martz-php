// Modern Admin Panel JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Add loading animation to stat cards
    const statCards = document.querySelectorAll('.modern-stat-card');
    statCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in');
    });

    // Add hover effects to sidebar menu
    const sidebarItems = document.querySelectorAll('.sidebar-menu > li > a');
    sidebarItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        
        item.addEventListener('mouseleave', function() {
            if (!this.parentElement.classList.contains('active')) {
                this.style.transform = 'translateX(0)';
            }
        });
    });

    // Add smooth scrolling
    document.documentElement.style.scrollBehavior = 'smooth';

    // Add loading states for charts
    const chartContainers = document.querySelectorAll('.chart-container canvas');
    chartContainers.forEach(canvas => {
        const container = canvas.parentElement;
        const loader = document.createElement('div');
        loader.className = 'chart-loader';
        loader.innerHTML = '<div class="loading-spinner"></div><p>Loading chart...</p>';
        loader.style.cssText = `
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #64748b;
        `;
        container.style.position = 'relative';
        container.appendChild(loader);
        
        // Remove loader after chart loads
        setTimeout(() => {
            if (loader.parentElement) {
                loader.remove();
            }
        }, 2000);
    });

    // Add real-time clock
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', {
            hour12: true,
            hour: '2-digit',
            minute: '2-digit'
        });
        const dateString = now.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        let clockElement = document.getElementById('admin-clock');
        if (!clockElement) {
            clockElement = document.createElement('div');
            clockElement.id = 'admin-clock';
            clockElement.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: rgba(255, 255, 255, 0.95);
                padding: 10px 15px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                font-size: 14px;
                color: #1f2937;
                z-index: 1000;
                backdrop-filter: blur(10px);
            `;
            document.body.appendChild(clockElement);
        }
        
        clockElement.innerHTML = `
            <div style="font-weight: 600;">${timeString}</div>
            <div style="font-size: 12px; color: #64748b;">${dateString}</div>
        `;
    }
    
    updateClock();
    setInterval(updateClock, 1000);

    // Add notification system
    window.showNotification = function(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1001;
            animation: slideDown 0.3s ease-out;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideUp 0.3s ease-out';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    };

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideDown {
            from { transform: translateX(-50%) translateY(-100%); opacity: 0; }
            to { transform: translateX(-50%) translateY(0); opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateX(-50%) translateY(0); opacity: 1; }
            to { transform: translateX(-50%) translateY(-100%); opacity: 0; }
        }
        
        .chart-loader {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
    `;
    document.head.appendChild(style);

    // Enhanced data tables styling
    if (typeof $.fn.DataTable !== 'undefined') {
        $('.dataTable').each(function() {
            $(this).addClass('modern-table');
        });
    }

    // Add search enhancement
    const searchInputs = document.querySelectorAll('input[type="search"]');
    searchInputs.forEach(input => {
        input.style.cssText = `
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            padding: 8px 12px;
            transition: border-color 0.3s ease;
        `;
        
        input.addEventListener('focus', function() {
            this.style.borderColor = '#667eea';
        });
        
        input.addEventListener('blur', function() {
            this.style.borderColor = '#e5e7eb';
        });
    });
});

// Performance monitoring
window.addEventListener('load', function() {
    const loadTime = performance.now();
    console.log(`Admin panel loaded in ${Math.round(loadTime)}ms`);
    
    if (loadTime > 3000) {
        console.warn('Admin panel is loading slowly. Consider optimizing assets.');
    }
});

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + D for Dashboard
    if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
        e.preventDefault();
        window.location.href = 'index.php';
    }
    
    // Ctrl/Cmd + P for Products
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        window.location.href = 'product.php';
    }
    
    // Ctrl/Cmd + O for Orders
    if ((e.ctrlKey || e.metaKey) && e.key === 'o') {
        e.preventDefault();
        window.location.href = 'order.php';
    }
});
