# LordChiffre
## Lien
* [LordChiffre](http://gauthier.cf/mes_sites/cryptage/)
## fonctionnement
### Pour chiffrer
```PHP
string chiffrement(string $msgClair, string $cle [, int $tours = 10]);
chiffrement() // retourne un message chiffrer, exemple : 6fb85d7170
$msgClair // est le message clair, exemple : salut
$cle // est la clé de chiffrement, exemple : test
$tours // est le nombre de fois que va être chiffre le message, optionnel, par défaut il vaut 10 
```
### Pour déchiffrer
```PHP
string deChiffrement(string $msgCrypt, string $cle [, int $tours = 10]);
deChiffrement() // retourne un message clair, exemple : salut
$msgCrypt // est le message chiffrer, exemple : 6fb85d7170
$cle // est la clé de chiffrement, exemple : test
$tours // est le nombre de fois que va être chiffre le message, optionnel, par défaut il vaut 10 
```
