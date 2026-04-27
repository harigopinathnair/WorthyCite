<?php
class BillingController extends Controller {
    
    public function index(): void {
        $this->requireAuth();
        $user = Auth::user();
        $csrf = $this->generateCSRF();
        $flash = $this->getFlash();
        $unreadAlerts = (new Alert())->unreadCount(Auth::id());
        
        $userModel = new User();
        $projectLimit = $userModel->canCreateProject(Auth::id());
        $currentPlan = $user['plan'] ?? 'free';
        $plans = PLANS;
        
        $this->view('billing.index', compact('user', 'csrf', 'flash', 'unreadAlerts', 'projectLimit', 'currentPlan', 'plans'));
    }
    
    public function upgrade(): void {
        $this->requireAuth();
        if (!$this->validateCSRF()) {
            $this->flash('error', 'Invalid request.');
            $this->redirect('billing');
        }
        
        $newPlan = trim($_POST['plan'] ?? '');
        
        if (!array_key_exists($newPlan, PLANS)) {
            $this->flash('error', 'Invalid plan selected.');
            $this->redirect('billing');
            return;
        }
        
        $user = Auth::user();
        $currentPlan = $user['plan'] ?? 'free';
        
        if ($newPlan === $currentPlan) {
            $this->flash('info', 'You are already on this plan.');
            $this->redirect('billing');
            return;
        }
        
        $userModel = new User();
        $result = $userModel->upgradePlan(Auth::id(), $newPlan);
        
        if ($result) {
            // Update the session user data
            $_SESSION['user']['plan'] = $newPlan;
            
            $planName = ucfirst($newPlan);
            if (PLANS[$newPlan]['price'] > PLANS[$currentPlan]['price']) {
                $this->flash('success', "🎉 Welcome to the $planName plan! You now have access to more features.");
            } else {
                $this->flash('success', "Plan changed to $planName successfully.");
            }
        } else {
            $this->flash('error', 'Failed to update plan. Please try again.');
        }
        
        $this->redirect('billing');
    }
}
