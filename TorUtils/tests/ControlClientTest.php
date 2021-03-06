<?php

use Dapphp\TorUtils\ControlClient;

class ControlClientTest extends PHPUnit_Framework_TestCase
{
    protected function getMock($data = null)
    {
        $tc = new ControlClientMock();

        if (is_array($data)) {
            $tc->recvData = $data;
        }

        return $tc;
    }

    public function testSingleLinePositiveReply()
    {
        $response = array("250 OK\r\n");
        $tc       = $this->getMock($response);
        $reply    = $tc->readReply();

        $this->assertEquals(250, $reply->getStatusCode());
    }

    public function testReadMultiReply()
    {
        $cmd      = 'testing';
        $response = array(
            "250+{$cmd}=\r\n",
            "this is some data for a reply line\r\n",
            "this is some data for another line\r\n",
            "and finally the last line of reply\r\n",
            ".\r\n",
            "250 OK\r\n",
        );

        $tc    = $this->getMock($response);
        $reply = $tc->readReply($cmd);

        $this->assertEquals(250, $reply->getStatusCode());
        $this->assertEquals(rtrim($response[1], "\r\n"), $reply[0]);
        $this->assertEquals(rtrim($response[2], "\r\n"), $reply[1]);
        $this->assertEquals(rtrim($response[3], "\r\n"), $reply[2]);
    }

    public function testReadMultiReply2()
    {
        $cmd      = 'option/value';
        $response = array(
            "250-{$cmd}=answer\r\n",
            "250 OK\r\n",
        );

        $tc    = $this->getMock($response);
        $reply = $tc->readReply($cmd);

        $this->assertEquals(250, $reply->getStatusCode());
        $this->assertEquals('answer', $reply[0]);
        $this->assertEquals(1, sizeof($reply->getReplyLines()));
    }

    public function testReadLongMultiReply()
    {
        $cmd      = 'getinfo/testing';
        $response = array(
            "250+{$cmd}=\r\n",
        );

        for ($i = 0; $i < 1000; ++$i) {
            $response[] = str_repeat('x', 80) . "\r\n";
        }

        $response[] = ".\r\n";
        $response[] = "250 OK\r\n";

        $tc    = $this->getMock($response);
        $reply = $tc->readReply($cmd);

        $this->assertEquals(250, $reply->getStatusCode());
        $this->assertEquals(1000, sizeof($reply->getReplyLines()));
        $this->assertEquals(str_repeat('x', 80), $reply[500]);
    }

    public function testParseReplyWithAsyncEvent()
    {
        $cmd = 'GETCONF SOCKSPORT ORPORT';
        $response = array(
            "650 CIRC 212 EXTENDED \$844AE9CAD04325E955E2BE1521563B79FE7094B7~Smeerboel BUILD_FLAGS=NEED_CAPACITY PURPOSE=GENERAL TIME_CREATED=2016-12-22T06:11:06.611813\r\n",
            "250-SOCKSPORT=9050\r\n",
            "250 ORPORT=0\r\n",
        );

        $GLOBALS['async_event'] = '';
        $GLOBALS['async_data']  = '';

        $tc    = $this->getMock($response);

        $tc->setAsyncEventHandler(function($event, $data) {
            $GLOBALS['async_event'] = $event;
            $GLOBALS['async_data']  = $data;
        });

        $reply = $tc->readReply($cmd);

        // the async event data comes first, but it should be read and handled
        // by the async event handler, and then the response to the issued
        // GETCONF command should be handled properly and returned in $reply

        $this->assertEquals(250,    $reply->getStatusCode());
        $this->assertEquals('9050', $reply['SOCKSPORT']);
        $this->assertEquals(null,   $reply['ORPORT']); // Port 0 is turned to null

        $this->assertEquals('CIRC', $GLOBALS['async_event']);
        $this->assertInstanceOf(Dapphp\TorUtils\CircuitStatus::class, $GLOBALS['async_data'][0]);
        $this->assertEquals('EXTENDED', $GLOBALS['async_data'][0]->status);
        $this->assertEquals('212', $GLOBALS['async_data'][0]->id);
        $this->assertEquals('GENERAL', $GLOBALS['async_data'][0]->purpose);

    }

    public function testAuthentication()
    {
        $response = array(
            "250-PROTOCOLINFO 1\r\n",
            "250-AUTH METHODS=COOKIE,SAFECOOKIE,HASHEDPASSWORD COOKIEFILE=\"/var/run/tor/control.authcookie\"\r\n",
            "250-VERSION Tor=\"0.2.9.8\"\r\n",
            "250 OK\r\n",
            "250 OK\r\n", // authenticate reply
        );

        $tc = $this->getMock($response);

        $tc->authenticate("password");

        $this->addToAssertionCount(1);
    }

    public function testFailedAuthentication()
    {
        $response = array(
            "250-PROTOCOLINFO 1\r\n",
            "250-AUTH METHODS=COOKIE,SAFECOOKIE,HASHEDPASSWORD COOKIEFILE=\"/var/run/tor/control.authcookie\"\r\n",
            "250-VERSION Tor=\"0.2.9.8\"\r\n",
            "250 OK\r\n",
            "515 Authentication failed: Password did not match HashedControlPassword *or* authentication cookie.\r\n",
        );

        $this->expectException(\Dapphp\TorUtils\ProtocolError::class);
        $this->expectExceptionCode(515);
        $this->expectExceptionMessage('Authentication failed: Password did not match HashedControlPassword *or* authentication cookie.');

        $tc = $this->getMock($response);
        $tc->authenticate("this is most definitely the wrong password ;)");
    }
}

/**
 * Weak way to mock a ControlClient such that when a test invokes readReply to
 * read from the control socket, we can override _recvData to return lines of
 * test data rather than reading from a socket.
 *
 * To mock reads, set recvData to a numerically keyed array where each index
 * is a line of data from the controller.
 */
class ControlClientMock extends ControlClient
{
    public $recvData = [];

    public function _recvData()
    {
        $v = current($this->recvData);
        next($this->recvData);
        return $v;
    }

    public function sendData($data)
    {
        $data = $data . "\r\n";
        return strlen($data);
    }
}
