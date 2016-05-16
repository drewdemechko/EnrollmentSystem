create table myuser (
  userid varchar2(8) primary key,
  password varchar2(12),
  usertype varchar2(1)
);

create table myusersession (
  sessionid varchar2(32) primary key,
  userid varchar2(8),
  sessiondate date,
  foreign key (userid) references myuser
);

commit;

