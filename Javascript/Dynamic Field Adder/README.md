# dynamic_field_adder
## Généralités
Ce script permet d'ajouter dynamiquement des champs à l'intérieur d'un formulaire lors d'un clic sur un bouton d'ajout
## Installation
### Importer le script
Le script doit être importé dans la vue (par le biais des assets), en ajoutant le lien suivant à l'intérieur du bloc {% javascripts '@MesClicsUtilsBundle/Resources/public/dynamic_field_adder/script.js' %}<script src="{{ asset_url }}"></script>{% endjavascripts %} du layout.
### Créer un bloc
Dans la vue du formulaire qui contiendra les champs ajoutés dynamiquement, insérer un bloc à l'intérieur duquel doivent être présents en tant qu'enfants directs, les blocs suivants :
1. un bouton recevant la class: "ooss-js-dynamic-button".
2. un bloc cible recevant la class: "oocss-js-dynamic-target" à l'intérieur duquel viendront se positionner les champs ajoutés. Cela peut-être un bloc vide comme un bloc déjà existant tant que celui-ci est un enfant direct du bloc ajouté en 1.
3. un bloc contenant le template du champ en tant qu'attribut data-protype="" et recevant la class: "oocss-js-dynamic-template"
