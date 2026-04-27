<?php
class Report extends Model {
    protected string $table = 'monthly_reports';
    
    public function findByUser(int $userId, int $limit = 12): array {
        return $this->query(
            "SELECT r.*, p.name as project_name, p.domain
             FROM monthly_reports r
             LEFT JOIN projects p ON r.project_id = p.id
             WHERE r.user_id = ?
             ORDER BY r.report_year DESC, r.report_month DESC
             LIMIT ?",
            [$userId, $limit]
        );
    }
    
    public function generateMonthlyReport(int $userId, int $projectId, int $month, int $year): int {
        $db = $this->db;
        
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));
        
        // Get stats
        $stats = $db->prepare(
            "SELECT 
                COUNT(*) as total_backlinks,
                SUM(CASE WHEN acquired_date BETWEEN ? AND ? THEN 1 ELSE 0 END) as new_backlinks,
                SUM(CASE WHEN status = 'lost' THEN 1 ELSE 0 END) as lost_backlinks,
                SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_backlinks,
                ROUND(AVG(da_score), 2) as avg_da
             FROM backlinks WHERE project_id = ?"
        );
        $stats->execute([$startDate, $endDate, $projectId]);
        $data = $stats->fetch();
        
        // Check if report exists
        $existing = $this->query(
            "SELECT id FROM monthly_reports WHERE user_id = ? AND project_id = ? AND report_month = ? AND report_year = ?",
            [$userId, $projectId, $month, $year]
        );
        
        $reportData = [
            'user_id'          => $userId,
            'project_id'       => $projectId,
            'report_month'     => $month,
            'report_year'      => $year,
            'total_backlinks'  => $data['total_backlinks'] ?? 0,
            'new_backlinks'    => $data['new_backlinks'] ?? 0,
            'lost_backlinks'   => $data['lost_backlinks'] ?? 0,
            'active_backlinks' => $data['active_backlinks'] ?? 0,
            'avg_da'           => $data['avg_da'] ?? 0,
            'report_data'      => json_encode($data)
        ];
        
        if (!empty($existing)) {
            $this->update($existing[0]['id'], $reportData);
            return $existing[0]['id'];
        }
        
        return $this->create($reportData);
    }
}
