drop procedure if exists check_client_empls;
drop TRIGGER if exists phone_diff_ins_cl;
drop TRIGGER if exists phone_diff_up_cl;
drop TRIGGER if exists phone_diff_ins_emp;
drop TRIGGER if exists phone_diff_up_emp;

delimiter $$
create procedure check_client_empls (
	IN new_phone INT,
	OUT already_exists INT)
begin 
	declare check_client integer;
	declare check_employee integer;

	SELECT COUNT(*) into check_client
	FROM phone_number_client
	WHERE phone_number_client.phone = new_phone;


	
	SELECT COUNT(*) into check_employee
	FROM phone_number_employee
	WHERE phone_number_client.phone = new_phone;
	
	IF (check_client <> 0 OR check_employee <> 0)  THEN
		SET already_exists = 1;
	ELSE
		SET already_exists = 0;
	END IF;

end $$ 

delimiter ;

delimiter $$
CREATE TRIGGER phone_diff_ins_cl
BEFORE INSERT ON phone_number_client
for each row
BEGIN
	CALL check_client_empls(new.phone,@already_exists);
	if @already_exists <> 0 THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Warning: different individuals cannot have the same phone number.';
    END if;
	
	
END $$
delimiter ;

delimiter $$
CREATE TRIGGER phone_diff_up_cl
BEFORE UPDATE ON phone_number_client
for each row
BEGIN
	CALL check_client_empls(new.phone,@already_exists);
	if @already_exists <> 0 THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Warning: different individuals cannot have the same phone number.';
    END if;
	
	
END $$
delimiter ;

delimiter $$
CREATE TRIGGER phone_diff_ins_emp
BEFORE INSERT ON phone_number_employee
for each row
BEGIN
	CALL check_client_empls(new.phone,@already_exists);
	if @already_exists <> 0 THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Warning: different individuals cannot have the same phone number.';
    END if;
	
	
END $$
delimiter ;

delimiter $$
CREATE TRIGGER phone_diff_up_emp
BEFORE UPDATE ON phone_number_employee
for each row
BEGIN
	CALL check_client_empls(new.phone,@already_exists);
	if @already_exists <> 0 THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Warning: different individuals cannot have the same phone number.';
    END if;
	
	
END $$
delimiter ;

