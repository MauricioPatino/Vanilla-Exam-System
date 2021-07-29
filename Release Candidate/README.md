# README #

### Online Exam System ###

### Assignment Description ###

Notes: Use Cases for CS 490 Project


Prereq: Instructor and Student login. Successful log in sends user to correct landing page (student or instructor).


1)Instructor adds a question to the Question Bank. 

Every question is of the form "Write a question named _________ that takes arguments ___________ does ________________________ and returns (or prints) the result." Please use a text area for the body of the description.

Pull down lists for topics (include at least six topics) and difficulty (only easy, medium and hard). No points!!!

Two test cases for each question were required for the Beta. Now, you must have a minimum of two and a maximum of 6 test cases. I will include questions the answers for which might pass some test cases and not others.

You must have a split screen that filters existing questions by topic, difficulty and keyword (found in the description).

You must include a drop down for constraints (e.g. for, while, print) meaning the answer must include a for statement or a while statement or a print statement. Only one contraint per question.


2)Instructor creates an Exam.

Must use split screen.

Points are assigned only to questions that have been added to an exam.


3)Student takes exam.

You must display the points for each question.

You must use a text area for the student's answer. Make sure it is large enough (no single line text fields!).


4) Instructor previews Auto-graded results.

Itemize every sub-item per question. You should use a table where the last column of each row may be used by the instructor to override the score on that sub-item.

For the Beta you were supposed to check the name of the function and run the two test cases. That would have been three rows in the results table. Going forward you will also check whether a colon appears at the end of the first line, and also if a required constraint was followed. Thus, for each question, your results table should have a minimum of 6 rows (5 sub-items and one comment).

You can check for more sub-items, but, you must have the 5 described above at a minimum.



5) Student reviews results.

This should should the complete auto-grading and overridden results. The goal here is to be clear and precise (and hopefully, educational). You have been taking exams for years - you know what good feedback should look like.


PS. Your system should be able to handle the following question:


		Write a function named "operation" that takes three arguments: "op" which is an 			arithmetic operator, "+","-","*" or "/", and "a" and "b" which are two int numbers. 			The function must return the result.

		For example, if operation is called as "operation("+", 2, 3)" the correct output would 		be 5.


A completely correct answer to the above question would be as follows:


def operation(op, a, b):
	if op == '+':
		return a + b
	elif op == '-':
		return a - b
	elif op == '*':
		return a * b
	elif op == '/':
		return a / b
	else:
		return -1

In order to properly test the above answer you will need 5 test cases. The student's answer might pass none, some or all of them.


In order to test the above answer you will need at least 5 test cases.

    
    
### mid setup ###
--get updated 
mid_autograder.php

old info:
Middle end consists of:
mid_autograder.php
mid_proxy.php

Make sure in those 2 scripts all URLs are changed from test backend computer
http://mp924.mooo.com:3000/onlineexam/<script_name>
to actual AFS URLs
https://web.njit.edu/~emo26/includes/<script_name>

### back setup ###
/* move points from questions table to exams table: */
ALTER TABLE questions DROP COLUMN points;
ALTER TABLE exams ADD COLUMN points VARCHAR(1000);
ALTER TABLE questions ADD COLUMN constr VARCHAR(255);
alter table answers drop column passed;
alter table answers add column maxPoints INTEGER;

Changed scripts:
back_exams.php
back_questions.php
back_results.php

old info:

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