SPOOL C:\ApacheDocs\mironov\SQL\create_sq.log
--PROMPT Создание последовательностей для таблиц информационной системы
--PROMPT Автор: Миронов К.С.
--PROMPT Дата создания 00.04.2022
----------------------------------------------------------------
--PROMPT Создание последовательности для таблицы users
DROP SEQUENCE seq_user_id;
CREATE SEQUENCE seq_user_id
	INCREMENT BY 1
	START WITH 1;
COMMIT;
----------------------------------------------------------------
--PROMPT Создание последовательности для таблицы rig
DROP SEQUENCE seq_rig_id;
CREATE SEQUENCE seq_rig_id
	INCREMENT BY 1
	START WITH 1;
COMMIT;
----------------------------------------------------------------
--PROMPT Создание последовательности для таблицы equipment
DROP SEQUENCE seq_equ_id;
CREATE SEQUENCE seq_equ_id
	INCREMENT BY 1
	START WITH 1;
COMMIT;
----------------------------------------------------------------
--PROMPT Создание последовательности для таблицы personal
DROP SEQUENCE seq_per_id;
CREATE SEQUENCE seq_per_id
	INCREMENT BY 1
	START WITH 1;
COMMIT;
----------------------------------------------------------------
--PROMPT Создание последовательности для таблицы operations
DROP SEQUENCE seq_oper_id;
CREATE SEQUENCE seq_oper_id
	INCREMENT BY 1
	START WITH 1;
COMMIT;
----------------------------------------------------------------
--PROMPT Создание последовательности для таблицы documents
DROP SEQUENCE seq_doc_id;
CREATE SEQUENCE seq_doc_id
	INCREMENT BY 1
	START WITH 1;
COMMIT;
----------------------------------------------------------------
--PROMPT Создание последовательности для таблицы devices
DROP SEQUENCE seq_dev_id;
CREATE SEQUENCE seq_dev_id
	INCREMENT BY 1
	START WITH 1;
COMMIT;
SPOOL off;