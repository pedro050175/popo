SELECT AM.idAmpliacion, AM.ganancia, AM.fechaInicio, AM.comisionComercial FROM ampliaciones AM
                                JOIN alquileres AL ON AM.alquiler = AL.id_alquiler
                                JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
                                            WHERE AM.fechaInicio BETWEEN '2025-09-23' AND '2025-10-01' AND V.id_vehiculo = 1;