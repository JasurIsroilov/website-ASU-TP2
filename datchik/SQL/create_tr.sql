SPOOL C:\ApacheDocs\mironov\SQL\create_tr.log
--PROMPT Создание триггеров для таблиц информационной системы
--PROMPT Автор :Миронов К.С.
--PROMPT Дата создания 00.04.2022
--------------------------------------------------------------
--PROMPT Создание триггера для таблицы users
CREATE OR REPLACE TRIGGER tr_user_id
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
         SELECT seq_user_id.nextval
         INTO :new.user_id
         FROM dual;
END; 
/
COMMIT;
--------------------------------------------------------------
--PROMPT Создание триггера для таблицы equipment
CREATE OR REPLACE TRIGGER tr_equ_id
BEFORE INSERT ON equipment
FOR EACH ROW
BEGIN
         SELECT seq_equ_id.nextval
         INTO :new.equ_id
         FROM dual;
END; 
/
COMMIT;
--------------------------------------------------------------
--PROMPT Создание триггера для таблицы rig
CREATE OR REPLACE TRIGGER tr_rig_id
BEFORE INSERT ON rig
FOR EACH ROW
BEGIN
         SELECT seq_rig_id.nextval
         INTO :new.rig_id
         FROM dual;
END; 
/
COMMIT;
--------------------------------------------------------------
--PROMPT Создание триггера для таблицы operations
CREATE OR REPLACE TRIGGER tr_oper_id
BEFORE INSERT ON operations
FOR EACH ROW
BEGIN
         SELECT seq_oper_id.nextval
         INTO :new.oper_id
         FROM dual;
END; 
/
COMMIT;
--------------------------------------------------------------
--PROMPT Создание триггера для таблицы personal
CREATE OR REPLACE TRIGGER tr_per_id
BEFORE INSERT ON personal
FOR EACH ROW
BEGIN
         SELECT seq_per_id.nextval
         INTO :new.per_id
         FROM dual;
END; 
/
COMMIT;
--------------------------------------------------------------
--PROMPT Создание триггера для таблицы documents
CREATE OR REPLACE TRIGGER tr_doc_id
BEFORE INSERT ON documents
FOR EACH ROW
BEGIN
         SELECT seq_doc_id.nextval
         INTO :new.doc_id
         FROM dual;
END; 
/
COMMIT;
--------------------------------------------------------------
--PROMPT Создание триггера для таблицы devices
CREATE OR REPLACE TRIGGER tr_dev_id
BEFORE INSERT ON devices
FOR EACH ROW
BEGIN
         SELECT seq_dev_id.nextval
         INTO :new.dev_id
         FROM dual;
END; 
/
COMMIT;
--------------------------------------------------------------
SPOOL off;