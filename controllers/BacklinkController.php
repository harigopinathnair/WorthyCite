<?php
class BacklinkController extends Controller {
    
    public function index(int $projectId): void {
        $this->requireAuth();
        
        $projectModel = new Project();
        $project = $projectModel->findByIdAndUser($projectId, Auth::id());
        if (!$project) {
            $this->flash('error', 'Project not found.');
            $this->redirect('projects');
        }
        
        $backlinkModel = new Backlink();
        $statusFilter = $_GET['status'] ?? null;
        $backlinks = $backlinkModel->findByProject($projectId, $statusFilter);
        
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        
        $userModel = new User();
        $backlinkLimit = $userModel->canAddBacklink(Auth::id(), $projectId);
        
        $this->view('backlinks.index', compact('project', 'backlinks', 'user', 'csrf', 'flash', 'statusFilter', 'unreadAlerts', 'backlinkLimit'));
    }
    
    public function create(int $projectId): void {
        $this->requireAuth();
        
        $projectModel = new Project();
        $project = $projectModel->findByIdAndUser($projectId, Auth::id());
        if (!$project) {
            $this->flash('error', 'Project not found.');
            $this->redirect('projects');
        }
        
        // Check backlink limit
        $userModel = new User();
        $backlinkLimit = $userModel->canAddBacklink(Auth::id(), $projectId);
        
        if (!$backlinkLimit['allowed']) {
            $this->flash('warning', "You've reached your plan limit of {$backlinkLimit['max']} backlinks for this project. Upgrade to Pro for more!");
            $this->redirect("projects/$projectId?tab=backlinks");
        }
        
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        $vendors = (new Contact())->findByUser(Auth::id());
        
        $this->view('backlinks.create', compact('project', 'user', 'csrf', 'flash', 'unreadAlerts', 'backlinkLimit', 'vendors'));
    }
    
    public function store(int $projectId): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect("projects/$projectId/backlinks/create");
        }
        
        $projectModel = new Project();
        $project = $projectModel->findByIdAndUser($projectId, Auth::id());
        if (!$project) {
            $this->flash('error', 'Project not found.');
            $this->redirect('projects');
        }
        
        // Enforce backlink limit
        $userModel = new User();
        $backlinkLimit = $userModel->canAddBacklink(Auth::id(), $projectId);
        if (!$backlinkLimit['allowed']) {
            $this->flash('warning', "You've reached your plan limit of {$backlinkLimit['max']} backlinks per project. Upgrade your plan to track more backlinks.");
            $this->redirect("projects/$projectId?tab=backlinks");
            return;
        }
        
        $sourceUrl = trim($_POST['source_url'] ?? '');
        $targetUrl = trim($_POST['target_url'] ?? '');
        $anchorText = trim($_POST['anchor_text'] ?? '');
        
        if (empty($sourceUrl) || empty($targetUrl)) {
            $this->flash('error', 'Source URL and Target URL are required.');
            $this->redirect("projects/$projectId/backlinks/create");
        }
        
        $backlinkModel = new Backlink();
        $backlinkModel->addBacklink($projectId, [
            'vendor_id'     => !empty($_POST['vendor_id']) ? (int) $_POST['vendor_id'] : null,
            'source_url'    => $sourceUrl,
            'target_url'    => $targetUrl,
            'anchor_text'   => $anchorText,
            'link_type'     => $_POST['link_type'] ?? 'dofollow',
            'da_score'      => (int)($_POST['da_score'] ?? 0),
            'acquired_date' => $_POST['acquired_date'] ?? date('Y-m-d')
        ]);
        
        $this->flash('success', 'Backlink added successfully!');
        $this->redirect("projects/$projectId?tab=backlinks");
    }
    
    public function destroy(int $id): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('projects');
        }
        
        $backlinkModel = new Backlink();
        $backlink = $backlinkModel->findById($id);
        
        if ($backlink) {
            // Verify ownership
            $projectModel = new Project();
            $project = $projectModel->findByIdAndUser($backlink['project_id'], Auth::id());
            if ($project) {
                $backlinkModel->delete($id);
                $this->flash('success', 'Backlink removed.');
                $this->redirect("projects/{$backlink['project_id']}?tab=backlinks");
                return;
            }
        }
        
        $this->flash('error', 'Backlink not found.');
        $this->redirect('projects');
    }
}
