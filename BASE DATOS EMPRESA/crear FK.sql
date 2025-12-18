alter table multas 
add constraint fk_coche foreign key (vehiculo) 
references vehiculos(id_vehiculo) 
on delete restrict on update restrict;