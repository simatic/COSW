<?php

// PHP script to add users to the database. CLI usage.

/**
 * Syntax:
 * php add_user.php <type> <first_name> <last_name> <email> [username:<username>] [password:<password>] [--help]
 * 
 * <type> is either "admin", "creator", "peer" or "jury" (without the quotation marks)
 */

require_once "bootstrap.php";

use App\Entity\Admin;
use App\Entity\Creator;
use App\Entity\JuryMember;
use App\Entity\LoggedUser;
use App\Entity\Peer;

$syntax = 
"\nSyntax:\n".
"php add_user.php <type> <first_name> <last_name> <email> [username:<username>] [password:<password>]\n".
"or\n".
"php add_user.php --help\n\n".
"<type> is either 'admin', 'creator', 'peer' or 'jury' (without the quotation marks)\n";

$help =
"\nAdds a user of type <type> to the database.\n\n".
$syntax;

if($argc == 2) {

    if($argv[1] === "--help") {echo $help;}
    else {echo $syntax;}

    exit(1);

}

if($argc < 5 || $argc > 7 || !in_array($argv[1], array("admin", "creator", "peer", "jury"))) {echo $syntax; exit(1);}
else {$type = $argv[1];}

if(strlen($argv[2]) > 50 || strlen($argv[3]) > 50) {echo "Firstname and lastname must be shorter than 50 characters"; exit(1);}
else {$firstName = $argv[2]; $lastName = $argv[3];}

if(strlen($argv[4]) > 255) {echo "Email has to be shorter than 255 characters"; exit(1);}
else {$email = $argv[4];}

switch($type) {

    case "creator":
        $user = new Creator();
        break;

    case "peer":
        $user = new Peer();
        break;
    
    case "jury":
        $user = new JuryMember();
        break;
    
    default:
        $user = new Admin();
        break;

}

$user->setFirstName($firstName);
$user->setLastName($lastName);
$user->setEmail($email);

for($k = 5; $k < $argc; $k++) {

    $hash = explode(":", $argv[$k]);

    if(!in_array($hash[0], array("username", "password"))) {

        $res =
        "\nWrong syntax for an optional argument.\n\n".
        "The correct syntax is the following:\n".
        "prefix:<value>\n\n".
        "Available prefixes are 'username' and 'password' (without the quotation marks).\n";

        echo $res;
        exit(1);

    }

    if($hash[0] === "username") {

        if(!$user instanceof Peer) {echo "Notice: Only peers can have a username. The given username will thus be ignored.\n";}
        else {

            if(strlen($hash[1]) == 0 || strlen($hash[1]) > 30) {echo "Username has to be comprised of 1 to 30 characters\n"; exit(1);}
            $user->setUsername($hash[1]);

        }

    }

    if($hash[0] === "password") {

        if(!$user instanceof LoggedUser) {echo "Notice: Only logged users (admins and creators) can have a password. The given password will thus be ignored.\n";}
        else {

            if(strlen($hash[1]) == 0 || strlen($hash[1]) > 255) {echo "Password has to be comprised of 1 to 255 characters\n"; exit(1);}
            $user->setPassword($hash[1]);

        }

    }

}

$entityManager->persist($user);
$entityManager->flush();


