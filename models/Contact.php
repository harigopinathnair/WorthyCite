<?php
class Contact extends Model {
    protected string $table = 'vendor_contacts';
    
    public function findByUser(int $userId): array {
        return $this->findAll(['user_id' => $userId]);
    }
}
