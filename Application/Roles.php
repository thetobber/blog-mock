<?php
namespace Application;

/**
 * Represents a collection of constants which reflects the different possible 
 * roles of this application used for authorization of users.
 */
class RoleTable
{
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
