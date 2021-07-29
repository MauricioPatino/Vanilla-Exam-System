# README #

### Online Exam System ###

### Assignment Description ###

2 Login roles: Teacher + Student
    When teacher logs they'll be sent to a teacher.html page
    while Student gets sent to a student.html apge

Use cases:
    1) teacher logs in + add questions to question bank
    2) teacher selects questions to make exam
    3) student logs in annd takes exams
    4) Exam is auto-graded. Instructor takes scores, adds comments + releases exam
    5)student reviews results 
    
    
### mid setup ###
Middle end consists of:
mid_autograder.php
mid_proxy.php

Make sure in those 2 scripts all URLs are changed from test backend computer
http://mp924.mooo.com:3000/onlineexam/<script_name>
to actual AFS URLs
https://web.njit.edu/~emo26/includes/<script_name>

### back setup ###
Scripts:
back_exams.php - handles requests for managing exams
back_include.php - authenticates each request, similar to login process
back_login.php - handles login
back_questions.php - requests for managing questions
back_results.php - requests for saving results, viewing and reviewing by instructor
db.php - connection (use your db.php)

Create database tables and data as follows

-in AFS terminal login into mysql commang line:
mysql -u emo26 -p 

/* switch to your database */
use emo26;

/* remove old users table because we need different fields in it */
DROP TABLE users;

/* create new users table */
CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255) NOT NULL,
	md5 VARCHAR(255) NOT NULL,
	userType VARCHAR(255) NOT NULL,
	CONSTRAINT unique_username UNIQUE (username)
);

/* create data: users 
student/student
instructor/instructor
 */
INSERT INTO users (username, md5, userType) values 
('student', 'cd73502828457d15655bbd7a63fb0bc8', 'student');
INSERT INTO users (username, md5, userType) values 
('instructor', '175cca0310b93021a7d3cfb3e4877ab6', 'instructor');

/* create questions table */
CREATE TABLE questions (
	id INT AUTO_INCREMENT PRIMARY KEY,
	category VARCHAR(255) NOT NULL,
	description VARCHAR(10000) NOT NULL,
	difficulty VARCHAR(255) NOT NULL,
	functionName VARCHAR(255) NOT NULL,
	outputWay VARCHAR(255) NOT NULL,
	testCaseValues VARCHAR(255) NOT NULL,
	testCaseResults VARCHAR(10000) NOT NULL,
	points INT NOT NULL);
	
/* create exams table */
CREATE TABLE exams (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(512) NOT NULL,
	questions VARCHAR(10000) NOT NULL,
	created VARCHAR(255) NOT NULL,
	CONSTRAINT unique_exam_name UNIQUE (name));
	
/*create table results*/
CREATE TABLE results (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255) NOT NULL,
	exam_id INT NOT NULL,
	takenOn VARCHAR(255) NOT NULL,
	autoGrade INT NOT NULL,
	released TINYINT NOT NULL,
	CONSTRAINT fk_exam FOREIGN KEY (exam_id) REFERENCES exams(id),
	CONSTRAINT fk_username FOREIGN KEY (username) REFERENCES users(username)
);

/*create answers */
CREATE TABLE answers (
	id INT AUTO_INCREMENT PRIMARY KEY,
	question_id INT NOT NULL,
	result_id INT NOT NULL,
	answer VARCHAR(10000) NOT NULL,
	passed TINYINT NOT NULL,
	autograderComment VARCHAR(10000) NOT NULL,
	CONSTRAINT fk_result FOREIGN KEY (result_id) REFERENCES results(id),
	CONSTRAINT fk_question FOREIGN KEY (question_id) REFERENCES questions(id)
);