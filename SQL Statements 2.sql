--Needs sub queries for each

------------------------

--Updating a particular post
  UPDATE post_writepost SET post_content = '' and post_title = '' WHERE post_username LIKE '' and post_time LIKE '';

-------------------------------------------------

--voting post
  insert into vote_post(hasVoted,voter_username,post_username,post_title, post_time) values ('Y','sebbysebseb','sebbysebseb','Introduction post','15/01/01 01:25:25')
  
  UPDATE post_writepost SET pvotes = pvotes+1 WHERE post_username LIKE '' and post_time LIKE '';


--voting comment
  insert into vote_comment(hasVoted,voter_username,comment_time,comment_username,post_title,post_username,post_time) 
  values ('Y','sebbysebseb','15/01/01 01:25:25','sebbysebseb','Introduction post','sebbysebseb','15/01/01 01:25:25');
  
  UPDATE contains_comments SET count_votes = count_votes+1 WHERE comment_username LIKE '' and comment_time LIKE '';

------------------------------------------------
  
--Decreasing the vote of a post
--insert into vote_post(hasVoted,voter_username,post_username,post_title,post_time) values ('N','sebbysebseb','sebbysebseb','Introduction post','15/01/01 01:25:25')
  UPDATE vote_post SET hasVoted = 'N' WHERE post_time = '' and post_username = '' and voter_username = '';
  
  UPDATE post_writepost SET pvotes = pvotes-1 WHERE post_username LIKE '' and post_time LIKE '';

--Decreasing the vote of a comment
--insert into vote_comment(hasVoted,voter_username,comment_time,comment_username,post_title,post_username,post_time) 
--values ('N','sebbysebseb','15/01/01 01:25:25','sebbysebseb','Introduction post','sebbysebseb','15/01/01 01:25:25');
  UPDATE vote_comment SET hasVoted = 'N' WHERE comment_username LIKE '' and comment_time LIKE '' and voter_username = '';
  
  UPDATE contains_comments SET count_votes = count_votes-1 WHERE comment_username LIKE '' and comment_time LIKE '';
  
