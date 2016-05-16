
drop table myusersession;
drop table myuser;

drop table StudentID;
drop table Prerequisite;
drop table Course;
drop table Course_description;
drop table Course_taken;


drop table myuser cascade constraints;
drop table myusersession cascade constraints;
drop table Student cascade constraints;
drop table Course_taken cascade constraints;
drop table Prerequisite cascade constraints;
drop table Course_description cascade constraints;
drop table Course cascade constraints;


create table myuser (
  userid varchar2(8),
  password varchar2(12),
  usertype varchar2(1),
  primary key(userid)
);

create table myusersession (
  sessionid varchar2(32),
  userid varchar2(8),
  sessiondate date,
  primary key(sessionid),
  foreign key (userid) references myuser
);

create table StudentID(
    nextseqno  number(5),
    primary key (nextseqno)   
);

create table Student(
  sid varchar2(10) ,
  user_id varchar2(8),
  fname varchar2(20) ,
  lname varchar2(20) ,
  birthdate varchar2(10),
  address1 varchar2(50),
  stu_city varchar(40),
  stu_state varchar2(2),
  stu_zip  varchar2(5),
  stype number(1),
  status number(1),
  primary key (sid),
  foreign key (user_id) references myuser
);

create table Course_description(
	course_no varchar2(10), 
	title varchar2(30) NOT NULL, 
	credit number(2),
	primary key (course_no)
);

create table Prerequisite(
	base_cno varchar2(10),
	prereq_cno varchar2(10),
	primary key (base_cno, prereq_cno),
	foreign key (base_cno) references Course_description,
	foreign key (prereq_cno) references Course_description
);

create table Course(
	seq_id varchar2(15),
	cno varchar2(10),
	semester varchar2(15),
	classtime varchar2(30),
	max_seat number(2),
        remained_seat number(2),
        deadline varchar2(10),
	primary key (seq_id),
	foreign key (cno) references Course_description
);

create table Course_taken(
	sequence_id varchar2(15), 
	student_id varchar2(10), 
	grade varchar2(2),
	primary key (sequence_id, student_id),
	foreign key (sequence_id) references Course,
	foreign key (student_id) references Student
);

commit;

