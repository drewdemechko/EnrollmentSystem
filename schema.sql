drop table emp;
drop table dept;

drop table myclientsession cascade constraints;
drop table myclient cascade constraints;

create table myclient (
  clientid varchar2(8) primary key,
  password varchar2(12)
);

create table myclientsession (
  sessionid varchar2(32) primary key,
  clientid varchar2(8),
  sessiondate date,
  foreign key (clientid) references myclient
);
 

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

create table dept (
  dnumber number(5) primary key,
  dname varchar2(50) not null unique,
  location varchar2(100)
);


create table emp (
  eid number(10) primary key,
  fname varchar2(30) not null, 
  lname varchar2(30) not null, 
  start_date date,
  dnumber number(5) not null references dept 
);

insert into myclient values ('a', 'a');

insert into myuser values ('jlee1', '123', 1);
insert into myuser values ('ypark2', '123',2);

insert into dept values (1, 'ABC', 'OKC');
insert into dept values (2, 'DEF', 'NYC');
insert into dept values (3, 'GHI', 'Houston');
insert into dept values (4, 'JKL', 'LA');

insert into emp values (1, 'A', 'B', to_date('12/01/2000', 'mm/dd/yyyy'), 1);
insert into emp values (2, 'C', 'D', to_date('12/01/2001', 'mm/dd/yyyy'), 1);
insert into emp values (3, 'E', 'F', to_date('12/01/1999', 'mm/dd/yyyy'), 2);
insert into emp values (4, 'G', 'H', to_date('12/01/1998', 'mm/dd/yyyy'), 3);
insert into emp values (5, 'I', 'J', to_date('12/01/1997', 'mm/dd/yyyy'), 4);
commit;

