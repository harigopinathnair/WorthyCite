ALTER TABLE vendor_contacts ENGINE=InnoDB;

ALTER TABLE backlinks 
ADD CONSTRAINT fk_backlink_vendor 
FOREIGN KEY (vendor_id) REFERENCES vendor_contacts(id) 
ON DELETE SET NULL;
