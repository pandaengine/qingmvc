#Throwable ¶

(PHP 7)
#Introduction ¶

Throwable is the base interface for any object that can be thrown via a throw statement in PHP 7, 
including Error and Exception.

#Note:
PHP classes cannot implement the Throwable interface directly, and must instead extend Exception.

#Interface synopsis ¶

Throwable {
/* Methods */
abstract public string getMessage ( void )
abstract public int getCode ( void )
abstract public string getFile ( void )
abstract public int getLine ( void )
abstract public array getTrace ( void )
abstract public string getTraceAsString ( void )
abstract public Throwable getPrevious ( void )
abstract public string _\_toString ( void )
}

