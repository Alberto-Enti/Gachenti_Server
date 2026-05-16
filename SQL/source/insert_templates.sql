INSERT INTO card_templates (card, initial_price, description, image, id_card_type, id_card_rarity) VALUES 
('Calamares', 4.50, 'Bocata de calamares', 'calamares.png', 
    (SELECT id_card_type FROM card_types WHERE type = 'Caliente'), 
    (SELECT id_card_rarity FROM card_rarities WHERE rarity = 'Común')),

('Falafel', 3.80, 'Durum de falafel', 'falafel.png', 
    (SELECT id_card_type FROM card_types WHERE type = 'Caliente'), 
    (SELECT id_card_rarity FROM card_rarities WHERE rarity = 'Raro')),

('Lobster Roll', 6.50, 'Bocadillo con langosta', 'lobster_roll.png', 
    (SELECT id_card_type FROM card_types WHERE type = 'Gourmet'), 
    (SELECT id_card_rarity FROM card_rarities WHERE rarity = 'Legendario'));