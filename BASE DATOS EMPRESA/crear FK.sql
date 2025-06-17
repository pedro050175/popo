alter table pagoscomven 
add constraint fk_compraventa foreign key (CompraVenta) 
references compraventas(id) 
on delete restrict on update restrict;