<h1 align="center"># Documentation PME Partner - Laravel</h1>

## Laravel modification de migrations [[Documentation Laravel]](https://laravel.com/docs/10.x/migrations)
Dans laravel, les migrations sont un moyen de créer votre base de données, avec ses différentes tables, champs et relations. Toutefois, il est parfois nécéssaire, tout particulièrement en production, de modifier ces tables après leur création. En fonction du nombre de fichiers de migrations déjà présents et de l'impact de vos modification sur votre base de données, il est alors primordial de ne pas venir remodifier un ancien fichier, mais plutôt d'en créer un nouveau qui s'occupera de vos modifications.<br />
*Exemple : Je peux vouloir rajouter un champ **birth_date** à ma table **user** alors que celle-ci a déjà été créée auparavant.*
<br /><br />
Modifier ainsi sa base de données nécéssite alors de créer un nouveau fichier de migration qui viendra s'ajouter aux précédents.
<br />
## Les tables <br/>
Il existe 4 grandes méthodes pour agir sur les tables utilisant *Schema* : <br/>
- Schema::create()
- Schema::table()
- Schema::rename()
- Schema::drop()

La méthode create() permet de créer une nouvelle table avec les informations données en paramètres (le nom de la table puis un blueprint).<br/>
```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    $table->timestamps();
});
```
La méthode table() permet de modifier des tables déjà existantes, en passant en paramètres le nom de la table à modifier et un blueprint.
<br/>
```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
Schema::table('users', function (Blueprint $table) {
    $table->integer('votes');
});
```
La méthode rename() permet de renomer déja existante.
```php
use Illuminate\Support\Facades\Schema;
 
Schema::rename($from, $to);
```
La méthode drop() permet de supprimer la table passée en paramètre.
```php
Schema::drop('users');
 
Schema::dropIfExists('users');
```
**ATTENTION**, avant de renommer une table, vous devez vérifier qu'aucune foreign key ne rentre en désacord avec votre modification. Ce problème peut survenir si vous avez donné un nom explicite à une clé étrangère au lieu de laisser Laravel lui assigner un nom automatiquement.
<br/><br/>

## Les colonnes
<br/>

Il existe 4 grandes méthodes pour agir sur les colonnes : <br/>
- **$table->*[type de colonne]*()**
- **$table->change()**
- **$table->renameColumn()**
- **$table->dropColumn()**
<br/><br/>

### La création de colonnes :
Que ce soit lors de la création ou la modification d'une table, il est nécessaire de préciser un type à notre nouvelle colonne. Il existe de nombreux types, que vous pouvez retrouver sur [la documentation officielle](https://laravel.com/docs/10.x/migrations#available-column-types).
<br/>
En voici tout de même quelques uns :
- **string()**      ->(crée une colonne *VARCHAR*)
- **boolean()**     ->(crée une colonne *BOOLEAN*)
- **dateTime()**    ->(crée une colonne *DATETIME*)
- **foreignId()**   ->(crée une colonne *UNSIGNED BIGINT*)

Dans la plupart des cas, le premier paramètre à donner sera le nom de la colonne à créer.
```php
$table->string('name', 100);
```
S'ajoute à ces types de colonnes des potentiels modifiers, retrouvables sur [la documentation officielle](https://laravel.com/docs/10.x/migrations#column-modifiers).
<br />
En voici tout de même quelques uns :
- **->first()**                     ->(place la colonne en *première place* de la table)
- **->unsigned()**                  ->(initialise à *UNSIGNED* une colonne *INTEGER*)
- **->nullable($value = true)**     ->(permet à des valeurs *NULL* d'être insérées dans la colonne)
- **->default($value)**             ->(spécifie une valeur *par défaut* pour la colonne)

Dans le cas du modifieur ***default***, celui-ci accepte une valeur ou une instance de ***Illuminate\Database\Query\Expression***. Utiliser cette dernière empêchera Laravel de *mettre la valeur entre guillemets* et vous permettra d'utiliser des *fonctions spécifiques*. Ceci est particulièrement utile dans le cas où vous souhaitez assigner des valeurs par défauts à des ***colonnes JSON***.
```php
<?php
 
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Migrations\Migration;
 
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->json('movies')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();
        });
    }
};
```
Lors de l'utilisation de bases de données MySQL, il est passible d'utiliser la method ***after*** pour ajouter des colonnes après une colonne déjà existante.
```php
$table->after('password', function (Blueprint $table) {
    $table->string('address_line1');
    $table->string('address_line2');
    $table->string('city');
});
```
### La modification de colonnes
Lors de la modification de colonnes pré-existantes, il est nécéssaire d'utiliser la méthode ***change()***. Pour ce faire, il suffit de rentrer la nouvelle valeur pour la colonne, avant de chaîner la méthode ***change()***.
```php
Schema::table('users', function (Blueprint $table) {
    $table->string('name', 50)->change();
});
```
<sub>Ici, nous modifions la colonne *name* pour être un string de taille 50, et ce, quelles qu'aient pu être ses anciennes valeurs.</sub>

De cette manière, vous devez donc explicitement indiquer tous les modifieurs que vous souhaitez appliquer et garder. Tout attribut non indiqué sera supprimé.
*Par exemple, pour garder les attributs **unsigned**, **default** et **comment**, vous devez tous les indiquer lors de la modification de la colonne :
```php
Schema::table('users', function (Blueprint $table) {
    $table->integer('votes')->unsigned()->default(1)->comment('my comment')->change();
});
```
### Modifier des colonnes sur SQLite
Il existe des règles spécifiques à appliquer si vous souhaitez modifier des colonnes sur SQLite. Celles-ci sont disponibles sur [la documentation officielle](https://laravel.com/docs/10.x/migrations#modifying-columns-on-sqlite).
### Renommer des colonnes
Pour renommer une colonne, il suffit d'utiliser la méthode renameColumn():
```php
Schema::table('users', function (Blueprint $table) {
    $table->renameColumn('from', 'to');
});
```
#### **Renommer des colonnes sur des vieilles bases de données :**
Si vous utilisez des bases de données sur des version inférieures à celles indiquées ci-dessous, vous devriez installer la librairie ***doctrine/dbal*** via Composer avant de renommer une colonne.
- MySQL < 8.0.3
- MariaDB < 10.5.2
- SQLite > 3.25.0
### Supprimer des colonnes
Pour supprimer une colonne, il suffit d'utiliser la méthode ***dropColumn()***:
```php
Schema::table('users', function (Blueprint $table) {
    $table->dropColumn('votes');
});
```
Vous pouvez également supprimer plusieurs colonnes à la fois en passant un tableau de noms de colonnes à la méthode ***dropColumn***.
```php
Schema::table('users', function (Blueprint $table) {
    $table->dropColumn(['votes', 'avatar', 'location']);
});
```
#### **Supprimer des colonnes sur des vieilles bases de données :**
Si vous utilisez des bases de données sur des version inférieures à celles indiquées ci-dessous, vous devriez installer la librairie ***doctrine/dbal*** via Composer avant de renommer une colonne. Supprimer plusieurs colonnes à la fois n'est alors dans ce cas pas possible.
- SQLite > 3.25.0
#### **Alias de suppression de colonnes :**
Il existe pour certains cas spécifiques, des alias de suppression pour supprimer plus rapidement des colonnes telles que les timestamps (***$table->dropTimestamps()***). Ces alias sont disponibles sur [la documentation officielle](https://laravel.com/docs/10.x/migrations#available-command-aliases).
## Les index
### Création d'index
Laravel permet, tout comme pour les tables et les colonnes, de créer des index. L'exemple suivant permet de créer une colonne *email* et spécifie que cette valeur doit être **unique**. Pour créer cela, on utilise donc la méthode ***unique()*** sur la colonne en question.
```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
Schema::table('users', function (Blueprint $table) {
    $table->string('email')->unique();
});
```
Autrement, vous pouvez aussi créer cet index après avoir défini la colonne. Pour cela, il vous suffit d'appeler la méthode ***unique*** sur le blueprint. Cette méthode accepte le nom de la colonne qui recevra cet index *unique*.
```php
$table->unique('email');
```
Vous pouvez même passer un tableau de colonnes à une méthode d'index pour créer *a compound (or composite) index* :
```php
$table->index(['account_id', 'created_at']);
```
Lorsque vous créer un index, Laravel va automatiquement générer un nom d'index basé sur le nom de la table, le nom de la colonne et le type d'index. Cependant, vous pouvez tout de même passer un deuxième argument à la méthode pour spécifier vous-même le nom de l'index :
```php
$table->unique('email', 'unique_email');
```
### Les types d'index
Il existe un certain nombre d'index mis à disposition par Laravel. Ceux-ci sont disponibles sur [la documentation officielle](https://laravel.com/docs/10.x/migrations#available-index-types).
On y retrouve :
- **$table->primary('id')** (qui ajoute une clé primaire)
- **$table->unique('email')** (qui ajoute une clé unique)
- **$table->index('state')** (qui ajoute un index)

#### **Tailles d'index sur des vieilles bases de données :**
Si vous utilisez des bases de données sur des version inférieures à celles indiquées ci-dessous, vous devrez configurer la taille des strings par défaut en ajoutant la ligne ci-dessous dans votre ***App\Providers\AppServiceProvider***
- MySQL > 5.7.7
- MariaDB > 10.2.2
```php
use Illuminate\Support\Facades\Schema;
 
/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    Schema::defaultStringLength(191);
}
```
Pour plus d'informations, voir [la documentation offcielle](https://laravel.com/docs/10.x/migrations#index-lengths-mysql-mariadb).

### Renommer des index
Pour renommer un index, vous devrez utiliser la méhtode ***renameIndex***. Cette méthode accepte le nom de l'index actuel en premier argument, et le nom désiré en deuxième argument :
```php
$table->renameIndex('from', 'to')
```
<sub>Si votre application utilise une base de données SQLite, vous devez install le package docctrine/dbal via Composer avant d'utiliser la méthode renameIndex.</sub>

### Supprimer des index
Pour supprimer un index, vous devez spécifier son nom. Par défaut, Laravel assigne automatiquement un nom d'index basé sur le nom de la table, le nom de la colonne indexée, et le type d'index. <br/>
*Exemple :*
```php
$table->dropPrimary('users_id_primary');
```
<sub>*Supprime une clé primaire de la table 'users'*</sub>

### Contrainte de clé étrangère
Voir le README de Remy :)
