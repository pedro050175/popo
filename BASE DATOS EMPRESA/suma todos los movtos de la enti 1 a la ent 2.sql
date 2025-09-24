SELECT   A.Nombre AS nombreEnvia, B.Nombre AS nombreRecibe, 
                                                    SUM(COALESCE(E.totalImporte, 0) - COALESCE(D.totalImporte, 0)) AS deuda
                                            FROM movimientos M
                                                LEFT JOIN entidad A ON M.envia = A.id_entidad
                                                LEFT JOIN entidad B ON M.recibe = B.id_entidad
                                                
                                                LEFT JOIN (
                                                    SELECT movimiento, SUM(importe) AS totalImporte
                                                    FROM entregas
                                                    GROUP BY movimiento
                                                ) E ON M.idMovimiento = E.movimiento

                                                LEFT JOIN (
                                                    SELECT movimiento, SUM(importe) AS totalImporte
                                                    FROM devoluciones
                                                    GROUP BY movimiento
                                                ) D ON M.idMovimiento = D.movimiento
                                                
                                                WHERE A.Nombre LIKE '%stelar%' and B.Nombre LIKE '%world%'
                                               GROUP BY A.Nombre, B.Nombre;