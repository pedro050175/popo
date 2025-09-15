SELECT 
    M.*,
    A.Nombre AS nombreEnvia,
    B.Nombre AS nombreRecibe,
    V.Marca_modelo,
    C.Nombre AS nombrePropietario,
    COALESCE(E.totalImporte, 0) AS totalEntregas,
    COALESCE(D.totalImporte, 0) AS totalDevoluciones,
    COALESCE(E.totalImporte, 0) - COALESCE(D.totalImporte, 0) AS diferencia
FROM movimientos M
LEFT JOIN entidad A ON M.envia = A.id_entidad
LEFT JOIN entidad B ON M.recibe = B.id_entidad
LEFT JOIN vehiculos V ON M.vehiculo = V.id_vehiculo
LEFT JOIN entidad C ON V.propietario = C.id_entidad

-- subconsulta para sumar entregas
LEFT JOIN (
    SELECT movimiento, SUM(importe) AS totalImporte
    FROM entregas
    GROUP BY movimiento
) E ON M.idMovimiento = E.movimiento

-- subconsulta para sumar devoluciones
LEFT JOIN (
    SELECT movimiento, SUM(importe) AS totalImporte
    FROM devoluciones
    GROUP BY movimiento
) D ON M.idMovimiento = D.movimiento;
