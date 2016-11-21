ALTER TABLE `fcs_orders` ADD `general_terms_and_conditions_accepted` TINYINT(4) UNSIGNED NOT NULL AFTER `total_deposit`, ADD `cancellation_terms_accepted` TINYINT(4) UNSIGNED NOT NULL AFTER `general_terms_and_conditions_accepted`;
ALTER TABLE `fcs_manufacturer` ADD `firmenbuchnummer` VARCHAR(20) NOT NULL AFTER `bank_name`, ADD `firmengericht` VARCHAR(150) NOT NULL AFTER `firmenbuchnummer`, ADD `aufsichtsbehoerde` VARCHAR(150) NOT NULL AFTER `firmengericht`, ADD `kammer` VARCHAR(150) NOT NULL AFTER `aufsichtsbehoerde`, ADD `homepage` VARCHAR(255) NOT NULL AFTER `kammer`;
