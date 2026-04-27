<?php
class ReportController extends Controller {
    
    public function index(): void {
        $this->requireAuth();
        $reportModel = new Report();
        $reports = $reportModel->findByUser(Auth::id());
        
        $projectModel = new Project();
        $projects = $projectModel->findByUser(Auth::id());
        
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        
        $this->view('reports.index', compact('reports', 'projects', 'user', 'csrf', 'flash', 'unreadAlerts'));
    }
    
    public function generate(): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('reports');
        }
        
        $projectId = (int)($_POST['project_id'] ?? 0);
        $month = (int)($_POST['month'] ?? date('n'));
        $year = (int)($_POST['year'] ?? date('Y'));
        
        if (empty($projectId)) {
            // Generate for all projects
            $projectModel = new Project();
            $projects = $projectModel->findByUser(Auth::id());
            $reportModel = new Report();
            foreach ($projects as $project) {
                $reportModel->generateMonthlyReport(Auth::id(), $project['id'], $month, $year);
            }
            $this->flash('success', 'Reports generated for all projects!');
        } else {
            // Verify ownership
            $projectModel = new Project();
            $project = $projectModel->findByIdAndUser($projectId, Auth::id());
            if (!$project) {
                $this->flash('error', 'Project not found.');
                $this->redirect('reports');
            }
            
            $reportModel = new Report();
            $reportModel->generateMonthlyReport(Auth::id(), $projectId, $month, $year);
            $this->flash('success', 'Report generated successfully!');
        }
        
        $this->redirect('reports');
    }
}
