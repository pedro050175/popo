SELECT 
    M.*,
    A.Nombre AS nombreEnvia,
    B.Nombre AS nombreRecibe,
    V.Marca_modelo,
    C.Nombre AS nombrePropietario,
    COALESCE(
        (SELECT SUM(E.importe) 
         FROM entregas E 
         WHERE E.movimiento = M.idMovimiento), 0
    ) AS totalEntregas,
    COALESCE(
        (SELECT SUM(D.importe) 
         FROM devoluciones D 
         WHERE D.movimiento = M.idMovimiento), 0
    ) AS totalDevoluciones,
    COALESCE(
        (SELECT SUM(E.importe) 
         FROM entregas E 
         WHERE E.movimiento = M.idMovimiento), 0
    ) - COALESCE(
        (SELECT SUM(D.importe) 
         FROM devoluciones D 
         WHERE D.movimiento = M.idMovimiento), 0
    ) AS diferencia
FROM movimientos M
LEFT JOIN entidad A ON M.envia = A.id_entidad
LEFT JOIN entidad B ON M.recibe = B.id_entidad
LEFT JOIN vehiculos V ON M.vehiculo = V.id_vehiculo
LEFT JOIN entidad C ON V.propietario = C.id_entidad;
