drop procedure if exists updatesalary;
delimiter $$
CREATE procedure updatesalary(in years integer)

begin

update employee 
	join doctor d
		on d.VAT = employee.VAT 
	join permanent_doctor p
		on p.VAT = d.VAT 
	join 
		(select count(c.VAT_doctor) as count, c.VAT_doctor from consultation c where year(c.date_timestamp) = year(current_date) group by c.VAT_doctor) t 
			on t.VAT_doctor = p.VAT 

set employee.salary  = if(count > 100, employee.salary*1.1, employee.salary*1.05)

where p.years > years;

end$$
delimiter ;
