SELECT 
    M.*,
    A.Nombre AS nombreEnvia,
    B.Nombre AS nombreRecibe,
    V.Marca_modelo,
    C.Nombre AS nombrePropietario,
    COALESCE(SUM(E.importe), 0) AS totalImporte
FROM movimientos M
LEFT JOIN entidad A ON M.envia = A.id_entidad
LEFT JOIN entidad B ON M.recibe = B.id_entidad
LEFT JOIN vehiculos V ON M.vehiculo = V.id_vehiculo
LEFT JOIN entidad C ON V.propietario = C.id_entidad
LEFT JOIN entregas E ON M.idMovimiento = E.movimiento
GROUP BY 
    M.idMovimiento,   -- clave principal de movimientos
    A.Nombre,
    B.Nombre,
    V.Marca_modelo,
    C.Nombre;
