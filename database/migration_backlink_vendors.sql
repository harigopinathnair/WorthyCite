ALTER TABLE backlinks 
ADD COLUMN vendor_id INT DEFAULT NULL AFTER project_id;

ALTER TABLE backlinks 
ADD CONSTRAINT fk_backlink_vendor 
FOREIGN KEY (vendor_id) REFERENCES vendor_contacts(id) 
ON DELETE SET NULL;
