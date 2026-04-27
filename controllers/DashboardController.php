<?php
class DashboardController extends Controller {
    
    public function index(): void {
        $this->requireAuth();
        $userId = Auth::id();
        $user = Auth::user();
        
        $projectModel  = new Project();
        $backlinkModel = new Backlink();
        $alertModel    = new Alert();
        $orderModel    = new Order();
        
        // Stats
        $totalProjects   = $projectModel->count(['user_id' => $userId]);
        $totalBacklinks  = count($backlinkModel->findByUser($userId));
        $statusCounts    = $backlinkModel->getStatusCounts($userId);
        $unreadAlerts    = $alertModel->unreadCount($userId);
        
        $activeBacklinks = 0;
        $lostBacklinks   = 0;
        foreach ($statusCounts as $sc) {
            if ($sc['status'] === 'active') $activeBacklinks = $sc['count'];
            if ($sc['status'] === 'lost') $lostBacklinks = $sc['count'];
        }
        
        // Recent alerts
        $recentAlerts = $alertModel->findByUser($userId, false, 10);
        
        // Recent backlinks
        $recentBacklinks = $backlinkModel->findByUser($userId, null, 5);
        
        // Monthly chart data
        $monthlyStats = $backlinkModel->getMonthlyStats($userId, 6);
        
        // Order status
        $orderCounts = $orderModel->getStatusCounts($userId);
        $pendingOrders = 0;
        foreach ($orderCounts as $oc) {
            if ($oc['status'] === 'pending') $pendingOrders = $oc['count'];
        }
        
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        
        $this->view('dashboard.index', compact(
            'user', 'totalProjects', 'totalBacklinks', 'activeBacklinks',
            'lostBacklinks', 'unreadAlerts', 'recentAlerts', 'recentBacklinks',
            'monthlyStats', 'pendingOrders', 'csrf', 'flash'
        ));
    }
    
    public function stats(): void {
        $this->requireAuth();
        $userId = Auth::id();
        
        $backlinkModel = new Backlink();
        $alertModel    = new Alert();
        
        $this->json([
            'unread_alerts' => $alertModel->unreadCount($userId),
            'status_counts' => $backlinkModel->getStatusCounts($userId),
        ]);
    }
    
    public function chartData(): void {
        $this->requireAuth();
        $backlinkModel = new Backlink();
        $monthlyStats = $backlinkModel->getMonthlyStats(Auth::id(), 6);
        $this->json($monthlyStats);
    }
}
