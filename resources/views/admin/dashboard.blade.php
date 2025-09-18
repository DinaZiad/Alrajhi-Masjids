@extends('layouts.admin')

@section('content')
<div class="admin-dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1 class="dashboard-title">لوحة تحكم المشرف</h1>
            <p class="dashboard-subtitle">مرحباً بك في نظام إدارة المساجد</p>
        </div>
        <div class="header-decoration">
            <div class="decoration-circle"></div>
            <div class="decoration-circle"></div>
            <div class="decoration-circle"></div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card masjids-card">
            <div class="card-icon">
                <i class="fas fa-mosque"></i>
            </div>
            <div class="card-content">
                <div class="stat-number">{{ $masjidsCount }}</div>
                <div class="stat-label">عدد المساجد</div>
            </div>
            <div class="card-decoration"></div>
        </div>

        <div class="stat-card programs-card">
            <div class="card-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="card-content">
                <div class="stat-number">{{ $programsCount }}</div>
                <div class="stat-label">عدد البرامج</div>
            </div>
            <div class="card-decoration"></div>
        </div>

        <div class="stat-card announcements-card">
            <div class="card-icon">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="card-content">
                <div class="stat-number">{{ $announcementsCount }}</div>
                <div class="stat-label">عدد الإعلانات</div>
            </div>
            <div class="card-decoration"></div>
        </div>

        <div class="stat-card users-card">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-content">
                <div class="stat-number">{{ $usersCount }}</div>
                <div class="stat-label">عدد المشرفين</div>
            </div>
            <div class="card-decoration"></div>
        </div>
    </div>

   
</div>

<style>
  
.admin-dashboard-container {
    font-family: 'Cairo', sans-serif;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    height: calc(100vh - 5rem);
    padding: 0;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Header Styles */
.dashboard-header {
    background: linear-gradient(135deg, #174032 0%, #14532d 100%);
    border-radius: 15px;
    padding: 1.2rem 1.5rem;
    margin-bottom: 1rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(23, 64, 50, 0.2);
    flex-shrink: 0;
    width: 100%;
}

.header-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.dashboard-title {
    color: #d4af37;
    font-size: 2rem;
    font-weight: 900;
    margin-bottom: 0.3rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dashboard-subtitle {
    color: #fff;
    font-size: 1rem;
    font-weight: 500;
    opacity: 0.9;
}

.header-decoration {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.decoration-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(212, 175, 55, 0.1);
}

.decoration-circle:nth-child(1) {
    width: 80px;
    height: 80px;
    top: 20%;
    right: 10%;
}

.decoration-circle:nth-child(2) {
    width: 60px;
    height: 60px;
    top: 60%;
    right: 30%;
}

.decoration-circle:nth-child(3) {
    width: 40px;
    height: 40px;
    top: 80%;
    right: 50%;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.8rem;
    margin: auto;
    flex: 1;
    align-content: center;
    justify-content: center;
    align-items: center;
    place-items: center;
    width: 100%;
    max-width: 1200px;
    padding: 0 1rem; /* Add padding to prevent cards from sticking to borders */
}

.stat-card {
    background: #fff;
    border-radius: 12px;
    padding: 1rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: all 0.7s ease;
    border: 1px solid rgba(212, 175, 55, 0.1);
    width: 100%;
    align-self: center;
    justify-self: center;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

.card-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.3rem;
    color: #fff;
    position: relative;
    z-index: 2;
}

.masjids-card .card-icon {
    background: linear-gradient(135deg, #174032 0%, #14532d 100%);
}

.programs-card .card-icon {
    background: linear-gradient(135deg, #d4af37 0%, #b8941f 100%);
}

.announcements-card .card-icon {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.users-card .card-icon {
    background: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%);
}

.card-content {
    position: relative;
    z-index: 2;
}

.stat-number {
    font-size: 2rem;
    font-weight: 900;
    color: #174032;
    margin-bottom: 0.3rem;
    line-height: 1;
}

.stat-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #6c757d;
}

.card-decoration {
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent 30%, rgba(212, 175, 55, 0.03) 50%, transparent 70%);
    transform: rotate(45deg);
    transition: all 0.7s ease;
}

.stat-card:hover .card-decoration {
    transform: rotate(45deg) scale(1.1);
}

/* Quick Actions Section */
.quick-actions-section {
    background: #fff;
    border-radius: 15px;
    padding: 1rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 0;
    overflow: hidden;
    justify-content: center;
}

.section-title {
    color: #174032;
    font-size: 1.3rem;
    font-weight: 800;
    margin-bottom: 0.8rem;
    text-align: center;
    position: relative;
    flex-shrink: 0;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #d4af37 0%, #174032 100%);
    border-radius: 2px;
}

.actions-grid {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    flex: 1;
    overflow-y: auto;
    padding-right: 0.3rem;
    justify-content: center;
    align-items: center;
}

.action-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    padding: 1rem;
    text-decoration: none;
    color: inherit;
    transition: all 0.7s ease;
    border: 1px solid rgba(212, 175, 55, 0.1);
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 0.8rem;
    height: 70px;
    width: 100%;
    max-width: 300px;
}

.action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    text-decoration: none;
    color: inherit;
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #d4af37 0%, #b8941f 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.action-content h3 {
    color: #174032;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
}

.action-content p {
    color: #6c757d;
    font-size: 0.8rem;
    margin: 0;
    opacity: 0.8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-dashboard-container {
        padding: 1rem;
    }
    
    .dashboard-header {
        padding: 2rem 1rem;
    }
    
    .dashboard-title {
        font-size: 2rem;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
    
    .stat-card {
        padding: 1.2rem;
    }
    
    .quick-actions-section {
        padding: 1.5rem;
    }
}

@media (max-width: 480px) {
    .dashboard-title {
        font-size: 1.8rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .stat-number {
        font-size: 1.8rem;
    }
    
    .action-card {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add entrance animation for cards
    const cards = document.querySelectorAll('.stat-card, .action-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = entry.target.classList.contains('stat-card') ? 
                        'translateY(0)' : 'translateY(0)';
                }, index * 100);
            }
        });
    });
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endsection