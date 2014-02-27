# create elections table
CREATE TABLE IF NOT EXISTS elections (
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	description TEXT NOT NULL
) TYPE = INNODB CHARACTER SET utf8;

# create candidate information table
CREATE TABLE IF NOT EXISTS candidates (
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	election_id INTEGER NOT NULL,
	username TEXT NOT NULL,
	password TEXT NOT NULL,
	website TEXT,
	thread TEXT,
	twitter TEXT,
	char_name TEXT NOT NULL,
	char_id INTEGER NOT NULL,
	corp_name TEXT,
	alliance_name TEXT,
	real_name TEXT,
	real_location TEXT,
	real_age INTEGER,
	real_occupation TEXT,
	played_since DATE,
	flies_in TEXT,
	playstyle TEXT,
	can_evemail BOOL,
	can_convo BOOL,
	email TEXT,
	campaign_statement TEXT,
	experience_eve TEXT,
	experience_real TEXT,
	INDEX char_id_ind (char_id),
	FOREIGN KEY (election_id) REFERENCES elections(id) ON DELETE CASCADE
) TYPE = INNODB CHARACTER SET utf8;

# create open questions table 
CREATE TABLE IF NOT EXISTS open_questions (
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	election_id INTEGER NOT NULL,
	question TEXT NOT NULL,
	FOREIGN KEY (election_id) REFERENCES elections(id) ON DELETE CASCADE
) TYPE = INNODB CHARACTER SET utf8;

#create table for answers to open questions
CREATE TABLE IF NOT EXISTS open_answers (
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	question_id INTEGER NOT NULL,
	candidate_id INTEGER NOT NULL,
	answer TEXT NOT NULL,
	FOREIGN KEY (question_id) REFERENCES open_questions(id) ON DELETE CASCADE,
	FOREIGN KEY (candidate_id) REFERENCES candidates(id) ON DELETE CASCADE
) TYPE = INNODB CHARACTER SET utf8;

# create table for OKCupid style questions
CREATE TABLE IF NOT EXISTS okc_questions (
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	election_id INTEGER NOT NULL,
	question_en TEXT NOT NULL,
	question_rus TEXT NOT NULL,
	question_ger TEXT NOT NULL,
	question_jp TEXT NOT NULL,
	FOREIGN KEY (election_id) REFERENCES elections(id) ON DELETE CASCADE
) TYPE = INNODB CHARACTER SET utf8;

# create table for options (possible answers) for OKC style questions
CREATE TABLE IF NOT EXISTS okc_options (
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	question_id INTEGER NOT NULL,
	option_en TEXT NOT NULL,
	option_rus TEXT NOT NULL,
	option_ger TEXT NOT NULL,
	option_jp TEXT NOT NULL,
	FOREIGN KEY (question_id) REFERENCES okc_questions(id) ON DELETE CASCADE
) TYPE = INNODB CHARACTER SET utf8;

# create table for candidate answers to the OKC style questions
CREATE TABLE IF NOT EXISTS okc_answers (
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	candidate_id INTEGER NOT NULL,
	answer_id INTEGER NOT NULL,
	weight INTEGER NOT NULL,
	comment TEXT,
	FOREIGN KEY (answer_id) REFERENCES okc_options(id) ON DELETE CASCADE,
	FOREIGN KEY (candidate_id) REFERENCES candidates(id) ON DELETE CASCADE
) TYPE = INNODB CHARACTER SET utf8;

# create table where we store preview CSM character id's (not FK)evecsm2
CREATE TABLE IF NOT EXISTS csm_history (
	id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
	character_id INTEGER NOT NULL,
	csm TINYINT(2) NOT NULL,
	INDEX char_id_ind (character_id),
) TYPE = INNODB CHARACTER SET utf8;