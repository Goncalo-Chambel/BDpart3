USE ist425352;
SET foreign_key_checks = 0;
drop TABLE if exists employee;
drop TABLE if exists phone_number_employee;
drop TABLE if exists receptionist;
drop TABLE if exists doctor;
drop TABLE if exists nurse;
drop TABLE if exists client;
drop TABLE if exists phone_number_client;
drop TABLE if exists permanent_doctor;
drop TABLE if exists trainee_doctor;
drop TABLE if exists supervision_report;
drop TABLE if exists appointment;
drop TABLE if exists consultation;
drop TABLE if exists consultation_assistant;
drop TABLE if exists diagnostic_code;
drop TABLE if exists diagnostic_code_relation;
drop TABLE if exists consultation_diagnostic;
drop TABLE if exists medication;
drop TABLE if exists prescription;
drop TABLE if exists procedures;
drop TABLE if exists procedure_in_consultation;
drop TABLE if exists procedure_radiology;
drop TABLE if exists teeth;
drop TABLE if exists procedure_charting;
SET foreign_key_checks = 1;


CREATE TABLE employee(VAT char(9), 
					 name char(20),
					 birth_date date, 
					 street char(30), 
					 city char(30), 
					 zip char(8), 
					 iban char(50), 
					 salary integer, 
					 job varchar(15),
					 primary key (VAT), 
					 unique(iban), 
					 unique(VAT, job),
					 check(job in ('nurse', 'receptionist', 'doctor')),
					 check(salary > 0)
					 );



CREATE TABLE phone_number_employee(VAT char(9),
							       phone integer,
							       foreign key(VAT) references employee(VAT),
							       primary key(phone, VAT)
							       );


CREATE TABLE receptionist(VAT char(9),
						 job varchar(15),
						 foreign key(VAT) references employee(VAT),
						 check(job = 'receptionist'),
						 primary key(VAT)
						 );


CREATE TABLE doctor(VAT char(9),
				   specialization char(30),
				   biography varchar(1000),
				   e_mail varchar(320),
				   job varchar(15),
				   type varchar(10),
				   unique(VAT, type),
				   check (type in ('permanent', 'trainee')),
				   foreign key(VAT) references employee(VAT),
				   check(job = 'doctor'),
				   unique(e_mail),
				   primary key(VAT)
				   );


CREATE TABLE nurse(VAT char(9),
				   job varchar(15),
				   foreign key(VAT) references employee(VAT),
				   check(job = 'nurse'),
				   primary key(VAT)
				   );


CREATE TABLE client(VAT char(9), 
					name char(20),
					birth_date date, 
					street char(30), 
					city char(30), 
					zip char(8), 
					gender char(10), 
					age integer,#as zip,
					primary key (VAT),
					check(age > 0)
					);


CREATE TABLE phone_number_client(VAT char(9),
							    phone integer,
							    foreign key(VAT) references client(VAT),
							    primary key(phone, VAT)
							    );



CREATE TABLE permanent_doctor(VAT char(9),
							 years integer,
							 type varchar(10),
							 foreign key(VAT) references doctor(VAT) ON DELETE CASCADE ON UPDATE CASCADE,
							 check(type = 'permanent'),
							 primary key(VAT)
							 );

CREATE TABLE trainee_doctor(VAT char(9),
							supervisor char(9),
							type varchar(10),
							foreign key(VAT) references doctor(VAT) ON DELETE CASCADE ON UPDATE CASCADE,
							check(type = 'trainee'),
							foreign key(supervisor) references permanent_doctor(VAT) ON DELETE CASCADE ON UPDATE CASCADE,
							primary key(VAT)
							);



CREATE TABLE supervision_report(VAT char(9),
								date_timestamp datetime,
								description varchar(1000),
								evaluation integer,
								foreign key(VAT) references trainee_doctor(VAT) ON DELETE CASCADE ON UPDATE CASCADE,
								primary key(VAT, date_timestamp),
								check(evaluation >=1 and evaluation <=5)
								);


CREATE TABLE appointment(VAT_doctor char(9),
						date_timestamp datetime,
						description varchar(1000),
						VAT_client char(9),
						primary key(date_timestamp, VAT_doctor),
						foreign key(VAT_doctor) references doctor(VAT) ON DELETE CASCADE ON UPDATE CASCADE,
						foreign key(VAT_client) references client(VAT)
						);



CREATE TABLE consultation(VAT_doctor char(9),
						  date_timestamp datetime,
						  SOAP_S varchar(500),
						  SOAP_O varchar(500),
						  SOAP_A varchar(500),
						  SOAP_P varchar(500),
						  foreign key(VAT_doctor) references appointment(VAT_doctor) ON DELETE CASCADE ON UPDATE CASCADE,
						  foreign key(date_timestamp) references appointment(date_timestamp) ON DELETE CASCADE ON UPDATE CASCADE,
						  primary key(VAT_doctor, date_timestamp)
						  );

CREATE TABLE consultation_assistant(VAT_doctor char(9),
									date_timestamp datetime,
									VAT_nurse char(9) not null,
									foreign key(VAT_doctor) references consultation(VAT_doctor) ON DELETE CASCADE ON UPDATE CASCADE,
									foreign key(VAT_nurse) references nurse(VAT) ,
						            foreign key(date_timestamp) references consultation(date_timestamp) ON DELETE CASCADE ON UPDATE CASCADE,
						            primary key(VAT_doctor, date_timestamp, VAT_nurse)
						            );




CREATE TABLE diagnostic_code(ID integer,
							 description varchar(1000),
							 primary key(ID)
							 );


CREATE TABLE diagnostic_code_relation(ID1 integer,
									  ID2 integer,
									  type char(30),
									  foreign key(ID1) references diagnostic_code(ID) ,
									  foreign key(ID2) references diagnostic_code(ID) ,
									  primary key(ID1, ID2)
									  );



CREATE TABLE consultation_diagnostic(VAT_doctor char(9),
									 date_timestamp datetime,
									 ID integer,
									 foreign key(VAT_doctor) references consultation(VAT_doctor) ON DELETE CASCADE ON UPDATE CASCADE,
									 foreign key(date_timestamp) references consultation(date_timestamp) ON DELETE CASCADE ON UPDATE CASCADE,
									 foreign key(ID) references diagnostic_code(ID),
									 primary key(VAT_doctor, date_timestamp,ID)
									 );



CREATE TABLE medication(name char(30),
						lab char(30),
						primary key(name, lab)
						);


CREATE TABLE prescription(name char(30), 
						  lab char(30), 
						  VAT_doctor char(9),
						  date_timestamp datetime, 
						  ID integer,
						  dosage numeric(5,2),
						  description varchar(1000),
						  foreign key(name, lab) references medication(name, lab),
						  foreign key(VAT_doctor) references consultation_diagnostic(VAT_doctor) ON DELETE CASCADE ON UPDATE CASCADE,
						  foreign key(date_timestamp) references consultation_diagnostic(date_timestamp) ON DELETE CASCADE ON UPDATE CASCADE,
						  foreign key(ID) references consultation_diagnostic(ID) ON DELETE CASCADE ON UPDATE CASCADE,
						  primary key(name, lab, VAT_doctor, date_timestamp, ID) 
						  );



CREATE TABLE procedures(name char(30),
					   tipo char(30),
					   primary key(name)
					   );



CREATE TABLE procedure_in_consultation(name char(30), 
									   VAT_doctor char(9),
									   date_timestamp datetime,
									   description varchar(1000),
									   foreign key(name) references procedures(name),
									   foreign key(VAT_doctor) references consultation(VAT_doctor) ON DELETE CASCADE ON UPDATE CASCADE,
									   foreign key(date_timestamp) references consultation(date_timestamp) ON DELETE CASCADE ON UPDATE CASCADE,
									   primary key (name, VAT_doctor, date_timestamp)
									   );




CREATE TABLE procedure_radiology(name char(30),
								 file varchar(300),
								 VAT_doctor char(9),
								 date_timestamp datetime,
								 foreign key(name) references procedure_in_consultation(name),
								 foreign key(VAT_doctor) references procedure_in_consultation(VAT_doctor),
								 foreign key(date_timestamp) references procedure_in_consultation(date_timestamp),
								 primary key(name, file, VAT_doctor, date_timestamp)
								 );

CREATE TABLE teeth(quadrant integer,
				   num integer,
				   name char(30),
				   primary key(quadrant, num)
				   );


 CREATE TABLE procedure_charting(name char(30),
 								 VAT char(9),
 								 date_timestamp datetime,
 								 quadrant integer,
 								 num integer,
 								 description varchar(1000),
 								 measure numeric(5,3),
 								 foreign key(name) references procedure_in_consultation(name),
								 foreign key(VAT) references procedure_in_consultation(VAT_doctor) ON DELETE CASCADE ON UPDATE CASCADE,
								 foreign key(date_timestamp) references procedure_in_consultation(date_timestamp) ON DELETE CASCADE ON UPDATE CASCADE,
								 foreign key(quadrant, num) references teeth(quadrant, num),
								 primary key(name, VAT, date_timestamp, quadrant, num)
 								 );

 								
 

