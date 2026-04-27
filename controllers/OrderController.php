<?php
class OrderController extends Controller {
    
    public function index(): void {
        $this->requireAuth();
        $orderModel = new Order();
        $orders = $orderModel->findByUser(Auth::id());
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        $this->view('orders.index', compact('orders', 'user', 'csrf', 'flash', 'unreadAlerts'));
    }
    
    public function create(): void {
        $this->requireAuth();
        $projectModel = new Project();
        $projects = $projectModel->findByUser(Auth::id());
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        $this->view('orders.create', compact('projects', 'user', 'csrf', 'flash', 'unreadAlerts'));
    }
    
    public function store(): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('orders/create');
        }
        
        $projectId = (int)($_POST['project_id'] ?? 0);
        $targetUrl = trim($_POST['target_url'] ?? '');
        
        if (empty($projectId) || empty($targetUrl)) {
            $this->flash('error', 'Project and Target URL are required.');
            $this->redirect('orders/create');
        }
        
        // Verify project ownership
        $projectModel = new Project();
        $project = $projectModel->findByIdAndUser($projectId, Auth::id());
        if (!$project) {
            $this->flash('error', 'Invalid project.');
            $this->redirect('orders/create');
        }
        
        $orderModel = new Order();
        $orderModel->createOrder($projectId, [
            'target_url'        => $targetUrl,
            'desired_anchor'    => trim($_POST['desired_anchor'] ?? ''),
            'source_preference' => trim($_POST['source_preference'] ?? ''),
            'notes'             => trim($_POST['notes'] ?? ''),
            'priority'          => $_POST['priority'] ?? 'medium'
        ]);
        
        $this->flash('success', 'Backlink order placed successfully!');
        $this->redirect('orders');
    }
    
    public function updateStatus(int $id): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('orders');
        }
        
        $orderModel = new Order();
        $order = $orderModel->findById($id);
        
        if ($order) {
            $projectModel = new Project();
            $project = $projectModel->findByIdAndUser($order['project_id'], Auth::id());
            if ($project) {
                $newStatus = $_POST['status'] ?? $order['status'];
                $orderModel->update($id, ['status' => $newStatus]);
                $this->flash('success', 'Order status updated.');
            }
        }
        
        $this->redirect('orders');
    }
    
    public function destroy(int $id): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('orders');
        }
        
        $orderModel = new Order();
        $order = $orderModel->findById($id);
        
        if ($order) {
            $projectModel = new Project();
            $project = $projectModel->findByIdAndUser($order['project_id'], Auth::id());
            if ($project) {
                $orderModel->delete($id);
                $this->flash('success', 'Order cancelled.');
            }
        }
        
        $this->redirect('orders');
    }
}
