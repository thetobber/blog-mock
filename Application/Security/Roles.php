<?php
namespace Application\Security;

/**
 * Represents a collection of constants which reflects the different possible 
 * roles of this application used for authorization of users.
 */
class Roles
{
    /**
     * The role names corresponding to their id.
     * 
     * @var string
     */
    const NAMES = [
        1 => 'Administrator',
        2 => 'Editor',
        3 => 'Subscriber'
    ];

    /**
     * Represents an administrator.
     * 
     * @var int
     */
    const ADMIN = 1;

    /**
     * Represents an editor.
     * 
     * @var int
     */
    const EDITOR = 2;

    /**
     * Represents a subscriber.
     * 
     * @var int
     */
    const SUBSCRIBER = 3;

    /**
     * Constructor with a private access modifier to prevent instantiation.
     */
    private function __construct()
    {
    }
}
