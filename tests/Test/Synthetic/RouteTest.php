<?php

namespace Test\Synthetic;

use Abigail\Server;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{

    public function testAllRoutesClosures()
    {

        $abigail = Server::create('/')
            ->setClient('Abigail\\InternalClient')
            ->addGetRoute('test', function () {
                return 'getTest';
            })
            ->addPostRoute('test', function () {
                return 'postTest';
            })
            ->addPatchRoute('test', function () {
                return 'patchTest';
            })
            ->addPutRoute('test', function () {
                return 'putTest';
            })
            ->addOptionsRoute('test', function () {
                return 'optionsTest';
            })
            ->addDeleteRoute('test', function () {
                return 'deleteTest';
            })
            ->addHeadRoute('test', function () {
                return 'headTest';
            })
            ->addRoute('all-test', function () {
                return 'allTest';
            });

        foreach ($abigail->getClient()->methods as $method) {
            $response = $abigail->simulateCall('/test', $method);
            $this->assertEquals(["status" => 200, "data" => "{$method}Test"], json_decode($response, true));

            $response = $abigail->simulateCall('/all-test', $method);
            $this->assertEquals(["status" => 200, "data" => "allTest"], json_decode($response, true));
        }

    }

}
