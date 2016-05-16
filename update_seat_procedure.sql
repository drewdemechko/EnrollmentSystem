CREATE OR REPLACE PROCEDURE update_seat (req_seq_id in varchar2, f_seat out number, result out number) AS
    
    CURSOR c1 IS
    select remained_seat from Course where seq_id = req_seq_id for update;
  
    rseat number(2);
begin

    OPEN c1;

    FETCH c1 INTO rseat;

    if rseat > 0 then
	update Course set remained_seat = rseat - 1 where seq_id = req_seq_id;
        commit;
        f_seat := rseat - 1;
	result := 1;
    else
	rollback;
	dbms_output.put_line('No seats, rollback');
	f_seat := 0;
        result := 0;
    end if;
 
    CLOSE c1; 
        	
end;
/
