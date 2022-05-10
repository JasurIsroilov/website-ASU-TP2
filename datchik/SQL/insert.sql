SPOOL C:\ApacheDocs\mironov\SQL\insert.log
--PROMPT Скрипт Внесение данных в таблицы
--PROMPT Автор: Миронов К.С.
--PROMPT Дата создания 00.04.2022
-------------------------------------------------------------------------------
--Внесение данных в таблицу users
INSERT INTO users (login, password, username, user_role)
VALUES ('Admin','Admin','Kiryuxa','administrator');
INSERT INTO users (login, password, username, user_role)
VALUES ('User1','User1','Chelik' ,'user');
INSERT INTO users (login, password, username, user_role)
VALUES ('Moder','Moder','Guy' ,'moderator');
COMMIT;
--------------------------------------------------------------------------------
INSERT INTO equipment (equ_name, equ_type)
VALUES ('Molotok', 'Udarka');
INSERT INTO equipment (equ_name, equ_type)
VALUES ('Otvertka', 'Vertelka');
INSERT INTO equipment (equ_name, equ_type)
VALUES ('Scissors', 'Rezat');
COMMIT;
--------------------------------------------------------------------------------
INSERT INTO rig (rig_name, rig_type)
VALUES ('Maska', 'PP');
INSERT INTO rig (rig_name, rig_type)
VALUES ('Fen', 'Pufff');
INSERT INTO rig (rig_name, rig_type)
VALUES ('Payalnik', 'TikTok');
COMMIT;
--------------------------------------------------------------------------------
INSERT INTO personal (per_surname, per_name, per_lastName, per_adr, per_job)
VALUES ('Mironov', 'Kirill', 'Sergeevich', 'Skhodnya', 'Uborshik');
INSERT INTO personal (per_surname, per_name, per_lastName, per_adr, per_job)
VALUES ('Isroilov', 'Jasur', 'Odilovich', 'Moscow', 'Director');
INSERT INTO personal (per_surname, per_name, per_lastName, per_adr, per_job)
VALUES ('Ivanov', 'Ivan', 'Ivanovich', 'Ivanovsk', 'Vanyushka');
COMMIT;
--------------------------------------------------------------------------------
INSERT INTO devices (dev_name, dev_odate, dev_defects)
VALUES ('Lampa', TO_DATE('25.11.2025','dd.mm.yyyy'), 'Hot');
INSERT INTO devices (dev_name, dev_odate, dev_defects)
VALUES ('Mouse', TO_DATE('01.01.2020','dd.mm.yyyy'), 'Tiny');
INSERT INTO devices (dev_name, dev_odate, dev_defects)
VALUES ('Keyboard', TO_DATE('15.10.2015','dd.mm.yyyy'), 'Large');
COMMIT;
--------------------------------------------------------------------------------
INSERT INTO documents (doc_name, doc_type, doc_date, doc_dev_id)
VALUES ('Metoda','Posobie', TO_DATE('01.01.2020','dd.mm.yyyy'), 1);
INSERT INTO documents (doc_name, doc_type, doc_date, doc_dev_id)
VALUES ('Dzhons','VUZ', TO_DATE('05.05.2050','dd.mm.yyyy'), 2);
INSERT INTO documents (doc_name, doc_type, doc_date, doc_dev_id)
VALUES ('Monk','VUZ', TO_DATE('03.03.2013','dd.mm.yyyy'), 3);
COMMIT;
--------------------------------------------------------------------------------
INSERT INTO operations (oper_type, oper_cost, oper_dur, oper_doc_id, oper_per_id, oper_equ_id, oper_rig_id)
VALUES ('Montaj', 12, 100, 1, 1, 1, 1);
INSERT INTO operations (oper_type, oper_cost, oper_dur, oper_doc_id, oper_per_id, oper_equ_id, oper_rig_id)
VALUES ('Payka', 10, 150, 2, 2, 2, 2);
INSERT INTO operations (oper_type, oper_cost, oper_dur, oper_doc_id, oper_per_id, oper_equ_id, oper_rig_id)
VALUES ('Sborka', 50, 3, 3, 3, 3, 3); 
COMMIT;
--------------------------------------------------------------------------------
SPOOL off;