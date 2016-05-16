CREATE OR REPLACE PROCEDURE GET_GPA (sid in varchar2, gpa out number) AS
    
    CURSOR c1 IS
    SELECT sequence_id, grade, CD.course_no,CD.credit
    FROM Course_taken JOIN Course ON sequence_id = seq_id JOIN Course_description CD ON cno = CD.course_no
    WHERE student_id = sid and grade is NOT NULL;
 
    total_grade NUMBER(3,1);
    course_no varchar2(10);
    seq_id varchar2(15);
    grade varchar2(2);
    credit number(2);
    total_credit number(2);
    ngrade number(2,1);

BEGIN
    OPEN c1;

    gpa := 0;
    total_grade := 0;
    total_credit := 0;

    LOOP
	FETCH c1 INTO seq_id, grade, course_no, credit;
            EXIT WHEN c1%NOTFOUND;
	
	ngrade := 0;

            CASE grade
	      when 'A' then ngrade :=4.0;
	      when 'B' then ngrade :=3.0;
	      when 'C' then ngrade :=2.0;
	      when 'D' then ngrade :=1.0;
	      when 'F' then ngrade := 0;
	      else dbms_output.put_line('No such grade');
	END CASE;
	
            total_credit := total_credit + credit;
	total_grade := total_grade + ngrade * credit;
               
    END LOOP;

    CLOSE c1; 
	
    gpa := total_grade / total_credit;

end;
/
