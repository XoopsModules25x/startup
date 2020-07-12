CREATE TABLE `startup_page` (
`group_id` INT NOT NULL ,
`module_id` INT NOT NULL ,
`start_order` INT NOT NULL ,
PRIMARY KEY ( `group_id` , `module_id` )
)TYPE = MYISAM 
COMMENT = 'Contient la relation entre le module de départ et le groupe';