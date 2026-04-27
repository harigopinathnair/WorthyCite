<?php
class Project extends Model {
    protected string $table = 'projects';
    
    public function findByUser(int $userId): array {
        return $this->query(
            "SELECT p.*, 
                    (SELECT COUNT(*) FROM backlinks WHERE project_id = p.id) as backlink_count,
                    (SELECT COUNT(*) FROM backlinks WHERE project_id = p.id AND status = 'active') as active_count,
                    (SELECT COUNT(*) FROM alerts WHERE project_id = p.id AND is_read = 0) as alert_count
             FROM projects p WHERE p.user_id = ? ORDER BY p.created_at DESC",
            [$userId]
        );
    }
    
    public function findByIdAndUser(int $id, int $userId): ?array {
        $stmt = $this->db->prepare(
            "SELECT p.*, 
                    (SELECT COUNT(*) FROM backlinks WHERE project_id = p.id) as backlink_count,
                    (SELECT COUNT(*) FROM backlinks WHERE project_id = p.id AND status = 'active') as active_count,
                    (SELECT COUNT(*) FROM backlinks WHERE project_id = p.id AND status = 'lost') as lost_count,
                    (SELECT COUNT(*) FROM backlink_orders WHERE project_id = p.id AND status != 'cancelled') as order_count
             FROM projects p WHERE p.id = ? AND p.user_id = ?"
        );
        $stmt->execute([$id, $userId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    public function createProject(int $userId, array $data): int {
        return $this->create([
            'user_id'     => $userId,
            'name'        => $data['name'],
            'domain'      => $data['domain'],
            'description' => $data['description'] ?? null,
            'status'      => 'active'
        ]);
    }
}
