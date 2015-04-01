--login
SELECT * FROM REGISTERED_USER where  username='$myusername' and userpassword='$mypassword'

--homepage (display all the posts)
  --what's new (sort by post_time)
  SELECT p.post_title FROM post_writepost p ORDER BY post_time desc;
  --what's hot (sort by pvotes)
  SELECT p.post_title FROM post_writepost p ORDER BY p.pvotes desc;
  
--modify vote
  UPDATE post_writepost SET pvotes = pvotes+1 WHERE post_title LIKE '%Intro%';

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
--search posts of some username
 Select * from post_writepost where post_username= ‘Ronny’ order by post_time desc;

--test statements
--search posts of some title
 Select * from post_writepost where post_title like ‘%Chicken Rice%’  order by post_time desc;




