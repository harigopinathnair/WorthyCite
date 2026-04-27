<?php
class AdminController extends Controller {
    
    public function __construct() {
        if (!Auth::check()) {
            $this->redirect('login');
        }
        $user = Auth::user();
        if (!$user || empty($user['is_admin'])) {
            $this->flash('error', 'Unauthorized access.');
            $this->redirect('dashboard');
        }
    }

    public function index(): void {
        $userModel = new User();
        $db = getDB();
        
        // Get metrics
        $metrics = [];
        $metrics['total_users'] = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $metrics['active_projects'] = $db->query("SELECT COUNT(*) FROM projects WHERE status = 'active'")->fetchColumn();
        
        $stmt = $db->query("SELECT id, name, email, plan, created_at, custom_projects_limit FROM users ORDER BY created_at DESC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->view('admin.index', compact('users', 'metrics'));
    }

    public function citecore(): void {
        $csrf = $this->generateCSRF();
        $this->view('admin.citecore', compact('csrf'));
    }

    public function editUser(int $id): void {
        $userModel = new User();
        $user = $userModel->findById($id);
        
        if (!$user) {
            $this->flash('error', 'User not found.');
            $this->redirect('admin');
        }
        
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $this->view('admin.edit', compact('user', 'csrf', 'flash'));
    }

    public function updateUser(int $id): void {
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect("admin/users/$id");
        }
        
        $userModel = new User();
        $user = $userModel->findById($id);
        if (!$user) {
            $this->redirect('admin');
        }
        
        // Update plan
        $plan = $_POST['plan'] ?? 'free';
        $customProjects = !empty($_POST['custom_projects_limit']) ? (int)$_POST['custom_projects_limit'] : null;
        $customBacklinks = !empty($_POST['custom_total_backlinks']) ? (int)$_POST['custom_total_backlinks'] : null;
        $customRuns = !empty($_POST['custom_analyzer_runs']) ? (int)$_POST['custom_analyzer_runs'] : null;
        
        // Manual override for trial extending etc (changing created_at potentially or logic?)
        // In worthycite core, trial expires based on created_at + 7 days
        // but let's add an override
        
        $db = getDB();
        $stmt = $db->prepare("UPDATE users SET plan = ?, custom_projects_limit = ?, custom_total_backlinks = ?, custom_analyzer_runs = ? WHERE id = ?");
        $stmt->execute([
            $plan,
            $customProjects,
            $customBacklinks,
            $customRuns,
            $id
        ]);
        
        $this->flash('success', "User #$id updated successfully.");
        $this->redirect("admin/users/$id");
    }
}
