<?php
class Order extends Model {
    protected string $table = 'backlink_orders';
    
    public function findByProject(int $projectId): array {
        return $this->query(
            "SELECT * FROM backlink_orders WHERE project_id = ? ORDER BY created_at DESC",
            [$projectId]
        );
    }
    
    public function findByUser(int $userId): array {
        return $this->query(
            "SELECT o.*, p.name as project_name, p.domain
             FROM backlink_orders o
             JOIN projects p ON o.project_id = p.id
             WHERE p.user_id = ?
             ORDER BY o.created_at DESC",
            [$userId]
        );
    }
    
    public function createOrder(int $projectId, array $data): int {
        return $this->create([
            'project_id'        => $projectId,
            'target_url'        => $data['target_url'],
            'desired_anchor'    => $data['desired_anchor'] ?? null,
            'source_preference' => $data['source_preference'] ?? null,
            'notes'             => $data['notes'] ?? null,
            'priority'          => $data['priority'] ?? 'medium',
            'status'            => 'pending'
        ]);
    }
    
    public function getStatusCounts(int $userId): array {
        return $this->query(
            "SELECT o.status, COUNT(*) as count
             FROM backlink_orders o
             JOIN projects p ON o.project_id = p.id
             WHERE p.user_id = ?
             GROUP BY o.status",
            [$userId]
        );
    }
}
