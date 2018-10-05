# MesClics Twig extensions

## Pluralizer
Cette extension permet de gérer les singuliers et pluriels avec une simple fonction TWIG.
### Fonctionnement
Il suffit d'utiliser la fonction pluralize() pour laisser à TWIG le soin de chosir s'il doit afficher la version au singulier ou la version au pluriel en fonction d'une variable (int ou array).
Twig vérifie que la variable nécessite le pluriel (si la valeur de l'intest supérieur> 1, ou si le nombre d'items contenus dans l'array est supérieur à 1)
### Syntaxe
```twig
{{ pluralize(string singulier, string pluriel, int|array variable) }}
Ex: Imaginons que nous ayons une variable "pers" qui contient .
```twig
<p>Il y a {{ personnes|length }} {{ pluralize("personne", "personnes", pers)}}
````


