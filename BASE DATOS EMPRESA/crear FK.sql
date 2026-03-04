alter table accionesTarea 
add constraint fk_tarea foreign key (tarea) 
references tareas(idTarea) 
on delete cascade on update cascade;