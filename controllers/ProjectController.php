<?php
class ProjectController extends Controller {
    
    public function index(): void {
        $this->requireAuth();
        $projectModel = new Project();
        $userModel = new User();
        $projects = $projectModel->findByUser(Auth::id());
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        $projectLimit = $userModel->canCreateProject(Auth::id());
        $this->view('projects.index', compact('projects', 'user', 'csrf', 'flash', 'unreadAlerts', 'projectLimit'));
    }
    
    public function create(): void {
        $this->requireAuth();
        $userModel = new User();
        $projectLimit = $userModel->canCreateProject(Auth::id());
        
        if (!$projectLimit['allowed']) {
            $this->flash('warning', "You've reached your plan limit of {$projectLimit['max']} project(s). Upgrade to Pro for more!");
            $this->redirect('billing');
        }
        
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        $this->view('projects.create', compact('user', 'csrf', 'flash', 'unreadAlerts', 'projectLimit'));
    }
    
    public function store(): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('projects/create');
        }
        
        // Enforce plan limits
        $userModel = new User();
        $projectLimit = $userModel->canCreateProject(Auth::id());
        if (!$projectLimit['allowed']) {
            $this->flash('warning', "You've reached your plan limit of {$projectLimit['max']} project(s). Upgrade your plan to add more websites.");
            $this->redirect('billing');
            return;
        }
        
        $name = trim($_POST['name'] ?? '');
        $domain = trim($_POST['domain'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        if (empty($name) || empty($domain)) {
            $this->flash('error', 'Project name and domain are required.');
            $this->redirect('projects/create');
        }
        
        // Clean domain
        $domain = preg_replace('#^https?://#', '', $domain);
        $domain = rtrim($domain, '/');
        
        $projectModel = new Project();
        $projectModel->createProject(Auth::id(), [
            'name'        => $name,
            'domain'      => $domain,
            'description' => $description
        ]);
        
        $this->flash('success', 'Project created successfully!');
        $this->redirect('projects');
    }
    
    public function show(int $id): void {
        $this->requireAuth();
        $projectModel = new Project();
        $project = $projectModel->findByIdAndUser($id, Auth::id());
        
        if (!$project) {
            $this->flash('error', 'Project not found.');
            $this->redirect('projects');
        }
        
        $backlinkModel = new Backlink();
        $orderModel = new Order();
        $alertModel = new Alert();
        $userModel = new User();
        
        $backlinks = $backlinkModel->findByProject($id);
        $orders = $orderModel->findByProject($id);
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = $alertModel->unreadCount(Auth::id());
        $backlinkLimit = $userModel->canAddBacklink(Auth::id(), $id);
        
        $tab = $_GET['tab'] ?? 'backlinks';
        
        $this->view('projects.show', compact('project', 'backlinks', 'orders', 'user', 'csrf', 'flash', 'tab', 'unreadAlerts', 'backlinkLimit'));
    }
    
    public function edit(int $id): void {
        $this->requireAuth();
        $projectModel = new Project();
        $project = $projectModel->findByIdAndUser($id, Auth::id());
        
        if (!$project) {
            $this->flash('error', 'Project not found.');
            $this->redirect('projects');
        }
        
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        $this->view('projects.edit', compact('project', 'user', 'csrf', 'flash', 'unreadAlerts'));
    }
    
    public function updateProject(int $id): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect("projects/$id/edit");
        }
        
        $projectModel = new Project();
        $project = $projectModel->findByIdAndUser($id, Auth::id());
        
        if (!$project) {
            $this->flash('error', 'Project not found.');
            $this->redirect('projects');
        }
        
        $projectModel->update($id, [
            'name'        => trim($_POST['name'] ?? $project['name']),
            'domain'      => trim($_POST['domain'] ?? $project['domain']),
            'description' => trim($_POST['description'] ?? ''),
            'status'      => $_POST['status'] ?? $project['status']
        ]);
        
        $this->flash('success', 'Project updated successfully!');
        $this->redirect("projects/$id");
    }
    
    public function destroy(int $id): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('projects');
        }
        
        $projectModel = new Project();
        $project = $projectModel->findByIdAndUser($id, Auth::id());
        
        if ($project) {
            $projectModel->delete($id);
            $this->flash('success', 'Project deleted.');
        }
        
        $this->redirect('projects');
    }
}
