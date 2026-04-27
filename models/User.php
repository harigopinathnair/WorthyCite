<?php
class User extends Model {
    protected string $table = 'users';
    
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    public function register(array $data): int {
        return $this->create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password_hash' => Auth::hashPassword($data['password']),
            'plan'          => 'free'
        ]);
    }
    
    public function updateProfile(int $id, array $data): bool {
        $allowed = ['name', 'email', 'email_notifications'];
        $filtered = array_intersect_key($data, array_flip($allowed));
        return $this->update($id, $filtered);
    }
    
    /**
     * Get the plan limits for a user
     */
    public function getPlanLimits(int $userId): array {
        $user = $this->findById($userId);
        $plan = $user['plan'] ?? 'free';
        $limits = PLANS[$plan] ?? PLANS['free'];
        
        // Manual User Overrides
        if (isset($user['custom_projects_limit']) && $user['custom_projects_limit'] !== null) {
            $limits['projects'] = (int) $user['custom_projects_limit'];
        }
        if (isset($user['custom_total_backlinks']) && $user['custom_total_backlinks'] !== null) {
            $limits['total_backlinks'] = (int) $user['custom_total_backlinks'];
            unset($limits['backlinks_per_project']);
        }

        
        return $limits;
    }
    
    /**
     * Check if user can create another project
     */
    public function canCreateProject(int $userId): array {
        $limits = $this->getPlanLimits($userId);
        $maxProjects = $limits['projects'];
        
        // -1 means unlimited
        if ($maxProjects === -1) {
            return ['allowed' => true, 'current' => 0, 'max' => -1];
        }
        
        $projectModel = new Project();
        $currentCount = $projectModel->count(['user_id' => $userId]);
        
        return [
            'allowed' => $currentCount < $maxProjects,
            'current' => $currentCount,
            'max'     => $maxProjects
        ];
    }
    
    public function canAddBacklink(int $userId, int $projectId): array {
        $limits = $this->getPlanLimits($userId);
        
        if (isset($limits['total_backlinks'])) {
            $maxBacklinks = $limits['total_backlinks'];
            
            if ($maxBacklinks === -1) {
                return ['allowed' => true, 'current' => 0, 'max' => -1];
            }
            
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM backlinks b JOIN projects p ON b.project_id = p.id WHERE p.user_id = ?");
            $stmt->execute([$userId]);
            $currentCount = (int) $stmt->fetchColumn();
            
        } else {
            $maxBacklinks = $limits['backlinks_per_project'] ?? 0;
            
            if ($maxBacklinks === -1) {
                return ['allowed' => true, 'current' => 0, 'max' => -1];
            }
            
            $backlinkModel = new Backlink();
            $currentCount = count($backlinkModel->findByProject($projectId));
        }
        
        return [
            'allowed' => $currentCount < $maxBacklinks,
            'current' => $currentCount,
            'max'     => $maxBacklinks
        ];
    }
    
    /**
     * Upgrade/change user plan
     */
    public function upgradePlan(int $id, string $plan): bool {
        if (!array_key_exists($plan, PLANS)) {
            return false;
        }
        return $this->update($id, ['plan' => $plan]);
    }
}
