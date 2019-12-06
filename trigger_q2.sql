
drop trigger if exists check_nurse;
drop trigger if exists check_nurse2;
drop trigger if exists check_receptionist;
drop trigger if exists check_receptionist2;
drop trigger if exists check_doctor;
drop trigger if exists check_doctor2;
drop trigger if exists check_trainee;
drop trigger if exists check_trainee2;
drop trigger if exists check_perm;
drop trigger if exists check_perm2;




		-- PARTE A

delimiter $$
CREATE TRIGGER check_nurse before INSERT ON nurse
for each row
BEGIN
	declare two_jobs integer;
	Select count(*) into two_jobs 
	from employee
	where employee.job != new.job  AND employee.VAT = new.VAT;

	if two_jobs > 0 then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error! Nurses can\'t simultaneously have other jobs';
	end if;
END$$

delimiter ;


delimiter $$
CREATE TRIGGER check_nurse2 before UPDATE ON nurse
for each row
BEGIN
	declare two_jobs integer;
	Select count(*) into two_jobs 
	from employee
	where employee.job != new.job  AND employee.VAT = new.VAT;

	if two_jobs > 0 then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error! Nurses can\'t simultaneously have other jobs';
	end if;
END$$

delimiter ;



delimiter $$
CREATE TRIGGER check_receptionist before INSERT ON receptionist
for each row
BEGIN
	declare two_jobs integer;
	Select count(*) into two_jobs 
	from employee
	where employee.job != new.job AND employee.VAT = new.VAT;

	if two_jobs > 0 then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error! Receptionists can\'t simultaneously have other jobs';
	end if;
END$$

delimiter ;



delimiter $$
CREATE TRIGGER check_receptionist2 before UPDATE ON receptionist
for each row
BEGIN
	declare two_jobs integer;
	Select count(*) into two_jobs 
	from employee
	where employee.job != new.job AND employee.VAT = new.VAT;

	if two_jobs > 0 then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error! Receptionists can\'t simultaneously have other jobs';
	end if;
END$$

delimiter ;



delimiter $$
CREATE TRIGGER check_doctor before INSERT ON doctor
for each row
BEGIN
	declare two_jobs integer;
	Select count(*) into two_jobs 
	from employee
	where employee.job != new.job  AND employee.VAT = new.VAT;

	if two_jobs > 0 then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error! Doctors can\'t simultaneously have other jobs';
	end if;
END$$

delimiter ;


delimiter $$
CREATE TRIGGER check_doctor2 before UPDATE ON doctor
for each row
BEGIN
	declare two_jobs integer;
	Select count(*) into two_jobs 
	from employee
	where employee.job != new.job  AND employee.VAT = new.VAT;

	if two_jobs > 0 then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error! Doctors can\'t simultaneously have other jobs';
	end if;
END$$

delimiter ;


	-- PARTE B

delimiter $$
CREATE TRIGGER check_trainee before INSERT ON trainee_doctor
for each row
BEGIN
	declare two_types integer;
	Select count(*) into two_types
	from doctor
	where doctor.type != new.type  AND doctor.VAT = new.VAT;

	if two_types > 0 then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error! Trainee doctors can\'t simultaneously be permanent doctors';
	end if;
END$$

delimiter ;



delimiter $$
CREATE TRIGGER check_trainee2 before UPDATE ON trainee_doctor
for each row
BEGIN
	declare two_types integer;
	Select count(*) into two_types
	from doctor
	where doctor.type != new.type  AND doctor.VAT = new.VAT;

	if two_types > 0 then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error! Trainee doctors can\'t simultaneously be permanent doctors';
	end if;
END$$

delimiter ;


delimiter $$
CREATE TRIGGER check_perm before INSERT ON permanent_doctor
for each row
BEGIN
	declare two_types integer;
	Select count(*) into two_types
	from doctor
	where doctor.type != new.type  AND doctor.VAT = new.VAT;

	if two_types > 0 then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error! Permanent doctors can\'t simultaneously be trainee doctors';
	end if;
END$$

delimiter ;


delimiter $$
CREATE TRIGGER check_perm2 before UPDATE ON permanent_doctor
for each row
BEGIN
	declare two_types integer;
	Select count(*) into two_types
	from doctor
	where doctor.type != new.type  AND doctor.VAT = new.VAT;

	if two_types > 0 then
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error! Permanent doctors can\'t simultaneously be trainee doctors';
	end if;
END$$

delimiter ;

