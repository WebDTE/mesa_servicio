UPDATE `ost_form` SET `title` = 'Información de contacto' WHERE (`id` = '1');
UPDATE `ost_form_field` SET `label` = 'Nombre completo' WHERE (`id` = '2');
UPDATE `ost_form_field` SET `label` = 'Número de teléfono' WHERE (`id` = '3');
UPDATE `ost_form_field` SET `label` = 'Correo electrónico' WHERE (`id` = '1');
UPDATE `ost_form_field` SET `sort` = '1' WHERE (`id` = '2');
UPDATE `ost_form_field` SET `sort` = '2' WHERE (`id` = '1');

UPDATE `ost_form` SET `instructions` = 'Necesarios para identificarte correctamente' WHERE (`id` = '1');
UPDATE `ost_form` SET `title` = 'Detalles del ticket', `instructions`  = 'Proporciona los detalles y/o información complementaria. Esto nos permitirá, brindarte una mejor asistencia.' WHERE (`id` = '2');

UPDATE `ost_form_field` SET `label` = 'Asunto' WHERE (`id` = '20');
UPDATE `ost_form_field` SET `label` = 'Detalle del ticket', `hint` = 'Detalle o razón por la que abres el ticket.' WHERE (`id` = '21');
UPDATE `ost_form_field` SET `label` = 'Prioridad' WHERE (`id` = '22');

UPDATE `ost_role` SET `name` = 'Acceso a todo' WHERE (`id` = '1');
UPDATE `ost_role` SET `name` = 'Acceso amplio' WHERE (`id` = '2');
UPDATE `ost_role` SET `name` = 'Acceso limitado' WHERE (`id` = '3');
UPDATE `ost_role` SET `name` = 'Solo lectura' WHERE (`id` = '4');

UPDATE `ost_queue` SET `title` = 'Mis tickets' WHERE (`id` = '5');
UPDATE `ost_queue` SET `title` = 'Asignados a mi' WHERE (`id` = '6');
UPDATE `ost_queue` SET `title` = 'Asignados a mi equipo' WHERE (`id` = '7');
UPDATE `ost_queue` SET `title` = 'Cerrados' WHERE (`id` = '8');
UPDATE `ost_queue` SET `title` = 'Hoy' WHERE (`id` = '9');
UPDATE `ost_queue` SET `title` = 'Ayer' WHERE (`id` = '10');
UPDATE `ost_queue` SET `title` = 'Esta semana' WHERE (`id` = '11');
UPDATE `ost_queue` SET `title` = 'Este mes' WHERE (`id` = '12');
UPDATE `ost_queue` SET `title` = 'Este periodo' WHERE (`id` = '13');
UPDATE `ost_queue` SET `title` = 'Este año' WHERE (`id` = '14');
UPDATE `ost_queue` SET `title` = 'Abierto' WHERE (`id` = '1');
UPDATE `ost_queue` SET `title` = 'Abierto' WHERE (`id` = '2');
UPDATE `ost_queue` SET `title` = 'Contestado' WHERE (`id` = '3');
UPDATE `ost_queue` SET `title` = 'Atrasado' WHERE (`id` = '4');

UPDATE `ost_queue_column` SET `name` = 'Fecha creación' WHERE (`id` = '2');
UPDATE `ost_queue_column` SET `name` = 'Tema' WHERE (`id` = '3');
UPDATE `ost_queue_column` SET `name` = 'Usuario' WHERE (`id` = '4');
UPDATE `ost_queue_column` SET `name` = 'Prioridad' WHERE (`id` = '5');
UPDATE `ost_queue_column` SET `name` = 'Estatus' WHERE (`id` = '6');
UPDATE `ost_queue_column` SET `name` = 'Fecha cierre' WHERE (`id` = '7');
UPDATE `ost_queue_column` SET `name` = 'Asignado' WHERE (`id` = '8');
UPDATE `ost_queue_column` SET `name` = 'Fecha vencimiento' WHERE (`id` = '9');
UPDATE `ost_queue_column` SET `name` = 'Ultima actualización' WHERE (`id` = '10');
UPDATE `ost_queue_column` SET `name` = 'Departamento' WHERE (`id` = '11');
UPDATE `ost_queue_column` SET `name` = 'Último mensaje' WHERE (`id` = '12');
UPDATE `ost_queue_column` SET `name` = 'Última respuesta' WHERE (`id` = '13');
UPDATE `ost_queue_column` SET `name` = 'Equipo' WHERE (`id` = '14');

SET SQL_SAFE_UPDATES = 0;
update ost_queue_columns set heading="De" where heading="From";
update ost_queue_columns set heading="Tema" where heading="Subject";
update ost_queue_columns set heading="Prioridad" where heading="Priority";
update ost_queue_columns set heading="Asignado a" where heading="Assigned To";
update ost_queue_columns set heading="Última actualización" where heading="Last Update";
update ost_queue_columns set heading="Fecha vencimiento" where heading="Due Date";
update ost_queue_columns set heading="Departamento" where heading="Department";
update ost_queue_columns set heading="Cerrado por" where heading="Closed By";
update ost_queue_columns set heading="Fecha cierre" where heading="Date Closed";

UPDATE `ost_ticket_status` SET `name` = 'Abierto' WHERE (`id` = '1');
UPDATE `ost_ticket_status` SET `name` = 'Resuelto' WHERE (`id` = '2');
UPDATE `ost_ticket_status` SET `name` = 'Cerrado' WHERE (`id` = '3');
UPDATE `ost_ticket_status` SET `name` = 'Archivado' WHERE (`id` = '4');
UPDATE `ost_ticket_status` SET `name` = 'Borrado' WHERE (`id` = '5');

UPDATE `controlescolar`.`ost_form` SET `instructions` = 'Proporciona los detalles y/o información complementaria. Esto nos permitirá, brindarte una mejor asistencia. <p style=\'color:red;\'>Puedes adjuntar un archivo de m&aacute;ximo 1MB en los siguientes formatos (PDF, jpg, jpeg, gif, png) </p>' WHERE (`id` = '2');


