<?php
namespace Auth0\Tests;

use Auth0\SDK\Auth0Api;

class RulesTest extends BasicCrudTest {

    protected function getApiClient() {
        $env = $this->getEnv();
        $token = $this->getToken($env, [
            'rules' => [
                'actions' => ['create', 'read', 'delete', 'update']
            ]
        ]);

        $this->domain = $env['DOMAIN'];

        $api = new Auth0Api($token, $env['DOMAIN']);

        return $api->rules;
    }

    protected function getCreateBody() {
        $name = 'test-create-rule' . rand();
        echo "\n-- Using rule name $name \n";

        return [
            "name" => $name,
            "script" => "function (user, context, callback) {\n  callback(null, user, context);\n}",
            "enabled" => true,
        ];
    }
    protected function getUpdateBody() {
        return [
            "enabled" => false,
        ];
    }
    protected function afterCreate($entity) {
        $this->assertTrue($entity['enabled']);
    }
    protected function afterUpdate($entity) {
        $this->assertNotTrue($entity['enabled']);
    }
}