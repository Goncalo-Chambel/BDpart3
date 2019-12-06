drop trigger if exists updateage;
delimiter $$
CREATE TRIGGER updateage before INSERT ON appointment
for each row
BEGIN
	declare cur_date datetime;
	declare prev_date datetime;
	select current_date() into cur_date;
	if new.VAT_client > 0 then
		select birth_date from client where client.VAT = new.VAT_client into prev_date; 
		update client
			set age = timestampdiff(year,prev_date,cur_date)
			where client.VAT = new.VAT_client;
	end if;
END$$
delimiter ;
