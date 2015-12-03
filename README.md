#  ObjectToAny

ObjectToAny is a simple php class that can allow you to make a lot of Conversion(array,binary,json,xml,CVS)

# Author

Abderrahim Soubai Elidrissi

# License

This software is distributed under the MIT license. https://opensource.org/licenses/MIT MIT

# features
 * From Objet  To Array
 * From Objet  To XML
 * From Objet  To JSON
 * From Objet  To Binary
 * From Objet  To CSV
 * From Array  To Object
 * From XML    To Object
 * From JSON   To Object
 * From Binary To Object
 * From CSV To Object
 
# installation 

    composer require soubai/object-to-any

# A Simple Example
    <?php
    namespace Soubai\ObjectToAny;
    require 'vendor/autoload.php';
    class ClassName 
    {
    var $a;
    var $b;
    var $c;
    }
    $c = new ClassName();
    $c->a = 10;
    $c->b = 100;
    $c->c = 1000;
    
    // exemple convesion Object to JSON
    var_dump(ObjectToAny::ToJSON($c));


