<?php
class Alert extends Model {
    protected string $table = 'alerts';
    
    public function findByUser(int $userId, bool $unreadOnly = false, int $limit = 50): array {
        $sql = "SELECT a.*, p.name as project_name, p.domain
                FROM alerts a
                LEFT JOIN projects p ON a.project_id = p.id
                WHERE a.user_id = ?";
        $params = [$userId];
        if ($unreadOnly) {
            $sql .= " AND a.is_read = 0";
        }
        $sql .= " ORDER BY a.created_at DESC LIMIT ?";
        $params[] = $limit;
        return $this->query($sql, $params);
    }
    
    public function unreadCount(int $userId): int {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM alerts WHERE user_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }
    
    public function createAlert(array $data): int {
        return $this->create([
            'user_id'     => $data['user_id'],
            'project_id'  => $data['project_id'] ?? null,
            'backlink_id' => $data['backlink_id'] ?? null,
            'alert_type'  => $data['alert_type'],
            'severity'    => $data['severity'] ?? 'warning',
            'message'     => $data['message'],
            'details'     => $data['details'] ?? null,
            'email_sent'  => $data['email_sent'] ?? 0
        ]);
    }
    
    public function markAsRead(int $id, int $userId): bool {
        return $this->execute(
            "UPDATE alerts SET is_read = 1 WHERE id = ? AND user_id = ?",
            [$id, $userId]
        );
    }
    
    public function markAllRead(int $userId): bool {
        return $this->execute(
            "UPDATE alerts SET is_read = 1 WHERE user_id = ? AND is_read = 0",
            [$userId]
        );
    }
    
    public function getRecentByType(int $userId, int $limit = 10): array {
        return $this->query(
            "SELECT alert_type, COUNT(*) as count, MAX(created_at) as latest
             FROM alerts WHERE user_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
             GROUP BY alert_type ORDER BY latest DESC",
            [$userId]
        );
    }
}
