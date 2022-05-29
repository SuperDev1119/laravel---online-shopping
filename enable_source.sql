INSERT INTO ss_xyz_sources
(
    name,
    parser,
    path,
    enabled,
    title,
    config
) VALUES (
    'modalova - PURA CLOTHES default',
    'shopify',
    'https://puraclothesworld.com/products.json?limit=500',
    't',
    'PURA CLOTHES',
    '{
        "force - gender": "femme",
        "convert - currency - from": "USD",
        "append - category": "clothing",
        "force - brand name": "PURA CLOTHES",
        "transform - url": "https:\/\/network.modalova.com\/c1-915301?u={url_encoded}"
    }'
);