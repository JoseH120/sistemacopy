<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OauthClients extends Seeder
{
    public function run()
    {
        //
        $data = [
            'client_id' => 'testclient',
            'client_secret' => 'testsecret',
            'grant_types' => 'password',
            'scope' => 'app',
        ];
        // Preparando consulta de sql
        $this->db->query(
            <<<text
            INSERT INTO oauth_clients (client_id, client_secret, grant_types, scope) values(:client_id:, :client_secret:, :grant_types:, :scope:)
            text,
            $data
        );
    }
}
