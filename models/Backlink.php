<?php
class Backlink extends Model {
    protected string $table = 'backlinks';
    
    public function findByProject(int $projectId, ?string $status = null): array {
        $sql = "SELECT b.*, v.name as vendor_name FROM backlinks b 
                LEFT JOIN vendor_contacts v ON b.vendor_id = v.id 
                WHERE b.project_id = ?";
        $params = [$projectId];
        if ($status) {
            $sql .= " AND b.status = ?";
            $params[] = $status;
        }
        $sql .= " ORDER BY b.created_at DESC";
        return $this->query($sql, $params);
    }
    
    public function findByUser(int $userId, ?string $status = null, int $limit = 50): array {
        $sql = "SELECT b.*, p.name as project_name, p.domain 
                FROM backlinks b 
                JOIN projects p ON b.project_id = p.id 
                WHERE p.user_id = ?";
        $params = [$userId];
        if ($status) {
            $sql .= " AND b.status = ?";
            $params[] = $status;
        }
        $sql .= " ORDER BY b.created_at DESC LIMIT ?";
        $params[] = $limit;
        return $this->query($sql, $params);
    }
    
    public function getActiveBacklinks(): array {
        return $this->query(
            "SELECT b.*, p.name as project_name, p.domain, p.user_id 
             FROM backlinks b 
             JOIN projects p ON b.project_id = p.id 
             WHERE b.status IN ('active', 'pending', 'warning') AND p.status = 'active'
             ORDER BY b.last_checked ASC"
        );
    }
    
    public function addBacklink(int $projectId, array $data): int {
        return $this->create([
            'project_id'    => $projectId,
            'vendor_id'     => !empty($data['vendor_id']) ? $data['vendor_id'] : null,
            'source_url'    => $data['source_url'],
            'target_url'    => $data['target_url'],
            'anchor_text'   => $data['anchor_text'] ?? null,
            'link_type'     => $data['link_type'] ?? 'dofollow',
            'da_score'      => $data['da_score'] ?? 0,
            'acquired_date' => $data['acquired_date'] ?? date('Y-m-d'),
            'status'        => 'pending'
        ]);
    }
    
    public function getMonthlyStats(int $userId, int $months = 6): array {
        return $this->query(
            "SELECT 
                DATE_FORMAT(b.acquired_date, '%Y-%m') as month,
                COUNT(*) as total,
                SUM(CASE WHEN b.status = 'active' THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN b.status = 'lost' THEN 1 ELSE 0 END) as lost,
                ROUND(AVG(b.da_score), 1) as avg_da
             FROM backlinks b
             JOIN projects p ON b.project_id = p.id
             WHERE p.user_id = ? AND b.acquired_date >= DATE_SUB(CURDATE(), INTERVAL ? MONTH)
             GROUP BY DATE_FORMAT(b.acquired_date, '%Y-%m')
             ORDER BY month ASC",
            [$userId, $months]
        );
    }
    
    public function getStatusCounts(int $userId): array {
        return $this->query(
            "SELECT b.status, COUNT(*) as count
             FROM backlinks b
             JOIN projects p ON b.project_id = p.id
             WHERE p.user_id = ?
             GROUP BY b.status",
            [$userId]
        );
    }
}
