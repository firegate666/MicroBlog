begin;

insert into Blog(title) values ('Blog 1');
insert into Blog(title) values ('Blog 2');
insert into Blog(title) values ('Blog 3');

insert into Post(blog_id, content) values (1, 'Post 1-1');
insert into Comment(post_id, content) values (1, 'Comment 1');
insert into Comment(post_id, content) values (1, 'Comment 2');
insert into Comment(post_id, content) values (1, 'Comment 3');

insert into Post(blog_id, content) values (1, 'Post 1-2');
insert into Comment(post_id, content) values (2, 'Comment 4');
insert into Comment(post_id, content) values (2, 'Comment 5');
insert into Comment(post_id, content) values (2, 'Comment 6');

insert into Post(blog_id, content) values (1, 'Post 1-3');
insert into Comment(post_id, content) values (3, 'Comment 7');

insert into Post(blog_id, content) values (2, 'Post 2-1');
insert into Comment(post_id, content) values (4, 'Comment 8');

insert into Post(blog_id, content) values (2, 'Post 2-2');
insert into Post(blog_id, content) values (2, 'Post 2-3');
insert into Post(blog_id, content) values (2, 'Post 2-4');
insert into Post(blog_id, content) values (3, 'Post 3-1');
insert into Post(blog_id, content) values (3, 'Post 3-2');


commit;
