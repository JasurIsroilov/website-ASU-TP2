SPOOL C:\ApacheDocs\mironov\SQL\create_pk.log
--PROMPT Создание первичных ключей таблиц информационной системы
--PROMPT Автор: Миронов К.С.
--PROMPT Дата создания 00.04.2022
--PROMPT Удаление первичных ключей
-------------------------------------------------------------------
ALTER TABLE users 
          DROP CONSTRAINT pk_users;
ALTER TABLE equipment 
          DROP CONSTRAINT pk_equipment;
ALTER TABLE rig
          DROP CONSTRAINT pk_rig;
ALTER TABLE personal
          DROP CONSTRAINT pk_personal;
ALTER TABLE operations
          DROP CONSTRAINT pk_operations;
ALTER TABLE documents
          DROP CONSTRAINT pk_documents;
ALTER TABLE devices
          DROP CONSTRAINT pk_devices;
COMMIT;
--------------------------------------------------------------------
--PROMPT Удаление индексов
DROP INDEX i_user_id;
DROP INDEX i_equ_id;
DROP INDEX i_rig_id;
DROP INDEX i_per_id;
DROP INDEX i_oper_id;
DROP INDEX i_dev_id;
DROP INDEX i_doc_id;
COMMIT;
--------------------------------------------------------------------
--PROMPT Добавление первичного ключа в таблицу users
CREATE UNIQUE INDEX i_user_id
	ON users (user_id);
ALTER TABLE users
	ADD CONSTRAINT pk_users
	PRIMARY KEY (user_id);
COMMIT;
------------------------------------------------------------------------
--PROMPT Добавление первичного ключа в таблицу equipment
CREATE UNIQUE INDEX i_equ_id
	ON  equipment (equ_id);
ALTER TABLE equipment
	ADD CONSTRAINT pk_equipment
	PRIMARY KEY (equ_id);
COMMIT;
------------------------------------------------------------------------
--PROMPT Добавление первичного ключа в таблицу rig
CREATE UNIQUE INDEX i_rig_id
	ON  rig (rig_id);
ALTER TABLE rig
	ADD CONSTRAINT pk_rig
	PRIMARY KEY (rig_id);
COMMIT;
-------------------------------------------------------------------------
--PROMPT Добавление первичного ключа в таблицу personal
CREATE UNIQUE INDEX i_per_id
	ON  personal (per_id);
ALTER TABLE personal
	ADD CONSTRAINT pk_personal
	PRIMARY KEY (per_id);
COMMIT;
-------------------------------------------------------------------------
--PROMPT Добавление первичного ключа в таблицу operations
CREATE UNIQUE INDEX i_oper_id
	ON  operations (oper_id);
ALTER TABLE operations
	ADD CONSTRAINT pk_operations
	PRIMARY KEY (oper_id);
COMMIT;
--------------------------------------------------------------------------
--PROMPT Добавление первичного ключа в таблицу documents
CREATE UNIQUE INDEX i_doc_id
	ON  documents (doc_id);
ALTER TABLE documents
	ADD CONSTRAINT pk_documents
	PRIMARY KEY (doc_id);
COMMIT;
--------------------------------------------------------------------------
--PROMPT Добавление первичного ключа в таблицу devices
CREATE UNIQUE INDEX i_dev_id
	ON  devices (dev_id);
ALTER TABLE devices
	ADD CONSTRAINT pk_devices
	PRIMARY KEY (dev_id);
COMMIT;
--------------------------------------------------------------------------
SPOOL off;
