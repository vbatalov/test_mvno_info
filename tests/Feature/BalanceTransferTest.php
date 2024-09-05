<?php

namespace Tests\Feature;

use App\Action\BalanceTransfer\SimIdSearchEngine;
use App\Models\Sim;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BalanceTransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_find_sender(): void
    {
        $f_subscriber = Subscriber::create([
            "group_id" => rand(10, 100)
        ]);
        $f_sim = Sim::create([
            "iccid" => 123456789,
            "subscriber_id" => $f_subscriber->id,
        ]);

        $simid_from = 6789;

        $search = SimIdSearchEngine::searchByIccid($simid_from);

        $this->assertTrue($search instanceof Sim);
        $search = SimIdSearchEngine::searchByIccid(6780);
        $this->assertFalse($search instanceof Sim);
    }

    public function test_bad_validate()
    {
        $response = $this->post(route("balance-transfer"), [
        ]);

        $response->assertStatus(422);

    }

    public function test_iccid_not_found()
    {
        $response = $this->post(route("balance-transfer"), [
            "simid_from" => 1234,
            "simid_to" => 5678,
            "sum" => 100.23,
            "comment" => "Comment",
        ]);

        $response->assertStatus(404);
    }

    public function test_success_transfer()
    {
        $f_subscriber = Subscriber::create([
            "group_id" => rand(10, 100),
            "min_balance" => -1000,
        ]);
        $sim_from = Sim::create([
            "iccid" => 123456789,
            "subscriber_id" => $f_subscriber->id,
        ]);

        $sim_to = Sim::create([
            "iccid" => 98658745125,
            "subscriber_id" => $f_subscriber->id,
        ]);

        $sum = (rand(1, 80) * 1.2345);
        $response = $this->post(route("balance-transfer"), [
            "simid_from" => 6789,
            "simid_to" => 5125,
            "sum" => $sum,
            "comment" => "Comment",
        ]);


        $response->assertStatus(200);

        $result_from = Sim::whereIccid($sim_from->iccid)->get()->first();
        dump("from balance: {$result_from->balance}");

    }

    public function test_bad_transfer_limit_minBalance()
    {
        $f_subscriber = Subscriber::create([
            "group_id" => rand(10, 100),
            "min_balance" => 100,
        ]);
        $current_balance = 150;
        $sim_from = Sim::create([
            "iccid" => 123456789,
            "subscriber_id" => $f_subscriber->id,
            "balance" => $current_balance
        ]);

        $sim_to = Sim::create([
            "iccid" => 98658745125,
            "subscriber_id" => $f_subscriber->id,
        ]);

        $sum = 50.01;

        $response = $this->post(route("balance-transfer"), [
            "simid_from" => 6789,
            "simid_to" => 5125,
            "sum" => $sum,
            "comment" => "Comment",
        ]);


        $response->assertStatus(422);
        dump(json_decode($response->content(), true));

        $result_from = Sim::whereIccid($sim_from->iccid)->get()->first();
        dump("from balance: {$result_from->balance}");
        $this->assertTrue($result_from->balance == $current_balance);

    }

    public function test_ok_transfer()
    {
        $f_subscriber = Subscriber::create([
            "group_id" => rand(10, 100),
            "min_balance" => 100,
        ]);
        $s_subscriber = Subscriber::create([
            "group_id" => rand(10, 100),
            "min_balance" => 100,
        ]);
        $current_balance = 150;
        $sim_from = Sim::create([
            "iccid" => 123456789,
            "subscriber_id" => $f_subscriber->id,
            "balance" => $current_balance
        ]);

        $sim_to = Sim::create([
            "iccid" => 98658745125,
            "subscriber_id" => $s_subscriber->id,
        ]);

        $sum = 49.25;

        $response = $this->post(route("balance-transfer"), [
            "simid_from" => 6789,
            "simid_to" => 5125,
            "sum" => $sum,
            "comment" => "Comment",
        ]);


        $response->assertStatus(200);
        dump(json_decode($response->content(), true));

        $result_from = Sim::whereIccid($sim_from->iccid)->get()->first();
        dump("From: current balance: {$result_from->balance}");
        $this->assertFalse($result_from->balance == $current_balance);

        $new_balance = $current_balance - $sum;
        dump("Wait new balance = $new_balance | Balance now: {$result_from->balance}");
        var_dump($result_from->balance, $new_balance);
        $this->assertEquals($result_from->balance, $new_balance);
//        $this->assertTrue($result_from->balance === $new_balance);

    }
}
