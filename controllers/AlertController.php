<?php
class AlertController extends Controller {
    
    public function index(): void {
        $this->requireAuth();
        $alertModel = new Alert();
        
        $typeFilter = $_GET['type'] ?? null;
        $alerts = $alertModel->findByUser(Auth::id());
        
        if ($typeFilter) {
            $alerts = array_filter($alerts, fn($a) => $a['alert_type'] === $typeFilter);
        }
        
        $alertsByType = $alertModel->getRecentByType(Auth::id());
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = $alertModel->unreadCount(Auth::id());
        
        $this->view('alerts.index', compact('alerts', 'alertsByType', 'user', 'csrf', 'flash', 'typeFilter', 'unreadAlerts'));
    }
    
    public function markRead(int $id): void {
        $this->requireAuth();
        $alertModel = new Alert();
        $alertModel->markAsRead($id, Auth::id());
        
        // Return JSON for AJAX calls
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $this->json(['success' => true]);
        }
        $this->redirect('alerts');
    }
    
    public function markAllRead(): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('alerts');
        }
        
        $alertModel = new Alert();
        $alertModel->markAllRead(Auth::id());
        $this->flash('success', 'All alerts marked as read.');
        $this->redirect('alerts');
    }
}
