USE swap;

-- Ajout d'un compte administrateur
INSERT INTO membre (
    pseudo
    , email
    , mdp
    , statut
) VALUES (
    'Svet'
    , 'kik@gmail.com'
    , '123456'
    , 1
);