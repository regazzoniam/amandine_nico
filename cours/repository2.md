
### Repository

```php
$this->_em->persist($account);
if ($flush) {
    $this->_em->flush();
}
```

Ici, le _persist_ permet de stocker une requête de type 'insert into'

```php
$this->_em->remove($account);
if ($flush) {
    $this->_em->flush();
}
```

Ici, le _remove_ permet de stocker une requête de type 'delete from'

Tant que le _flush_ n'a pas été appelé, les requêtes sont simplement 'stockées' et ne sont pas exécutées en BDD

Ces fonctions sont appelées depuis l'_EntityManagerInterface_, il s'occupe de gérer les intéractions entre entités et BDD (insert, delete, update)


### DQL

```php
return $this->createQueryBuilder('p')
    ->select('p', 'country', 'games')
    ->join('p.country', 'country')
    ->join('p.games', 'games')
    ->orderBy('p.name')
    ->getQuery()
    ->getResult()
;
```

Détail de la requête en SQL :

```sql
SELECT p.*, country.*, games.*
FROM publisher p
JOIN country AS country
ON country.id = p.country_id
JOIN games AS games
ON games.publisher_id = p.id
ORDER BY p.name ASC;
```

### DQL avec paramètre

```php
->where('p.slug = :slug')
->setParameter('slug', $slug)
```

Dans un QueryBuilder, on peut donc lui passer des conditions Where qui peuvent varier en fonction de paramètres.

Ici, je veux rechercher l'entité d'alias "p" sur son slug.
Dans le where on déclare une "clé" qui est précédée de deux points (ici : **:slug**)
Et on lui indique sa valeur via le setParameter qui prend en premier paramètre la clé déclarée dans le where, et en second sa valeur.














