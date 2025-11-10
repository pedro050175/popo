SELECT vehiculo FROM compraventas
LEFT JOIN (SELECT compraventa, SUM(importe) AS sumaGastos FROM gastoscompraventa GROUP BY compraventa) GCV on id_compraventa = GCV.compraventa;