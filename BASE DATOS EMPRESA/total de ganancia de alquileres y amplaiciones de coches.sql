SELECT ALS.vehiculo, ALS.Marca_modelo, MIN(ALS.fechaInicio) AS primerAlquiler,
                        SUM(ALS.TotalGananciaAlquiler) AS totalGananciaAlquileres, 
                        SUM(ALS.TotalPrecioAlquiler) AS totalPrecioAlquileres, 
                        SUM(ALS.TotalDiasAlquiler) AS TotalDiasAlquileres FROM
												(SELECT AL.vehiculo, V.Marca_modelo, AL.fechaInicio,
															COALESCE(AM.sumaGanancia, 0) + COALESCE(AL.ganancia) AS TotalGananciaAlquiler,
															COALESCE(AM.sumaDias, 0) + COALESCE(AL.dias) AS TotalDiasAlquiler, 
															COALESCE(AM.sumaPrecio, 0) + COALESCE(AL.precio) AS TotalPrecioAlquiler
												FROM alquileres AL
														LEFT JOIN vehiculos V ON AL.vehiculo = V.id_vehiculo
														LEFT JOIN (SELECT alquiler, SUM(precio) AS sumaPrecio, 
																					SUM(dias) AS sumaDias,
																					SUM(ganancia) AS sumaGanancia
																	FROM ampliaciones
																	GROUP BY alquiler) AM ON AM.alquiler = AL.id_alquiler
												WHERE vehiculo IN (82, 1)) AS ALS
                    GROUP BY Al.vehiculo;