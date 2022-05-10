SPOOL C:\ApacheDocs\mironov\SQL\create_fk.log
--PROMPT Создание внешних ключей таблиц информационной системы
--PROMPT Автор: Миронов К.С.
--PROMPT Дата создания 00.04.22
-------------------------------------------------------------------
--PROMPT Удаление внешних ключей
ALTER TABLE documents
          DROP CONSTRAINT c_doc_dev_id;
ALTER TABLE operations
          DROP CONSTRAINT c_oper_doc_id;
ALTER TABLE operations
          DROP CONSTRAINT c_oper_per_id;
ALTER TABLE operations
          DROP CONSTRAINT c_oper_equ_id;
ALTER TABLE operations
          DROP CONSTRAINT c_oper_rig_id;
COMMIT;
----------------------------------------------------------------------
--PROMPT Добавление внешнего ключа в таблицу documents
ALTER TABLE documents
	ADD CONSTRAINT c_doc_dev_id
	FOREIGN KEY (doc_dev_id)
REFERENCES devices (dev_id);
COMMIT;
-----------------------------------------------------------------------
--PROMPT Добавление внешнего ключа в таблицу operations
ALTER TABLE operations
	ADD CONSTRAINT c_oper_doc_id
	FOREIGN KEY (oper_doc_id)
REFERENCES documents (doc_id);
COMMIT;
-------------------------------------------------------------------------
ALTER TABLE operations
	ADD CONSTRAINT c_oper_per_id
	FOREIGN KEY (oper_per_id)
REFERENCES personal (per_id);
COMMIT;
------------------------------------------------------------------------
ALTER TABLE operations
	ADD CONSTRAINT c_oper_equ_id
	FOREIGN KEY (oper_equ_id)
REFERENCES equipment (equ_id);
COMMIT;
------------------------------------------------------------------------
ALTER TABLE operations
	ADD CONSTRAINT c_oper_rig_id
	FOREIGN KEY (oper_rig_id)
REFERENCES rig (rig_id);
COMMIT;
SPOOL off;