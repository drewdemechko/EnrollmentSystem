drop table tmp_course_taken;

create table tmp_course_taken(  
         student_id varchar2(10));

create or replace trigger before_trigg_gpa
before update of grade on Course_taken
for each row
begin
  dbms_output.put_line('insert sid into tmp_course_taken: ' || :new.student_id);
  insert into tmp_course_taken values (:new.student_id);
end;
/

create or replace trigger trigg_gpa
after update on Course_taken
declare
    gpa number(3,1);
    std_id Course_taken.student_id%type;

    CURSOR c1 IS
    SELECT student_id FROM tmp_course_taken;
begin    
     open c1;

     gpa := 0;

     loop
	fetch c1 into std_id;
            dbms_output.put_line('fetch STD ID : ' || std_id);

	exit when c1%NOTFOUND;

            GET_GPA(std_id, gpa);

            dbms_output.put_line('GPA : ' || gpa);

            if gpa < 2.0 then
                   update student set status = '1' where sid = std_id;
            else
                   update student set status = '0' where sid = std_id;
            end if;

     end loop;
     delete from tmp_course_taken;
     close c1;     
end;
/

