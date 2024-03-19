SELECT
    D.code,
    D.name,
    BL.name,
    D.note,
    LST_Field.name,
    D.id,
    (
        SELECT
            Name
        FROM
            departments
        where
            departments.id = D.parent_id
    ) as TrucThuoc
FROM
    departments D
    LEFT JOIN LST_Block BL on D.block_id = BL.id
    LEFT JOIN LST_Field on D.field_id = LST_Field.id;