<?php
declare(strict_types=1);
namespace Context;

require_once(__DIR__ . '/../../app/config.php');
use function Config\get_db_dir;



// ############################################################################
// Context Class
// ############################################################################

class Context {
    public bool   $logged_in;
    public string $name;
    public string $role;

    public function __construct(bool $logged_in = false, string $name = '', string $role = ''){
        
        $this->logged_in = $logged_in;
        $this->name      = $name;
        $this->role      = $role;
    }

    public function writeToDisk(string $browser_id): void {

        $data = ['logged_in' => $this->logged_in,
                 'name'      => $this->name,
                 'role'      => $this->role      ];

        $filename = get_db_dir() . "/$browser_id.json";

        file_put_contents($filename, $data);
    }

    public static function readFromDisk(string $browser_id): self {

        $json_str = file_get_contents(get_db_dir() . "/$browser_id.json");
        $data     = json_decode($json_str, true);

        $context = new Context($data['logged_in'], $data['name'], $data['role']);
        return $context;
    }
}
