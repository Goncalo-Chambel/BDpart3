drop FUNCTION if exists noshows;

delimiter $$
CREATE FUNCTION noshows(gender varchar(5), _year integer, age_upper integer, age_lower integer)
returns integer
begin
	declare count integer;
	select count(client.VAT) into count 
		from appointment as a left join consultation as c 
		on a.date_timestamp = c.date_timestamp and a.VAT_doctor = c.VAT_doctor 
		join client on client.VAT = a.VAT_client
		where c.VAT_doctor is null 
			and client.gender = gender
			and client.age >= age_lower
			and client.age <= age_upper
			and year(a.date_timestamp) = _year;

	return count;
end$$
delimiter ;
