CREATE OR REPLACE TRIGGER CHANGE_VOTE
BEFORE UPDATE
ON vote_post
FOR EACH ROW
BEGIN
if(:old.hasVoted = 'N' and :new.hasVoted = 'Y') then
update POST_WRITEPOST
	set pvotes = pvotes + 1
	where post_time = :new.post_time and
	post_title = :new.post_title and
	post_username = :new.post_username;
 END IF; 
if (:old.hasVoted = 'Y' and :new.hasVoted = 'N') then
update POST_WRITEPOST
	set pvotes = pvotes - 1
	where post_time = :new.post_time and
	post_title = :new.post_title and
	post_username = :new.post_username;
END IF;
END;