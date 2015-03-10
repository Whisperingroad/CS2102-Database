CREATE TABLE REGISTERED_USER(
reputation INT,
email VARCHAR(64),
userPassword VARCHAR(64),
username VARCHAR(32) PRIMARY KEY
);

CREATE TABLE post_writepost (
post_time TIMESTAMP,
post_title VARCHAR(32),
post_username VARCHAR(32) REFERENCES REGISTERED_USER(USERNAME),
PRIMARY KEY (post_time, post_title, post_username)
);
CREATE TABLE contains_comments(
count_votes INT,
comment_username VARCHAR(32),
comment_content VARCHAR(128), 
comment_time TIMESTAMP,
post_username VARCHAR(32),
post_title VARCHAR(32),
post_time TIMESTAMP,
FOREIGN KEY (post_username, post_title, post_time) REFERENCES post_writepost( post_username, post_title, post_time),
PRIMARY KEY (post_username, post_title, post_time, comment_username, comment_time)
); 

CREATE TABLE write_comments(
comment_username VARCHAR(32), 
comment_time TIMESTAMP,
post_username VARCHAR(32),
post_title VARCHAR(32),
post_time TIMESTAMP,
FOREIGN KEY (comment_username, comment_time,post_username, post_title, post_time) REFERENCES contains_comments (comment_username, comment_time, post_username, post_title, post_time),
PRIMARY KEY (comment_username, comment_time, post_username, post_title, post_time)
); 

CREATE TABLE vote_post(
hasVoted CHAR(1) CHECK (hasVoted = 'Y' or hasVoted = 'N'),
voter_username VARCHAR(32), 
post_time  TIMESTAMP,
post_title VARCHAR(32),
post_username VARCHAR(32),
FOREIGN KEY(post_time,post_title, post_username) REFERENCES post_writepost(  post_time,post_title, post_username),
FOREIGN KEY(voter_username) REFERENCES REGISTERED_USER(username),
PRIMARY KEY(post_time, post_title, post_username)
);

CREATE TABLE Topic(
topic_title VARCHAR(32) PRIMARY KEY);

CREATE TABLE classifiedBy(
topic_title VARCHAR(32),
post_title VARCHAR(32),
post_time TIMESTAMP,
post_username VARCHAR(32),
FOREIGN KEY (topic_title) REFERENCES  Topic(topic_title),
FOREIGN KEY (post_title, post_time,post_username) REFERENCES post_writepost(post_title, post_time,post_username), 
PRIMARY KEY (topic_title,post_title, post_time,post_username));

CREATE TABLE vote_comments(
hasVoted CHAR(1) CHECK(hasVoted = 'Y' or hasVoted = 'N'),
post_username VARCHAR(32),
post_title VARCHAR(32),
post_time TIMESTAMP,
comment_time TIMESTAMP,
comment_username VARCHAR(32),
vote_username VARCHAR(32),
FOREIGN KEY (vote_username) REFERENCES Registered_User(username),
FOREIGN KEY (comment_time, comment_username, post_username, post_title, post_time) references write_comments(comment_time, comment_username, post_username, post_title, post_time),
PRIMARY KEY (comment_username, comment_time, post_username, post_title, post_time, vote_username, hasVoted)
);
