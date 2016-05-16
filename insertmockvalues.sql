
insert into myuser values ('jlee1', '123456', '0');
insert into myuser values ('jlee2', '123456', '0');
insert into myuser values ('jlee3', '123456', '0');
insert into myuser values ('jlee4', '123456', '0');
insert into myuser values ('jlee5', '123456', '0');
insert into myuser values ('admin','testtest','1');
insert into myuser values ('Drew', 'testtest', '0');
insert into myuser values ('stuadmin', 'testtest', '2');

insert into Student values ('JL000001','jlee1','Jackie','Lee','06-SEP-91','100E 2nd University Dr.', 'Edmond', 'OK','73034',0,0);
insert into Student values ('JL000002','jlee2','Jay','Lee','23-NOV-90','100E 2nd University Dr.', 'Edmond', 'OK','73034',1,1);
insert into Student values ('JL000003','jlee3','Jasmine','Lee','11-JAN-92','100E 2nd University Dr.', 'Edmond', 'OK','73034',0,0);
insert into Student values ('JL000004','jlee4','Jeanie','Lee','24-JUN-93','100E 2nd University Dr.', 'Edmond', 'OK','73034',0,0);
insert into Student values ('JL000005','jlee5','Josephine','Lee','17-OCT-94','100E 2nd University Dr.', 'Edmond', 'OK','73034',0,0);
insert into Student values ('DD000006','Drew','Drew','Demechko','06-19-1994','937 sw','Moore','OK','73170',0,0);
insert into Student values ('SA000007','stuadmin','First','Last','07-15-1990','88 park drive','Edmond','OK','73114',0,0);

insert into StudentID values (7);

insert into Course_description values ('HA10','Success in College',1);
insert into Course_description values ('EN10','English Composition',3);
insert into Course_description values ('BA11','Introduction to Art',3);
insert into Course_description values ('MA12','Algebra I',3);
insert into Course_description values ('MA21','Algebra II',3);
insert into Course_description values ('MA31','Applied Math',3);
insert into Course_description values ('MA32','Operation Research',4);
insert into Course_description values ('CS11','Programming I',3);
insert into Course_description values ('CS22','Programming II',3);
insert into Course_description values ('GE32','Government',3);
insert into Course_description values ('CS33','Data Structure',3);
insert into Course_description values ('CS44','Software Engineering',3);
insert into Course_description values ('CS55','Database',3);
insert into Course_description values ('CS56','Network',3);

insert into Course values ('2013S0001','EN10','2013 Spring','TR 10:00-11:30am',30,30,'12-10-2012');
insert into Course values ('2013S0002','BA11','2013 Spring','TR 10:00-11:30am',20,20,'12-10-2012');
insert into Course values ('2013S0003','MA12','2013 Fall','TR 10:00-11:30am',30,30,'06-15-2012');
insert into Course values ('2014F0004','CS22','2014 Spring','TR 04:00-07:00pm',30,30,'12-10-2013');
insert into Course values ('2014F0005','GE32','2014 Fall','TR 10:00-11:30am',30,30,'07-30-2013');
insert into Course values ('2014F0006','CS33','2014 Fall','WF 10:00-11:30am',30,30,'07-30-2013');
insert into Course values ('2015S0001','CS11','2015 Spring','TR 10:00-11:30am',20,20,'12-10-2014');
insert into Course values ('2015S0002','CS22','2015 Spring','TR 13:00-14:30am',30,30,'12-10-2014');
insert into Course values ('2015S0003','CS33','2015 Spring','TR 10:00-11:30am',20,20,'12-10-2014');
insert into Course values ('2015S0004','CS44','2015 Spring','MW 10:00-11:30am',30,30,'12-10-2014');
insert into Course values ('2015S0005','MA12','2015 Spring','TR 16:15-17:15pm',40,0,'12-10-2014');
insert into Course values ('2015S0006','MA31','2015 Spring','MW 10:00-11:30am',30,30,'12-10-2014');
insert into Course values ('2015F0001','CS56','2015 Fall','MW 08:00-09:30am',10,10,'06-15-2015');
insert into Course values ('2015F0002','GE32','2015 Fall','TR 10:00-11:30am',30,30,'06-15-2015');
insert into Course values ('2015F0003','CS33','2015 Fall','WF 10:00-11:30am',30,30,'06-15-2015');
insert into Course values ('2016S0001','CS56','2016 Spring','MW 10:00-11:30am', 30, 30, '07-16-2016');
insert into Course values ('2016S0002','GE32','2016 Spring','TR 10:00-11:30am',30,30,'06-15-2015');
insert into Course values ('2016F0001','CS33','2016 Fall','WF 10:00-11:30am',30,30,'08-08-2015');
insert into Course values ('2016F0002','CS56','2016 Fall','MW 10:00-11:30am', 30, 30, '08-08-2016');
insert into Course values ('2016F0003','CS11','2016 Fall', 'TR 7:30-8:45pm',30, 30, '08-08-2016');

insert into Prerequisite values ('CS22', 'BA11');
insert into Prerequisite values ('CS33', 'CS22');
insert into Prerequisite values ('CS44', 'CS33');
insert into Prerequisite values ('CS55', 'CS44');
insert into Prerequisite values ('CS44', 'EN10');
insert into Prerequisite values ('CS55', 'CS33');
insert into Prerequisite values ('MA31', 'MA12');

insert into Course_taken values ('2013S0001','JL000001','A');
insert into Course_taken values ('2013S0002','JL000001','A');
insert into Course_taken values ('2013S0003','JL000001','A');
insert into Course_taken values ('2014F0004','JL000001','A');
insert into Course_taken values ('2014F0005','JL000001','C');
insert into Course_taken values ('2014F0006','JL000001','D');

insert into Course_taken values ('2013S0001','JL000002','B');
insert into Course_taken values ('2013S0002','JL000002','C');
insert into Course_taken values ('2013S0003','JL000002','C');
insert into Course_taken values ('2014F0004','JL000002','A');

insert into Course_taken values ('2013S0001','JL000003','D');
insert into Course_taken values ('2013S0002','JL000003','D');
insert into Course_taken values ('2013S0003','JL000003','D');

insert into Course_taken values ('2013S0003','DD000006', 'A');

commit;
