CREATE TABLE IF NOT EXISTS t_caisseDetails (
	id INT(11) NOT NULL AUTO_INCREMENT,
	dateOperation DATE DEFAULT NULL,
	personne VARCHAR(100) DEFAULT NULL,
	designation TEXT DEFAULT NULL,
	projet VARCHAR(100) DEFAULT NULL,
	type VARCHAR(50) DEFAULT NULL,
	montant DECIMAL(12,2) DEFAULT NULL,
	commentaire TEXT DEFAULT NULL,
	created DATE DEFAULT NULL,
	createdBy VARCHAR(50) DEFAULT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;