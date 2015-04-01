--test statements
insert into Registered_User (email,userPassword,username) values('sebastian.wong@hotmail.com', 'password123', 'sebbysebseb');
insert into Registered_User (email,userPassword,username) values('chewyxiu@hotmail.com', 'chewyxiu', 'chewyxiu');
insert into Registered_User (email,userPassword,username) values('april_angela21@hotmail.com', 'angelalala', 'angela');
insert into Registered_User (email,userPassword,username) values('ronney@hotmail.com', 'ronney123', 'ronney91');
insert into Registered_User (email,userPassword,username) values('allen@hotmail.com', 'allen321', 'allen');
select * from registered_user;
drop table registered_user;



--test statements
--username should be automatically reflect user himself
--success in posting duplicates
insert into post_writepost(post_title, post_content, post_username) values ('Introduction post','Hello, this is my first post in social networking site, thank you', 'sebbysebseb');
insert into post_writepost(post_title, post_content, post_username) values ('Introduction post','Hello, this is my first post in social networking site, thank you', 'sebbysebseb');
select * from post_writepost;
DROP table post_writepost;


--test statements
--sub query 
--insert into contains_comments(comment_username,post_username,post_title,post_time,comment_content)
 --values ('sebbysebseb','sebbysebseb','Introduction post','15/01/01 01:25:25','Your post is excellent')

--test statements
--voting post
--insert into vote_post(hasVoted,voter_username,post_username,post_title) values ('Y','sebbysebseb','sebbysebseb','Introduction post')

--test statements
--voting comment
--insert into vote_comment(hasVoted,voter_username,comment_username,post_title, post_content, post_username) 
--values ('Y','sebbysebseb','sebbysebseb','Introduction post','Hello, this is my first post in social networking site, thank you','sebbysebseb');

--test statements
--vote comment

--test statements
--search posts of some username
--Select * from post_writepost where post_username= ‘Ronny’ order by post_time desc;

--test statements
--search posts of some title
--Select * from post_writepost where post_title like ‘%Chicken Rice%’  order by post_time desc;
