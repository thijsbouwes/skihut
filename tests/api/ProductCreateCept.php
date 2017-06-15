<?php
$I = new ApiTester($scenario);

$I->wantTo('create a product via API');

$I->sendPOST('/products', json_encode([
        'name' => 'Example product',
        'cost' => '100.55'
    ])
);
$I->canSeeResponseIsJson();
$I->seeResponseContainsJson(['name' => 'Example product']);
$I->seeResponseContainsJson(['cost' => '100.55']);
$I->seeResponseContainsJson(['id' => '1']);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);

$I->sendGET('/products/1');
$I->canSeeResponseIsJson();
$I->seeResponseContainsJson(['name' => 'Example product']);
$I->seeResponseContainsJson(['cost' => '100.55']);
$I->seeResponseContainsJson(['id' => '1']);
$I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);

$I->seeRecord('products', ['name' => 'Example product', 'cost' => '100.55', 'id' => '1']);