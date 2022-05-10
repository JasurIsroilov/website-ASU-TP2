SPOOL C:\ApacheDocs\mironov\SQL\сreate_table.log
--PROMPT Скрипт создания таблиц
--PROMPT Автор: Миронов К.С.
--PROMPT Дата создания 00.04.2022
----------------------------------------------------------
DROP TABLE users CASCADE CONSTRAINTS;
CREATE TABLE users (
			  user_id  INTEGER NOT NULL
			, login  VARCHAR2(20) NOT NULL
			, password VARCHAR2(20) NOT NULL
			, username VARCHAR2(20) NOT NULL
			, user_role VARCHAR2(20) NOT NULL
)
TABLESPACE users;
COMMIT;
---------------------------------------------------------
DROP TABLE rig CASCADE CONSTRAINTS;
CREATE TABLE rig (
			  rig_id INTEGER NOT NULL
			, rig_name VARCHAR2(20) NULL
			, rig_type VARCHAR2(20) NULL
)
TABLESPACE users;
COMMIT;
---------------------------------------------------------
DROP TABLE equipment CASCADE CONSTRAINTS;
CREATE TABLE equipment (
			  equ_id INTEGER NOT NULL
			, equ_name VARCHAR2(20) NULL
			, equ_type VARCHAR2(20) NULL
)
TABLESPACE users;
COMMIT;
---------------------------------------------------------
DROP TABLE personal CASCADE CONSTRAINTS;
CREATE TABLE personal (
          per_id  INTEGER NOT NULL
		, per_name VARCHAR2(20) NOT NULL
		, per_surname VARCHAR2(20) NOT NULL
		, per_lastName VARCHAR2(20) NOT NULL
		, per_job VARCHAR2(20) NOT NULL
		, per_adr VARCHAR2(20) NULL
)
TABLESPACE users;
COMMIT;
---------------------------------------------------------
DROP TABLE devices CASCADE CONSTRAINTS;
CREATE TABLE devices (
          dev_id  INTEGER NOT NULL
        , dev_name VARCHAR2(20) NULL
        , dev_odate DATE NULL
		, dev_defects VARCHAR2(20) NULL
)
TABLESPACE users;
COMMIT;
--------------------------------------------------------
DROP TABLE documents CASCADE CONSTRAINTS;
CREATE TABLE documents (
          doc_id  INTEGER NOT NULL
        , doc_name VARCHAR2(20) NOT NULL
        , doc_type VARCHAR2(20) NOT NULL
		, doc_date DATE NOT NULL
		, doc_dev_id INTEGER NULL
)
TABLESPACE users;
COMMIT;
--------------------------------------------------------
DROP TABLE operations CASCADE CONSTRAINTS;
CREATE TABLE operations (
          oper_id  INTEGER NOT NULL
        , oper_type VARCHAR2(20) NOT NULL
		, oper_cost INTEGER NOT NULL
		, oper_dur INTEGER NOT NULL
		, oper_doc_id INTEGER NULL
		, oper_per_id INTEGER NULL
		, oper_equ_id INTEGER NULL
		, oper_rig_id INTEGER NULL
)
TABLESPACE users;
COMMIT;
--------------------------------------------------------
SPOOL off;
