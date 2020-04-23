# Console
The Console is the simple PHP class for getting options from the command-line argument list.

## Ability
### Constructor

    __construct( [string $small [, string $large [, bool $value]]] )

* $small — the short option name, the character will be mapped to the option names starting with a single hyphen ("_-_"). For example, the “_x_” character for receiving the “_-x_” option value. Only one character. Only “_a-z_”, “_A-Z_” and “_0-9_” are allowed.
* $large — the full option name, the string will be mapped to the option names starting with a double hyphen (“_--_”). For example, the “_opt_” string for receiving the “_--opt_” option value.  Only one character. Only “_a-z_”, “_A-Z_” and “_0-9_” are allowed.
* $value — the option value required or not. Only true and false are allowed.

### Create
Creating the option to observe for the command-line argument list.

    self console->create( [string $small [, string $large [, bool $value]]] )

* $small — the short option name, the character will be mapped to the option names starting with a single hyphen ("_-_"). For example, the “_x_” character for receiving the “_-x_” option value. Only one character. Only “_a-z_”, “_A-Z_” and “_0-9_” are allowed.
* $large — the full option name, the string will be mapped to the option names starting with a double hyphen (“_--_”). For example, the “_opt_” string for receiving the “_--opt_” option value.  Only one character. Only “_a-z_”, “_A-Z_” and “_0-9_” are allowed.
* $value — the option value required or not. Only true and false are allowed.

### Update
Updating the received value of the command-line option.

    self console->update( [string $small [, string $large [, bool $value]]] )

* $small — the short option name, the character will be mapped to the option names starting with a single hyphen ("_-_"). For example, the “_x_” character for receiving the “_-x_” option value. Only one character. Only “_a-z_”, “_A-Z_” and “_0-9_” are allowed.
* $large — the full option name, the string will be mapped to the option names starting with a double hyphen (“_--_”). For example, the “_opt_” string for receiving the “_--opt_” option value.  Only one character. Only “_a-z_”, “_A-Z_” and “_0-9_” are allowed.
* $value — the option value required or not. Only true and false are allowed.

### Delete
Deleting the command-line option.

    self console->delete( string $element )

* $element — the short or full option name.

### Select
Selecting the command-line option values passed to the script.

    array|string console->select( [string $element] )

* $element — the short or full option name.

### Set
Setting the command-line option value in the selected data.

    array|string console->set( string $element, string|bool $content )

* $element — the option name.
* $content — the option value.

### Has
Checking the command-line to enable the option with the given name.

    bool console->has( [string $element] )

* $element — the option name.

### Get
Getting the command-line option value from the selected data.

    string|bool console->get( [string $element] )

* $element — the option name.

## Example
Create a console object:

    $console = new Console();

Create options to observe:

    $console->create('a');
    $console->create('b', 'test1', false);
    $console->create('c', 'test2', true);

Update parameters matching:

    $console->update('a', 'test');

Delete options:

    $console->delete('test');
    $console->delete('c');

Receive option values:

    $options = $console->select();
